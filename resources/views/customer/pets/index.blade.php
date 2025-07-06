@extends('layouts.main')

@section('container')
    <div class="container">
        <h2 class="mb-4">Hewan Peliharaan saya</h2>
        <a href="/mypet/create" class="btn btn-primary mb-3">Tambah Hewan</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            @forelse ($pets as $pet)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pet->name }}</h5>
                            <p class="card-text"><strong>Jenis:</strong> {{ $pet->species }}</p>
                            <p class="card-text"><strong>Ras:</strong> {{ $pet->breed ?? '-' }}</p>
                            <p class="card-text"><strong>Usia:</strong> {{ $pet->age ?? '-' }} tahun</p>
                            <p class="card-text"><strong>Pemilik:</strong> {{ $pet->user->name }}</p>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-between">
                            <a href="{{ route('pets.show', $pet) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('pets.edit', $pet) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('pets.destroy', $pet) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada hewan peliharaan yang terdaftar.</p>
            @endforelse
        </div>
    </div>
@endsection
