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

                            @foreach ($users as $u)
                                <tr>
                                    <td>{{ $u->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $u->email ?? '-' }}</td>

                                    <td>
                                        @if ($u->role === 'admin')
                                            <span class="badge bg-primary">Admin</span>
                                        @elseif ($u->role === 'marketing')
                                            <span class="badge bg-warning text-dark">Marketing</span>
                                        @elseif ($u->role === 'manajer')
                                            <span class="badge bg-info text-dark">Manajer</span>
                                        @else
                                            <span class="badge bg-secondary">Pelanggan</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($u->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>

                                    <td class="text-end">

                                        <!-- Edit (tombol buka modal per user) -->
                                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $u->user_id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('user.destroy', $u->user_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Hapus pengguna ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>

                                {{-- MODAL EDIT — taruh di dalam loop supaya $u tersedia --}}
                                <div class="modal fade" id="modalEdit{{ $u->user_id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <form action="{{ route('user.update', $u->user_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Pengguna</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <input type="text" name="nama_lengkap" class="form-control"
                                                            value="{{ $u->nama_lengkap }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Username *</label>
                                                        <input type="text" name="username" class="form-control"
                                                            value="{{ $u->username }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Email *</label>
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{ $u->email }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Password <small class="text-muted">(kosongkan jika tidak
                                                                diganti)</small>
                                                        </label>
                                                        <input type="password" name="password" class="form-control">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Peran *</label>
                                                        <select name="role" class="form-control" required>
                                                            <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>
                                                                Admin</option>
                                                            <option value="marketing" {{ $u->role === 'marketing' ? 'selected' : '' }}>Marketing</option>
                                                            <option value="manajer" {{ $u->role === 'manajer' ? 'selected' : '' }}>Manajer</option>
                                                            <option value="pelanggan" {{ $u->role === 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button class="btn btn-primary">Update</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                                {{-- END MODAL EDIT --}}

                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>


    {{-- MODAL TAMBAH (tetap di luar loop) --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('user.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username *</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Peran *</label>
                            <select name="role" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="marketing">Marketing</option>
                                <option value="manajer">Manajer</option>
                                <option value="pelanggan">Pelanggan</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection