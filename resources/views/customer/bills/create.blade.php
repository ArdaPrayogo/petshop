@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Buat Tagihan Pembayaran</h2>

        {{-- Alert jika ada error --}}
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
                <h5>Hewan: {{ $booking->pet->name }} ({{ $booking->pet->user->name }})</h5>
                <p><strong>Tanggal Booking:</strong>
                    {{ \Carbon\Carbon::parse($booking->schedule_time)->format('d M Y H:i') }}</p>
                <p><strong>Layanan:</strong></p>
                <ul>
                    @foreach ($booking->services as $service)
                        <li>{{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Form Pembuatan Tagihan --}}
        <form method="POST" action="{{ route('bookings.pay.process', $booking->id) }}">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

            <div class="mb-3">
                <label>Total Tagihan</label>
                <input type="number" class="form-control" name="total_amount" value="{{ $total }}" readonly>
            </div>

            <div class="mb-3">
                <label>Jumlah Dibayarkan</label>
                <input type="number" name="paid_amount" id="paid_amount" class="form-control"
                    placeholder="Minimal Rp {{ $total }}" min="{{ $total }}" required>
            </div>

            <div class="mb-3" id="change-group" style="display:none;">
                <label>Kembalian</label>
                <input type="text" id="change_display" class="form-control bg-light" readonly>
            </div>

            <div class="mb-3">
                <label>Metode Pembayaran</label>
                <select name="payment_method" class="form-select" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="cash">Cash / Tunai</option>
                    <option value="transfer">Transfer</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>

            {{-- Status diset default dan tersembunyi --}}
            <input type="hidden" name="status" value="paid">
            <input type="hidden" name="bill_date" value="{{ \Carbon\Carbon::now()->toDateString() }}">

            <button class="btn btn-success">Buat Tagihan</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
        const input = document.getElementById('paid_amount');
        const changeGroup = document.getElementById('change-group');
        const changeDisplay = document.getElementById('change_display');
        const total = {{ $total }};

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
