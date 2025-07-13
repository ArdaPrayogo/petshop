@extends('layouts.main')

@section('container')
    <div class="container">
        {{-- Alert Berhasil Tambah/Edit --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert Berhasil Hapus --}}
        @if (session()->has('deleted'))
            <div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
                {{ session('deleted') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-3">
            <h2 class="mb-0">Daftar Layanan</h2>
            <p class="text-sm text-muted">Berikut layanan yang kami sediakan untuk menunjang kesehatan anabulmu.</p>
        </div>

        <div class="row">
            @forelse ($services as $service)
                <div class="col-md-4 mb-4">
                    <div class="card border-warning mb-3 h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title fw-bold">🐾 {{ $service->name }}</h3>
                            <hr>
                            <h6 class="card-text fw-bold mb-3">Deskripsi:</h6>
                            <p class="card-text">{{ $service->description }}:</p>
                            <p class="card-text"><strong>Harga:</strong> Rp
                                {{ number_format($service->price, 0, ',', '.') }}
                            </p>
                            <p class="card-text"><strong>Durasi:</strong> {{ $service->duration }} menit</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada layanan tersedia.</p>
            @endforelse
        </div>
    </div>
@endsection
