<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\KontrakLeasing;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    public function index()
    {
        $angsuran = Angsuran::with('kontrak.pelanggan')->get();
        $kontrak = KontrakLeasing::with('pelanggan')->get(); // untuk dropdown modal tambah
        return view('admin.Pembayaran', compact('angsuran', 'kontrak'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kontrak_id' => 'required|exists:kontrak_leasing,kontrak_id',
            'angsuran_ke' => 'required|integer',
            'jumlah_bayar' => 'required|numeric',
            'denda' => 'nullable|numeric',
            'tanggal_bayar' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'metode_pembayaran' => 'required|string',
            'status_angsuran' => 'required|in:lunas,tertunda'
        ]);

        Angsuran::create($data);

        return redirect()->route('admin.Pembayaran')->with('success', 'Pembayaran berhasil ditambahkan.');
    }
}
