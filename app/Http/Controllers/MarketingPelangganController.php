<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\User;

class MarketingPelangganController extends Controller
{
    // Tampilkan semua pelanggan untuk halaman marketing
    public function index()
    {
        $pelanggan = Pelanggan::all();

        // Ambil user yang rolenya pelanggan
        $users = User::where('role', 'pelanggan')->get();

        return view('marketing.pelanggan', compact('pelanggan', 'users'));
    }



    // Simpan data pelanggan dari marketing
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:user,user_id',
            'nama_lengkap' => 'required',
            'nik' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'pekerjaan' => 'required',
            'alamat' => 'required'
        ]);

        Pelanggan::create($data);

        return redirect()->route('marketing.pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    // Update data pelanggan
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required',
            'nik' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'pekerjaan' => 'required',
            'alamat' => 'required'
        ]);

        $pelanggan->update($data);

        return redirect()->route('marketing.pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    // Hapus pelanggan
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('marketing.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
