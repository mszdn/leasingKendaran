<?php

namespace App\Exports;

use App\Models\Angsuran;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class AnalisisPembayaranExport implements FromCollection
{
    public function collection()
    {
        $angsuran = Angsuran::where('status_angsuran', 'lunas')
            ->whereNotNull('tanggal_bayar')
            ->get();

        $data = [];

        foreach ($angsuran as $a) {
            $due = Carbon::parse($a->tanggal_jatuh_tempo);
            $pay = Carbon::parse($a->tanggal_bayar);

            if ($pay->gt($due)) {
                $daysLate = $due->diffInDays($pay);

                $data[] = [
                    'ID Angsuran' => $a->id,
                    'Tanggal Jatuh Tempo' => $a->tanggal_jatuh_tempo,
                    'Tanggal Bayar' => $a->tanggal_bayar,
                    'Terlambat (hari)' => $daysLate,
                ];
            }
        }

        return collect($data);
    }
}