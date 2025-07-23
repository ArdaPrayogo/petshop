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
                        <option value="{{ $pet->id }}">{{ $pet->name }}
                            (Pemilik : {{ $pet->user->name }})
                        </option>
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

            {{-- Pilih Tanggal & Waktu --}}
            <div class="mb-4">
                <label for="scheduled_at" class="form-label"><strong>Tanggal & Jam</strong></label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control" required>
            </div>

            {{-- Pickup Service --}}
            <div class="mb-4">
                <label class="form-label"><strong>Layanan Antar</strong></label>

                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pickup_service" id="pickup_yes" value="1"
                            required>
                        <label class="form-check-label" for="pickup_yes">Iya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pickup_service" id="pickup_no" value="0"
                            required>
                        <label class="form-check-label" for="pickup_no">Tidak</label>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="d-flex">
                <button type="submit" class="btn btn-primary me-3">
                    <i class="bi bi-floppy"></i> Simpan Jadwal
                </button>
                <a href="/mybooking" class="btn btn-danger">
                    <i class="bi bi-x-circle-fill"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
