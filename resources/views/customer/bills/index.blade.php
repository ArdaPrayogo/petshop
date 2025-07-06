@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Daftar Tagihan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hewan</th>
                    <th>Layanan</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bills as $bill)
                    <tr>
                        <td>{{ $bill->booking->pet->name }} ({{ $bill->booking->pet->user->name }})</td>
                        <td>
                            <ul class="mb-0 ps-3">
                                @foreach ($bill->booking->services as $service)
                                    <li>{{ $service->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>Rp {{ number_format($bill->total_amount, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</td>
                        <td>
                            @php
                                $badge = match ($bill->status) {
                                    'unpaid' => 'warning',
                                    'paid' => 'success',
                                    'cancelled' => 'secondary',
                                    default => 'light',
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($bill->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-info btn-sm">Lihat</a>

                            @if ($bill->status === 'unpaid')
                                <a href="{{ route('bills.pay.form', $bill->id) }}" class="btn btn-success btn-sm">
                                    Bayar
                                </a>
                            @endif

                            @can('admin')
                                <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus tagihan ini?')" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
