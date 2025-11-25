<?php

namespace App\Http\Controllers;

use App\Models\KontrakLeasing;
use Illuminate\Http\Request;

class KontrakLeasingController extends Controller
{
    public function index()
    {
        // Ambil semua kontrak beserta relasi pelanggan dan kendaraan
        $kontrak = KontrakLeasing::with(['pelanggan', 'kendaraan'])->get();
        return view('admin.KontrakLeasing', compact('kontrak'));
    }

    public function verifikasi(KontrakLeasing $kontrak)
    {
        // Ubah status verifikasi menjadi 'approved'
        $kontrak->status_verifikasi = 'approved';
        $kontrak->save();

        return redirect()->route('kontrak.index')
            ->with('success', 'Kontrak berhasil diverifikasi.');
    }
}
