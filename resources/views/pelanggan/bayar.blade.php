@extends('layouts.app')

@section('content')
    <div class="container my-4">

        <div class="mb-4">
            <h2>Bayar Cicilan Online</h2>
            <p class="text-muted">Lakukan pembayaran untuk kontrak leasing Anda.</p>
        </div>

        <div class="row">

            <!-- FORM PEMBAYARAN -->
            <div class="col-12 col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-1">Detail Pembayaran</h5>
                        <small class="text-muted">Selesaikan pembayaran Anda dengan aman</small>
                    </div>

                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('pelanggan.bayar.process') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Hidden Kontrak ID -->
                            <input type="hidden" name="kontrak_id" value="{{ $kontrak->kontrak_id }}">

                            <!-- PILIH KONTRAK -->
                            <div class="mb-3">
                                <label class="form-label">Pilih Kontrak</label>
                                <select class="form-select" disabled>
                                    <option selected>
                                        {{ $kontrak->kontrak_id }} - {{ $kontrak->kendaraan->nama_kendaraan }}
                                    </option>
                                </select>
                            </div>

                            <!-- METODE PEMBAYARAN -->
                            <div class="mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <select class="form-select" name="metode_pembayaran" required>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="cash">Cash / Tunai</option>
                                    <option value="ewallet">E-Wallet (Dana, OVO, dll)</option>
                                </select>
                            </div>

                            <!-- Upload Bukti Pembayaran -->
                            <div class="mb-3">
                                <label class="form-label">Upload Bukti Pembayaran</label>
                                <input type="file" name="bukti_pembayaran" class="form-control" required>
                            </div>

                            <!-- SUBMIT -->
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-credit-card me-1"></i>
                                Bayar Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <!-- RINGKASAN PEMBAYARAN -->
            <div class="col-12 col-lg-4">

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ringkasan Pembayaran</h5>
                    </div>

                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col-6 text-muted">ID Kontrak</div>
                            <div class="col-6 text-end">{{ $kontrak->kontrak_id }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6 text-muted">Kendaraan</div>
                            <div class="col-6 text-end">{{ $kontrak->kendaraan->nama_kendaraan }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6 text-muted">Angsuran Ke</div>
                            <div class="col-6 text-end">{{ $angsuran->angsuran_ke }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6 text-muted">Jatuh Tempo</div>
                            <div class="col-6 text-end">{{ date('d M Y', strtotime($angsuran->tanggal_jatuh_tempo)) }}</div>
                        </div>

                        <hr>

                        <div class="row mb-2">
                            <div class="col-6 text-muted">Jumlah Tagihan</div>
                            <div class="col-6 text-end">Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6 text-muted">Denda</div>
                            <div class="col-6 text-end">Rp {{ number_format($angsuran->denda, 0, ',', '.') }}</div>
                        </div>

                        <hr>

                        <div class="row fw-bold">
                            <div class="col-6">Total</div>
                            <div class="col-6 text-end">Rp
                                {{ number_format($angsuran->jumlah_bayar + $angsuran->denda, 0, ',', '.') }}</div>
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