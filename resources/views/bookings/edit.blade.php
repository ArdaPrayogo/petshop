@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Edit Jadwal Layanan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Hewan</label>
                <select name="pet_id" class="form-select" required>
                    @foreach ($pets as $pet)
                        <option value="{{ $pet->id }}" {{ $booking->pet_id == $pet->id ? 'selected' : '' }}>
                            {{ $pet->name }} ({{ $pet->user->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Layanan</label>
                <select name="service_id" class="form-select" required>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{ $booking->service_id == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Waktu Jadwal</label>
                <input type="datetime-local" name="schedule_time" class="form-control"
                    value="{{ \Carbon\Carbon::parse($booking->schedule_time)->format('Y-m-d\TH:i') }}" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    @foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $booking->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
