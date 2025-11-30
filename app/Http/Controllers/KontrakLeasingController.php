<?php

namespace App\Http\Controllers;

use App\Models\KontrakLeasing;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\Angsuran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            'tenor_bulan' => 'required|integer|min:1',
            'dp_amount' => 'required|numeric|min:0',
            'total_pembayaran' => 'required|numeric|min:0',
            'status_kontrak' => 'required'
        ]);

        $tenor = (int) $request->tenor_bulan;

        // Tanggal Mulai
        $tanggalMulai = now()->toDateString();

        // FIX — tenor harus integer
        $tanggalSelesai = now()->copy()->addMonths($tenor)->toDateString();

        // Hitung angsuran
        $angsuranPerBulan = ($request->total_pembayaran - $request->dp_amount) / $tenor;

        // Simpan kontrak
        $kontrak = KontrakLeasing::create([
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
        ]);

        return redirect()->back()->with('success', 'Kontrak berhasil dibuat');
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

    private function generateAngsuran(KontrakLeasing $kontrak)
    {
        if (Angsuran::where('kontrak_id', $kontrak->kontrak_id)->exists()) {
            return;
        }

        $baseDate = Carbon::parse($kontrak->tanggal_mulai)->startOfDay();
        $tenor = (int) $kontrak->tenor_bulan;
        $nominal = (int) $kontrak->angsuran_per_bulan;

        for ($i = 1; $i <= $tenor; $i++) {

            $jatuhTempo = $baseDate->copy()->addMonths($i - 1)->setDay(15);

            Angsuran::create([
                'kontrak_id' => $kontrak->kontrak_id,
                'angsuran_ke' => $i,
                'jumlah_bayar' => $nominal,
                'tanggal_jatuh_tempo' => $jatuhTempo,
                'tanggal_bayar' => null,
                'status_angsuran' => 'tertunda',
                'metode_pembayaran' => null,
                'denda' => 0,
                'bukti_pembayaran' => null
            ]);
        }
    }


    public function verifikasi(KontrakLeasing $kontrak)
    {
        DB::transaction(function () use ($kontrak) {

            $kontrak->update([
                'status_verifikasi' => 'approved'
            ]);

            $this->generateAngsuran($kontrak);

        });

        return redirect()->route('kontrak.index')
            ->with('success', 'Kontrak berhasil diverifikasi & angsuran berhasil dibuat otomatis!');
    }

    public function reject(KontrakLeasing $kontrak)
    {
        $kontrak->status_verifikasi = 'rejected';
        $kontrak->save();

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil ditolak.');
    }
}
