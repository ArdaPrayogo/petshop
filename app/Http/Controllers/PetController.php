<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with('user')->get();
        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        $users = User::all();
        return view('pets.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name'    => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed'   => 'nullable|string|max:100',
            'age'     => 'nullable|integer|min:0',
        ]);

        Pet::create($request->all());
        return redirect()->route('pets.index')->with('success', 'Hewan berhasil ditambahkan.');
    }

    public function show(Pet $pet)
    {
        return view('pets.show', compact('pet'));
    }

    public function edit(Pet $pet)
    {
        $users = User::all();
        return view('pets.edit', compact('pet', 'users'));
    }

    public function update(Request $request, Pet $pet)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name'    => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed'   => 'nullable|string|max:100',
            'age'     => 'nullable|integer|min:0',
        ]);

        $pet->update($request->all());
        return redirect()->route('pets.index')->with('success', 'Data hewan berhasil diperbarui.');
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();
        return redirect()->route('pets.index')->with('success', 'Hewan berhasil dihapus.');
    }
}
