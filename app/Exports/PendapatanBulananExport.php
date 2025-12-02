<?php

namespace App\Exports;

use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;

class PendapatanBulananExport implements FromCollection
{
    public function collection()
    {
        return Laporan::selectRaw('
            MONTH(tanggal_laporan) as bulan,
            SUM(total_pendapatan) as total
        ')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
    }
}