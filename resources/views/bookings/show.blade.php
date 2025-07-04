@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Detail Jadwal Layanan</h2>

        <a href="{{ route('bookings.index') }}" class="btn btn-secondary mb-3">Kembali</a>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Hewan: {{ $booking->pet->name }} ({{ $booking->pet->user->name }})
                </h5>
                <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($booking->schedule_time)->format('d M Y H:i') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                <hr>
                <p><strong>Layanan yang Dipilih:</strong></p>
                <ul>
                    @foreach ($booking->services as $service)
                        <li>{{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
