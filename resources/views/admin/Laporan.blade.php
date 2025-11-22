@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1 class="mb-2">Laporan Keuangan</h1>
        <p class="text-muted mb-4">Selamat datang, {{ auth()->user()->username }}</p>

        <!-- ====== TOTAL PENDAPATAN & TUNGGAKAN ====== -->
        <div class="row mb-4">

            <!-- Total Pendapatan -->
            <div class="col-md-6 mb-3">
                <div class="card border-start border-success border-4">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center gap-2">
                            <i class="bi bi-graph-up text-success"></i>
                            Total Pendapatan
                        </h5>

                        <div class="fs-2 fw-semibold text-dark">Rp 35.500.000</div>
                        <p class="text-muted small mb-0">Dari 3 periode</p>
                    </div>
                </div>
            </div>

            <!-- Total Tunggakan -->
            <div class="col-md-6 mb-3">
                <div class="card border-start border-danger border-4">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-circle text-danger"></i>
                            Total Tunggakan
                        </h5>

                        <div class="fs-2 fw-semibold text-dark">Rp 4.200.000</div>
                        <p class="text-muted small mb-0">Perlu ditindaklanjuti</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- ====== LIST LAPORAN PER PERIODE ====== -->
        <div class="row">

            <!-- ====== ITEM LAPORAN 1 ====== -->
            <div class="col-12 mb-4">
                <div class="card border-start border-primary border-4">
                    <div class="card-body">

                        <h5 class="card-title d-flex align-items-center gap-2">
                            <i class="bi bi-bar-chart text-primary"></i>
                            Laporan #1 – Januari 2024
                        </h5>

                        <div class="row mt-3 g-3">

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-calendar"></i> Periode
                                </label>
                                <div class="fw-semibold">01 Januari 2024</div>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-cash-stack text-success"></i> Pendapatan
                                </label>
                                <div class="fw-semibold">Rp 15.000.000</div>
                                <small class="text-success d-flex align-items-center gap-1">
                                    <i class="bi bi-graph-up"></i> Naik
                                </small>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-exclamation-circle text-danger"></i> Tunggakan
                                </label>
                                <div class="fw-semibold">Rp 1.000.000</div>
                                <small class="text-muted">6.66% dari pendapatan</small>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-check-circle text-primary"></i> Pendapatan Bersih
                                </label>
                                <div class="fw-semibold">Rp 14.000.000</div>
                            </div>

                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Persentase Tunggakan</span>
                                <span class="fw-semibold">6.7%</span>
                            </div>

                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 6.7%"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ====== ITEM LAPORAN 2 ====== -->
            <div class="col-12 mb-4">
                <div class="card border-start border-primary border-4">
                    <div class="card-body">

                        <h5 class="card-title d-flex align-items-center gap-2">
                            <i class="bi bi-bar-chart text-primary"></i>
                            Laporan #2 – Februari 2024
                        </h5>

                        <div class="row mt-3 g-3">

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-calendar"></i> Periode
                                </label>
                                <div class="fw-semibold">01 Februari 2024</div>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-cash-stack text-success"></i> Pendapatan
                                </label>
                                <div class="fw-semibold">Rp 12.500.000</div>
                                <small class="text-danger d-flex align-items-center gap-1">
                                    <i class="bi bi-graph-down"></i> Turun
                                </small>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-exclamation-circle text-danger"></i> Tunggakan
                                </label>
                                <div class="fw-semibold">Rp 1.700.000</div>
                                <small class="text-muted">13.6% dari pendapatan</small>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-check-circle text-primary"></i> Pendapatan Bersih
                                </label>
                                <div class="fw-semibold">Rp 10.800.000</div>
                            </div>

                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Persentase Tunggakan</span>
                                <span class="fw-semibold">13.6%</span>
                            </div>

                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 13.6%"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ====== ITEM LAPORAN 3 ====== -->
            <div class="col-12 mb-4">
                <div class="card border-start border-primary border-4">
                    <div class="card-body">

                        <h5 class="card-title d-flex align-items-center gap-2">
                            <i class="bi bi-bar-chart text-primary"></i>
                            Laporan #3 – Maret 2024
                        </h5>

                        <div class="row mt-3 g-3">

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-calendar"></i> Periode
                                </label>
                                <div class="fw-semibold">01 Maret 2024</div>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-cash-stack text-success"></i> Pendapatan
                                </label>
                                <div class="fw-semibold">Rp 8.000.000</div>
                                <small class="text-danger d-flex align-items-center gap-1">
                                    <i class="bi bi-graph-down"></i> Turun
                                </small>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-exclamation-circle text-danger"></i> Tunggakan
                                </label>
                                <div class="fw-semibold">Rp 1.500.000</div>
                                <small class="text-muted">18.7% dari pendapatan</small>
                            </div>

                            <div class="col-md-3">
                                <label class="text-muted small d-flex align-items-center gap-1">
                                    <i class="bi bi-check-circle text-primary"></i> Pendapatan Bersih
                                </label>
                                <div class="fw-semibold">Rp 6.500.000</div>
                            </div>

                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Persentase Tunggakan</span>
                                <span class="fw-semibold">18.7%</span>
                            </div>

                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 18.7%"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection