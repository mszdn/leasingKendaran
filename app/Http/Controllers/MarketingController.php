<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KontrakLeasing;
use App\Models\PengajuanKontrak;
use App\Models\Pelanggan;
use App\Models\Angsuran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengingatBayarMail;

class MarketingController extends Controller
{
    public function ajukanKontrak()
    {
        return view('marketing.ajukankontrak');
    }

    public function ajuan()
{
    $kontraks = KontrakLeasing::where('marketing_id', Auth::id())
        ->with(['pelanggan', 'kendaraan'])
        ->orderBy('kontrak_id', 'DESC')
        ->get();

    return view('marketing.ajuansaya', compact('kontraks'));
}


    public function pengingat()
    {
        $today = Carbon::today();

        $pengingat = Angsuran::with(['kontrak.pelanggan'])
            ->whereNull('tanggal_bayar')
            ->where('status_angsuran', 'tertunda')
            ->whereBetween('tanggal_jatuh_tempo', [$today, $today->copy()->addDays(14)])
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->get()
            ->map(function($item) use ($today) {
                $item->sisa_hari = $today->diffInDays(Carbon::parse($item->tanggal_jatuh_tempo), false);
                return $item;
            });

        return view('marketing.pengingatbayar', compact('pengingat'));
    }

    public function pelanggan()
    {
        return view('marketing.pelanggan');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('marketing.profil', compact('user'));
    }

        public function dashboard()
    {
        $kontraks = KontrakLeasing::where('marketing_id', Auth::id())
            ->with(['pelanggan', 'kendaraan'])
            ->orderBy('id', 'DESC')
            ->get();

        $pelangganCount = Pelanggan::count();
        $pendingCount = KontrakLeasing::where('marketing_id', Auth::id())
            ->where('status_verifikasi', 'pending')
            ->count();

        return view('marketing.dashboard', compact('kontraks', 'pelangganCount', 'pendingCount'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
   

    public function kirimPengingat($id)
    {
        $angsuran = Angsuran::with('kontrak.pelanggan')->findOrFail($id);

        Mail::to($angsuran->kontrak->pelanggan->email)->queue(new PengingatBayarMail($angsuran));

        return back()->with('success', 'Email pengingat berhasil dikirim!');
    }
}
