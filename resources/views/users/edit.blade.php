@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Edit User</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/pelanggan/{{ $user->id }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label>Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-select" required>
                    <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer
                    </option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="/pelanggan" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
