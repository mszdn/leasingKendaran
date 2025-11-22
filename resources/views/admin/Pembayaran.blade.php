@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1 class="mb-3">Pembayaran</h1>
        <p>Selamat datang, {{ auth()->user()->username }}</p>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Manajemen Pembayaran</h5>
                    <small class="text-muted">3 pembayaran tercatat dalam sistem</small>
                </div>

                <!-- Tombol Tambah Pembayaran -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPembayaran">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Pembayaran Manual
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Pelanggan</th>
                                <th>No. Kontrak</th>
                                <th>Angsuran Ke-</th>
                                <th>Jumlah Bayar</th>
                                <th>Denda</th>
                                <th>Total</th>
                                <th>Tgl. Jatuh Tempo</th>
                                <th>Tgl. Bayar</th>
                                <th>Metode</th>
                                <th>Bukti</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Baris Dummy 1 -->
                            <tr>
                                <td>
                                    <i class="bi bi-credit-card me-1 text-secondary"></i>
                                    <span class="font-monospace">ANG-001</span>
                                </td>
                                <td>Ahmad Putra</td>
                                <td>
                                    <i class="bi bi-file-text me-1 text-secondary"></i>
                                    KTR-001
                                </td>
                                <td><span class="badge bg-secondary">1</span></td>
                                <td>Rp 2.300.000</td>
                                <td><span class="text-muted">-</span></td>
                                <td><strong>Rp 2.300.000</strong></td>
                                <td>
                                    <i class="bi bi-calendar me-1 text-secondary"></i>
                                    01 Jan
                                </td>
                                <td>01 Jan 2024</td>
                                <td>
                                    <span class="badge bg-outline border text-dark">🏦 Transfer</span>
                                </td>
                                <td><span class="text-muted">-</span></td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Lunas
                                    </span>
                                </td>
                            </tr>

                            <!-- Baris Dummy 2 -->
                            <tr>
                                <td>
                                    <i class="bi bi-credit-card me-1 text-secondary"></i>
                                    <span class="font-monospace">ANG-002</span>
                                </td>
                                <td>Dina Lestari</td>
                                <td>
                                    <i class="bi bi-file-text me-1 text-secondary"></i>
                                    KTR-002
                                </td>
                                <td><span class="badge bg-secondary">2</span></td>
                                <td>Rp 1.900.000</td>
                                <td>
                                    <span class="text-danger fw-bold">Rp 100.000</span>
                                </td>
                                <td><strong>Rp 2.000.000</strong></td>
                                <td>
                                    <i class="bi bi-calendar me-1 text-secondary"></i>
                                    10 Feb
                                </td>
                                <td>—</td>
                                <td><span class="badge bg-outline border">📱 E-Wallet</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Lihat
                                    </button>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-clock me-1"></i> Tertunda
                                    </span>
                                </td>
                            </tr>

                            <!-- Baris Dummy 3 -->
                            <tr>
                                <td>
                                    <i class="bi bi-credit-card me-1 text-secondary"></i>
                                    <span class="font-monospace">ANG-003</span>
                                </td>
                                <td>Budi Santoso</td>
                                <td>
                                    <i class="bi bi-file-text me-1 text-secondary"></i>
                                    KTR-003
                                </td>
                                <td><span class="badge bg-secondary">3</span></td>
                                <td>Rp 2.000.000</td>
                                <td><span class="text-muted">-</span></td>
                                <td><strong>Rp 2.000.000</strong></td>
                                <td>
                                    <i class="bi bi-calendar me-1 text-secondary"></i>
                                    15 Mar
                                </td>
                                <td>15 Mar 2024</td>
                                <td><span class="badge bg-outline border">💵 Tunai</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Lihat
                                    </button>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Lunas
                                    </span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH PEMBAYARAN -->
    <div class="modal fade" id="modalTambahPembayaran" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pembayaran Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Pilih Kontrak *</label>
                            <select class="form-select">
                                <option>Pilih kontrak leasing</option>
                                <option>KTR-001 - Ahmad Putra</option>
                                <option>KTR-002 - Dina Lestari</option>
                                <option>KTR-003 - Budi Santoso</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Angsuran Ke *</label>
                            <input type="number" class="form-control" placeholder="1">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah Bayar (Rp) *</label>
                            <input type="number" class="form-control" placeholder="7500000">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Denda (Rp)</label>
                            <input type="number" class="form-control" placeholder="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Bayar *</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Jatuh Tempo *</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Metode Pembayaran *</label>
                            <select class="form-select">
                                <option value="">Pilih metode</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="cash">Tunai</option>
                                <option value="ewallet">E-Wallet</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status Pembayaran *</label>
                            <select class="form-select">
                                <option value="lunas">Lunas</option>
                                <option value="tertunda">Tertunda</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Simpan Pembayaran
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection