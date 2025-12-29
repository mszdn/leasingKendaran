@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <h2 class="mb-4">Data Pelanggan</h2>
        <p class="text-muted">Selamat datang, {{ auth()->user()->username }}</p>

        <div class="card shadow-sm">

            <div
                class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
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
                                <th class="d-none d-md-table-cell">NIK</th>
                                <th>No. HP</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th class="d-none d-md-table-cell">Pekerjaan</th>
                                <th class="d-none d-md-table-cell">Alamat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pelanggan as $p)
                                <tr>
                                    <td>{{ $p->pelanggan_id }}</td>
                                    <td class="fw-bold">{{ $p->nama_lengkap }}</td>
                                    <td class="d-none d-md-table-cell">{{ $p->nik }}</td>
                                    <td>{{ $p->no_hp }}</td>
                                    <td class="d-none d-md-table-cell">{{ $p->email }}</td>
                                    <td class="d-none d-md-table-cell">{{ $p->pekerjaan }}</td>
                                    <td class="d-none d-md-table-cell" style="max-width: 200px;" class="text-truncate">
                                        {{ $p->alamat }}
                                    </td>

                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Aksi">
                                            <button class="btn btn-outline-secondary btn-sm px-2" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $p->pelanggan_id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form action="{{ route('admin.DataPelanggan.delete', $p->pelanggan_id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Hapus pelanggan ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-outline-danger btn-sm px-2">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL EDIT -->
                                <div class="modal fade" id="modalEdit{{ $p->pelanggan_id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">

                                            <form action="{{ route('admin.DataPelanggan.update', $p->pelanggan_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Pelanggan</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body" style="max-height:60vh; overflow-y:auto;">
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
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <form action="{{ route('admin.DataPelanggan.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pelanggan</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" style="max-height:60vh; overflow-y:auto;">

                        <div class="row g-3">

                            <!-- DROPDOWN USER -->
                            <div class="col-md-6">
                                <label class="form-label">Pilih Akun Pelanggan</label>
                                <select name="user_id" id="selectUser" class="form-select" required>
                                    <option value="">-- Pilih User Pelanggan --</option>
                                    @foreach ($usersPelanggan as $u)
                                        <option value="{{ $u->user_id }}" data-nama="{{ $u->username }}"
                                            data-email="{{ $u->email }}" data-hp="{{ $u->no_hp }}"
                                            data-alamat="{{ $u->alamat }}">
                                            {{ $u->username }} (ID: {{ $u->user_id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" id="namaLengkap" name="nama_lengkap" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" id="emailUser" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. HP</label>
                                <input type="text" id="hpUser" name="no_hp" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap</label>
                                <input type="text" id="alamatUser" name="alamat" class="form-control" required>
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


<!-- JS AUTO FILL -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ambil elemen (bisa null jika tidak ada di halaman)
        const selectUser = document.getElementById('selectUser');
        const namaLengkap = document.getElementById('namaLengkap');
        const emailUser = document.getElementById('emailUser');
        const hpUser = document.getElementById('hpUser');
        const alamatUser = document.getElementById('alamatUser');

        if (!selectUser) {
            // kalau null, hentikan dengan tenang (berguna jika file dipakai di halaman lain)
            return;
        }

        selectUser.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];

            // beberapa safety check kalau dataset kosong
            namaLengkap && (namaLengkap.value = selected?.dataset?.nama ?? '');
            emailUser && (emailUser.value = selected?.dataset?.email ?? '');
            hpUser && (hpUser.value = selected?.dataset?.hp ?? '');
            alamatUser.value = selected?.dataset?.alamat ?? '';
        });

        // OPTIONAL: jika modal bisa dibuka ulang dan ingin reset ketika membuka modal
        const modalTambah = document.getElementById('modalTambah');
        if (modalTambah) {
            modalTambah.addEventListener('show.bs.modal', function () {
                // reset fields jika perlu
                selectUser.value = '';
                namaLengkap && (namaLengkap.value = '');
                emailUser && (emailUser.value = '');
                hpUser && (hpUser.value = '');
                alamatUser.value = '';
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const selectUser = document.getElementById('selectUser');
        const namaLengkap = document.getElementById('namaLengkap');
        const emailUser = document.getElementById('emailUser');
        const hpUser = document.getElementById('hpUser');
        const alamatUser = document.getElementById('alamatUser'); // ⬅ baru ditambahkan

        if (!selectUser) return;

        selectUser.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];

            namaLengkap.value = selected?.dataset?.nama ?? '';
            emailUser.value = selected?.dataset?.email ?? '';
            hpUser.value = selected?.dataset?.hp ?? '';
            alamatUser.value = selected?.dataset?.alamat ?? ''; // ⬅ auto fill alamat
        });

        // reset saat modal dibuka ulang
        const modalTambah = document.getElementById('modalTambah');
        if (modalTambah) {
            modalTambah.addEventListener('show.bs.modal', function () {
                selectUser.value = '';
                namaLengkap.value = '';
                emailUser.value = '';
                hpUser.value = '';
                alamatUser.value = ''; // ⬅ reset alamat
            });
        }

    });
</script>