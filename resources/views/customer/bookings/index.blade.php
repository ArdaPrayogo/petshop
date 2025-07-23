@extends('layouts.main')

@section('container')
    @php
        \Carbon\Carbon::setLocale('id');
    @endphp

    <div class="container">
        <h2 class="mb-4">Jadwal Layanan Saya</h2>
        <a href="/mybooking/create" class="btn btn-success mb-3">
            <i class="bi bi-calendar2-plus"></i> Buat Reservasi
        </a>
        <a href="{{ route('mybooking.history') }}" class="btn btn-dark mb-3">
            <i class="bi bi-clock-history"></i> Riwayat Reservasi
        </a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            @forelse ($bookings as $booking)
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $booking->pet->name }}</h5>
                            <p class="card-text mb-1">
                                <strong>Waktu:</strong>
                                {{ \Carbon\Carbon::parse($booking->schedule_time)->translatedFormat('l, d F Y H:i') }}
                            </p>
                            <p class="card-text mb-2">
                                <strong>Status:</strong>
                                @php
                                    $statusColor = match ($booking->status) {
                                        'pending' => 'secondary',
                                        'confirmed' => 'primary',
                                        'completed' => 'success',
                                        default => 'dark',
                                    };
                                @endphp

                                <span class="badge bg-{{ $statusColor }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>

                            <div class="d-flex">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-info btn-sm me-2">
                                    Detail
                                </a>
                                <a href="{{ route('bookings.edit', $booking->id) }}?redirect_to={{ request()->fullUrl() }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center mt-5">
                    <p class="text-muted">Tidak ada jadwal layanan. Silakan tambahkan jadwal baru.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
