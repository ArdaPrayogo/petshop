@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Daftar Jadwal Layanan</h2>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hewan</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->pet->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->schedule_time)->format('d M Y H:i') }}</td>
                        <td>{{ ucfirst($booking->status) }}</td>
                        <td>
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>

                            {{-- Tombol Konfirmasi atau Selesaikan --}}
                            @if ($booking->status === 'pending')
                                <form action="{{ route('bookings.updateStatus', [$booking->id, 'confirmed']) }}"
                                    method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <button class="btn btn-success btn-sm"
                                        onclick="return confirm('Konfirmasi jadwal ini?')">Konfirmasi</button>
                                </form>
                            @elseif ($booking->status === 'confirmed')
                                <form action="{{ route('bookings.updateStatus', [$booking->id, 'completed']) }}"
                                    method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <button class="btn btn-primary btn-sm"
                                        onclick="return confirm('Tandai jadwal ini selesai?')">Selesaikan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
