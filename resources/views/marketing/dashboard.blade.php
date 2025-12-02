@extends('layouts.app')

@section('content')

    <div class="mb-4">
        <h2 class="text-dark">Dashboard Marketing</h2>
        <p class="text-muted">Kelola pendaftaran pelanggan dan pengajuan kontrak.</p>
    </div>

    <!-- 3 Kartu Utama -->
    <div class="row mb-4">

        <!-- Daftar Pelanggan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0" onclick="window.location='{{ route('marketing.pelanggan.index') }}'"
                style="cursor: pointer;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="bi bi-person-plus text-primary fs-2"></i>
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex justify-content-center align-items-center"
                            style="width: 50px; height: 50px;">
                            <span class="text-primary fw-bold">{{ $pelangganCount ?? 0 }}</span>
                        </div>
                    </div>
                    <h5 class="mt-3">Daftar Pelanggan</h5>
                    <p class="text-muted mb-0">Tambahkan pelanggan baru ke sistem</p>
                </div>
            </div>
        </div>

        <!-- Ajukan Kontrak -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0" onclick="window.location='{{ route('marketing.ajukanKontrak') }}'"
                style="cursor: pointer;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="bi bi-file-earmark-text text-success fs-2"></i>
                        <div class="rounded-circle bg-success bg-opacity-10 d-flex justify-content-center align-items-center"
                            style="width: 50px; height: 50px;">
                            <span class="text-success fw-bold">{{ $kontraks->count() }}</span>
                        </div>
                    </div>
                    <h5 class="mt-3">Ajukan Kontrak</h5>
                    <p class="text-muted mb-0">Buat kontrak leasing baru</p>
                </div>
            </div>
        </div>

        <!-- Pengingat Pembayaran -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0" onclick="window.location='{{ route('marketing.pengingat') }}'"
                style="cursor: pointer;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="bi bi-bell text-warning fs-2"></i>
                        <div class="rounded-circle bg-warning bg-opacity-10 d-flex justify-content-center align-items-center"
                            style="width: 50px; height: 50px;">
                            <span class="text-warning fw-bold">{{ $pendingCount ?? 0 }}</span>
                        </div>
                    </div>
                    <h5 class="mt-3">Pengingat Pembayaran</h5>
                    <p class="text-muted mb-0">Tindak lanjuti dengan pelanggan</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabel Pengajuan Terbaru -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Pengajuan Terbaru</h5>
            <small class="text-muted">Pengajuan kontrak terbaru Anda</small>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID Kontrak</th>
                            <th>Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Tenor</th>
                            <th>Status</th>
                            <th>Tanggal Mulai</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($kontraks as $kontrak)
                            <tr>
                                <td>LC-{{ str_pad($kontrak->kontrak_id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $kontrak->pelanggan->nama_lengkap ?? 'Tidak ada data' }}</td>
                                <td>{{ $kontrak->kendaraan->merk ?? '-' }}</td>
                                <td>{{ $kontrak->tenor_bulan ?? '-' }} bulan</td>

                                <td>
                                    <span class="badge
                                                                @if($kontrak->status_verifikasi == 'pending') bg-warning text-dark
                                                                @elseif($kontrak->status_verifikasi == 'approved') bg-success
                                                                @elseif($kontrak->status_verifikasi == 'rejected') bg-danger
                                                                @elseif($kontrak->status_verifikasi == 'Menunggu Pembayaran') bg-info text-dark
                                                                @else bg-secondary
                                                                @endif">
                                        {{ $kontrak->status_verifikasi }}
                                    </span>
                                </td>

                                <td>{{ $kontrak->tanggal_mulai ? \Carbon\Carbon::parse($kontrak->tanggal_mulai)->format('d-m-Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada pengajuan kontrak.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.table').DataTable();
            });
        </script>
    @endpush

@endsection