@extends('layouts.app')

@section('content')
    <div class="container mt-4">


        <h1 class="mb-3">Kontrak Leasing</h1>
        <p>Selamat datang, {{ auth()->user()->username }}</p>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="">
                    <h4 class="mb-1">Kontrak Leasing</h4>
                    <p class="text-muted">{{ $kontrak->count() }} kontrak dalam sistem</p>
                </div>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateKontrak">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Kontrak
                </button>

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
                                    <th>Status Kontrak</th>
                                    <th>Verifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kontrak as $k)
                                    <tr>
                                        <td><i class="bi bi-file-text text-secondary me-1"></i>{{ $k->nomor_kontrak }}</td>
                                        <td>{{ $k->pelanggan?->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $k->kendaraan?->merk ?? '-' }}</td>
                                        <td><i class="bi bi-calendar text-secondary me-1"></i>{{ $k->tenor_bulan }} bulan</td>
                                        <td>Rp {{ number_format($k->dp_amount, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($k->angsuran_per_bulan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($k->total_pembayaran, 0, ',', '.') }}</td>
                                        <td>
                                            <div>{{ \Carbon\Carbon::parse($k->tanggal_mulai)->format('d/m/Y') }}</div>
                                            <small class="text-muted">s/d
                                                {{ \Carbon\Carbon::parse($k->tanggal_selesai)->format('d/m/Y') }}</small>
                                        </td>

                                        {{-- STATUS KONTRAK DROPDOWN --}}
                                        <td>
                                            <form action="{{ route('kontrak.update', $k->kontrak_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status_kontrak" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="aktif" @selected($k->status_kontrak == 'aktif')>Aktif</option>
                                                    <option value="selesai" @selected($k->status_kontrak == 'selesai')>Selesai
                                                    </option>
                                                    <option value="terlambat" @selected($k->status_kontrak == 'terlambat')>
                                                        Terlambat
                                                    </option>
                                                </select>
                                            </form>
                                        </td>

                                        {{-- STATUS VERIFIKASI --}}
                                        <td>
                                            <span class="badge 
                                                                                            @if($k->status_verifikasi == 'pending') bg-warning text-dark
                                                                                            @elseif($k->status_verifikasi == 'approved') bg-success
                                                                                            @else bg-danger @endif">
                                                {{ $k->status_verifikasi }}
                                            </span>
                                        </td>

                                        {{-- Aksi --}}
                                        <td>
                                            <div class="d-flex gap-2">

                                                {{-- Tombol Edit --}}
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modalEdit{{ $k->kontrak_id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                {{-- Tombol Delete --}}
                                                <form action="{{ route('kontrak.delete', $k->kontrak_id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus kontrak ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>

                                                {{-- Approve / Reject --}}
                                                @if($k->status_verifikasi == 'pending')
                                                    <form action="{{ route('admin.KontrakLeasing.verifikasi', $k->kontrak_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-success btn-sm">
                                                            <i class="bi bi-check-circle"></i>
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.KontrakLeasing.reject', $k->kontrak_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-warning btn-sm">
                                                            <i class="bi bi-x-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </td>

                                    </tr>

                                    {{-- MODAL EDIT PER KONTRAK --}}
                                    <div class="modal fade" id="modalEdit{{ $k->kontrak_id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Kontrak #{{ $k->nomor_kontrak }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form action="{{ route('kontrak.update', $k->kontrak_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body row g-3">

                                                        <div class="col-md-6">
                                                            <label class="form-label">Nomor Kontrak</label>
                                                            <input type="text" class="form-control" name="nomor_kontrak"
                                                                value="{{ $k->nomor_kontrak }}" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Pelanggan</label>
                                                            <select class="form-select" name="pelanggan_id" required>
                                                                @foreach ($pelanggan as $p)
                                                                    <option value="{{ $p->pelanggan_id }}"
                                                                        @selected($k->pelanggan_id == $p->pelanggan_id)>
                                                                        {{ $p->nama_lengkap }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Kendaraan</label>
                                                            <select class="form-select" name="kendaraan_id" required>
                                                                @foreach ($kendaraan as $kd)
                                                                    <option value="{{ $kd->kendaraan_id }}"
                                                                        @selected($k->kendaraan_id == $kd->kendaraan_id)>
                                                                        {{ $kd->merk }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="form-label">Tenor (bulan)</label>
                                                            <input type="number" class="form-control" name="tenor_bulan"
                                                                value="{{ $k->tenor_bulan }}" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label class="form-label">DP</label>
                                                            <input type="number" class="form-control" name="dp_amount"
                                                                value="{{ $k->dp_amount }}" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Angsuran / Bulan</label>
                                                            <input type="number" class="form-control" name="angsuran_per_bulan"
                                                                value="{{ $k->angsuran_per_bulan }}" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Total Pembayaran</label>
                                                            <input type="number" class="form-control" name="total_pembayaran"
                                                                value="{{ $k->total_pembayaran }}" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Status Kontrak</label>
                                                            <select name="status_kontrak" class="form-select">
                                                                <option value="aktif" @selected($k->status_kontrak == 'aktif')>
                                                                    Aktif
                                                                </option>
                                                                <option value="selesai"
                                                                    @selected($k->status_kontrak == 'selesai')>
                                                                    Selesai</option>
                                                                <option value="terlambat"
                                                                    @selected($k->status_kontrak == 'terlambat')>Terlambat
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Tanggal Mulai</label>
                                                            <input type="date" class="form-control" name="tanggal_mulai"
                                                                value="{{ $k->tanggal_mulai }}" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Tanggal Selesai</label>
                                                            <input type="date" class="form-control" name="tanggal_selesai"
                                                                value="{{ $k->tanggal_selesai }}" required>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button class="btn btn-warning">Update</button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CREATE KONTRAK --}}
    <div class="modal fade" id="modalCreateKontrak" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kontrak Leasing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('kontrak.store') }}" method="POST">
                    @csrf
                    <div class="modal-body row g-3">

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
                            <label class="form-label">DP</label>
                            <input type="number" name="dp_amount" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Angsuran / Bulan</label>
                            <input type="number" name="angsuran_per_bulan" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Total Pembayaran</label>
                            <input type="number" name="total_pembayaran" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status Kontrak</label>
                            <select name="status_kontrak" class="form-select" required>
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                                <option value="terlambat">Terlambat</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection