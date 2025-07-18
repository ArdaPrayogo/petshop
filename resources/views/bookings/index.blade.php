@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="mb-3 d-flex justify-content-between">
            <h2 class="p-0">Riwayat Jadwal Layanan</h2>
            @guest
                {{-- Guest: Belum login --}}
                <a href="{{ route('login') }}" class="btn btn-warning align-content-center">
                    <i class="bi bi-receipt-cutoff"></i> Pesan layanan
                </a>
            @else
                @if (auth()->user()->role === 'customer')
                    {{-- Customer: Tampilkan tombol ke form booking --}}
                    <a href="/mybooking/create" class="btn btn-warning align-content-center">
                        <i class="bi bi-receipt-cutoff"></i> Pesan layanan
                    </a>
                @endif
                {{-- Admin: Tidak ditampilkan --}}
            @endguest

            @can('admin')
                <div>
                    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3"><i class="bi bi-calendar2-plus"></i>
                        Tambah Jadwal</a>
                    <a href="/riwayat" class="btn btn-dark mb-3"><i class="bi bi-clock-history"></i> Riwayat Jadwal</a>
                </div>
            @endcan
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
