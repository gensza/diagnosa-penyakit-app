<?php

namespace App\Livewire\Dasboards;

use App\Models\Symptom;
use Livewire\Component;

class Index extends Component
{
    public $rules = [];

    public function render()
    {
        $tipes_ringan = Symptom::where('tipes_ringan', 'Yes')->get();
        $tipes_menengah = Symptom::where('tipes_menengah', 'Yes')->get();
        $tipes_berat = Symptom::where('tipes_berat', 'Yes')->get();

        $this->rules = [
            [
                'id' => 1,
                'penyakit' => 'Tipes Ringan',
                'color' => 'success',
                'gejala' => $tipes_ringan,
            ],
            [
                'id' => 2,
                'penyakit' => 'Tipes Menengah',
                'color' => 'warning',
                'gejala' => $tipes_menengah,
            ],
            [
                'id' => 3,
                'penyakit' => 'Tipes Berat',
                'color' => 'danger',
                'gejala' => $tipes_berat,
            ],
        ];

        return view('livewire.dasboards.index', ['posts' => $this->rules]);
    }
}
