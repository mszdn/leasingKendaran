@extends('layouts.app')

@section('content')

    <div class="container">

        <h2 class="mb-4">Data Pelanggan</h2>
        <p class="text-muted">Selamat datang, {{ auth()->user()->username }}</p>

        <!-- Card -->
        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-people text-primary"></i>
                        Data Pelanggan
                    </h5>
                    <small class="text-muted">12 pelanggan terdaftar dalam sistem</small>
                    <!-- angka dibuat statis dulu -->
                </div>

                <!-- Tombol Tambah -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Pelanggan
                </button>
            </div>

            <!-- Body -->
            <div class="card-body">

                <!-- Tabel -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>No. HP</th>
                                <th>Email</th>
                                <th>Pekerjaan</th>
                                <th>Alamat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Row 1 (statis) -->
                            <tr>
                                <td>1</td>
                                <td class="fw-bold">John Doe</td>
                                <td>1234567890123456</td>
                                <td>081234567890</td>
                                <td>john.doe@example.com</td>
                                <td>Pegawai Negeri</td>
                                <td class="text-truncate" style="max-width: 200px;">
                                    Jl. Contoh No. 123, Jakarta Selatan
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEditPelanggan">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr>
                                <td>2</td>
                                <td class="fw-bold">Budi Santoso</td>
                                <td>9876543210123456</td>
                                <td>082312341234</td>
                                <td>budi@gmail.com</td>
                                <td>Karyawan Swasta</td>
                                <td class="text-truncate" style="max-width: 200px;">
                                    Perumahan Griya Asri, Bandung
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEditPelanggan">
                                        <i class="bi bi-pencil me-1"></i> Edit
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


    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="modalTambahPelanggan" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. HP</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <input type="text" class="form-control">
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- Modal Edit Pelanggan -->
    <div class="modal fade" id="modalEditPelanggan" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="John Doe">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" value="1234567890123456">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. HP</label>
                            <input type="text" class="form-control" value="081234567890">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="john.doe@example.com">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" value="Pegawai Negeri">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <input type="text" class="form-control" value="Jl. Contoh No. 123, Jakarta Selatan">
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection