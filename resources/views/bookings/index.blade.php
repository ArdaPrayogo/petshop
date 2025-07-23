@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="mb-3 d-flex justify-content-between">
            <h2 class="p-0">Jadwal Layanan</h2>

            @guest
                <a href="{{ route('login') }}" class="btn btn-warning align-content-center">
                    <i class="bi bi-receipt-cutoff"></i> Buat Reservasi
                </a>
            @else
                @if (auth()->user()->role === 'customer')
                    <a href="/mybooking/create" class="btn btn-warning align-content-center">
                        <i class="bi bi-receipt-cutoff"></i> Buat Reservasi
                    </a>
                @endif
            @endguest

            @can('admin')
                <div>
                    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3"><i class="bi bi-calendar2-plus"></i>
                        Buat Reservasi</a>
                    <a href="/riwayat" class="btn btn-dark mb-3"><i class="bi bi-clock-history"></i> Riwayat Jadwal</a>
                </div>
            @endcan
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @php
            \Carbon\Carbon::setLocale('id');
        @endphp

        <div class="row">
            @foreach ($grouped as $date => $bookings)
                <div class="col-md-4 mb-4">
                    @include('partials.card', [
                        'day' => \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y'),
                        'bookings' => $bookings,
                    ])
                </div>
            @endforeach
        </div>

    </div>
@endsection
