@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">

        <h1 class="mb-3">Data Kendaraan</h1>
        <p>Selamat datang, {{ auth()->user()->username }}</p>

        <div class="card mb-4">
            <div
                class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <div>
                    <h5 class="mb-0">Manajemen Kendaraan</h5>
                    <small class="text-muted">{{ $kendaraan->count() }} kendaraan terdaftar</small>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kendaraan
                </button>
            </div>

            <div class="card-body">
                <div class="row g-4">

                    @foreach ($kendaraan as $k)
                        <div class="col-md-6 col-lg-4">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h6 class="mb-0">{{ $k->tahun }} {{ $k->merk }} {{ $k->tipe }}</h6>
                                    <small class="text-muted">Rp {{ number_format($k->harga, 0, ',', '.') }}</small>
                                </div>

                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <span class="badge {{ $k->status == 'tersedia' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $k->status }}
                                    </span>

                                    <div class="d-flex gap-2">
                                        <!-- Edit -->
                                        <button class="btn btn-outline-secondary btn-sm px-2" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $k->kendaraan_id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('kendaraan.destroy', $k->kendaraan_id) }}" method="POST"
                                            onsubmit="return confirm('Hapus kendaraan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm px-2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL EDIT -->
                        <div class="modal fade" id="modalEdit{{ $k->kendaraan_id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">

                                    <form action="{{ route('kendaraan.update', $k->kendaraan_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Kendaraan</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body" style="max-height:60vh; overflow-y:auto;">

                                            <div class="mb-2">
                                                <label class="form-label">Merk</label>
                                                <input type="text" name="merk" class="form-control" value="{{ $k->merk }}"
                                                    required>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">Tipe</label>
                                                <input type="text" name="tipe" class="form-control" value="{{ $k->tipe }}"
                                                    required>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">Tahun</label>
                                                <input type="number" name="tahun" class="form-control" value="{{ $k->tahun }}"
                                                    required>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">Harga</label>
                                                <input type="number" name="harga" class="form-control" value="{{ $k->harga }}"
                                                    required>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="tersedia" {{ $k->status == 'tersedia' ? 'selected' : '' }}>
                                                        tersedia</option>
                                                    <option value="terpakai" {{ $k->status == 'terpakai' ? 'selected' : '' }}>
                                                        terpakai
                                                    </option>
                                                    <option value="rusak" {{ $k->status == 'rusak' ? 'selected' : '' }}>rusak
                                                    </option>
                                                </select>
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

                </div>
            </div>
        </div>

    </div>


    <!-- MODAL TAMBAH KENDARAAN -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <form action="{{ route('kendaraan.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kendaraan</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" style="max-height:60vh; overflow-y:auto;">

                        <div class="mb-2">
                            <label class="form-label">Merk</label>
                            <input type="text" name="merk" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Tipe</label>
                            <input type="text" name="tipe" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="tersedia">tersedia</option>
                                <option value="terpakai">terpakai</option>
                                <option value="rusak">rusak</option>

                            </select>
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