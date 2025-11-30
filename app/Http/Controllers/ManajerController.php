<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontrakLeasing;
use App\Models\Angsuran;
use App\Models\User;
use Carbon\Carbon;

class ManajerController extends Controller
{
    // Dashboard utama
    public function dashboard()
    {
        // Total pendapatan dari semua kontrak
        $totalPendapatan = KontrakLeasing::sum('total_pembayaran');

        // Jumlah kontrak yang aktif (status_verifikasi = approved)
        $kontrakAktif = KontrakLeasing::where('status_verifikasi', 'approved')->count();

        // Hitung pembayaran terlambat (jumlah angsuran yang belum dibayar dan lewat jatuh tempo)
        $pembayaranTerlambat = Angsuran::where('tanggal_jatuh_tempo', '<', Carbon::now())
                              ->whereNull('tanggal_bayar')
                              ->count();

        // Top marketing berdasarkan jumlah kontrak yang mereka tangani
        $topMarketing = User::where('role', 'marketing')
                            ->withCount('kontrak')
                            ->get()
                            ->map(function ($m) {
                                return [
                                    'nama' => $m->name,
                                    'jumlahKontrak' => $m->kontrak_count
                                ];
                            });

        return view('manajer.dashboard', compact(
            'totalPendapatan',
            'kontrakAktif',
            'pembayaranTerlambat',
            'topMarketing'
        ));
    }

    // Analisis Kontrak
    public function analisisKontrak()
    {
        $kontrak = KontrakLeasing::with(['user', 'kendaraan'])->get();
        return view('manajer.AnalisisKontrak', compact('kontrak'));
    }

    // Analisis Pembayaran
    public function analisisPembayaran()
    {
        $angsuran = Angsuran::with('kontrak')->get();

        return view('manajer.AnalisisPembayaran', compact('angsuran'));
    }

    // Laporan Pendapatan
    public function laporanPendapatan()
    {
        $pendapatanBulanan = KontrakLeasing::selectRaw('MONTH(tanggal_mulai) as bulan, SUM(total_pembayaran) as total')
            ->groupBy('bulan')
            ->get();

        return view('manajer.LaporanPendapatan', compact('pendapatanBulanan'));
    }

    // Marketing Performance
    public function marketingPerformance()
    {
        $marketing = User::where('role', 'marketing')->get();

        return view('manajer.MarketingPerformance', compact('marketing'));
    }
}