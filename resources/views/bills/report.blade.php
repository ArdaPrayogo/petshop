<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Tagihan Bulanan - {{ $selectedMonth }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        h1,
        h2 {
            text-align: center;
            margin: 0;
        }

        .header {
            margin-bottom: 20px;
        }

        .no-data {
            text-align: center;
            margin-top: 50px;
            font-style: italic;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>AURA PETSHOP</h1>
        <h2>Laporan Tagihan Bulanan - {{ $selectedMonth }}</h2>
    </div>

    @if ($bills->isEmpty())
        <p class="no-data">Belum ada laporan bulan ini.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Hewan (Pemilik)</th>
                    <th>Layanan</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bills as $bill)
                    <tr>
                        <td>{{ $bill->booking->pet->name }} ({{ $bill->booking->pet->user->name }})</td>
                        <td>
                            <ul style="margin:0; padding-left:15px;">
                                @foreach ($bill->booking->services as $service)
                                    <li>{{ $service->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>Rp {{ number_format($bill->total_amount, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</td>
                        <td>{{ ucfirst($bill->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
