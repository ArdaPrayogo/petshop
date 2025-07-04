@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Detail Hewan Peliharaan</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $pet->name }}</h5>

                <p><strong>Spesies:</strong> {{ $pet->species }}</p>
                <p><strong>Ras (Breed):</strong> {{ $pet->breed ?? '-' }}</p>
                <p><strong>Usia:</strong> {{ $pet->age ? $pet->age . ' tahun' : '-' }}</p>
                <p><strong>Pemilik:</strong> {{ $pet->user->name }} ({{ $pet->user->email }})</p>

                <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('pets.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
