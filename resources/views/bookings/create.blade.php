@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Tambah Jadwal Layanan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            {{-- Pilih Hewan --}}
            <div class="mb-3">
                <label for="pet_id">Hewan</label>
                <select name="pet_id" id="pet_id" class="form-select" required>
                    <option disabled selected>Pilih Hewan</option>
                    @foreach ($pets as $pet)
                        <option value="{{ $pet->id }}">
                            {{ $pet->name }} ({{ $pet->user->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Layanan (Checkbox) --}}
            <div class="mb-3">
                <label for="services">Pilih Layanan</label>
                <div class="form-control" style="height:auto;">
                    @foreach ($services as $service)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="services[]" value="{{ $service->id }}"
                                id="service-{{ $service->id }}">
                            <label class="form-check-label" for="service-{{ $service->id }}">
                                {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Jadwal --}}
            {{-- Pilih Hari --}}
            <div class="mb-3">
                <label for="day">Hari</label>
                <select name="day" id="day" class="form-select" required>
                    <option disabled selected>Pilih Hari</option>
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Jam --}}
            <div class="mb-3">
                <label for="time">Jam</label>
                <select name="time" id="time" class="form-select" required>
                    <option disabled selected>Pilih Jam</option>
                    @for ($hour = 8; $hour <= 20; $hour++)
                        <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                    @endfor
                </select>
            </div>


            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
