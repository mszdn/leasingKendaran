@extends('layouts.app')

@section('content')

    @push('styles')
        <style>
            /* Responsive dashboard utilities moved here */
            .card-clickable {
                cursor: pointer
            }

            .stat-circle {
                width: clamp(38px, 8vw, 56px);
                height: clamp(38px, 8vw, 56px);
            }

            .stat-circle .stat-count {
                font-size: clamp(.9rem, 1.8vw, 1.1rem)
            }

            /* Ensure table cells wrap on small screens and remain readable */
            .table td,
            .table th {
                vertical-align: middle
            }

            @media (max-width:575.98px) {
                .table {
                    font-size: .95rem
                }

                .table td,
                .table th {
                    white-space: normal
                }
            }

            /* Small visual tweak so cards take equal height in row */
            .card.h-100 {
                display: flex;
                flex-direction: column
            }

            .card.h-100 .card-body {
                flex: 1
            }
        </style>
    @endpush

    <div class="mb-4">
        <h2 class="text-dark">Dashboard Marketing</h2>
        <p class="text-muted">Kelola pendaftaran pelanggan dan pengajuan kontrak.</p>
    </div>

    <!-- 3 Kartu Utama -->
    <div class="row mb-4">

        <!-- Daftar Pelanggan -->
        <div class="col-12 col-sm-6 col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100 card-clickable" role="button" tabindex="0"
                onclick="window.location='{{ route('marketing.pelanggan.index') }}'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="bi bi-person-plus text-primary fs-2"></i>
                        <div
                            class="rounded-circle bg-primary bg-opacity-10 d-flex justify-content-center align-items-center stat-circle">
                            <span class="text-primary fw-bold stat-count">{{ $pelangganCount ?? 0 }}</span>
                        </div>
                    </div>
                    <h5 class="mt-3">Daftar Pelanggan</h5>
                    <p class="text-muted mb-0">Tambahkan pelanggan baru ke sistem</p>
                </div>
            </div>
        </div>

        <!-- Ajukan Kontrak -->
        <div class="col-12 col-sm-6 col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100 card-clickable" role="button" tabindex="0"
                onclick="window.location='{{ route('marketing.ajukanKontrak') }}'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="bi bi-file-earmark-text text-success fs-2"></i>
                        <div
                            class="rounded-circle bg-success bg-opacity-10 d-flex justify-content-center align-items-center stat-circle">
                            <span class="text-success fw-bold stat-count">{{ $kontraks->count() }}</span>
                        </div>
                    </div>
                    <h5 class="mt-3">Ajukan Kontrak</h5>
                    <p class="text-muted mb-0">Buat kontrak leasing baru</p>
                </div>
            </div>
        </div>

        <!-- Pengingat Pembayaran -->
        <div class="col-12 col-sm-6 col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100 card-clickable" role="button" tabindex="0"
                onclick="window.location='{{ route('marketing.pengingat') }}'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="bi bi-bell text-warning fs-2"></i>
                        <div
                            class="rounded-circle bg-warning bg-opacity-10 d-flex justify-content-center align-items-center stat-circle">
                            <span class="text-warning fw-bold stat-count">{{ $pendingCount ?? 0 }}</span>
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