<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    // Tampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('profil.profil', compact('user'));
    }

    // Update data pribadi
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'bio' => 'nullable|string',
        ]);

        $user->update($request->all());

        return redirect()->route('profil.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profil.profil')->with('success', 'Password berhasil diperbarui.');
    }
}
