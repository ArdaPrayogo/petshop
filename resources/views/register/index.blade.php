@extends('layouts.main')

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="mb-4 text-center">Register</h3>

            <form action="/register" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                        placeholder="Nama lengkap" value="{{ old('name') }}" required>
                    <label for="name">Nama</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                    <label for="email">Email</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary w-100" type="submit">Register</button>
            </form>

            <small class="d-block text-center mt-3">
                Sudah punya akun? <a href="/login">Login di sini</a>
            </small>
        </div>
    </div>
@endsection
