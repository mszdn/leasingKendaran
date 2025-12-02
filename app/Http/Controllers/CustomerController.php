<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontrakLeasing;
use App\Models\Angsuran;
use App\Models\Pelanggan;

class CustomerController extends Controller
{
    /**
     * Halaman utama pelanggan (kontrak leasing).
     */
    public function home()
    {
        $pelanggan = Pelanggan::where('user_id', auth()->id())->first();

        if (!$pelanggan) {
            return view('pelanggan.home', ['contracts' => collect()]);
        }

        // Ambil semua kontrak pelanggan
        $contracts = KontrakLeasing::with(['kendaraan', 'angsuran'])
            ->where('pelanggan_id', $pelanggan->pelanggan_id)
            ->get()
            ->map(function ($c) {

                // Total cicilan berdasarkan jumlah angsuran
                $c->total = $c->angsuran->count();

                // Cicilan yang sudah lunas
                $c->paid = $c->angsuran->where('status_angsuran', 'lunas')->count();

                // Persentase progress
                $c->progress = $c->total > 0
                    ? round(($c->paid / $c->total) * 100)
                    : 0;

                // Angsuran yang belum dibayar (tertunda) terdekat
                $c->next_due = $c->angsuran
                    ->where('status_angsuran', 'tertunda')
                    ->sortBy('tanggal_jatuh_tempo')
                    ->first();

                // Angsuran terbaru berdasarkan angsuran_ke
                $c->latest_due = $c->angsuran
                    ->sortByDesc('angsuran_ke')
                    ->first();

                // Sisa cicilan (jumlah angsuran tertunda)
                $c->total_pembayaran = $c->angsuran
                    ->where('status_angsuran', 'tertunda')
                    ->count();

                return $c;
            });

        return view('pelanggan.home', compact('contracts'));
    }


    /**
     * Halaman bayar cicilan.
     */
    public function bayar()
    {
        $pelanggan = Pelanggan::where('user_id', auth()->id())->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        // Ambil kontrak pelanggan
        $kontrak = KontrakLeasing::where('pelanggan_id', $pelanggan->pelanggan_id)->first();

        if (!$kontrak) {
            return redirect()->back()->with('error', 'Kontrak tidak ditemukan.');
        }

        // Ambil angsuran pertama yang tertunda
        $angsuran = Angsuran::where('kontrak_id', $kontrak->kontrak_id)
            ->where('status_angsuran', 'tertunda')
            ->orderBy('angsuran_ke', 'ASC')
            ->first();

        if (!$angsuran) {
            return redirect()->back()->with('success', 'Semua cicilan sudah lunas!');
        }

        return view('pelanggan.bayar', compact('kontrak', 'angsuran'));
    }


    /**
     * Proses pembayaran angsuran.
     */
    public function processBayar(Request $request)
    {
        $angsuran = Angsuran::where('status_angsuran', 'tertunda')
            ->where('kontrak_id', $request->kontrak_id)
            ->orderBy('angsuran_ke', 'ASC')
            ->first();

        if (!$angsuran) {
            return redirect()->back()->with('error', 'Tidak ada angsuran tertunda.');
        }

        // Upload bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('bukti_pembayaran'), $namaFile);
            $angsuran->bukti_pembayaran = $namaFile;
        }

        // Valid metode pembayaran sesuai ENUM
        $allowed = ['transfer', 'cash', 'ewallet'];
        if (!in_array($request->metode_pembayaran, $allowed)) {
            return redirect()->back()->with('error', 'Metode pembayaran tidak valid.');
        }

        // Update pembayaran
        $angsuran->status_angsuran = 'lunas';
        $angsuran->tanggal_bayar = now();
        $angsuran->metode_pembayaran = $request->metode_pembayaran;
        $angsuran->save();

        return redirect()->back()->with('success', 'Pembayaran Berhasil!');
    }


    public function riwayat()
    {
        $userId = auth()->user()->id;

        // Ambil kontrak milik pelanggan
        $kontrak = \App\Models\KontrakLeasing::where('user_id', $userId)->first();

        if (!$kontrak) {
            return back()->with('error', 'Kontrak tidak ditemukan.');
        }

        // Ambil semua angsuran berdasarkan kontrak_id
        $riwayat = Angsuran::where('kontrak_id', $kontrak->kontrak_id)
            ->where('status_angsuran', 'lunas')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();


        return view('pelanggan.riwayat', compact('riwayat'));
    }

}
