<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use App\Models\Angsuran;
use Carbon\Carbon;


class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::orderBy('tanggal_laporan', 'asc')->get();

        $totalPendapatan = $laporan->sum('total_pendapatan');
        $totalTunggakan = $laporan->sum('total_tunggakan');

        // Ambil bulan & tahun dari angsuran yang sudah lunas
        $periode = Angsuran::where('status_angsuran', 'lunas')
            ->selectRaw('YEAR(tanggal_bayar) as tahun, MONTH(tanggal_bayar) as bulan')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('admin.Laporan', compact('laporan', 'totalPendapatan', 'totalTunggakan', 'periode'));
    }


    public function generateForm()
    {
        return view('admin.laporan');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer'
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Ambil angsuran yang LUNAS DI BULAN & TAHUN TERSEBUT
        $angsuranLunas = Angsuran::where('status_angsuran', 'lunas')
            ->whereYear('tanggal_bayar', $tahun)
            ->whereMonth('tanggal_bayar', $bulan)
            ->get();

        $totalPendapatan = $angsuranLunas->sum(function ($a) {
            return $a->jumlah_bayar + $a->denda;
        });

        // Ambil angsuran TUNGGAKAN s/d akhir bulan
        $tanggalAkhir = Carbon::create($tahun, $bulan)->endOfMonth();

        $angsuranTunggakan = Angsuran::whereIn('status_angsuran', ['tertunda'])
            ->whereDate('tanggal_jatuh_tempo', '<=', $tanggalAkhir)
            ->get();

        $totalTunggakan = $angsuranTunggakan->sum('jumlah_bayar');

        // Simpan laporan
        Laporan::create([
            'tanggal_laporan' => Carbon::create($tahun, $bulan)->endOfMonth(),
            'total_pendapatan' => $totalPendapatan,
            'total_tunggakan' => $totalTunggakan
        ]);

        return redirect()->route('admin.Laporan')
            ->with('success', "Laporan $bulan/$tahun berhasil dibuat!");
    }

}
