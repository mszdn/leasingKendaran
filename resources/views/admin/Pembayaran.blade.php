@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">

        <h1 class="mb-3">Pembayaran</h1>
        <p>Selamat datang, {{ auth()->user()->username }}</p>

        <div class="card mb-4">
            <div
                class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <div>
                    <h5 class="mb-1">Manajemen Pembayaran</h5>
                    <small class="text-muted">{{ $angsuran->count() }} angsuran mendekati jatuh tempo</small>
                </div>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPembayaran">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Pembayaran Manual
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Pelanggan</th>
                                <th>No. Kontrak</th>
                                <th>Angsuran Ke-</th>
                                <th>Jumlah Bayar</th>
                                <th class="d-none d-md-table-cell">Denda</th>
                                <th>Total</th>
                                <th class="d-none d-md-table-cell">Tgl. Jatuh Tempo</th>
                                <th class="d-none d-md-table-cell">Tgl. Bayar</th>
                                <th class="d-none d-md-table-cell">Metode</th>
                                <th class="d-none d-md-table-cell">Bukti</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($angsuran as $a)
                                <tr>
                                    <td>ANG-{{ str_pad($a->angsuran_id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $a->kontrak->pelanggan?->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $a->kontrak->nomor_kontrak ?? '-' }}</td>
                                    <td>{{ $a->angsuran_ke }}</td>
                                    <td>Rp {{ number_format($a->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td class="d-none d-md-table-cell">
                                        {{ $a->denda ? 'Rp ' . number_format($a->denda, 0, ',', '.') : '-' }}</td>
                                    <td><b>Rp {{ number_format(($a->jumlah_bayar ?? 0) + ($a->denda ?? 0), 0, ',', '.') }}</b>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        {{ \Carbon\Carbon::parse($a->tanggal_jatuh_tempo)->format('d M Y') }}</td>
                                    <td class="d-none d-md-table-cell">
                                        {{ $a->tanggal_bayar ? \Carbon\Carbon::parse($a->tanggal_bayar)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ ucfirst($a->metode_pembayaran) }}</td>
                                    <td class="d-none d-md-table-cell">
                                        @if($a->bukti_pembayaran)
                                            <a href="{{ asset('storage/' . $a->bukti_pembayaran) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">Lihat</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge @if($a->status_angsuran == 'lunas') bg-success @else bg-warning text-dark @endif">
                                            {{ ucfirst($a->status_angsuran) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAL TAMBAH PEMBAYARAN -->
    <div class="modal fade" id="modalTambahPembayaran" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route('admin.Pembayaran.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pembayaran Manual</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" style="max-height:60vh; overflow-y:auto;">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Pilih Kontrak *</label>
                                <select name="kontrak_id" class="form-select" id="kontrak_select" required>
                                    <option value="">Pilih kontrak leasing</option>
                                    @foreach($kontrak as $k)
                                        <option value="{{ $k->kontrak_id }}">
                                            {{ $k->nomor_kontrak }} - {{ $k->pelanggan?->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Angsuran Tertunda *</label>
                                <select name="angsuran_ke" id="angsuran_ke" class="form-select" required>
                                    <option value="">Pilih kontrak terlebih dahulu</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jumlah Bayar (Rp) *</label>
                                <input type="number" name="jumlah_bayar" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Denda (Rp)</label>
                                <input type="number" name="denda" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Bayar *</label>
                                <input type="date" name="tanggal_bayar" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Jatuh Tempo *</label>
                                <input type="date" name="tanggal_jatuh_tempo" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Metode Pembayaran *</label>
                                <select name="metode_pembayaran" class="form-select" required>
                                    <option value="">Pilih metode</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="cash">Tunai</option>
                                    <option value="ewallet">E-Wallet</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status Pembayaran *</label>
                                <select name="status_angsuran" class="form-select" required>
                                    <option value="lunas">Lunas</option>
                                    <option value="tertunda">Tertunda</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Simpan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT DROPDOWN ANGSURAN --}}
    <script>
        const kontrakData = @json($kontrak);

        document.getElementById("kontrak_select").addEventListener("change", function () {
            let id = this.value;
            let dropdown = document.getElementById("angsuran_ke");

            dropdown.innerHTML = "<option value=''>Memuat...</option>";

            let kontrak = kontrakData.find(k => k.kontrak_id == id);

            if (!kontrak || kontrak.angsuran.length === 0) {
                dropdown.innerHTML = "<option value=''>Tidak ada angsuran tertunda</option>";
                return;
            }

            dropdown.innerHTML = "";
            kontrak.angsuran.forEach(a => {
                dropdown.innerHTML += `
                        <option value="${a.angsuran_ke}">
                            Angsuran ke-${a.angsuran_ke} (Jatuh tempo: ${a.tanggal_jatuh_tempo})
                        </option>
                    `;
            });
        });
    </script>

@endsection