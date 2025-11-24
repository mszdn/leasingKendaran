@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="mb-2">Pengaturan Profil</h2>
        <p class="text-muted mb-4">Kelola informasi pribadi dan preferensi akun Anda.</p>

        <div class="row">
            {{-- Sidebar Kiri --}}
            <div class="col-lg-3">

                {{-- Profile Card --}}
                <div class="card mb-4">
                    <div class="card-body text-center">

                        {{-- Avatar --}}
                        <div class="position-relative d-inline-block">
                            <img src="{{ $user->foto_profil ?? 'https://via.placeholder.com/150' }}"
                                class="rounded-circle img-thumbnail mb-3" width="130" height="130">

                            <label class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2"
                                style="cursor:pointer;">
                                <i class="bi bi-camera-fill"></i>
                                <input type="file" class="d-none" name="foto_profil">
                            </label>
                        </div>

                        <h5 class="mb-0">{{ $user->nama_lengkap }}</h5>
                        <p class="text-muted text-capitalize">{{ $user->role }}</p>

                        <div class="mt-3 text-start small text-muted">
                            <div class="mb-2"><i class="bi bi-envelope"></i> {{ $user->email }}</div>
                            <div class="mb-2"><i class="bi bi-telephone"></i> {{ $user->no_hp }}</div>
                            <div class="mb-2"><i class="bi bi-geo-alt"></i> {{ $user->alamat }}</div>
                        </div>
                    </div>
                </div>

                {{-- Tingkat Kelengkapan --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Tingkat Kelengkapan Profil</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Kemajuan</span>
                            <span>85%</span>
                        </div>

                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 85%;"></div>
                        </div>

                        <p class="small text-muted mt-2">Lengkapi bio dan verifikasi email untuk mencapai 100%</p>
                    </div>
                </div>

            </div>

            {{-- Konten Utama --}}
            <div class="col-lg-9">

                {{-- Tabs --}}
                <ul class="nav nav-tabs" id="profileTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personal">
                            <i class="bi bi-person me-1"></i> Pribadi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#security">
                            <i class="bi bi-shield-lock me-1"></i> Keamanan
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-4">

                    {{-- Tab Informasi Pribadi --}}
                    <div class="tab-pane fade show active" id="personal">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Pribadi</h5>
                                <small class="text-muted">Perbarui informasi pribadi Anda di sini</small>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('admin.profil.update') }}" method="POST">
                                    @csrf

                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap *</label>
                                        <input type="text" name="nama_lengkap" class="form-control"
                                            value="{{ $user->nama_lengkap }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Alamat Email *</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Nomor Telepon *</label>
                                        <input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control"
                                            value="{{ $user->tanggal_lahir }}">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" value="{{ $user->alamat }}">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Bio</label>
                                        <textarea rows="4" name="bio" class="form-control">{{ $user->bio }}</textarea>
                                    </div>

                                    <div>
                                        <button class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan
                                            Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Tab Keamanan --}}
                    <div class="tab-pane fade" id="security">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Ubah Kata Sandi</h5>
                                <small class="text-muted">Pastikan kata sandi Anda kuat dan aman</small>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('admin.profil.password') }}" method="POST">
                                    @csrf

                                    <div class="col-12">
                                        <label class="form-label">Kata Sandi Saat Ini *</label>
                                        <input type="password" name="current_password" class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Kata Sandi Baru *</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Konfirmasi Kata Sandi Baru *</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>

                                    <div class="alert alert-primary small">
                                        <strong>Persyaratan Kata Sandi:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Minimal 8 karakter</li>
                                            <li>Minimal 1 huruf besar</li>
                                            <li>Minimal 1 huruf kecil</li>
                                            <li>Minimal 1 angka</li>
                                            <li>Minimal 1 karakter khusus</li>
                                        </ul>
                                    </div>

                                    <button class="btn btn-primary">
                                        <i class="bi bi-shield-lock me-1"></i> Perbarui Kata Sandi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection