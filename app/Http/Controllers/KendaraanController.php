<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::all();
        return view('admin.DataKendaraan', compact('kendaraan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'merk' => 'required',
            'tipe' => 'required',
            'tahun' => 'required|numeric',
            'harga' => 'required|numeric',
            'status' => 'required'
        ]);

        Kendaraan::create($data);

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $data = $request->validate([
            'merk' => 'required',
            'tipe' => 'required',
            'tahun' => 'required|numeric',
            'harga' => 'required|numeric',
            'status' => 'required'
        ]);

        $kendaraan->update($data);

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
