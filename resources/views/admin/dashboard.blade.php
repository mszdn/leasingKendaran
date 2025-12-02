@extends('layouts.app')

@section('content')

    <div class="container mt-4">

        {{-- Header --}}
        <div class="mb-4">
            <h2 class="text-dark fw-bold">Dashboard Admin</h2>
            <p class="text-muted">Selamat datang, {{ auth()->user()->username }}!</p>
        </div>

        {{-- Statistik Dinamis --}}
        <div class="row g-4 mb-4">

            {{-- Total Pelanggan --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Total Pelanggan</span>
                            <i class="bi bi-people text-primary"></i>
                        </div>
                        <h4 class="mt-2 mb-1 text-dark">{{ $totalPelanggan }}</h4>
                        <small class="text-success">
                            <i class="bi bi-graph-up"></i> +12% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>

            {{-- Kontrak Aktif --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Kontrak Aktif</span>
                            <i class="bi bi-file-earmark-text text-success"></i>
                        </div>
                        <h4 class="mt-2 mb-1 text-dark">{{ $kontrakAktif }}</h4>
                        <small class="text-success">
                            <i class="bi bi-graph-up"></i> +8% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>

            {{-- Pendapatan Bulanan --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Pendapatan Bulanan</span>
                            <i class="bi bi-cash-coin text-warning"></i>
                        </div>
                        <h4 class="mt-2 mb-1 text-dark">
                            Rp {{ number_format($pendapatanBulanan, 0, ',', '.') }}
                        </h4>
                        <small class="text-success">
                            <i class="bi bi-graph-up"></i> +15% dari bulan lalu
                        </small>
                    </div>
                </div>
            </div>

            {{-- Verifikasi Pending --}}
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Menunggu Verifikasi</span>
                            <i class="bi bi-check-circle text-warning"></i>
                        </div>
                        <h4 class="mt-2 mb-1 text-dark">{{ $verifikasiPending }}</h4>
                        <small class="text-muted">Memerlukan perhatian</small>
                    </div>
                </div>
            </div>

        </div>


        {{-- Tabel Kontrak Terbaru --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Kontrak Terbaru</h5>
                <small class="text-muted">Pengajuan terbaru yang memerlukan verifikasi</small>
            </div>

            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID Kontrak</th>
                            <th>Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <!-- <th class="text-end">Aksi</th> -->
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($kontrakTerbaru as $k)
                            <tr>
                                <td>{{ $k->nomor_kontrak }}</td>

                                <td>{{ $k->pelanggan->nama_lengkap ?? '-' }}</td>

                                <td>
                                    {{ $k->kendaraan->merk ?? '' }}
                                    {{ $k->kendaraan->tipe ?? '' }}
                                </td>

                                <td>Rp {{ number_format($k->total_pembayaran, 0, ',', '.') }}</td>

                                <td>
                                    @if($k->status_verifikasi === 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($k->status_verifikasi === 'approved')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Terverifikasi</span>
                                    @endif
                                </td>

                                <td>{{ $k->tanggal_mulai }}</td>

                                <!-- <td class="text-end">
                                    @if($k->status_verifikasi === 'pending')
                                        <button class="btn btn-sm btn-primary">
                                            <i class="bi bi-check-circle me-1"></i> Verifikasi
                                        </button>
                                    @endif -->

                                    <!-- <button class="btn btn-sm btn-outline-dark">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </button> -->
                                <!-- </td> -->
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

    </div>

@endsection