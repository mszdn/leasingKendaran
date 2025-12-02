<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontrakLeasing;
use App\Models\Angsuran;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use App\Models\Laporan;


class ManajerController extends Controller
{
    // Dashboard utama
    public function dashboard()
    {
        // === 1. Total Pendapatan ===
        // $totalPendapatan = KontrakLeasing::sum('total_pembayaran');

        // === 2. Kontrak Aktif ===
        $kontrakAktif = KontrakLeasing::where('status_kontrak', 'aktif')->count();

        // === 3. Pembayaran Terlambat ===
        $pembayaranTerlambat = Angsuran::where('tanggal_jatuh_tempo', '<', Carbon::now())
            ->whereNull('tanggal_bayar')
            ->count();

        // === 4. Top Marketing ===
        $topMarketing = User::where('role', 'marketing')
            ->withCount('kontrak') // jumlah kontrak yang di-handle marketing
            ->get()
            ->map(function ($m) {
                // Jika ingin menghitung tingkat konversi bisa disesuaikan
                $totalLeads = $m->leads_count ?? 1; // gunakan default 1 untuk hindari division by zero
                $konversi = ($totalLeads > 0) ? ($m->kontrak_count / $totalLeads) * 100 : 0;

                return [
                    'nama' => $m->username,
                    'jumlahKontrak' => $m->kontrak_count,
                    'tingkatKonversi' => round($konversi, 2),
                ];
            });

        // === 5. LINE CHART: Pendapatan Bulanan ===
        $pendapatanBulanan = Laporan::selectRaw('
            MONTH(tanggal_laporan) as bulan,
            SUM(total_pendapatan) as total
        ')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $totalPendapatan = $pendapatanBulanan->sum('total');
        
        // Label bulan
        $labelBulan = $pendapatanBulanan->pluck('bulan')->map(function ($b) {
            return Carbon::create()->month($b)->translatedFormat('M');
        });

        // Data pendapatan
        $dataPendapatan = $pendapatanBulanan->pluck('total');

        // === 6. PIE CHART: Status Kontrak ===
        $statusKontrak = [
            'aktif' => KontrakLeasing::where('status_kontrak', 'aktif')->count(),
            'selesai' => KontrakLeasing::where('status_kontrak', 'selesai')->count(),
            'terlambat' => KontrakLeasing::where('status_kontrak', 'terlambat')->count(),
        ];

        // === 7. BAR CHART: Kategori Keterlambatan ===
        $kategoriTerlambat = [
            '0_7' => 0,
            '8_15' => 0,
            '16_30' => 0,
            '30_up' => 0,
        ];

        // Ambil angsuran yang sudah dibayar dan terlambat
        $angsuranTerlambat = Angsuran::whereNotNull('tanggal_bayar')
            ->whereColumn('tanggal_bayar', '>', 'tanggal_jatuh_tempo')
            ->where('status_angsuran', 'lunas') // pastikan hanya yang lunas
            ->get();

        foreach ($angsuranTerlambat as $a) {
            $daysLate = Carbon::parse($a->tanggal_jatuh_tempo)
                ->diffInDays(Carbon::parse($a->tanggal_bayar)); // selalu positif

            if ($daysLate <= 7) {
                $kategoriTerlambat['0_7']++;
            } elseif ($daysLate <= 15) {
                $kategoriTerlambat['8_15']++;
            } elseif ($daysLate <= 30) {
                $kategoriTerlambat['16_30']++;
            } else {
                $kategoriTerlambat['30_up']++;
            }
        }


        // === RETURN KE VIEW ===
        return view('manajer.dashboard', compact(
            'totalPendapatan',
            'kontrakAktif',
            'pembayaranTerlambat',
            'topMarketing',
            'labelBulan',
            'dataPendapatan',
            'statusKontrak',
            'kategoriTerlambat'
        ));
    }


    // Analisis Kontrak
    public function analisisKontrak()
    {
        $kontrak = KontrakLeasing::with(['user', 'kendaraan'])->get();
        return view('manajer.AnalisisKontrak', compact('kontrak'));
    }

    // Analisis Pembayaran
    public function analisisPembayaran()
    {
        // Ambil semua angsuran yang sudah lunas dan ada tanggal bayar
        $angsuran = Angsuran::with(['kontrak.user'])
            ->where('status_angsuran', 'lunas')
            ->whereNotNull('tanggal_bayar')
            ->get();

        // Inisialisasi statistik keterlambatan
        $latePaymentStats = [
            '0-7 Hari' => 0,
            '8-15 Hari' => 0,
            '16-30 Hari' => 0,
            '30+ Hari' => 0,
        ];

        $angsuranTerlambat = [];

        foreach ($angsuran as $a) {
            if (!$a->tanggal_jatuh_tempo)
                continue;

            // Parse tanggal dari database
            $dueDate = \Carbon\Carbon::parse($a->tanggal_jatuh_tempo);
            $paymentDate = \Carbon\Carbon::parse($a->tanggal_bayar);

            // Cek apakah terlambat
            if ($paymentDate->gt($dueDate)) {
                $daysLate = $dueDate->diffInDays($paymentDate); // selalu positif

                // Tentukan range keterlambatan
                if ($daysLate <= 7)
                    $range = '0-7 Hari';
                elseif ($daysLate <= 15)
                    $range = '8-15 Hari';
                elseif ($daysLate <= 30)
                    $range = '16-30 Hari';
                else
                    $range = '30+ Hari';

                $latePaymentStats[$range]++;

                // Simpan info tambahan untuk tabel
                $a->daysLate = $daysLate;
                $a->rangeLate = $range;

                $angsuranTerlambat[] = $a;
            }
        }

        // Kirim data ke view
        return view('manajer.AnalisisPembayaran', [
            'angsuran' => collect($angsuranTerlambat),
            'latePaymentStats' => $latePaymentStats
        ]);
    }

    // Laporan Pendapatan
    public function laporanPendapatan()
    {
        $pendapatanBulanan = Laporan::selectRaw('
            MONTH(tanggal_laporan) as bulan,
            SUM(total_pendapatan) as total
        ')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('manajer.LaporanPendapatan', compact('pendapatanBulanan'));
    }

    // Marketing Performance
    public function marketingPerformance()
    {
        // Ambil semua user dengan role marketing dan jumlah kontraknya
        $marketing = User::where('role', 'marketing')
            ->withCount('kontrak') // jumlah kontrak yang ditangani marketing
            ->get()
            ->map(function ($m) {
                // Misal tingkat konversi = kontrak disetujui / total leads
                $totalLeads = $m->leads_count ?? 1; // hindari pembagian 0
                $konversi = ($totalLeads > 0) ? ($m->kontrak_count / $totalLeads) * 100 : 0;

                return [
                    'nama' => $m->username,
                    'jumlahKontrak' => $m->kontrak_count,
                    'tingkatKonversi' => round($konversi, 2),
                ];
            });

        return view('manajer.MarketingPerformance', compact('marketing'));
    }

}