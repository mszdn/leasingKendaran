@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Judul --}}
        <div class="mb-4">
            <h2 class="text-dark mb-1">Kinerja Marketing</h2>
            <p class="text-muted">Metrik kinerja individu staf.</p>
        </div>

        {{-- CARD 1 --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Kinerja Staf Marketing</h5>
                    <small class="text-muted">Kontrak dan pendapatan per staf</small>
                </div>
                <a href="{{ route('export.MarketingPerformance') }}" class="btn btn-outline-primary">
                    <i class="bi bi-download me-2"></i> Export
                </a>
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
                                $totalPendapatan = $m['jumlahKontrak'] * 100000;
                                $rataDeal = $m['jumlahKontrak'] > 0 ? $totalPendapatan / $m['jumlahKontrak'] : 0;
                            @endphp
                            <tr>
                                <td>{{ $m['nama'] }}</td>
                                <td class="text-end"><span class="badge bg-primary">{{ $m['jumlahKontrak'] }}</span></td>
                                <td class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($m['tingkatKonversi'], 1) }}%</td>
                                <td class="text-end">Rp {{ number_format($rataDeal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        {{-- CARD 2 Grafik --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Perbandingan Kinerja</h5>
            </div>
            <div class="card-body">

                {{-- Canvas Chart.js --}}
                <canvas id="marketingChart" height="100"></canvas>

            </div>
        </div>

    </div>

    {{-- Load Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Chart Script --}}
    <script>
        const ctx = document.getElementById('marketingChart').getContext('2d');

        // Data array dari controller
        const labels = @json(array_column($marketing->toArray(), 'nama'));
        const dataKontrak = @json(array_column($marketing->toArray(), 'jumlahKontrak'));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Kontrak Baru',
                    data: dataKontrak,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

@endsection