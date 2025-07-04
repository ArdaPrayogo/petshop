@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Tambah Tagihan</h2>

        {{-- Error Handling --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bills.store') }}" method="POST">
            @csrf

            {{-- PILIH BOOKING --}}
            <div class="mb-3">
                <label>Booking (Hewan - Layanan)</label>
                <select name="booking_id" id="booking-select" class="form-select" required>
                    <option value="">-- Pilih Booking --</option>
                    @foreach ($bookings as $booking)
                        <option value="{{ $booking->id }}" data-services='@json($booking->services->map(fn($s) => ['name' => $s->name, 'price' => $s->price]))'>
                            {{ $booking->pet->name }} - {{ $booking->services->pluck('name')->join(', ') }}
                            ({{ $booking->pet->user->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DETAIL LAYANAN --}}
            <div class="mb-3">
                <label>Detail Layanan & Harga</label>
                <div id="service-detail" class="form-control bg-light" style="height:auto;">
                    <em>Silakan pilih booking terlebih dahulu</em>
                </div>
            </div>

            {{-- TANGGAL TAGIHAN --}}
            <div class="mb-3">
                <label>Tanggal Tagihan</label>
                <input type="date" name="bill_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            {{-- STATUS --}}
            <div class="mb-3">
                <label>Status</label>
                <select name="status" id="status-select" class="form-select" required>
                    <option value="unpaid">Belum Lunas</option>
                    <option value="paid">Lunas</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>

            {{-- JUMLAH DIBAYARKAN --}}
            <div class="mb-3" id="paid-amount-group" style="display: none;">
                <label>Jumlah Dibayarkan</label>
                <input type="number" name="paid_amount" id="paid_amount" class="form-control" step="0.01" min="0"
                    placeholder="Masukkan jumlah pembayaran">
            </div>

            {{-- KEMBALIAN --}}
            <div class="mb-3" id="change-amount-group" style="display: none;">
                <label>Kembalian</label>
                <input type="text" class="form-control bg-light" id="change_display" readonly>
            </div>

            {{-- TOTAL (Hidden) --}}
            <input type="hidden" name="total_amount" id="total_amount">

            {{-- SUBMIT --}}
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('bills.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    {{-- JS UNTUK MENAMPILKAN DETAIL DAN HITUNG KEMBALIAN --}}
    <script>
        const bookingSelect = document.getElementById('booking-select');
        const serviceDetail = document.getElementById('service-detail');
        const totalInput = document.getElementById('total_amount');
        const statusSelect = document.getElementById('status-select');
        const paidGroup = document.getElementById('paid-amount-group');
        const paidInput = document.getElementById('paid_amount');
        const changeGroup = document.getElementById('change-amount-group');
        const changeDisplay = document.getElementById('change_display');

        bookingSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const services = JSON.parse(selected.getAttribute('data-services') || '[]');

            if (services.length > 0) {
                let html = '<ul>';
                let total = 0;
                services.forEach(service => {
                    html +=
                        `<li>${service.name} - Rp ${parseFloat(service.price).toLocaleString('id-ID')}</li>`;
                    total += parseFloat(service.price);
                });
                html += `</ul><strong>Total:</strong> Rp ${total.toLocaleString('id-ID')}`;
                serviceDetail.innerHTML = html;
                totalInput.value = total;

                // Reset paid & change display
                paidInput.value = '';
                changeDisplay.value = '';
                changeGroup.style.display = 'none';
            } else {
                serviceDetail.innerHTML = '<em>Silakan pilih booking terlebih dahulu</em>';
                totalInput.value = '';
            }
        });

        statusSelect.addEventListener('change', function() {
            if (this.value === 'paid') {
                paidGroup.style.display = 'block';
            } else {
                paidGroup.style.display = 'none';
                changeGroup.style.display = 'none';
                paidInput.value = '';
                changeDisplay.value = '';
            }
        });

        paidInput.addEventListener('input', function() {
            const total = parseFloat(totalInput.value || 0);
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
