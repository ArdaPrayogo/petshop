@extends('layouts.main')

@section('container')
    <div class="container py-4">
        {{-- Header --}}
        <div class="text-center mb-5">
            <h2 class="fw-bold">🐾 Selamat Datang di <span class="text-primary">Aura Petshop</span>!</h2>
            <p class="fs-5 text-muted">Perawatan terbaik untuk sahabat berbulu Anda sejak <strong>2025</strong></p>
        </div>

        {{-- Gambar & Tentang --}}
        <div class="row align-items-center mb-5">
            <div class="col-md-6 d-flex justify-content-center">
                <img src="/img/logopet.png" class="img-fluid w-50" alt="Petshop Aura">
            </div>

            <div class="col-md-6">
                <h4 class="fw-bold mb-3">Tentang Kami</h4>
                <p>
                    <strong>Aura Petshop</strong> adalah pusat layanan kesehatan dan perawatan hewan yang telah dipercaya
                    sejak 2025.
                    Kami menghadirkan perawatan terbaik dengan tenaga profesional dan kasih sayang terhadap hewan peliharaan
                    Anda.
                </p>
                <ul class="list-unstyled">
                    <li>🐶 Grooming</li>
                    <li>💉 Konsultasi Dokter Hewan</li>
                    <li>🏠 Penitipan Harian</li>
                    <li>🚗 Antar-Jemput Hewan</li>
                </ul>
                <div class="mt-3">
                    <p class="mb-1"><i class="bi bi-geo-alt-fill text-danger"></i> Jl. Samudra Pasai, RT 02 RW 06,
                        Kadipiro, Kecamatan Banjarsari, Jawa Tengah 57375.</p>
                    <p class="mb-1"><i class="bi bi-telephone-fill text-success"></i> 0812-3456-7890</p>
                    <p><i class="bi bi-instagram"></i> <a href="https://instagram.com/Aura.Petshop" target="_blank"
                            class="text-decoration-none">@Aura.Petshop</a></p>
                </div>
            </div>
        </div>

        {{-- Visi &  --}}
        <div class="row mb-5 g-4">
            <div class="col-md-12">
                <div class="p-4 border-start border-4 border-primary bg-light h-100 rounded">
                    <h5 class="fw-bold mb-3">🎯 Visi Kami</h5>
                    <p class="mb-0">
                        Menjadi pilihan utama keluarga Indonesia dalam memberikan perawatan yang aman, nyaman, dan
                        profesional bagi hewan kesayangan mereka.
                    </p>
                </div>
            </div>
        </div>

        {{-- Call To Action --}}
        <div class="text-center mt-4">
            @auth
                <a href="/mybooking" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-calendar-plus me-1"></i> Buat Jadwal Layanan Sekarang
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Buat Jadwal
                </a>
            @endauth
        </div>

    </div>
@endsection
