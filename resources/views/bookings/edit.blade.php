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

            @can('admin')
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
            @endcan

            @can('customer')
                <div class="mb-3">
                    <label>Hewan</label>
                    <select name="pet_id" class="form-select" required disabled>
                        @foreach ($pets as $pet)
                            <option value="{{ $pet->id }}" {{ $booking->pet_id == $pet->id ? 'selected' : '' }}>
                                {{ $pet->name }} ({{ $pet->user->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endcan

            <div class="mb-3">
                <label>Layanan</label>
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="service_ids[]"
                                    value="{{ $service->id }}"
                                    {{ in_array($service->id, $booking->services->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $service->name }} (Rp{{ number_format($service->price) }})
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="mb-3">
                <label>Waktu Jadwal</label>
                <input type="datetime-local" name="schedule_time" class="form-control"
                    value="{{ \Carbon\Carbon::parse($booking->schedule_time)->format('Y-m-d\TH:i') }}" required>
            </div>

            @can('admin')
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
            @endcan

            @can('customer')
                <input type="hidden" name="status" value="{{ $booking->status }}">
            @endcan

            <button class="btn btn-primary">Update</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Kembali</a>
        </form>
    </div>
@endsection
