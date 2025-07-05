<?php

namespace App\Livewire\Diagnosa;

use App\Models\Symptom_role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class History extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'suh.id';
    public $sortDirection = 'desc';
    public $detailData = [];

    public function render()
    {
        $posts = DB::table('symptoms_users_history as suh')
            ->join('users as u', 'suh.id_users', '=', 'u.id')
            ->where('u.name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->select('suh.id', 'u.name', 'suh.kode_rule', 'suh.result', 'suh.color', 'suh.created_at')
            ->paginate($this->perPage);

        return view('livewire.diagnosa.history', ['posts' => $posts]);
    }

    public function openDetailModal($kd)
    {
        $posts = Symptom_role::query()
            ->select('s.kode_gejala', 's.nama_penyakit', 's.created_at')
            ->join('symptoms as s', 'symptom_roles.kode_gejala', '=', 's.kode_gejala')
            ->where('kode_rule', $kd)
            ->get();

        $this->detailData = $posts;

        $this->dispatch('show-detail-modal');
    }

    public function modalDetailClosed()
    {
        $this->dispatch('hide-detail-modal');
    }
}
