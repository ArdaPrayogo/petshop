@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Edit Hewan Peliharaan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pets.update', $pet->id) }}" method="POST">
            @csrf
            @method('PUT')

            @can('admin')
                <div class="mb-3">
                    <label>Pemilik</label>
                    <select name="user_id" class="form-select" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id', $pet->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endcan

            <div class="mb-3">
                <label>Nama Hewan</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $pet->name) }}" required>
            </div>

            <div class="mb-3">
                <label>Spesies</label>
                <input type="text" name="species" class="form-control" value="{{ old('species', $pet->species) }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Ras (Breed)</label>
                <input type="text" name="breed" class="form-control" value="{{ old('breed', $pet->breed) }}">
            </div>

            <div class="mb-3">
                <label>Usia (tahun)</label>
                <input type="number" name="age" class="form-control" value="{{ old('age', $pet->age) }}">
            </div>

            <button class="btn btn-primary"><i class="bi bi-floppy"></i> Update</button>
            <a href="{{ url()->previous() }}" class="btn btn-danger"><i class="bi bi-x-circle-fill"></i> Kembali</a>

        </form>
    </div>
@endsection
