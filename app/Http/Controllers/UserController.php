<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        User::create([
            'user_id' => $request->user_id,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'required',
            'role' => 'required'
        ]);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $data['nama_lengkap'] = $request->nama_lengkap;
        $data['email'] = $request->email;
        $data['no_hp'] = $request->no_hp;
        $data['alamat'] = $request->alamat;
        $data['tanggal_lahir'] = $request->tanggal_lahir;
        $data['jenis_kelamin'] = $request->jenis_kelamin;

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
