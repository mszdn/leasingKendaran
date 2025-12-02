@extends('layouts.app')

@section('content')
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="text-dark mb-1">Laporan Pendapatan</h2>
            <p class="text-muted">Analisis dan tren pendapatan terperinci.</p>
        </div>

        <div class="d-flex gap-2">
            <div class="d-flex gap-2">
                <a href="{{ route('export.PendapatanBulanan') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-download me-2"></i> Ekspor Excel
                </a>
            </div>

        </div>
    </div>

    {{-- =================== KARTU CHART =================== --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Rincian Pendapatan</h5>
            <small class="text-muted">Metrik kinerja bulanan</small>
        </div>
        <div class="card-body">

            {{-- CANVAS CHART --}}
            <canvas id="pendapatanChart" height="120"></canvas>

        </div>
    </div>

    {{-- =================== TABEL DETAIL =================== --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Detail Bulanan</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover mb-0">
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