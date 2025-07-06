@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Detail Jadwal Layanan</h2>

        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Kembali</a>


        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Hewan: {{ $booking->pet->name }} ({{ $booking->pet->user->name }})
                </h5>
                <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($booking->schedule_time)->format('d M Y H:i') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                <hr>
                <p><strong>Layanan yang Dipilih:</strong></p>
                <ul>
                    @foreach ($booking->services as $service)
                        <li>{{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @can('customer')
            @if ($booking->status !== 'cancelled')
                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Yakin ingin membatalkan pemesanan ini?')">
                        Batalkan Pemesanan
                    </button>
                </form>
            @endif

            @if (in_array($booking->status, ['confirmed', 'completed']))
                <a href="{{ route('bookings.pay', $booking->id) }}" class="btn btn-success btn-sm ">
                    Bayar
                </a>
            @elseif ($booking->status === 'pending')
                <a href="{{ route('bookings.pay', $booking->id) }}" class="btn btn-success btn-sm disabled">
                    Bayar
                </a>
                <p class=" small text-muted mt-2">
                    Pembayaran hanya bisa dilakukan setelah pemesanan dikonfirmasi atau diselesaikan.
                </p>
            @endif
        @endcan


    </div>
@endsection
