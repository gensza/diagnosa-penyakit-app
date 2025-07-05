<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diagnosa History') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-6 max-w-2xl mx-auto">
            <div class="bg-white p-6 rounded shadow">
                <div class="mb-3 d-flex justify-content-between">
                    <input type="text" class="form-control border rounded w-50" placeholder="Search title..."
                        wire:model.live.debounce.300ms="search">

                    <select wire:model.live.debounce.300ms="perPage" class="form-select border rounded w-25">
                        <option value="5">5 / page</option>
                        <option value="10">10 / page</option>
                        <option value="25">25 / page</option>
                    </select>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('id')" style="cursor: pointer">
                                No
                                @if ($sortField == 'id')
                                    @if ($sortDirection == 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </th>
                            <th wire:click="sortBy('name')" style="cursor: pointer">
                                Name
                                @if ($sortField == 'name')
                                    @if ($sortDirection == 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </th>
                            <th>Diagnosa Code</th>
                            <th>Diagnosa Result</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration + $posts->firstItem() - 1 }}</td>
                                <td>{{ $post->name }}</td>
                                <td>{{ $post->kode_rule }}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $post->result)) }}</td>
                                <td>{{ $post->created_at }}</td>
                                <td>
                                    <button wire:click="openDetailModal('{{ $post->kode_rule }}')"
                                        class="btn btn-sm btn-primary">
                                        Gejala Detail
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

                {{ $posts->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-2xl font-semibold text-center mb-4 text-gray-800">Hasil Diagnosa</h2>
                    <button type="button" wire:click="modalDetailClosed()" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Gejala</th>
                                <th>Nama Penyakit</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($detailData as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->kode_gejala }}</td>
                                    <td>{{ $detail->nama_penyakit }}</td>
                                    <td>{{ $detail->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="modalDetailClosed()">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('show-detail-modal', () => {
        setTimeout(() => {
            const modal = document.getElementById('detailModal');
            if (modal) {
                modal.classList.add('show', 'd-block');
                modal.style.display = 'block';
            }
        }, 100);
    });

    window.addEventListener('hide-detail-modal', () => {
        setTimeout(() => {
            const modal = document.getElementById('detailModal');
            if (modal) {
                modal.classList.remove('show', 'd-block');
                modal.style.display = 'none';
            }
        }, 100);
    });
</script>
