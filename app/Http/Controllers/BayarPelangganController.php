<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use App\Models\KontrakLeasing;
use App\Models\Angsuran;
use Carbon\Carbon;

class BayarPelangganController extends Controller
{
    public function index()
    {
        // Ambil user login
        $user = Auth::user();

        // Ambil pelanggan berdasarkan user_id
        $pelanggan = Pelanggan::where('user_id', $user->id)->first();

        if (!$pelanggan) {
            return view('pelanggan.bayar', [
                'kontrak' => null,
                'angsuran' => null
            ]);
        }

        // Ambil kontrak leasing milik pelanggan
        $kontrak = KontrakLeasing::with(['kendaraan'])
            ->where('pelanggan_id', $pelanggan->pelanggan_id)
            ->first();

        if (!$kontrak) {
            return view('pelanggan.bayar', [
                'kontrak' => null,
                'angsuran' => null
            ]);
        }

        // Ambil angsuran yang masih tertunda dan paling awal
        $angsuran = Angsuran::where('kontrak_id', $kontrak->kontrak_id)
            ->where('status_angsuran', 'tertunda')
            ->orderBy('angsuran_ke', 'ASC')
            ->first();

        return view('pelanggan.bayar', [
            'kontrak' => $kontrak,
            'angsuran' => $angsuran
        ]);
    }

    public function prosesBayar(Request $request, $angsuran_id)
    {
        $angsuran = Angsuran::find($angsuran_id);

        if (!$angsuran) {
            return back()->with('error', 'Angsuran tidak ditemukan.');
        }

        // Update status pembayaran
        $angsuran->update([
            'status_angsuran' => 'lunas',
            'tanggal_bayar' => Carbon::now(),
            'metode_pembayaran' => $request->input('metode'),
        ]);

        return redirect()->route('pelanggan.bayar')
            ->with('success', 'Pembayaran berhasil.');
    }
}
