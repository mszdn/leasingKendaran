<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\KontrakLeasing;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    public function index()
    {
        // Angsuran tertunda + mendekati jatuh tempo (7 hari)
        $angsuran = Angsuran::with('kontrak.pelanggan')
            ->where('status_angsuran', 'tertunda')
            ->whereDate('tanggal_jatuh_tempo', '<=', now()->addDays(15))
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->get();

        // Kontrak yang memiliki angsuran tertunda + mendekati jatuh tempo
        $kontrak = KontrakLeasing::with([
            'pelanggan',
            'angsuran' => function ($q) {
                $q->where('status_angsuran', 'tertunda')
                    ->whereDate('tanggal_jatuh_tempo', '<=', now()->addDays(15))
                    ->orderBy('angsuran_ke', 'asc');
            }
        ])
            ->whereHas('angsuran', function ($q) {
                $q->where('status_angsuran', 'tertunda')
                    ->whereDate('tanggal_jatuh_tempo', '<=', now()->addDays(15));
            })
            ->get();

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

        // Ambil angsuran yang cocok (harus tertunda)
        $angsuran = Angsuran::where('kontrak_id', $request->kontrak_id)
            ->where('angsuran_ke', $request->angsuran_ke)
            ->where('status_angsuran', 'tertunda')
            ->first();

        if (!$angsuran) {
            return back()->with('error', 'Angsuran tidak ditemukan atau sudah lunas.');
        }

        // Update data angsuran (BUKAN membuat baru)
        $angsuran->update([
            'jumlah_bayar' => $request->jumlah_bayar,
            'denda' => $request->denda,
            'tanggal_bayar' => $request->tanggal_bayar,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_angsuran' => $request->status_angsuran,
        ]);

        return redirect()->route('admin.Pembayaran')->with('success', 'Pembayaran berhasil diperbarui.');
    }
}
