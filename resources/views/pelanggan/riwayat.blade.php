@extends('layouts.app')
@section('content')

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-1">Riwayat Pembayaran</h5>
        <small class="text-muted">Semua transaksi pembayaran Anda</small>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
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
                <tr>
                    <td>1001</td>
                    <td>12 Jan 2025</td>
                    <td>Rp 850.000</td>
                    <td>Transfer Bank</td>
                    <td>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i> Selesai
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1002</td>
                    <td>12 Feb 2025</td>
                    <td>Rp 850.000</td>
                    <td>Kartu Kredit</td>
                    <td>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i> Selesai
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1003</td>
                    <td>-</td>
                    <td>Rp 850.000</td>
                    <td>-</td>
                    <td>
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-exclamation-circle me-1"></i> Belum Bayar
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
