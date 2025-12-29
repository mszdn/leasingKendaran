@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">

        <div class="mb-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-2">
            <div>
                <h2 class="text-dark mb-1">Laporan Pendapatan</h2>
                <p class="text-muted">Analisis dan tren pendapatan terperinci.</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('export.PendapatanBulanan') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-download me-2"></i> Ekspor Excel
                </a>
            </div>
        </div>

        {{-- =================== KARTU CHART =================== --}}
        <div class="card mb-4 shadow-sm">
            <div
                class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <div>
                    <h5 class="mb-0">Rincian Pendapatan</h5>
                    <small class="text-muted">Metrik kinerja bulanan</small>
                </div>
            </div>
            <div class="card-body">
                <div style="height:220px; max-height:40vh;">
                    <canvas id="pendapatanChart"></canvas>
                </div>
            </div>
        </div>

        {{-- =================== TABEL DETAIL =================== --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Detail Bulanan</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0" id="pendapatanTable">
                        <thead class="table-light">
                            <tr>
                                <th>Bulan</th>
                                <th class="text-end">Pendapatan</th>
                                <th class="text-end">Target</th>
                                <th class="text-end">Selisih</th>
                                <th class="text-end">Pencapaian</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pendapatanBulanan as $data)
                                @php
                                    $bulan = \Carbon\Carbon::create()->month($data->bulan)->format('M');
                                    $revenue = $data->total ?? 0;
                                    $target = 500000000;
                                    $variance = $revenue - $target;
                                    $achievement = $target > 0 ? ($revenue / $target) * 100 : 0;
                                @endphp
                                <tr>
                                    <td>{{ $bulan }}</td>
                                    <td class="text-end">Rp {{ number_format($revenue, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($target, 0, ',', '.') }}</td>
                                    <td class="text-end">
                                        <span class="{{ $variance >= 0 ? 'text-success' : 'text-danger' }}">
                                            Rp {{ number_format(abs($variance), 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge {{ $achievement >= 100 ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ number_format($achievement, 1) }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <style>
            /* Small-screen table tweaks while keeping horizontal scroll */
            @media (max-width: 576px) {
                #pendapatanTable {
                    min-width: 560px;
                }

                .table thead th,
                .table tbody td {
                    font-size: .78rem;
                    padding: .32rem .4rem;
                    white-space: normal;
                    word-break: break-word;
                }

                .table-responsive {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }

                .table-responsive::-webkit-scrollbar {
                    height: 6px;
                }

                .table-responsive::-webkit-scrollbar-thumb {
                    background: rgba(0, 0, 0, 0.12);
                    border-radius: 3px;
                }
            }
        </style>

        {{-- ================== CHART SCRIPT ================== --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const pendapatanBulanan = @json($pendapatanBulanan);

                const labels = pendapatanBulanan.map(item =>
                    new Date(0, item.bulan - 1).toLocaleString('id-ID', { month: 'short' })
                );

                const values = pendapatanBulanan.map(item => item.total);

                const ctx = document.getElementById('pendapatanChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan Bulanan',
                            data: values,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 500000000, // set max ke 1 miliar
                                ticks: {
                                    callback: (value) => 'Rp ' + value.toLocaleString('id-ID')
                                }
                            }
                        }

                    }
                });
            });
        </script>
@endsection