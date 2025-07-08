<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gejala') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session()->has('message'))
                        <div class="alert alert-info">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <button wire:click="openAddModal" class="btn btn-success btn-sm">Tambah Data</button>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Gejala</th>
                                <th>Penyakit</th>
                                <th>Tipes Ringan</th>
                                <th>Tipes Menengah</th>
                                <th>Tipes Berat</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>{{ $post->kode_gejala }}</td>
                                    <td>{{ $post->nama_penyakit }}</td>
                                    <td><input type="checkbox" class="form-check-input"
                                            {{ $post->tipes_ringan == 'Yes' ? 'checked' : '' }}
                                            wire:click="updateStatusChecked('{{ $post->id }}', 'tipes_ringan', '{{ $post->tipes_ringan }}')">
                                    </td>
                                    <td><input type="checkbox" class="form-check-input"
                                            {{ $post->tipes_menengah == 'Yes' ? 'checked' : '' }}
                                            wire:click="updateStatusChecked('{{ $post->id }}', 'tipes_menengah', '{{ $post->tipes_menengah }}')">
                                    </td>
                                    <td><input type="checkbox" class="form-check-input"
                                            {{ $post->tipes_berat == 'Yes' ? 'checked' : '' }}
                                            wire:click="updateStatusChecked('{{ $post->id }}', 'tipes_berat', '{{ $post->tipes_berat }}')">
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"
                                            wire:click="confirmDelete({{ $post->id }})">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Gejala</h5>
                    <button type="button" wire:click="hideAddModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Kode Gejala</label>
                        <input type="text" class="form-control border rounded" placeholder="GL001"
                            wire:model.defer="kode_gejala">
                        @error('kode_gejala')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Penyakit</label>
                        <input type="text" class="form-control border rounded" placeholder="Demam"
                            wire:model.defer="nama_penyakit">
                        @error('nama_penyakit')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Tipes Ringan</label>
                        <select wire:model.defer="tipes_ringan" class="form-control">
                            <option value="">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Tipes Menengah</label>
                        <select wire:model.defer="tipes_menengah" class="form-control">
                            <option value="">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Tipes Berat</label>
                        <select wire:model.defer="tipes_berat" class="form-control">
                            <option value="">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="hideAddModal">Cancel</button>
                    <button type="button" wire:click="save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('show-add-modal', () => {
        new bootstrap.Modal(document.getElementById('addModal')).show();
    });

    window.addEventListener('hide-add-modal', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
        modal.hide();
    });

    window.addEventListener('show-delete-confirmation', () => {
        Swal.fire({
            title: 'Delete this Gejala?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // ✅ this hits the `delete()` Livewire method
                Livewire.find(@js($this->getId())).call('delete');
            }
        });
    });
</script>
