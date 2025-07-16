<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email',
            'password' => 'nullable|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string',
        ]);

        // Role fix customer
        $validated['role'] = 'customer';

        // Dummy email jika kosong
        if (empty($validated['email'])) {
            do {
                $dummyEmail = 'pelanggan' . rand(1000, 9999) . '@gmail.com';
            } while (User::where('email', $dummyEmail)->exists());

            $validated['email'] = $dummyEmail;
        }

        // Dummy password jika kosong
        if (empty($validated['password'])) {
            $validated['password'] = bcrypt('password123'); // atau bisa pakai Str::random(8)
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $validated['remember_token'] = Str::random(10);

        User::create($validated);

        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil ditambahkan.');
    }


    public function show($id)
    {
        $user = User::get()->findOrfail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $id,
            'role'    => 'required|in:admin,customer',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect('/pelanggan')->with('success', 'User berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/pelanggan')->with('success', 'User berhasil dihapus.');
    }
}
