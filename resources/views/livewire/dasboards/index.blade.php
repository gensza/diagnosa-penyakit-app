<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboards') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Daftar Gejala Berdasarkan Rule Penyakit Tipes</h2>

        <div class="row">
            {{-- Tipes Ringan --}}
            @forelse ($posts as $d)
                <div class="col-md-4">
                    <div class="card border-|{{ $d['color'] }} mb-3">
                        <div class="card-header bg-{{ $d['color'] }} text-white">
                            <strong>{{ $d['penyakit'] }}</strong> <span class="badge bg-light text-dark float-end">Rule
                                #{{ $d['id'] }}</span>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @forelse ($d['gejala'] as $item)
                                    <li class="list-group-item">{{ $item['kode_gejala'] }} -
                                        {{ $item['nama_penyakit'] }}</li>
                                @empty
                                    <li class="list-group-item">No Found Data.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <h2 class="text-center">No Found Data.</h2>
            @endforelse
        </div>
    </div>
</div>
