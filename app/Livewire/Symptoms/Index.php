<?php

namespace App\Livewire\Symptoms;

use App\Models\Symptom;
use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    public $search = '';
    public $perPage = 10;

    public string $kode_gejala = '';
    public string $nama_penyakit = '';
    public string $tipes_ringan = 'No';
    public string $tipes_menengah = 'No';
    public string $tipes_berat = 'No';

    public function render()
    {
        $posts = Symptom::query()
            ->whereAny(['kode_gejala', 'nama_penyakit'], 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.symptoms.index', ['posts' => $posts]);
    }

    public function openAddModal()
    {
        $this->dispatch('show-add-modal');
    }

    #[On('modal-closed')]
    public function hideAddModal()
    {
        $this->dispatch('hide-add-modal');
    }

    public function save()
    {
        $validated = $this->validate([
            'kode_gejala'       => 'required|string|unique:symptoms|max:100',
            'nama_penyakit'     => 'required|string|unique:symptoms|max:100',
        ]);

        Symptom::create([
            'kode_gejala'       => $validated['kode_gejala'],
            'nama_penyakit'     => $validated['nama_penyakit'],
            'tipes_ringan'      => $this->tipes_ringan,
            'tipes_menengah'    => $this->tipes_menengah,
            'tipes_berat'       => $this->tipes_berat
        ]);

        $this->reset(); // bersihkan input
        $this->dispatch('post-added-alert', message: "Gejala successfully created!"); // trigger event jika ingin refresh data
        $this->dispatch('modal-closed'); // tutup modal
    }

    public function updateStatusChecked($id, $field, $value)
    {
        $user = Symptom::findOrFail($id);
        $user->update([
            $field => $value === 'Yes' ? 'No' : 'Yes'
        ]);
        $this->dispatch('post-added-alert', message: "gejala updated successfully!");
    }
}
