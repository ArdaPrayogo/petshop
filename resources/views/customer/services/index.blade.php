@extends('layouts.main')

@section('container')
    <div class="container">
        <h2 class="mb-4">Hewan Peliharaan Saya</h2>
        <a href="{{ route('pets.create') }}" class="btn btn-primary mb-3">Tambah Hewan</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            @forelse ($pets as $pet)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pet->name }}</h5>
                            <p class="card-text mb-1"><strong>Jenis:</strong> {{ $pet->species }}</p>
                            <p class="card-text mb-1"><strong>Ras:</strong> {{ $pet->breed ?? '-' }}</p>
                            <p class="card-text mb-1"><strong>Usia:</strong> {{ $pet->age ?? '-' }} tahun</p>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('pets.show', $pet) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('bookings.create', ['pet_id' => $pet->id]) }}"
                                    class="btn btn-success btn-sm">Tambah ke Booking</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada hewan peliharaan. Tambahkan sekarang.</p>
            @endforelse
        </div>
    </div>
@endsection
