<?php

namespace App\Http\Controllers;

use App\Models\KontrakLeasing;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class MarketingDashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah pelanggan
        $pelangganCount = Pelanggan::count();

        // Ambil semua kontrak (jika hanya yang terbaru, bisa pakai take(5))
        $kontraks = KontrakLeasing::with(['pelanggan', 'kendaraan'])
            ->orderBy('kontrak_id', 'desc')
            ->take(5)
            ->get();

        // Hitung kontrak dengan status pending pembayaran
        $pendingCount = KontrakLeasing::where('status_kontrak', 'pending')->count();

        return view('marketing.dashboard', compact('pelangganCount', 'kontraks', 'pendingCount'));
    }
    public function pengajuanSaya()
    {
        $user = auth()->user();

        // ambil pelanggan_id dari tabel pelanggan yg terkait user login
        $pelanggan = Pelanggan::where('user_id', $user->id)->first();

        $kontraks = KontrakLeasing::with(['pelanggan', 'kendaraan'])
            ->where('pelanggan_id', $pelanggan->pelanggan_id)
            ->orderBy('kontrak_id', 'DESC')
            ->get();

        return view('pengajuan.index', compact('kontraks'));
    }

}