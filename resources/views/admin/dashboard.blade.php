@extends('layouts.app')

@section('content')

    <div class="container mt-4">

        {{-- Header Dashboard --}}
        <div class="mb-4">
            <h2 class="text-dark fw-bold">Dashboard Admin</h2>
            <p class="text-muted">Selamat datang, {{ auth()->user()->username }}!</p>
        </div>

        {{-- Empat Card Statistik --}}
        <div class="row g-4 mb-4">

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Total Pelanggan</span>
                            <i class="bi bi-people text-primary"></i>
                        </div>
                        <h4 class="mt-2 mb-1 text-dark">1,248</h4>
                        <small class="text-success">
                            <i class="bi bi-graph-up"></i> +12% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Kontrak Aktif</span>
                            <i class="bi bi-file-earmark-text text-success"></i>
                        </div>
                        <h4 class="mt-2 mb-1 text-dark">342</h4>
                        <small class="text-success">
                            <i class="bi bi-graph-up"></i> +8% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Pendapatan Bulanan</span>
                            <i class="bi bi-cash-coin text-warning"></i>
                        </div>
                        <h4 class="mt-2 mb-1 text-dark">$248,500</h4>
                        <small class="text-success">
                            <i class="bi bi-graph-up"></i> +15% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Menunggu Verifikasi</span>
                            <i class="bi bi-check-circle text-warning"></i>
                        </div>
                        <h4 class="mt-2 mb-1 text-dark">23</h4>
                        <small class="text-muted">Memerlukan perhatian</small>
                    </div>
                </div>
            </div>

        </div>


        {{-- Tabel Kontrak Terbaru (STÁTIS) --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Kontrak Terbaru</h5>
                <small class="text-muted">Pengajuan terbaru yang memerlukan verifikasi</small>
            </div>

            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID Kontrak</th>
                            <th>Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        {{-- contoh data statis 1 --}}
                        <tr>
                            <td>CTR-001</td>
                            <td>Budi Santoso</td>
                            <td>Toyota Avanza</td>
                            <td>Rp 45.000.000</td>
                            <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                            <td>2025-01-12</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Verifikasi
                                </button>

                                <button class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>

                        {{-- contoh data statis 2 --}}
                        <tr>
                            <td>CTR-002</td>
                            <td>Agus Wijaya</td>
                            <td>Honda Brio</td>
                            <td>Rp 38.000.000</td>
                            <td><span class="badge bg-primary">Aktif</span></td>
                            <td>2025-01-15</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>

                        {{-- contoh data statis 3 --}}
                        <tr>
                            <td>CTR-003</td>
                            <td>Siti Nurhaliza</td>
                            <td>Mitsubishi Xpander</td>
                            <td>Rp 60.000.000</td>
                            <td><span class="badge bg-secondary">Terverifikasi</span></td>
                            <td>2025-01-18</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>

    </div>

@endsection