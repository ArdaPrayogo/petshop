<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login',
            'active' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);
        if (Auth::attempt($credential)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->intended('/admin');
            } elseif ($role === 'customer') {
                return redirect()->intended('/customer');
            } else {
                Auth::logout(); // jika role tidak dikenali
                return back()->with('loginError', 'Role tidak dikenali.');
            }
        }

        return back()->with('loginError', 'Login gagal! Periksa kembali email dan password Anda.');
    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
