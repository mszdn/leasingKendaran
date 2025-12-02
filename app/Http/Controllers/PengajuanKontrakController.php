<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\KontrakLeasing;
use Illuminate\Support\Facades\Auth;


class PengajuanKontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggan = Pelanggan::all();
        $kendaraan = Kendaraan::all();

        return view('marketing.ajukankontrak', compact('pelanggan', 'kendaraan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggan = Pelanggan::all();
        $kendaraan = Kendaraan::all();

        return view('marketing.ajukankontrak', compact('pelanggan', 'kendaraan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_kontrak' => 'required',
            'pelanggan_id' => 'required',
            'kendaraan_id' => 'required',
            'tenor_bulan' => 'required|integer|min:1',
            'dp_amount' => 'required|numeric|min:0',
            'total_pembayaran' => 'required|numeric|min:0',
            'status_kontrak' => 'required'
        ]);

        $tenor = (int) $request->tenor_bulan;

        $tanggalMulai = now()->toDateString();
        $tanggalSelesai = now()->copy()->addMonths($tenor)->toDateString();
        $angsuranPerBulan = ($request->total_pembayaran - $request->dp_amount) / $tenor;

        KontrakLeasing::create([
            'nomor_kontrak' => $request->nomor_kontrak,
            'pelanggan_id' => $request->pelanggan_id,
            'kendaraan_id' => $request->kendaraan_id,
            'tenor_bulan' => $tenor,
            'dp_amount' => $request->dp_amount,
            'angsuran_per_bulan' => (float) $angsuranPerBulan,
            'total_pembayaran' => $request->total_pembayaran,
            'status_kontrak' => $request->status_kontrak,
            'status_verifikasi' => 'pending',
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'marketing_id' => auth()->id(),

        ]);

        return redirect()->back()->with('success', 'Kontrak berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function ajuanSaya()
    {
        $kontraks = KontrakLeasing::where('marketing_id', Auth::id())
            ->with(['pelanggan', 'kendaraan'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('marketing.ajuansaya', compact('kontraks'));
    }

}