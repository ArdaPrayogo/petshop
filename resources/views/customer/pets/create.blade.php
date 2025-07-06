{{-- resources/views/pets/create.blade.php --}}
@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Tambah Hewan Peliharaan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/mypet" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Hewan</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label>Spesies</label>
                <input type="text" name="species" class="form-control" value="{{ old('species') }}" required>
            </div>

            <div class="mb-3">
                <label>Ras (Breed)</label>
                <input type="text" name="breed" class="form-control" value="{{ old('breed') }}">
            </div>

            <div class="mb-3">
                <label>Usia (tahun)</label>
                <input type="number" name="age" class="form-control" value="{{ old('age') }}">
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="/mypet" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
