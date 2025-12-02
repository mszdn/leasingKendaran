@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h3>Data Pelanggan (Marketing)</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                Tambah Pelanggan
            </button>
        </div>

        <!-- NOTIFIKASI -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- TABEL -->
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Pekerjaan</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggan as $p)
                            <tr>
                                <td>{{ $p->user_id }}</td>
                                <td>{{ $p->nama_lengkap }}</td>
                                <td>{{ $p->nik }}</td>
                                <td>{{ $p->no_hp }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->alamat }}</td>
                                <td>{{ $p->pekerjaan }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $p->pelanggan_id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('marketing.pelanggan.delete', $p->pelanggan_id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Hapus pelanggan ini?')" class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- =============================== -->
    <!--           MODAL TAMBAH          -->
    <!-- =============================== -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('marketing.pelanggan.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pelanggan</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Dropdown User -->
                    <div class="mb-3">
                        <label class="form-label">Pilih User Pelanggan</label>
                        <select id="selectUser" class="form-control" required>
                            <option value="">-- Pilih User --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->user_id }}" data-nama="{{ $u->username }}" data-email="{{ $u->email }}"
                                    data-hp="{{ $u->no_hp }}" data-alamat="{{ $u->alamat }}">
                                    {{ $u->user_id }} - {{ $u->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="user_id" id="userId">

                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" id="namaLengkap" name="nama_lengkap" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="emailUser" name="email" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" id="hpUser" name="no_hp" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" id="alamatUser" name="alamat" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>



    <!-- =============================== -->
    <!--     MODAL EDIT (di luar TABEL)  -->
    <!-- =============================== -->
    @foreach ($pelanggan as $p)
        <div class="modal fade" id="modalEdit{{ $p->pelanggan_id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('marketing.pelanggan.update', $p->pelanggan_id) }}" method="POST" class="modal-content">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5>Edit Pelanggan</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $p->nama_lengkap }}" required>
                        </div>

                        <div class="mb-3">
                            <label>NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ $p->nik }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $p->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $p->no_hp }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ $p->alamat }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ $p->pekerjaan }}" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach



    <!-- SCRIPT AUTO-FILL -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const selectUser = document.getElementById('selectUser');
            const userId = document.getElementById('userId');
            const namaLengkap = document.getElementById('namaLengkap');
            const emailUser = document.getElementById('emailUser');
            const hpUser = document.getElementById('hpUser');
            const alamatUser = document.getElementById('alamatUser');

            if (!selectUser) return;

            selectUser.addEventListener('change', function () {
                const selected = this.options[this.selectedIndex];

                userId.value = selected.value ?? '';
                namaLengkap.value = selected.dataset.nama ?? '';
                emailUser.value = selected.dataset.email ?? '';
                hpUser.value = selected.dataset.hp ?? '';
                alamatUser.value = selected.dataset.alamat ?? '';
            });

            // Reset saat modal dibuka
            const modalTambah = document.getElementById('modalTambah');
            modalTambah.addEventListener('show.bs.modal', function () {
                selectUser.value = '';
                userId.value = '';
                namaLengkap.value = '';
                emailUser.value = '';
                hpUser.value = '';
                alamatUser.value = '';
            });

        });
    </script>

@endsection