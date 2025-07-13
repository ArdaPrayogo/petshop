@extends('layouts.main')

@section('container')
    <div class="container">
        <h2 class="mb-3">Tambah Pelanggan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/pelanggan" method="POST">
            @csrf
            <div class="mb-3 col-6">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3 col-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="d-flex">
                <div class="mb-3 me-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="d-flex">
                <div class="mb-3 me-3">
                    <label>Role</label>
                    <select name="role" class="form-select" required>
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
            </div>
            <button class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan</button>
            <a href="/pelanggan" class="btn btn-danger"><i class="bi bi-x-circle-fill"></i> Batal</a>
        </form>
        <br>
    </div>
@endsection
