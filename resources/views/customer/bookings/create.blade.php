@extends('layouts.main')

@section('container')
    <div class="container">
        <h2 class="mb-4">Tambah Jadwal Layanan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            {{-- Pilih Hewan --}}
            <div class="mb-4">
                <label for="pet_id" class="form-label"><strong>Hewan Peliharaan</strong></label>
                <select name="pet_id" id="pet_id" class="form-select" required>
                    <option disabled selected>Pilih Hewan Anda</option>
                    @foreach ($pets as $pet)
                        <option value="{{ $pet->id }}">{{ $pet->name }} ({{ $pet->species }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Layanan --}}
            <div class="mb-4">
                <label class="form-label"><strong>Pilih Layanan</strong></label>
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="services[]"
                                            value="{{ $service->id }}" id="service-{{ $service->id }}">
                                        <label class="form-check-label" for="service-{{ $service->id }}">
                                            <strong>{{ $service->name }}</strong>
                                        </label>
                                    </div>
                                    <hr>
                                    <p class="mb-1"><i class="bi bi-cash"></i> Rp
                                        {{ number_format($service->price, 0, ',', '.') }}</p>
                                    <p class="mb-0"><i class="bi bi-clock"></i> {{ $service->duration }} menit</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Pilih Hari --}}
            <div class="mb-3">
                <label for="day" class="form-label"><strong>Hari</strong></label>
                <select name="day" id="day" class="form-select" required>
                    <option disabled selected>Pilih Hari</option>
                    @foreach ($days as $day)
                        <option value="{{ $day['label'] }}">{{ $day['display'] }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Jam --}}
            <div class="mb-3">
                <label for="time" class="form-label"><strong>Jam</strong></label>
                <select name="time" id="time" class="form-select" required>
                    <option disabled selected>Pilih Jam</option>
                    @for ($hour = 8; $hour <= 20; $hour++)
                        <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                    @endfor
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/mybooking" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
@endsection
