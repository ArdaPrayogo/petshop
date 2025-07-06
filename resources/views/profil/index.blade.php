@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Profil Saya</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>

                <a href="{{ route('profile.edit') }}" class="btn btn-warning">Edit Profil</a>
                <a href="{{ route('profile.password.edit') }}" class="btn btn-outline-warning">
                    <i class="bi bi-key-fill"></i> Ubah Password
                </a>

            </div>
        </div>
    </div>
@endsection
