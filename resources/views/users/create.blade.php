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

            <div class="mb-3 col-md-6">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="d-flex">
                <div class="mb-3 me-3 col-md-3">
                    <label>Email <small class="text-muted">(Akan digenerate otomatis)</small></label>
                    <input type="text" class="form-control" value="Akan dibuat otomatis" disabled>
                </div>

                <div class="mb-3 col-md-3 g-0">
                    <label>Password <small class="text-muted">(Akan digenerate otomatis)</small></label>
                    <input type="text" class="form-control" value="password123" disabled>
                    <small class="text-muted">Password default: <strong>password123</strong></small>
                </div>
            </div>

            <input type="hidden" name="role" value="customer">
            <div class="mb-3 col-md-6">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="mb-3 col-md-6">
                <label>Alamat</label>
                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
            </div>

            <button class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan</button>
            <a href="/pelanggan" class="btn btn-danger"><i class="bi bi-x-circle-fill"></i> Batal</a>
        </form>
        <br>
    </div>
@endsection
