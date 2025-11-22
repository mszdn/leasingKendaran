@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1 class="mb-3">Kontrak Leasing</h1>
        <p>Selamat datang, {{ auth()->user()->username }}</p>

        <div class="mb-4">
            <h4 class="mb-1">Kontrak Leasing</h4>
            <p class="text-muted">3 kontrak leasing dalam sistem</p>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No. Kontrak</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Tenor</th>
                                <th>DP</th>
                                <th>Angsuran/Bulan</th>
                                <th>Total</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Baris 1 -->
                            <tr>
                                <td>
                                    <i class="bi bi-file-text text-secondary me-1"></i>
                                    KTR-001
                                </td>
                                <td>Ahmad Putra</td>
                                <td>Toyota Camry 2024</td>
                                <td>
                                    <i class="bi bi-calendar text-secondary me-1"></i>
                                    12 bulan
                                </td>
                                <td>Rp 5.000.000</td>
                                <td>Rp 2.300.000</td>
                                <td>Rp 32.000.000</td>
                                <td>
                                    <div>01/01/2024</div>
                                    <small class="text-muted">s/d 01/01/2025</small>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i> aktif
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-clock me-1"></i> pending
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle me-1"></i> Verifikasi
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Baris 2 -->
                            <tr>
                                <td>
                                    <i class="bi bi-file-text text-secondary me-1"></i>
                                    KTR-002
                                </td>
                                <td>Dina Lestari</td>
                                <td>Honda Accord 2024</td>
                                <td>
                                    <i class="bi bi-calendar text-secondary me-1"></i>
                                    24 bulan
                                </td>
                                <td>Rp 8.000.000</td>
                                <td>Rp 1.900.000</td>
                                <td>Rp 54.000.000</td>
                                <td>
                                    <div>10/02/2024</div>
                                    <small class="text-muted">s/d 10/02/2026</small>
                                </td>
                                <td>
                                    <span class="badge bg-primary">selesai</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i> approved
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Baris 3 -->
                            <tr>
                                <td>
                                    <i class="bi bi-file-text text-secondary me-1"></i>
                                    KTR-003
                                </td>
                                <td>Budi Santoso</td>
                                <td>Ford Escape 2024</td>
                                <td>
                                    <i class="bi bi-calendar text-secondary me-1"></i>
                                    18 bulan
                                </td>
                                <td>Rp 6.000.000</td>
                                <td>Rp 2.000.000</td>
                                <td>Rp 40.000.000</td>
                                <td>
                                    <div>15/03/2024</div>
                                    <small class="text-muted">s/d 15/09/2025</small>
                                </td>
                                <td>
                                    <span class="badge bg-danger">cancelled</span>
                                </td>
                                <td>
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i> rejected
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection