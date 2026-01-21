<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Menampilkan halaman login.
    public function showLoginForm()
    {
        // View login: resources/views/auth/login.blade.php
        return view('auth.login');
    }

    //Memproses login user.
    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // login dengan credentials di atas
        if (Auth::attempt($credentials)) {

            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'manager') {
                return redirect()->intended('/manager/dashboard');
            }

            // Default role: sales
            return redirect()->intended('/sales/dashboard');
        }

        // Jika gagal login, kembali ke halaman login dengan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    //Proses logout user.
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Invalidasi session
        $request->session()->invalidate();

        // Regenerasi CSRF token
        $request->session()->regenerateToken();

        // Kembali ke halaman login
        return redirect('/login');
    }
}
