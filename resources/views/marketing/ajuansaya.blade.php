@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Pengajuan Saya</h5>
        <small class="text-muted">Semua pengajuan kontrak yang telah Anda buat</small>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID Kontrak</th>
                    <th>Pelanggan</th>
                    <th>Kendaraan</th>
                    <th>Tenor</th>
                    <th>Status</th>
                    <th>Tanggal Ajukan</th>
                </tr>
            </thead>

                <tbody>
            @forelse ($kontraks as $item)
                <tr>
                    <td>{{ $item->kontrak_id }}</td>
                    <td>{{ $item->pelanggan->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->kendaraan->merk ?? '' }} {{ $item->kendaraan->model ?? '' }}</td>
                    <td>{{ $item->tenor_bulan }} bulan</td>
                    <td>
                        <span class="badge 
                            @if($item->status_verifikasi == 'approved') bg-success
                            @elseif($item->status_verifikasi == 'rejected') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($item->status_verifikasi ?? 'menunggu') }}
                        </span>
                    </td>
                    <td>{{ $item->tanggal_mulai ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada pengajuan kontrak</td>
                </tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>
@endsection