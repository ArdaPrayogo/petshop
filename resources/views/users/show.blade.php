@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Detail User</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="card-text"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                <p class="card-text"><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</p>
                <p class="card-text"><strong>Alamat:</strong> {{ $user->address ?? '-' }}</p>
                {{-- <p class="card-text"><strong>Tanggal Daftar:</strong> {{ $user->created_at->format('d M Y') }}</p> --}}

                <a href="/pelanggan/{{ $user->id }}" class="btn btn-warning">Edit</a>
                <a href="/pelanggan" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
