@extends('layouts.app')

@section('content')
<div class="container my-4">

    <!-- Header -->
    <div class="mb-4">
        <h2>Bayar Cicilan Online</h2>
        <p class="text-muted">Lakukan pembayaran untuk kontrak leasing Anda.</p>
    </div>

    <div class="row">

        <!-- FORM PEMBAYARAN -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">Detail Pembayaran</h5>
                    <small class="text-muted">Selesaikan pembayaran Anda dengan aman</small>
                </div>

                <div class="card-body">

                    <form action="#" method="POST">
                        @csrf

                        <!-- PILIH KONTRAK -->
                        <div class="mb-3">
                            <label class="form-label">Pilih Kontrak</label>
                            <select class="form-select" name="kontrak_id" disabled>
                                <option selected>
                                    202501 - Honda Beat Deluxe
                                </option>
                            </select>
                        </div>

                        <!-- METODE PEMBAYARAN -->
                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select class="form-select" name="metode" required>
                                <option value="Kartu Kredit">Kartu Kredit/Debit</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="PayPal">PayPal</option>
                            </select>
                        </div>

                        <!-- FORM DETAIL KARTU -->
                        <div class="p-3 mb-3 bg-light rounded">
                            <h6>Informasi Kartu</h6>

                            <div class="mb-2">
                                <label class="form-label">Nomor Kartu</label>
                                <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label class="form-label">Tanggal Kadaluarsa</label>
                                    <input type="text" class="form-control" placeholder="MM/YY">
                                </div>
                                <div class="col">
                                    <label class="form-label">CVV</label>
                                    <input type="password" class="form-control" placeholder="123" maxlength="3">
                                </div>
                            </div>

                            <div class="mt-2">
                                <label class="form-label">Nama Pemegang Kartu</label>
                                <input type="text" class="form-control" placeholder="John Doe">
                            </div>
                        </div>

                        <!-- SUBMIT -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-credit-card me-1"></i>
                            Bayar Rp 850.000
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <!-- RINGKASAN PEMBAYARAN -->
        <div class="col-lg-4">

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ringkasan Pembayaran</h5>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">ID Kontrak</span>
                        <span>202501</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Kendaraan</span>
                        <span>Honda Beat Deluxe</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Jatuh Tempo</span>
                        <span>15 Des 2025</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Jumlah Bulanan</span>
                        <span>Rp 850.000</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Biaya Proses</span>
                        <span>Rp 0</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total Jumlah</span>
                        <span>Rp 850.000</span>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle text-primary fs-4"></i>
                    <small class="text-muted">
                        Pembayaran Anda diproses dengan aman. Anda akan menerima konfirmasi setelah transaksi berhasil.
                    </small>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
