<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diagnosa') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-6 max-w-2xl mx-auto">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-semibold mb-4">
                    Pertanyaan {{ $step + 1 }} dari {{ count($gejalaList) }}
                </h2>
                <p class="mb-6">
                    Apakah anda mengalami gejala <b>{{ $gejalaList[$step]['nama_penyakit'] }} ?</b>
                </p>
                <div class="flex gap-2">
                    <button wire:click="answer('yes')" class="btn btn-success">Ya</button>
                    <button wire:click="answer('no')" class="btn btn-danger">Tidak</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resultModal" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-2xl font-semibold text-center mb-4 text-gray-800">Hasil Diagnosa</h2>
                    <button type="button" wire:click="modalResultClosed()" class="btn-close"></button>
                </div>
                <div class="modal-body">

                    @if (isset($hasil['persentase']))
                        <div class="space-y-3">
                            @foreach ($hasil['persentase'] as $tipe => $data)
                                @php
                                    $color = match ($tipe) {
                                        'tipes_ringan' => 'bg-green-100 text-green-800',
                                        'tipes_menengah' => 'bg-yellow-100 text-yellow-800',
                                        'tipes_berat' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp

                                <div class="p-4 rounded-lg {{ $color }} shadow-sm">
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm font-bold uppercase">{{ str_replace('_', ' ', $tipe) }}
                                        </div>
                                        <div class="text-sm font-semibold">
                                            {{ $data['percentage'] }}%
                                            <span
                                                class="text-xs font-normal">({{ $data['matched'] }}/{{ $data['total'] }}
                                                gejala cocok)</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 text-center text-lg">
                            <span class="font-medium text-gray-700">Kesimpulan:</span>
                            <span class="text-xl font-bold text-indigo-600">{{ $hasil['kesimpulan'] }}</span>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="modalResultClosed()">Close</button>
                    <button class="btn btn-primary" wire:click="save">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('show-diagnosa-confirmation', () => {
        Swal.fire({
            title: 'Save this diagnosa?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // ✅ this hits the `delete()` Livewire method
                Livewire.find(@js($this->getId())).call('hitungDiagnosa');
            }
        });
    });

    window.addEventListener('show-result-modal', () => {
        setTimeout(() => {
            const modal = document.getElementById('resultModal');
            if (modal) {
                modal.classList.add('show', 'd-block');
                modal.style.display = 'block';
            }
        }, 100);
    });

    window.addEventListener('hide-result-modal', () => {
        setTimeout(() => {
            const modal = document.getElementById('resultModal');
            if (modal) {
                modal.classList.remove('show', 'd-block');
                modal.style.display = 'none';
            }
        }, 100);
    });
</script>
