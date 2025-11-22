@extends('layouts.app')

@section('content')

    <div class="container">

        <h2 class="mb-4">Manajemen Pengguna</h2>
        <p class="text-muted">Selamat datang, {{ auth()->user()->username }}</p>

        <!-- Card -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Data Pengguna</h5>
                    <small class="text-muted">Kelola pengguna sistem dan peran mereka</small>
                </div>

                <!-- Button trigger modal -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Pengguna
                </button>
            </div>

            <div class="card-body">

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Peran</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Row 1 -->
                            <tr>
                                <td>Admin User</td>
                                <td>admin@lease.com</td>
                                <td><span class="badge bg-primary">Admin</span></td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td class="text-end">
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr>
                                <td>Marketing Team</td>
                                <td>marketing@lease.com</td>
                                <td><span class="badge bg-warning text-dark">Marketing</span></td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td class="text-end">
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="John Doe">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="john@contoh.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Peran</label>
                        <input type="text" class="form-control" placeholder="Admin, Marketing, Manajer">
                    </div>

                    <button class="btn btn-primary w-100">Buat Pengguna</button>
                </div>

            </div>
        </div>
    </div>

@endsection