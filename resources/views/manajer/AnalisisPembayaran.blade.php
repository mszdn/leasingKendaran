@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">

        <div class="mb-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-2">
            <div>
                <h2 class="text-dark mb-1">Analisis Pembayaran Terlambat</h2>
                <p class="text-muted">Lacak dan kelola pembayaran yang tertunggak.</p>
            </div>
            <a href="{{ route('export.AnalisisPembayaran') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-download me-2"></i> Ekspor Laporan
            </a>
        </div>

        {{-- ==================== KARTU STATISTIK ==================== --}}
        <div class="row g-3 mb-4">
            @foreach ($latePaymentStats as $category => $count)
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6 class="text-muted mb-0">{{ $category }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="fw-bold text-dark">{{ $count }} pembayaran</div>
                            <p class="text-muted small mt-1">Rp {{ number_format($count * 100000, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ==================== DETAIL TABEL ==================== --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Detail Pembayaran Tertunggak</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0" id="pembayaranTable">
                        <thead class="table-light">
                            <tr>
                                <th>Pelanggan</th>
                                <th>ID Kontrak</th>
                                <th>Jatuh Tempo</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-end">Hari Terlambat</th>
                                <th>Range Terlambat</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($angsuran as $a)
                                @php
                                    // Status sesuai range keterlambatan
                                    $status = match ($a->rangeLate) {
                                        '0-7 Hari' => 'Baru',
                                        '8-15 Hari', '16-30 Hari' => 'Peringatan',
                                        '30+ Hari' => 'Kritis',
                                        default => 'Baru',
                                    };

                                    $badgeClass = match ($status) {
                                        'Baru' => 'bg-secondary',
                                        'Peringatan' => 'bg-warning text-dark',
                                        'Kritis' => 'bg-danger',
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $a->kontrak->user->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $a->kontrak->kontrak_id ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->tanggal_jatuh_tempo)->format('d-m-Y') }}</td>
                                    <td class="text-end">Rp {{ number_format($a->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ $a->daysLate }}</td>
                                    <td>{{ $a->rangeLate }}</td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada pembayaran tertunggak</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <style>
            /* Responsive table tweaks */
            @media (max-width: 576px) {
                #pembayaranTable {
                    min-width: 720px;
                }

                .table thead th,
                .table tbody td {
                    font-size: .78rem;
                    padding: .32rem .4rem;
                    white-space: normal;
                    /* allow wrapping */
                    word-break: break-word;
                }

                .table-responsive {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }

                .table-responsive::-webkit-scrollbar {
                    height: 6px;
                }

                .table-responsive::-webkit-scrollbar-thumb {
                    background: rgba(0, 0, 0, 0.12);
                    border-radius: 3px;
                }
            }
        </style>

    </div>
@endsection