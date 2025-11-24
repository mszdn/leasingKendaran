@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1 class="mb-3">Kontrak Leasing</h1>
        <p>Selamat datang, {{ auth()->user()->username }}</p>

        <div class="mb-4">
            <h4 class="mb-1">Kontrak Leasing</h4>
            <p class="text-muted">{{ $kontrak->count() }} kontrak dalam sistem</p>
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
                            @foreach ($kontrak as $k)
                                <tr>
                                    <td><i class="bi bi-file-text text-secondary me-1"></i>{{ $k->nomor_kontrak }}</td>
                                    <td>{{ $k->pelanggan?->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $k->kendaraan?->nama_kendaraan ?? '-' }}</td>
                                    <td><i class="bi bi-calendar text-secondary me-1"></i>{{ $k->tenor_bulan }} bulan</td>
                                    <td>Rp {{ number_format($k->dp_amount, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($k->angsuran_per_bulan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($k->total_pembayaran, 0, ',', '.') }}</td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($k->tanggal_mulai)->format('d/m/Y') }}</div>
                                        <small class="text-muted">s/d
                                            {{ \Carbon\Carbon::parse($k->tanggal_selesai)->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge 
                                                            @if($k->status_kontrak == 'aktif') bg-success
                                                            @elseif($k->status_kontrak == 'selesai') bg-primary
                                                            @else bg-danger @endif">
                                            {{ $k->status_kontrak }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                                            @if($k->status_verifikasi == 'pending') bg-warning text-dark
                                                            @elseif($k->status_verifikasi == 'approved') bg-success
                                                            @else bg-danger @endif">
                                            {{ $k->status_verifikasi }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if($k->status_verifikasi == 'pending')
                                                <form action="{{ route('admin.KontrakLeasing.verifikasi', $k->kontrak_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-success btn-sm">
                                                        <i class="bi bi-check-circle me-1"></i> Verifikasi
                                                    </button>
                                                </form>
                                            @endif
                                            <button class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection