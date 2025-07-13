@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Pembayaran Tagihan</h2>

        {{-- Alert --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Detail Booking --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5>Hewan: {{ $bill->booking->pet->name }} ({{ $bill->booking->pet->user->name }})</h5>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</p>
                <p><strong>Layanan:</strong></p>
                <ul>
                    @foreach ($bill->booking->services as $service)
                        <li>{{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
                <p><strong>Total:</strong> Rp {{ number_format($bill->total_amount, 0, ',', '.') }}</p>
                <p><strong>Status:</strong>
                    <span class="badge bg-{{ $bill->status === 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($bill->status) }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Form Pembayaran --}}
        @if ($bill->status === 'unpaid')
            <form method="POST" action="{{ route('bills.pay.process', $bill->id) }}">
                @csrf

                {{-- Jumlah Bayar --}}
                <div class="mb-3">
                    <label>Jumlah Dibayarkan</label>
                    <input type="number" name="paid_amount" id="paid_amount" class="form-control" step="0.01"
                        min="{{ $bill->total_amount }}" placeholder="Minimal Rp {{ $bill->total_amount }}" required>
                </div>

                {{-- Kembalian --}}
                <div class="mb-3" id="change-group" style="display:none;">
                    <label>Kembalian</label>
                    <input type="text" id="change_display" class="form-control bg-light" readonly>
                </div>

                {{-- Metode --}}
                <div class="mb-3">
                    <label>Metode Pembayaran</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="cash">Cash / Tunai</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>

                <button class="btn btn-success">Bayar</button>
                <a href="{{ route('bills.index') }}" class="btn btn-danger">Batal</a>
            </form>
        @else
            <div class="alert alert-success">Tagihan ini sudah dibayar.</div>
            <a href="{{ route('bills.index') }}" class="btn btn-secondary">Kembali</a>
        @endif
    </div>

    <script>
        const input = document.getElementById('paid_amount');
        const changeGroup = document.getElementById('change-group');
        const changeDisplay = document.getElementById('change_display');
        const total = {{ $bill->total_amount }};

        input.addEventListener('input', function() {
            const paid = parseFloat(this.value || 0);
            const change = paid - total;

            if (!isNaN(change) && change >= 0) {
                changeDisplay.value = `Rp ${change.toLocaleString('id-ID')}`;
                changeGroup.style.display = 'block';
            } else {
                changeDisplay.value = '';
                changeGroup.style.display = 'none';
            }
        });
    </script>
@endsection
