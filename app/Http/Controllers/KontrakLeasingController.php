<?php

namespace App\Http\Controllers;

use App\Models\KontrakLeasing;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Kendaraan;

class KontrakLeasingController extends Controller
{
    public function index()
    {
        $kontrak = KontrakLeasing::with(['pelanggan', 'kendaraan'])->get();
        $pelanggan = Pelanggan::all();
        $kendaraan = Kendaraan::all();

        return view('admin.KontrakLeasing', compact('kontrak', 'pelanggan', 'kendaraan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kontrak' => 'required',
            'pelanggan_id' => 'required',
            'kendaraan_id' => 'required',
            'tenor_bulan' => 'required|integer',
            'dp_amount' => 'required|integer',
            'angsuran_per_bulan' => 'required|integer',
            'total_pembayaran' => 'required|integer',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        KontrakLeasing::create($request->all());

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil ditambahkan!');
    }

    public function update(Request $request, KontrakLeasing $kontrak)
    {
        $kontrak->update($request->all());

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil diperbarui!');
    }

    public function destroy(KontrakLeasing $kontrak)
    {
        $kontrak->delete();

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil dihapus.');
    }

    public function verifikasi(KontrakLeasing $kontrak)
    {
        $kontrak->status_verifikasi = 'approved';
        $kontrak->save();

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil diverifikasi.');
    }

    public function reject(KontrakLeasing $kontrak)
    {
        $kontrak->status_verifikasi = 'rejected';
        $kontrak->save();

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil ditolak.');
    }
}
