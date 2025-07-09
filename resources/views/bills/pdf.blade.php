<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pembayaran</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }

        h2 {
            margin-bottom: 20px;
        }

        ul {
            padding-left: 20px;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-size: 0.9rem;
        }

        .bg-success {
            background-color: #198754;
        }

        .bg-warning {
            background-color: #ffc107;
            color: black;
        }

        .bg-secondary {
            background-color: #6c757d;
        }

        .text-danger {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Detail Pembayaran</h2>

    <p><strong>🐾 Hewan:</strong> {{ $bill->booking->pet->name }}</p>
    <p><strong>👤 Pemilik:</strong> {{ $bill->booking->pet->user->name }}</p>

    <p><strong>🛠️ Layanan:</strong></p>
    <ul>
        @foreach ($bill->booking->services as $service)
            <li>{{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}</li>
        @endforeach
    </ul>

    <hr>

    <p><strong>💰 Total Tagihan:</strong> Rp {{ number_format($bill->total_amount, 0, ',', '.') }}</p>
    <p><strong>🗓️ Tanggal Tagihan:</strong> {{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</p>
    <p><strong>📌 Status:</strong>
        <span
            class="badge 
            @if ($bill->status === 'paid') bg-success 
            @elseif ($bill->status === 'unpaid') bg-warning 
            @else bg-secondary @endif">
            {{ ucfirst($bill->status) }}
        </span>
    </p>

    @if ($bill->status === 'paid')
        <p><strong>💵 Dibayar:</strong> Rp {{ number_format($bill->paid_amount, 0, ',', '.') }}</p>
        <p><strong>🎁 Kembalian:</strong> Rp {{ number_format($bill->change_amount, 0, ',', '.') }}</p>
        <p><strong>💳 Metode Pembayaran:</strong> {{ ucfirst($bill->payment_method) }}</p>
    @else
        <p class="text-danger">⚠️ Tagihan ini belum dibayar.</p>
    @endif
</body>

</html>
