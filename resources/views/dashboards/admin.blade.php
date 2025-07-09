@extends('layouts.main')

@section('container')
    <div class="container py-4">
        <h2 class="mb-4">Dashboard Admin</h2>

        <div class="row g-4">
            {{-- Pelanggan --}}
            <div class="col-md-6 col-lg-4">
                <a href="/pelanggan" class="text-decoration-none">
                    <div class="card border-primary shadow h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-people display-5 text-primary mb-3"></i>
                            <h5 class="card-title">Pelanggan</h5>
                            <p class="card-text">Lihat & kelola data pelanggan.</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Hewan (Pet) --}}
            <div class="col-md-6 col-lg-4">
                <a href="/pets" class="text-decoration-none">
                    <div class="card border-success shadow h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-heart display-5 text-success mb-3"></i>
                            <h5 class="card-title">Hewan</h5>
                            <p class="card-text">Data hewan peliharaan pelanggan.</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Layanan --}}
            <div class="col-md-6 col-lg-4">
                <a href="/service" class="text-decoration-none">
                    <div class="card border-info shadow h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-gear display-5 text-info mb-3"></i>
                            <h5 class="card-title">Layanan</h5>
                            <p class="card-text">Kelola jenis layanan & harga.</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Pemesanan --}}
            <div class="col-md-6 col-lg-4">
                <a href="/bookings" class="text-decoration-none">
                    <div class="card border-warning shadow h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-check display-5 text-warning mb-3"></i>
                            <h5 class="card-title">Pemesanan</h5>
                            <p class="card-text">Kelola jadwal layanan pelanggan.</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Transaksi --}}
            <div class="col-md-6 col-lg-4">
                <a href="/bill" class="text-decoration-none">
                    <div class="card border-danger shadow h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-receipt display-5 text-danger mb-3"></i>
                            <h5 class="card-title">Transaksi</h5>
                            <p class="card-text">Kelola tagihan & pembayaran.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
