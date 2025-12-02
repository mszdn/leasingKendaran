@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Judul --}}
        <div class="mb-4">
            <h2 class="text-dark mb-1">Analitik Kontrak</h2>
            <p class="text-muted">Statistik dan analisis kontrak leasing.</p>
        </div>

        {{-- GRID STATISTIK DINAMIS --}}
        <div class="row g-4 mb-4">
            @php
                $statusCounts = [
                    'aktif' => $kontrak->where('status_verifikasi', 'approved')->count(),
                    'selesai' => $kontrak->where('status_verifikasi', 'selesai')->count(),
                    'pending' => $kontrak->where('status_verifikasi', 'pending')->count(),
                    'dibatalkan' => $kontrak->where('status_verifikasi', 'dibatalkan')->count()
                ];
            @endphp

            @foreach($statusCounts as $status => $count)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <span class="text-muted small">{{ ucfirst($status) }}</span>
                        </div>
                        <div class="card-body">
                            <div class="fs-3 text-dark">{{ $count }}</div>
                            <p class="text-muted small mb-0">kontrak</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- TABEL KONTRAK --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Kontrak Leasing</h5>
                <small class="text-muted">Detail kontrak beserta pelanggan dan kendaraan</small>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Total Pembayaran</th>
                            <th>Status Verifikasi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kontrak as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $k->nama_lengkap ?? '-' }}</td>
                                <td>
                                    @if($k->kendaraan)
                                        {{ $k->kendaraan->merk ?? '-' }} ({{ $k->kendaraan->tipe ?? '-' }})
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>Rp {{ number_format($k->total_pembayaran, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($k->status_verifikasi) }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_mulai)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_selesai)->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada kontrak tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PIE CHART DINAMIS --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Distribusi Status Kontrak</h5>
                <small class="text-muted">Gambaran menyeluruh dari semua kontrak</small>
            </div>

            <div class="card-body">
                <div style="height: 380px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('pieChart');

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Aktif', 'Selesai', 'Pending', 'Dibatalkan'],
                        datasets: [{
                            data: [
                            {{ $statusCounts['aktif'] }},
                            {{ $statusCounts['selesai'] }},
                            {{ $statusCounts['pending'] }},
                                {{ $statusCounts['dibatalkan'] }}
                            ],
                            backgroundColor: [
                                '#4caf50',
                                '#2196f3',
                                '#ff9800',
                                '#f44336'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,  // WAJIB dibuka biar bisa full height
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            });
        </script>

@endsection