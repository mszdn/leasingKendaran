<?php

namespace App\Exports;

use App\Models\KontrakLeasing;
use Maatwebsite\Excel\Concerns\FromCollection;

class AnalisisKontrakExport implements FromCollection
{
    public function collection()
    {
        return KontrakLeasing::with(['user', 'kendaraan'])
            ->get()
            ->map(function ($k) {
                return [
                    'ID Kontrak' => $k->id,
                    'Nama Pelanggan' => $k->user->username ?? '-',
                    'Kendaraan' => $k->kendaraan->nama_kendaraan ?? '-',
                    'Tanggal Mulai' => $k->tanggal_mulai,
                    'Status Kontrak' => $k->status_kontrak,
                    'Total Pembayaran' => $k->total_pembayaran,
                ];
            });
    }
}