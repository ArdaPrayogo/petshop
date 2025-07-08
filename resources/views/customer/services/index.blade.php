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

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Daftar Layanan</h2>

        </div>

        <div class="row">
            @forelse ($services as $service)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $service->name }}</h5>
                            <h6 class="card-text">Deskripsi:</h6>
                            <p class="card-text">{{ $service->description }}:</p>
                            <p class="card-text"><strong>Harga:</strong> Rp{{ number_format($service->price, 0, ',', '.') }}
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
