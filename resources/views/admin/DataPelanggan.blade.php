@extends('layouts.app')

@section('content')

    <div class="container">

        <h2 class="mb-4">Data Pelanggan</h2>
        <p class="text-muted">Selamat datang, {{ auth()->user()->username }}</p>

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-people text-primary"></i>
                        Data Pelanggan
                    </h5>
                    <small class="text-muted">{{ $pelanggan->count() }} pelanggan terdaftar</small>
                </div>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Pelanggan
                </button>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>No. HP</th>
                                <th>Email</th>
                                <th>Pekerjaan</th>
                                <th>Alamat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pelanggan as $p)
                                <tr>
                                    <td>{{ $p->pelanggan_id }}</td>
                                    <td class="fw-bold">{{ $p->nama_lengkap }}</td>
                                    <td>{{ $p->nik }}</td>
                                    <td>{{ $p->no_hp }}</td>
                                    <td>{{ $p->email }}</td>
                                    <td>{{ $p->pekerjaan }}</td>
                                    <td style="max-width: 200px;" class="text-truncate">{{ $p->alamat }}</td>

                                    <td class="text-end">

                                        <!-- Edit -->
                                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $p->pelanggan_id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('pelanggan.destroy', $p->pelanggan_id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus pelanggan ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- MODAL EDIT -->
                                <div class="modal fade" id="modalEdit{{ $p->pelanggan_id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <form action="{{ route('pelanggan.update', $p->pelanggan_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Pelanggan</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row g-3">

                                                        <div class="col-md-6">
                                                            <label class="form-label">Nama Lengkap</label>
                                                            <input type="text" name="nama_lengkap" class="form-control"
                                                                value="{{ $p->nama_lengkap }}" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">NIK</label>
                                                            <input type="text" name="nik" class="form-control"
                                                                value="{{ $p->nik }}" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">No. HP</label>
                                                            <input type="text" name="no_hp" class="form-control"
                                                                value="{{ $p->no_hp }}" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" class="form-control"
                                                                value="{{ $p->email }}" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Pekerjaan</label>
                                                            <input type="text" name="pekerjaan" class="form-control"
                                                                value="{{ $p->pekerjaan }}" required>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label">Alamat</label>
                                                            <input type="text" name="alamat" class="form-control"
                                                                value="{{ $p->alamat }}" required>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button class="btn btn-primary">Update</button>
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


    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pelanggan</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. HP</label>
                                <input type="text" name="no_hp" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap</label>
                                <input type="text" name="alamat" class="form-control" required>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Tambah</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection