@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Detail Hewan Peliharaan</h2>

        <div class="card border-success-subtle">
            <div class="card-body">
                <h2 class="card-title fw-bold">{{ $pet->name }}</h2>
                <hr>
                <p><strong>Spesies:</strong> {{ $pet->species }}</p>
                <p><strong>Ras (Breed):</strong> {{ $pet->breed ?? '-' }}</p>
                <p><strong>Usia:</strong> {{ $pet->age ? $pet->age . ' tahun' : '-' }}</p>
                <p><strong>Pemilik:</strong> {{ $pet->user->name }} ({{ $pet->user->email }})</p>

                <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-warning me-1">Edit</a>
                <a href="{{ url()->previous() }}" class="btn btn-danger">Kembali</a>

            </div>
        </div>
    </div>
@endsection
