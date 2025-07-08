<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diagnosa') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="container">
            <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeIn">
                <div class="card-body p-5">

                    {{-- Gambar ilustrasi --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/undraw_developer-activity_4zqd.svg') }}" alt="Diagnosa"
                            class="img-fluid mx-auto d-block" style="max-height: 150px;">
                    </div>

                    {{-- Progress bar --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold">Pertanyaan {{ $step + 1 }} dari
                                {{ count($gejalaList) }}</span>
                            <span>{{ round((($step + 1) / count($gejalaList)) * 100) }}%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar progress-bar-striped bg-info" role="progressbar"
                                style="width: {{ (($step + 1) / count($gejalaList)) * 100 }}%;" aria-valuenow="50"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    {{-- Pertanyaan --}}
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Apakah Anda mengalami gejala:</h4>
                        <p class="fs-5 text-primary fw-semibold mt-2">
                            {{ $gejalaList[$step]['nama_penyakit'] }}?
                        </p>
                    </div>

                    {{-- Tombol jawaban --}}
                    <div class="d-flex justify-content-center gap-3">
                        <button wire:click="answer('no')" class="btn btn-danger btn-lg px-5 shadow-sm">
                            ❌ Tidak
                        </button>
                        <button wire:click="answer('yes')" class="btn btn-success btn-lg px-5 shadow-sm">
                            ✅ Ya
                        </button>
                    </div>
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
