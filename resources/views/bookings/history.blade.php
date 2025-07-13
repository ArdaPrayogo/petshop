@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="mb-3 d-flex justify-content-between">
            <h2>Kalender Jadwal Layanan</h2>
            <a href="{{ url()->previous() }}" class="btn btn-warning mb-3">Kembali</a>

            @guest
                {{-- Guest: Belum login --}}
                <a href="{{ route('login') }}" class="btn btn-outline-warning">
                    Pesan layanan
                </a>
            @else
                @if (auth()->user()->role === 'customer')
                    {{-- Customer: Tampilkan tombol ke form booking --}}
                    <a href="/mybooking/create" class="btn btn-sm btn-warning">
                        Pesan layanan
                    </a>
                @endif
                {{-- Admin: Tidak ditampilkan --}}
            @endguest

            {{-- @can('admin')
                <a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>
                <a href="{{ route('bookings.history') }}" class="btn btn-primary mb-3">Riwayat Jadwal</a>
            @endcan --}}
        </div>

        @php
            // Urutan hari Indonesia
            $dayOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

            // Siapkan struktur kosong per hari
            $days = [];
            foreach ($dayOrder as $day) {
                $days[$day] = collect();
            }

            // Isi jadwal berdasarkan hari dari grouped
            foreach ($grouped as $label => $items) {
                $dayName = \Carbon\Carbon::parse($items->first()->schedule_time)
                    ->locale('id')
                    ->isoFormat('dddd');
                $dayName = ucfirst($dayName);
                if (isset($days[$dayName])) {
                    $days[$dayName] = $items->sortBy('schedule_time');
                }
            }
        @endphp

        {{-- Grid Baris 1: Senin - Rabu --}}
        <div class="row">
            @foreach (['Senin', 'Selasa', 'Rabu'] as $day)
                <div class="col-md-4 mb-4">
                    @include('partials.card', ['day' => $day, 'bookings' => $days[$day]])
                </div>
            @endforeach
        </div>

        {{-- Grid Baris 2: Kamis - Sabtu --}}
        <div class="row">
            @foreach (['Kamis', 'Jumat', 'Sabtu'] as $day)
                <div class="col-md-4 mb-4">
                    @include('partials.card', ['day' => $day, 'bookings' => $days[$day]])
                </div>
            @endforeach
        </div>

        {{-- Grid Baris 3: Minggu --}}
        <div class="row">
            <div class="col-md-4 mb-4">
                @include('partials.card', ['day' => 'Minggu', 'bookings' => $days['Minggu']])
            </div>
        </div>
    </div>
@endsection
