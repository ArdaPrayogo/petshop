@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Detail Layanan</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $service->name }}</h5>

                <p class="card-text"><strong>Deskripsi:</strong><br>
                    {{ $service->description ?? '-' }}
                </p>

                <p class="card-text"><strong>Harga:</strong><br>
                    Rp{{ number_format($service->price, 0, ',', '.') }}
                </p>

                <p class="card-text"><strong>Durasi:</strong><br>
                    {{ $service->duration ? $service->duration . ' menit' : '-' }}
                </p>

                <p class="card-text"><strong>Staff:</strong><br>
                    {{ $service->staff ?? '-' }}
                </p>

                <a href="/service/{{ $service->id }}/edit" class="btn btn-warning">Edit</a>
                <a href="/service" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
