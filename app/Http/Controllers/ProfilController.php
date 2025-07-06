<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfilController extends Controller
{
    public function index()
    {
        return view('profil.index', [
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('profil.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email:dns|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
    public function editPassword()
    {
        return view('profil.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('profile.password.edit')->with('success', 'Password berhasil diubah.');
    }
}
