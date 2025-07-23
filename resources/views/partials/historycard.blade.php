<div class="card shadow-sm h-100">
    <div class="card-header bg-dark-subtle text-black">
        <h5 class="mb-0">{{ $day }}</h5>
    </div>

    <div class="card-body">
        @if ($bookings->isEmpty())
            <p class="text-muted">Belum ada jadwal.</p>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach ($bookings as $booking)
                    @php
                        $bg = match ($booking->status) {
                            'pending' => 'border-warning bg-warning bg-opacity-25',
                            'confirmed' => 'border-primary bg-primary bg-opacity-25',
                            'completed' => 'border-success bg-success bg-opacity-25',
                            'canceled' => 'border-danger bg-danger bg-opacity-25',
                            default => 'border-secondary bg-light',
                        };
                    @endphp

                    <div class="card {{ $bg }} shadow-sm">
                        <div class="card-body py-2">
                            {{-- ADMIN --}}
                            @if (Auth::check() && Auth::user()->role === 'admin')
                                <strong>{{ $booking->pet->name }}</strong>
                                (Pemilik: {{ $booking->pet->user->name }})
                                <br>
                                Jadwal:
                                {{ \Carbon\Carbon::parse($booking->schedule_time)->translatedFormat('d F Y, H:i') }}<br>

                                Status:
                                <span
                                    class="badge 
                                    @if ($booking->status === 'pending') bg-warning 
                                    @elseif ($booking->status === 'confirmed') bg-primary 
                                    @elseif ($booking->status === 'completed') bg-success 
                                    @elseif ($booking->status === 'canceled') bg-danger 
                                    @else bg-secondary @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>

                                {{-- Tombol Aksi --}}
                                <div class="mt-2 d-flex flex-wrap gap-1">
                                    <a href="{{ route('bookings.show', $booking->id) }}"
                                        class="btn btn-sm btn-outline-info">Detail</a>
                                    <a href="{{ route('bookings.edit', $booking->id) }}?redirect_to={{ request()->fullUrl() }}"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>


                                    @if ($booking->status === 'pending')
                                        <form action="{{ route('bookings.updateStatus', [$booking->id, 'confirmed']) }}"
                                            method="POST" onsubmit="return confirm('Konfirmasi jadwal ini?')">
                                            @csrf @method('PUT')
                                            <button class="btn btn-sm btn-success">Konfirmasi</button>
                                        </form>
                                    @elseif ($booking->status === 'confirmed')
                                        <form
                                            action="{{ route('bookings.updateStatus', [$booking->id, 'completed']) }}"
                                            method="POST" onsubmit="return confirm('Tandai sebagai selesai?')">
                                            @csrf @method('PUT')
                                            <button class="btn btn-sm btn-primary">Selesaikan</button>
                                        </form>
                                    @endif
                                </div>

                                {{-- GUEST --}}
                            @else
                                <p><strong>Sudah Dipesan</strong></p>
                                Waktu :
                                {{ \Carbon\Carbon::parse($booking->schedule_time)->translatedFormat(' H:i') }}<br>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
