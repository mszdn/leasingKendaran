@extends('layouts.app')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="text-dark mb-1">Analisis Pembayaran</h2>
        <p class="text-muted">Lacak dan kelola pembayaran yang tertunggak.</p>
    </div>

    <button class="btn btn-primary">
        <i class="bi bi-download me-2"></i> Ekspor Laporan
    </button>
</div>

{{-- ==================== KARTU STATISTIK ==================== --}}
@php
    $latePaymentStats = [
        '0-7 Hari' => 0,
        '8-14 Hari' => 0,
        '15-30 Hari' => 0,
        '30+ Hari' => 0,
    ];

    foreach($angsuran as $a) {
        if ($a->tanggal_bayar === null) {
            $daysLate = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($a->tanggal_jatuh_tempo), false);
            if ($daysLate <= 7) $latePaymentStats['0-7 Hari']++;
            elseif ($daysLate <= 14) $latePaymentStats['8-14 Hari']++;
            elseif ($daysLate <= 30) $latePaymentStats['15-30 Hari']++;
            else $latePaymentStats['30+ Hari']++;
        }
    }
@endphp

<div class="row mb-4">
    @foreach ($latePaymentStats as $category => $count)
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="text-muted mb-0">{{ $category }}</h6>
                </div>
                <div class="card-body">
                    <div class="fw-bold text-dark">{{ $count }} pembayaran</div>
                    <p class="text-muted small mt-1">
                        Rp {{ number_format($count * 100000, 0, ',', '.') }}
                    </p>
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

    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Pelanggan</th>
                    <th>ID Kontrak</th>
                    <th>Jatuh Tempo</th>
                    <th class="text-end">Jumlah</th>
                    <th class="text-end">Hari Terlambat</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($angsuran as $a)
                    @php
                        $daysLate = $a->tanggal_bayar ? 0 : \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($a->tanggal_jatuh_tempo));
                        if ($daysLate > 30) $status = 'Kritis';
                        elseif ($daysLate > 14) $status = 'Peringatan';
                        elseif ($daysLate > 0) $status = 'Baru';
                        else $status = 'Tepat Waktu';
                    @endphp
                    <tr>
                        <td>{{ $a->kontrak->user->nama_lengkap ?? '-' }}</td>
                        <td>{{ $a->kontrak->kontrak_id ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->tanggal_jatuh_tempo)->format('d-m-Y') }}</td>
                        <td class="text-end">Rp {{ number_format($a->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="text-end">{{ $daysLate }}</td>
                        <td>
                            @if($status == 'Kritis')
                                <span class="badge bg-danger">{{ $status }}</span>
                            @elseif($status == 'Peringatan')
                                <span class="badge bg-secondary">{{ $status }}</span>
                            @elseif($status == 'Baru')
                                <span class="badge bg-outline border">{{ $status }}</span>
                            @else
                                <span class="badge bg-success">{{ $status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada pembayaran tertunggak</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection