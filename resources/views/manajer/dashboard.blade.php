@extends('layouts.app')

@section('content')
<div>
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="text-dark mb-1">Dashboard Manajer</h2>
            <p class="text-muted">Gambaran menyeluruh tentang kinerja bisnis dan analitik.</p>
        </div>

        <select class="form-select w-auto">
            <option value="weekly">Mingguan</option>
            <option value="monthly">Bulanan</option>
            <option value="quarterly">Kuartalan</option>
            <option value="yearly">Tahunan</option>
        </select>
    </div>

    {{-- ===== KARTU RINGKASAN ===== --}}
    <div class="row g-3 mb-4">

        {{-- TOTAL PENDAPATAN --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Pendapatan (YTD)</h6>
                    <h4 class="text-dark">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h4>
                    <p class="text-success small mt-1">+18.2% dari periode lalu</p>
                </div>
            </div>
        </div>

        {{-- KONTRAK AKTIF --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Kontrak Aktif</h6>
                    <h4 class="text-dark">{{ $kontrakAktif }}</h4>
                    <p class="text-success small mt-1">+8.4% dari bulan lalu</p>
                </div>
            </div>
        </div>

        {{-- PEMBAYARAN TERLAMBAT --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Pembayaran Terlambat</h6>
                    <h4 class="text-dark">{{ $pembayaranTerlambat }}</h4>
                    <p class="text-danger small mt-1">
                        Rp {{ number_format($pembayaranTerlambat * 100000, 0, ',', '.') }} tertunggak
                    </p>
                </div>
            </div>
        </div>

        {{-- TINGKAT PENAGIHAN --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Tingkat Penagihan</h6>
                    <h4 class="text-dark">{{ number_format(0, 1) }}%</h4>
                    <p class="text-success small mt-1">Di atas target (95%)</p>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== CHART PENGGANTI (STATIC) ===== --}}
    <div class="row g-3 mb-4">

        {{-- Placeholder Chart --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h6 class="mb-0">Tren Pendapatan Bulanan</h6>
                        <small class="text-muted">Perbandingan Pendapatan vs Target</small>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm">Ekspor</button>
                </div>
                <div class="card-body">
                    <div class="bg-light border rounded p-5 text-center text-muted">
                        (Chart Placeholder)
                    </div>
                </div>
            </div>
        </div>

        {{-- Pie Chart Placeholder --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">Kontrak per Status</h6>
                    <small class="text-muted">Gambaran distribusi</small>
                </div>
                <div class="card-body">
                    <div class="bg-light border rounded p-5 text-center text-muted">
                        (Pie Chart Placeholder)
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== STATISTIK + TABEL ===== --}}
    <div class="row g-3">

        {{-- Late payments chart placeholder --}}
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">Statistik Pembayaran Terlambat</h6>
                    <small class="text-muted">Rincian per periode keterlambatan</small>
                </div>
                <div class="card-body">
                    <div class="bg-light border rounded p-4 text-center text-muted">
                        (Bar Chart Placeholder)
                    </div>
                </div>
            </div>
        </div>

        {{-- Marketing Table --}}
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">Staf Marketing Terbaik</h6>
                    <small class="text-muted">Kinerja berdasarkan kontrak baru</small>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
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
                                    <td class="text-end">{{ number_format(0, 1) }}%</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection