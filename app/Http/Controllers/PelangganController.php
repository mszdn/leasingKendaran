<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontrakLeasing;

class PelangganController extends Controller
{
    /**
     * Halaman utama pelanggan (kontrak leasing).
     */
    public function home()
    {
        // Ambil data pelanggan berdasarkan user yang login
        $pelanggan = \App\Models\Pelanggan::where('user_id', auth()->id())->first();

        // Jika user belum punya pelanggan → kontrak kosong
        if (!$pelanggan) {
            return view('pelanggan.home', ['contracts' => collect()]);
        }

        // Ambil kontrak berdasarkan pelanggan_id
        $contracts = KontrakLeasing::with(['kendaraan', 'angsuran'])
            ->where('pelanggan_id', $pelanggan->pelanggan_id)
            ->get();

        return view('pelanggan.home', compact('contracts'));
    }


    /**
     * Halaman bayar cicilan.
     */
    public function bayar()
    {
        return view('pelanggan.bayar');
    }

    /**
     * Halaman riwayat pembayaran cicilan.
     */
    public function riwayat()
    {
        return view('pelanggan.riwayat');
    }
}
