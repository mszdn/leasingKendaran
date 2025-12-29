@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        {{-- ===== HEADER ===== --}}
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Dashboard Manajer</h2>
                <p class="text-muted">Gambaran menyeluruh tentang kinerja bisnis dan analitik.</p>
            </div>
        </div>

        {{-- ===== TOP CARDS ===== --}}
        <div class="row g-3 mb-4">

            {{-- Total Pendapatan --}}
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total Pendapatan (YTD)</p>
                        <h4 class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                        <small class="text-success">+18.2% dari periode lalu</small>
                    </div>
                </div>
            </div>

            {{-- Kontrak Aktif --}}
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <p class="text-muted mb-1">Kontrak Aktif</p>
                        <h4 class="fw-bold">{{ $kontrakAktif }}</h4>
                        <small class="text-success">+8.4% dari bulan lalu</small>
                    </div>
                </div>
            </div>

            {{-- Pembayaran Terlambat --}}
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <p class="text-muted mb-1">Pembayaran Terlambat</p>
                        <h4 class="fw-bold">{{ $pembayaranTerlambat }}</h4>
                        <small class="text-danger">
                            Rp {{ number_format($pembayaranTerlambat * 100000, 0, ',', '.') }} tertunggak
                        </small>
                    </div>
                </div>
            </div>

            {{-- Tingkat Penagihan --}}
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <p class="text-muted mb-1">Tingkat Penagihan</p>
                        <h4 class="fw-bold">0.0%</h4>
                        <small class="text-success">Di atas target (0%)</small>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== TREND & PIE CHART ===== --}}
        <div class="row g-3 mb-4">

            {{-- Line Chart --}}
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0">Tren Pendapatan Bulanan</h6>
                            <small class="text-muted">Perbandingan Pendapatan vs Target</small>
                        </div>
                        <a href="{{ route('export.PendapatanBulanan') }}" class="btn btn-light border shadow-sm btn-sm">
                            <i class="bi bi-download"></i> Ekspor
                        </a>
                    </div>

                    <div class="card-body">
                        <div style="height:220px; max-height:40vh;">
                            <canvas id="incomeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pie Chart --}}
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Kontrak per Status</h6>
                        <small class="text-muted">Gambaran distribusi</small>
                    </div>
                    <div class="card-body">
                        <div style="height:220px; max-height:40vh;">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== BAR CHART + TABLE ===== --}}
        <div class="row g-3 mb-4">

            {{-- Bar Chart --}}
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Statistik Pembayaran Terlambat</h6>
                        <small class="text-muted">Rincian per periode keterlambatan</small>
                    </div>
                    <div class="card-body">
                        <div style="height:200px; max-height:36vh;">
                            <canvas id="latePaymentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Marketing Table --}}
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Staf Marketing Terbaik</h6>
                        <small class="text-muted">Kinerja berdasarkan kontrak baru</small>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th class="text-end">Kontrak</th>
                                    <th class="text-end">Tingkat Konv.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topMarketing as $m)
                                    <tr>
                                        <td>{{ $m['nama'] }}</td>
                                        <td class="text-end">
                                            <span class="badge bg-secondary">{{ $m['jumlahKontrak'] }}</span>
                                        </td>
                                        <td class="text-end">{{ $m['tingkatKonversi'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>

    {{-- ===== CHART.JS CDN ===== --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- ===== CHART SCRIPTS ===== --}}
    @php
        // Pastikan $kategoriTerlambat ada dan default 0
        $barChartData = [
            $kategoriTerlambat['0_7'] ?? 0,
            $kategoriTerlambat['8_15'] ?? 0,
            $kategoriTerlambat['16_30'] ?? 0,
            $kategoriTerlambat['30_up'] ?? 0,
        ];
    @endphp

    <script>
        // ===== LINE CHART =====
        new Chart(document.getElementById("incomeChart"), {
            type: "line",
            data: {
                labels: {!! json_encode($labelBulan) !!},
                datasets: [{
                    label: "Pendapatan",
                    data: {!! json_encode($dataPendapatan) !!},
                    borderWidth: 3,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: "bottom" }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0, // nilai minimum
                        max: 500000000, // nilai maksimum (misalnya 1 miliar)
                        ticks: {
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }


        });

        // ===== PIE CHART =====
        new Chart(document.getElementById("statusChart"), {
            type: "pie",
            data: {
                labels: ['aktif', 'selesai', 'terlambat'],
                datasets: [{
                    data: [
                                    {{ $statusKontrak['aktif'] ?? 0 }},
                                    {{ $statusKontrak['selesai'] ?? 0 }},
                        {{ $statusKontrak['terlambat'] ?? 0 }}
                    ],
                    backgroundColor: ['#0d6efd', '#198754', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: "bottom" } }
            }
        });

        // ===== BAR CHART =====
        new Chart(document.getElementById("latePaymentChart"), {
            type: "bar",
            data: {
                labels: ["0–7 hari", "8–15 hari", "16–30 hari", ">30 hari"],
                datasets: [{
                    label: "Jumlah Terlambat",
                    data: @json($barChartData),
                    backgroundColor: '#0d6efd',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: "bottom" }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>

@endsection