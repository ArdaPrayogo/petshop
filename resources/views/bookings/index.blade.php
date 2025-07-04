@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Daftar Jadwal Layanan (Satu Per Hewan)</h2>
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
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus?')"
                                    class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
