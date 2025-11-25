<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\KontrakLeasing;
use App\Models\Angsuran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Statistik (Dinamis)
        $totalPelanggan = Pelanggan::count();
        $kontrakAktif = KontrakLeasing::where('status_kontrak', 'aktif')->count();

        // Pendapatan bulan ini
        $pendapatanBulanan = Angsuran::whereMonth('tanggal_bayar', now()->month)
            ->sum('jumlah_bayar');

        // Verifikasi pending
        $verifikasiPending = KontrakLeasing::where('status_verifikasi', 'pending')->count();

        // 5 kontrak terbaru
        $kontrakTerbaru = KontrakLeasing::with(['user', 'kendaraan'])
            ->orderBy('kontrak_id', 'DESC')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPelanggan',
            'kontrakAktif',
            'pendapatanBulanan',
            'verifikasiPending',
            'kontrakTerbaru'
        ));
    }
}
