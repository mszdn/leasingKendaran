<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::orderBy('tanggal_laporan', 'asc')->get();

        $totalPendapatan = $laporan->sum('total_pendapatan');
        $totalTunggakan = $laporan->sum('total_tunggakan');

        return view('admin.Laporan', compact('laporan', 'totalPendapatan', 'totalTunggakan'));
    }
}
