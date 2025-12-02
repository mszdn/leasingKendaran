@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah Kontrak Leasing</h5>
                <small class="text-muted">Buat kontrak leasing baru untuk pelanggan</small>
            </div>

            <div class="card-body">

                <!-- Pesan sukses -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Pesan error validasi -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('marketing.kontrak.store') }}" method="POST" class="row g-4">
                    @csrf

                    <div class="col-md-6">
                        <label class="form-label">Nomor Kontrak</label>
                        <input type="text" name="nomor_kontrak" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pelanggan</label>
                        <select name="pelanggan_id" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggan as $p)
                                <option value="{{ $p->pelanggan_id }}">{{ $p->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kendaraan</label>
                        <select name="kendaraan_id" class="form-select" required>
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach ($kendaraan as $kd)
                                <option value="{{ $kd->kendaraan_id }}">{{ $kd->merk }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tenor (bulan)</label>
                        <input type="number" name="tenor_bulan" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">DP (Down Payment)</label>
                        <input type="number" name="dp_amount" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Total Pembayaran</label>
                        <input type="number" name="total_pembayaran" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status Kontrak</label>
                        <select name="status_kontrak" class="form-select" required>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                            <option value="terlambat">Terlambat</option>
                        </select>
                    </div>

                    <div class="alert alert-info mt-3">
                        Angsuran bulanan & tanggal mulai/selesai akan dihitung otomatis saat kontrak dibuat.
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <input type="hidden" name="marketing_id" value="{{ Auth::id() }}">
                        <a href="{{ url('/marketing/dashboard') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Kontrak</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection