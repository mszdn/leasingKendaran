@extends('layouts.app')
@section('content')

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-1">Riwayat Pembayaran</h5>
            <small class="text-muted">Semua transaksi pembayaran Anda</small>
        </div>

        <div class="card-body">
            <div class="table-responsive" style="-webkit-overflow-scrolling: touch;">
                <table class="table table-bordered table-striped mb-0" style="min-width:720px;">
                    <thead>
                        <tr>
                            <th>ID Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($riwayat as $r)
                            <tr>
                                <td>{{ $r->angsuran_id }}</td>

                                <td>
                                    @if ($r->tanggal_bayar)
                                        {{ date('d M Y', strtotime($r->tanggal_bayar)) }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    Rp {{ number_format($r->jumlah_bayar + $r->denda, 0, ',', '.') }}
                                </td>

                                <td>
                                    @if ($r->metode_pembayaran)
                                        {{ ucfirst($r->metode_pembayaran) }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if ($r->status_angsuran == 'lunas')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i> lunas
                                        </span>
                                    @elseif ($r->status_angsuran == 'tertunda')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-exclamation-circle me-1"></i> Tertunda
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            -
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada riwayat pembayaran
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection