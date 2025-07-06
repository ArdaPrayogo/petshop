@extends('layouts.main')

@section('container')
    <div class="container col-md-6">
        <h2>Ubah Password</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="current_password" class="form-label">Password Lama</label>
                <input type="password" name="current_password"
                    class="form-control @error('current_password') is-invalid @enderror" required>
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Ubah Password</button>
            <a href="/profile" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
