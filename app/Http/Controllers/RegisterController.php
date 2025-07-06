<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'customer'; // Set otomatis

        User::create($validated);

        return redirect('/')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
