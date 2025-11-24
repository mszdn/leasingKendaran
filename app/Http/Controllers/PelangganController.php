<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('admin.DataPelanggan', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required',
            'nik' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'pekerjaan' => 'required',
            'alamat' => 'required'
        ]);

        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

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

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
