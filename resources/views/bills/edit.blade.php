@extends('layouts.main')

@section('container')
    <div class="container">
        <h2>Edit Tagihan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bills.update', $bill->id) }}" method="POST">
            @csrf @method('PUT')

            {{-- SELECT BOOKING --}}
            <div class="mb-3">
                <label>Booking (Hewan - Layanan)</label>
                <select name="booking_id" id="booking-select" class="form-select" required>
                    @foreach ($appointments as $a)
                        <option value="{{ $a->id }}" data-services='@json($a->services->map(fn($s) => ['name' => $s->name, 'price' => $s->price]))'
                            {{ $bill->booking_id == $a->id ? 'selected' : '' }}>
                            {{ $a->pet->name }} - {{ $a->services->pluck('name')->join(', ') }} ({{ $a->pet->user->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DETAIL LAYANAN --}}
            <div class="mb-3">
                <label>Detail Layanan & Harga</label>
                <div id="service-detail" class="form-control bg-light" style="height:auto;">
                    <em>Silakan pilih booking untuk melihat layanan</em>
                </div>
            </div>

            {{-- INPUT TANGGAL --}}
            <div class="mb-3">
                <label>Tanggal Tagihan</label>
                <input type="date" name="bill_date" class="form-control" value="{{ $bill->bill_date }}" required>
            </div>

            {{-- SELECT STATUS --}}
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    @foreach (['unpaid', 'paid', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $bill->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- HIDDEN TOTAL --}}
            <input type="hidden" name="total_amount" id="total_amount" value="{{ $bill->total_amount }}">

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('bills.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    {{-- SCRIPT UNTUK MENAMPILKAN DETAIL LAYANAN --}}
    <script>
        function updateServiceDetail() {
            const select = document.getElementById('booking-select');
            const selected = select.options[select.selectedIndex];
            const services = JSON.parse(selected.getAttribute('data-services') || '[]');

            const detailDiv = document.getElementById('service-detail');
            const totalInput = document.getElementById('total_amount');

            if (services.length > 0) {
                let html = '<ul>';
                let total = 0;

                services.forEach(service => {
                    html += `<li>${service.name} - Rp ${parseFloat(service.price).toLocaleString('id-ID')}</li>`;
                    total += parseFloat(service.price);
                });

                html += `</ul><strong>Total:</strong> Rp ${total.toLocaleString('id-ID')}`;
                detailDiv.innerHTML = html;
                totalInput.value = total;
            } else {
                detailDiv.innerHTML = '<em>Silakan pilih booking terlebih dahulu</em>';
                totalInput.value = '';
            }
        }

        // Panggil saat halaman pertama kali dimuat
        window.addEventListener('DOMContentLoaded', updateServiceDetail);

        // Panggil ulang saat select berubah
        document.getElementById('booking-select').addEventListener('change', updateServiceDetail);
    </script>
@endsection
