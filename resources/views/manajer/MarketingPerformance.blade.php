@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Judul --}}
    <div class="mb-4">
        <h2 class="text-dark mb-1">Marketing Performance</h2>
        <p class="text-muted">Metrik kinerja individu staf.</p>
    </div>

    {{-- CARD 1 --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Kinerja Staf Marketing</h5>
                <small class="text-muted">Kontrak dan pendapatan per staf</small>
            </div>
            <button class="btn btn-outline-primary">
                <i class="bi bi-download me-2"></i> Ekspor
            </button>
        </div>

        <div class="card-body">
            {{-- Table --}}
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Nama Staf</th>
                        <th class="text-end">Kontrak Baru</th>
                        <th class="text-end">Total Pendapatan</th>
                        <th class="text-end">Tingkat Konversi</th>
                        <th class="text-end">Rata-rata Deal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($marketing as $m)
                        @php
                            $totalPendapatan = $m->kontrak_count * 100000; // contoh perhitungan pendapatan
                            $tingkatKonversi = $m->kontrak_count > 0 ? ($m->kontrak_count / 12) * 100 : 0; // misal 12 prospek
                            $rataDeal = $m->kontrak_count > 0 ? $totalPendapatan / $m->kontrak_count : 0;
                        @endphp
                        <tr>
                            <td>{{ $m->name }}</td>
                            <td class="text-end"><span class="badge bg-primary">{{ $m->kontrak_count }}</span></td>
                            <td class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($tingkatKonversi, 1) }}%</td>
                            <td class="text-end">Rp {{ number_format($rataDeal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- CARD 2 Grafik (Statis) --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Perbandingan Kinerja</h5>
        </div>
        <div class="card-body">

            {{-- Gambar statis chart (placeholder) --}}
            <div class="text-center p-4">
                <img src="https://via.placeholder.com/600x300?text=Bar+Chart+Statis" 
                     class="img-fluid rounded" alt="Bar Chart">
            </div>

        </div>
    </div>

</div>
@endsection