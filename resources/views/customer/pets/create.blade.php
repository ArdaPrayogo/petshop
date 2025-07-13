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

            <div class="mb-3 col-6">
                <label>Nama Hewan</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="d-flex">
                <div class="mb-3 me-3 col-3">
                    <label>Spesies</label>
                    <input type="text" name="species" class="form-control" value="{{ old('species') }}" required>
                </div>

                <div class="mb-3 col-2">
                    <label>Ras (Breed)</label>
                    <input type="text" name="breed" class="form-control" value="{{ old('breed') }}">
                </div>
            </div>

            <div class="mb-3 col-6">
                <label>Usia (tahun)</label>
                <input type="number" name="age" class="form-control" value="{{ old('age') }}">
            </div>

            <button class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan</button>
            <a href="/mypet" class="btn btn-danger"><i class="bi bi-x-circle-fill"></i> Batal</a>
        </form>
    </div>
@endsection
