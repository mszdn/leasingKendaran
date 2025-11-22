@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1 class="mb-3">Data Kendaraan</h1>
        <p>Selamat datang, {{ auth()->user()->username }}</p>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Manajemen Kendaraan</h5>
                    <small class="text-muted">Kelola kendaraan yang tersedia untuk leasing</small>
                </div>
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kendaraan
                </a>
            </div>

            <div class="card-body">
                <div class="row g-4">

                    <!-- 1 -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h6 class="mb-0">2024 Toyota Camry</h6>
                                <small class="text-muted">$25,000</small>
                            </div>
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">Tersedia</span>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2 -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h6 class="mb-0">2024 Honda Accord</h6>
                                <small class="text-muted">$28,000</small>
                            </div>
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">Disewa</span>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3 -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h6 class="mb-0">2024 Ford Escape</h6>
                                <small class="text-muted">$32,000</small>
                            </div>
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">Tersedia</span>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- row -->
            </div> <!-- card-body -->
        </div> <!-- card -->

    </div>
@endsection