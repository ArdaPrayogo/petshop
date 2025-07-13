@extends('layouts.main')

@section('container')
    <div class="container">
        <h2 class="mb-4">Hewan Peliharaan saya</h2>
        <a href="/mypet/create" class="btn btn-success mb-3"><i class="bi bi-heart-fill"></i> Tambah Hewan</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            @forelse ($pets as $pet)
                <div class="col-md-4 mb-4">
                    <div class="card border-success h-100 shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title">
                                @if (strtolower($pet->species) === 'kucing')
                                    🐱
                                @elseif(strtolower($pet->species) === 'anjing')
                                    🐶
                                @else
                                    🐾
                                @endif
                                {{ $pet->name }}
                            </h2>

                            <hr>
                            <p class="card-text"><strong>Jenis:</strong> {{ $pet->species }}</p>
                            <p class="card-text"><strong>Ras:</strong> {{ $pet->breed ?? '-' }}</p>
                            <p class="card-text"><strong>Usia:</strong> {{ $pet->age ?? '-' }} tahun</p>
                            <p class="card-text"><strong>Pemilik:</strong> {{ $pet->user->name }}</p>
                        </div>
                        <div class="card-footer bg-white d-flex">
                            <a href="{{ route('pets.show', $pet) }}" class="btn btn-info btn-sm me-2">Lihat</a>
                            <a href="{{ route('pets.edit', $pet) }}" class="btn btn-warning btn-sm me-2">Edit</a>
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
