@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Detail Tagihan</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $bill->booking->pet->name }}
                </h5>

                <p><strong>Pemilik:</strong> {{ $bill->booking->pet->user->name }}</p>

                <p><strong>Layanan:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($bill->booking->services as $service)
                        <li>{{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
                </p>

                <p><strong>Total:</strong> Rp {{ number_format($bill->total_amount, 0, ',', '.') }}</p>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($bill->status) }}</p>

                <a href="{{ route('bills.edit', $bill->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('bills.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
