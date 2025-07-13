@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Tambah Layanan</h2>
        <form method="POST" action="/service">
            @csrf
            <div class="mb-3">
                <label>Nama Layanan</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Harga (Rp)</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Durasi (menit)</label>
                <input type="number" name="duration" class="form-control">
            </div>
            <button class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan</button>
        </form>
    </div>
@endsection
