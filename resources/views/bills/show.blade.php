@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Detail Pembayaran</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $bill->booking->pet->name }}</h5>
                <p><strong>Pemilik:</strong> {{ $bill->booking->pet->user->name }}</p>

                <p><strong>Layanan:</strong></p>
                <ul class="mb-0 ps-3">
                    @foreach ($bill->booking->services as $service)
                        <li>{{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}</li>
                    @endforeach
                </ul>

                <hr>

                <p><strong>Total Tagihan:</strong> Rp {{ number_format($bill->total_amount, 0, ',', '.') }}</p>
                <p><strong>Tanggal Tagihan:</strong> {{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</p>
                <p><strong>Status:</strong>
                    <span
                        class="badge bg-{{ $bill->status === 'paid' ? 'success' : ($bill->status === 'unpaid' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($bill->status) }}
                    </span>
                </p>

                @if ($bill->status === 'paid')
                    <p><strong>Dibayar:</strong> Rp {{ number_format($bill->paid_amount, 0, ',', '.') }}</p>
                    <p><strong>Kembalian:</strong> Rp {{ number_format($bill->change_amount, 0, ',', '.') }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ ucfirst($bill->payment_method) }}</p>
                @else
                    <p class="text-danger">Tagihan ini belum dibayar.</p>
                    <a href="{{ route('bills.pay.form', $bill->id) }}" class="btn btn-success">Bayar Sekarang</a>
                @endif

                <a href="{{ url()->previous() }}" class="btn btn-secondary mt-2">Kembali</a>

            </div>
        </div>
    </div>
@endsection
