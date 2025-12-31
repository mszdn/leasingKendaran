@extends('layouts.app')

@section('content')
    <div class="container my-4">

        <div class="mb-4">
            <h2>Kontrak Leasing Saya</h2>
            <p class="text-muted">Lihat dan kelola kontrak leasing aktif Anda.</p>
        </div>

        @if ($contracts->count() > 0)

            @foreach ($contracts as $c)

                {{-- RINGKASAN KONTRAK --}}
                <div class="row mb-4">

                    {{-- Pembayaran Berikutnya --}}
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card p-3">
                            <small class="text-muted">Pembayaran Berikutnya</small>
                            <h5 class="mt-2">
                                {{ $c->next_due ? date('d M Y', strtotime($c->next_due->tanggal_jatuh_tempo)) : '-' }}
                            </h5>
                            <p class="text-muted">
                                Rp {{ number_format($c->angsuran_per_bulan, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Sisa Cicilan --}}
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card p-3">
                            <small class="text-muted">Sisa Cicilan</small>
                            <h5 class="mt-2">{{ $c->total_pembayaran }} cicilan</h5>
                            <p class="text-muted">Belum lunas</p>
                        </div>
                    </div>

                    {{-- Status Kontrak --}}
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card p-3">
                            <small class="text-muted">Status Kontrak</small>
                            <h5 class="mt-2">{{ $c->status_kontrak ?? '-' }}</h5>
                            <p class="text-muted">Status baik</p>
                        </div>
                    </div>

                </div>

                {{-- DETAIL KONTRAK --}}
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5>
                                <i class="bi bi-car-front me-2 text-primary"></i>
                                {{ $c->kendaraan->merk ?? '-' }}
                                {{ $c->kendaraan->tipe ?? '' }}
                                {{ $c->kendaraan->tahun ?? '' }}
                            </h5>
                            <small>ID Kontrak: {{ $c->nomor_kontrak }}</small>
                        </div>

                        <span class="badge bg-success">{{ $c->status_kontrak }}</span>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Periode & Cicilan --}}
                            <div class="col-12 col-md-6">
                                <p class="text-muted mb-0">Periode Kontrak</p>
                                <p>
                                    {{ date('d M Y', strtotime($c->tanggal_mulai)) }} -
                                    {{ date('d M Y', strtotime($c->tanggal_selesai)) }}
                                </p>

                                <p class="text-muted mb-0">Cicilan Bulanan</p>
                                <p>Rp {{ number_format($c->angsuran_per_bulan, 0, ',', '.') }}</p>
                            </div>

                            {{-- Next & Latest Due --}}
                            <div class="col-12 col-md-6">

                                <p class="text-muted mb-0">Jatuh Tempo Berikutnya</p>
                                <p>{{ $c->next_due ? date('d M Y', strtotime($c->next_due->tanggal_jatuh_tempo)) : '-' }}</p>

                                <p class="text-muted mb-0">Jatuh Tempo Terbaru</p>
                                <p>{{ $c->latest_due ? date('d M Y', strtotime($c->latest_due->tanggal_jatuh_tempo)) : '-' }}</p>

                                <p class="text-muted mb-0">Progres Pembayaran</p>
                                <p>{{ $c->paid }} dari {{ $c->total }} cicilan terbayar</p>

                            </div>

                        </div>

                        {{-- PROGRESS BAR --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Progres Kontrak</small>
                                <small>{{ $c->progress }}%</small>
                            </div>

                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $c->progress }}%" aria-valuenow="{{ $c->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        {{-- BUTTONS: stack on mobile, inline on md+ --}}
                        <div class="d-grid gap-2 d-md-flex">
                            <a href="{{ route('pelanggan.bayar') }}" class="btn btn-primary me-md-2">
                                <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                            </a>

                            <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-outline-secondary">
                                Lihat Riwayat Bayar
                            </a>
                        </div>

                    </div>
                </div>

            @endforeach

        @else
            <div class="alert alert-info">
                Anda belum memiliki kontrak leasing.
            </div>
        @endif

    </div>
@endsection