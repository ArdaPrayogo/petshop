@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="mb-3">
            <h2 class="p-0">Riwayat Jadwal Layanan</h2>
            <a href="/bookings" class="btn btn-warning mb-3">Kembali</a>
        </div>
        @php
            \Carbon\Carbon::setLocale('id');
        @endphp

        <div class="row">
            @foreach ($grouped as $date => $bookings)
                <div class="col-md-4 mb-4">
                    @include('partials.historycard', [
                        'day' => \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y'),
                        'bookings' => $bookings,
                    ])
                </div>
            @endforeach
        </div>
    @endsection
