@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Edit Layanan</h2>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form edit --}}
        <form action="/service/{{ $service->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Layanan</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $service->price) }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Durasi (menit)</label>
                <input type="number" name="duration" class="form-control"
                    value="{{ old('duration', $service->duration) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/service" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
