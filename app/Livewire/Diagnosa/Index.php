<?php

namespace App\Livewire\Diagnosa;

use App\Models\Symptom;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Symptom_role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $gejalaList = [];
    public $step = 0;
    public $jawaban = [];
    public $hasil = null;
    public $topTipes = null;

    public $rulesGejala = [
        'tipes_ringan' => ['GL005', 'GL006', 'GL007'],
        'tipes_menengah' => ['GL001', 'GL002', 'GL003', 'GL004'],
        'tipes_berat' => ['GL001', 'GL002', 'GL003', 'GL004', 'GL005', 'GL006', 'GL007'],
    ];

    public function mount()
    {
        $this->gejalaList = Symptom::all()->toArray();
    }

    public function answer($jawab)
    {
        $kode = $this->gejalaList[$this->step]['kode_gejala'];
        $this->jawaban[$kode] = $jawab;

        if ($this->step + 1 >= count($this->gejalaList)) {
            // $this->hitungDiagnosa();
            $this->dispatch('show-diagnosa-confirmation');
        } else {
            $this->step++;
        }
    }

    public function hitungDiagnosa()
    {

        $selected = array_keys(array_filter($this->jawaban, fn($v) => $v === 'yes'));
        $result = [];

        foreach ($this->rulesGejala as $tipes => $required) {
            $total = count($required);
            $matched = count(array_intersect($required, $selected));
            $percent = $total > 0 ? round(($matched / $total) * 100, 2) : 0;

            $result[$tipes] = [
                'matched' => $matched,
                'total' => $total,
                'percentage' => $percent,
            ];
        }

        uasort($result, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage']; // descending
        });

        $this->topTipes = array_key_first($result);
        if ($result['tipes_berat']['percentage'] == '100') {
            $this->topTipes = 'tipes_berat';
        }

        $this->hasil = [
            'persentase' => $result,
            'kesimpulan' => strtoupper(str_replace('_', ' ', $this->topTipes)),
        ];

        // show modal
        $this->dispatch('show-result-modal');
    }

    public function save()
    {
        $yaJawaban = array_keys(array_filter($this->jawaban, fn($v) => $v === 'yes'));

        $kodeRule = 'RC-' . now()->format('YmdH');

        foreach ($yaJawaban as $kode) {
            Symptom_role::create([
                'kode_rule' => $kodeRule,
                'kode_gejala' => $kode,
            ]);
        }

        $color = 'secondary';
        if ($this->topTipes == 'tipes_ringan') {
            $color = 'green';
        } elseif ($this->topTipes == 'tipes_menengah') {
            $color = 'yellow';
        } elseif ($this->topTipes == 'tipes_berat') {
            $color = 'red';
        }

        //save to tb_symptoms_users_history
        DB::table('symptoms_users_history')->insert([
            'id_users' => Auth::user()->id,
            'kode_rule' => $kodeRule,
            'result' => $this->topTipes,
            'color' => $color,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->dispatch('post-added-alert', message: "Diagnosa successfully created!"); // trigger event jika ingin refresh data

    }

    public function modalResultClosed()
    {
        $this->dispatch('hide-result-modal');
    }

    public function render()
    {
        return view('livewire.diagnosa.index');
    }
}
