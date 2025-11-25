@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1 class="mb-2">Laporan Keuangan</h1>
        <p class="text-muted mb-4">Selamat datang, {{ auth()->user()->username }}</p>

        <!-- TOTAL PENDAPATAN & TUNGGAKAN -->
        <div class="row mb-4">
            <!-- Total Pendapatan -->
            <div class="col-md-6 mb-3">
                <div class="card border-start border-success border-4">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center gap-2">
                            <i class="bi bi-graph-up text-success"></i> Total Pendapatan
                        </h5>
                        <div class="fs-2 fw-semibold text-dark">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        <p class="text-muted small mb-0">Dari {{ $laporan->count() }} periode</p>
                    </div>
                </div>
            </div>

            <!-- Total Tunggakan -->
            <div class="col-md-6 mb-3">
                <div class="card border-start border-danger border-4">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-circle text-danger"></i> Total Tunggakan
                        </h5>
                        <div class="fs-2 fw-semibold text-dark">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</div>
                        <p class="text-muted small mb-0">Perlu ditindaklanjuti</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- LIST LAPORAN PER PERIODE -->
        <div class="row">
            @foreach($laporan as $index => $l)
                @php
                    $pendapatanBersih = $l->total_pendapatan - $l->total_tunggakan;
                    $persenTunggakan = $l->total_pendapatan > 0 ? ($l->total_tunggakan / $l->total_pendapatan) * 100 : 0;
                @endphp

                <div class="col-12 mb-4">
                    <div class="card border-start border-primary border-4">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center gap-2">
                                <i class="bi bi-bar-chart text-primary"></i>
                                Laporan #{{ $index + 1 }} – {{ \Carbon\Carbon::parse($l->tanggal_laporan)->format('F Y') }}
                            </h5>

                            <div class="row mt-3 g-3">
                                <div class="col-md-3">
                                    <label class="text-muted small d-flex align-items-center gap-1">
                                        <i class="bi bi-calendar"></i> Periode
                                    </label>
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($l->tanggal_laporan)->format('d F Y') }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="text-muted small d-flex align-items-center gap-1">
                                        <i class="bi bi-cash-stack text-success"></i> Pendapatan
                                    </label>
                                    <div class="fw-semibold">Rp {{ number_format($l->total_pendapatan, 0, ',', '.') }}</div>
                                    <small
                                        class="text-{{ $l->total_pendapatan >= $pendapatanBersih ? 'success' : 'danger' }} d-flex align-items-center gap-1">
                                        <i
                                            class="bi {{ $l->total_pendapatan >= $pendapatanBersih ? 'bi-graph-up' : 'bi-graph-down' }}"></i>
                                        {{ $l->total_pendapatan >= $pendapatanBersih ? 'Naik' : 'Turun' }}
                                    </small>
                                </div>

                                <div class="col-md-3">
                                    <label class="text-muted small d-flex align-items-center gap-1">
                                        <i class="bi bi-exclamation-circle text-danger"></i> Tunggakan
                                    </label>
                                    <div class="fw-semibold">Rp {{ number_format($l->total_tunggakan, 0, ',', '.') }}</div>
                                    <small class="text-muted">{{ number_format($persenTunggakan, 2) }}% dari pendapatan</small>
                                </div>

                                <div class="col-md-3">
                                    <label class="text-muted small d-flex align-items-center gap-1">
                                        <i class="bi bi-check-circle text-primary"></i> Pendapatan Bersih
                                    </label>
                                    <div class="fw-semibold">Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Persentase Tunggakan</span>
                                    <span class="fw-semibold">{{ number_format($persenTunggakan, 1) }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-danger" role="progressbar"
                                        style="width: {{ $persenTunggakan }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endsection