<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class MarketingPerformanceExport implements FromCollection
{
    public function collection()
    {
        return User::where('role', 'marketing')
            ->withCount('kontrak')
            ->get()
            ->map(function ($m) {
                $totalLeads = $m->leads_count ?? 1;
                $konversi = ($m->kontrak_count / $totalLeads) * 100;

                return [
                    'Nama Marketing' => $m->username,
                    'Jumlah Kontrak' => $m->kontrak_count,
                    'Tingkat Konversi (%)' => round($konversi, 2),
                ];
            });
    }
}