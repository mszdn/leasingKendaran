<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah!');
        }

        Auth::login($user);

        // Update last login
        $user->update(['last_login' => now()]);

        //Redirect sesuai role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'marketing':
                return redirect()->route('marketing.dashboard');

            case 'pelanggan':
                return redirect()->route('pelanggan.home');

            case 'manajer':
                return redirect()->route('manajer.dashboard');

            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak dikenali');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
