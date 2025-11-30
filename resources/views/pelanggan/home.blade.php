@extends('layouts.app')

@section('content')
<div class="container my-4">

    <div class="mb-4">
        <h2>Kontrak Leasing Saya</h2>
        <p class="text-muted">Lihat dan kelola kontrak leasing aktif Anda.</p>
    </div>

    {{-- Jika ada kontrak --}}
    @if ($contracts->count() > 0)

        @foreach ($contracts as $c)

            @php
                $total = $c->angsuran->count();
                $lunas = $c->angsuran->where('status_angsuran', 'lunas')->count();
                $belum = $total - $lunas;
                $progres = $total > 0 ? round(($lunas / $total) * 100) : 0;

                $next = $c->angsuran
                    ->where('status_angsuran', 'belum bayar')
                    ->sortBy('tanggal_jatuh_tempo')
                    ->first();
            @endphp

            {{-- Ringkasan Kontrak --}}
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <small class="text-muted">Pembayaran Berikutnya</small>
                        <h5 class="mt-2">
                            {{ $next?->tanggal_jatuh_tempo 
                                ? date('d M Y', strtotime($next->tanggal_jatuh_tempo)) 
                                : '-' }}
                        </h5>
                        <p class="text-muted">
                            {{ $c->angsuran_per_bulan ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <small class="text-muted">Sisa Saldo</small>
                        <h5 class="mt-2">
                            {{ $belum > 0 ? $belum * $c->angsuran_per_bulan : '-' }}
                        </h5>
                        <p class="text-muted">
                            {{ $belum > 0 ? $belum . ' cicilan tersisa' : '-' }}
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <small class="text-muted">Status Kontrak</small>
                        <h5 class="mt-2">{{ $c->status_kontrak ?? '-' }}</h5>
                        <p class="text-muted">Status baik</p>
                    </div>
                </div>
            </div>

            {{-- Detail Kontrak --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5>
                            <i class="bi bi-car-front me-2 text-primary"></i>
                            {{ $c->kendaraan->merk ?? '-' }}
                            {{ $c->kendaraan->tipe ?? '' }}
                            {{ $c->kendaraan->tahun ?? '' }}
                        </h5>
                        <small>ID Kontrak: {{ $c->nomor_kontrak ?? '-' }}</small>
                    </div>
                    <span class="badge bg-success">{{ $c->status_kontrak ?? '-' }}</span>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">Periode Kontrak</p>
                            <p>
                                {{ $c->tanggal_mulai ? date('d M Y', strtotime($c->tanggal_mulai)) : '-' }}
                                s/d
                                {{ $c->tanggal_selesai ? date('d M Y', strtotime($c->tanggal_selesai)) : '-' }}
                            </p>

                            <p class="text-muted mb-0">Cicilan Bulanan</p>
                            <p>{{ $c->angsuran_per_bulan ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted mb-0">Jatuh Tempo Berikutnya</p>
                            <p>
                                {{ $next?->tanggal_jatuh_tempo 
                                    ? date('d M Y', strtotime($next->tanggal_jatuh_tempo)) 
                                    : '-' }}
                            </p>

                            <p class="text-muted mb-0">Progres Pembayaran</p>
                            <p>
                                {{ $lunas }} dari {{ $total }} cicilan terbayar
                            </p>
                        </div>
                    </div>

                    {{-- Progress --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Progres Kontrak</small>
                            <small>{{ $progres }}%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $progres }}%"></div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <a href="{{ route('pelanggan.bayar') }}" class="btn btn-primary">
                        <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                    </a>
                    <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-outline-secondary">
                        Lihat Riwayat Bayar
                    </a>
                </div>
            </div>

        @endforeach

    @else
        {{-- Tidak ada data sama sekali --}}
        <div class="alert alert-info">
            Anda belum memiliki kontrak leasing.
        </div>

        <div class="card p-4">
            <h5 class="text-center text-muted">Tidak Ada Kontrak</h5>

            <div class="row text-center mt-3">

                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <small class="text-muted">Pembayaran Berikutnya</small>
                        <h5 class="mt-2">-</h5>
                        <p class="text-muted">-</p>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <small class="text-muted">Sisa Saldo</small>
                        <h5 class="mt-2">-</h5>
                        <p class="text-muted">-</p>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <small class="text-muted">Status Kontrak</small>
                        <h5 class="mt-2">-</h5>
                        <p class="text-muted">-</p>
                    </div>
                </div>

            </div>

        </div>

    @endif

</div>
@endsection
