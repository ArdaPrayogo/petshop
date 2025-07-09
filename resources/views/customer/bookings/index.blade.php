@extends('layouts.main')

@section('container')
    <div class="container">
        <h2 class="mb-4">Jadwal Layanan Saya</h2>
        <a href="/mybooking/create" class="btn btn-primary mb-3">Tambah Jadwal</a>
        <a href="{{ route('mybooking.history') }}" class="btn btn-primary mb-3">Riwayat pemesanan</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            @forelse ($bookings as $booking)
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $booking->pet->name }}</h5>
                            <p class="card-text mb-1">
                                <strong>Waktu:</strong>
                                {{ \Carbon\Carbon::parse($booking->schedule_time)->translatedFormat('d M Y H:i') }}
                            </p>
                            <p class="card-text mb-2"><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('bookings.edit', $booking->id) }}?redirect_to={{ request()->fullUrl() }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada jadwal layanan. Silakan tambahkan jadwal baru.</p>
            @endforelse
        </div>
    </div>
@endsection
