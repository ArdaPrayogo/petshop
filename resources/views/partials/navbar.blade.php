<nav class="navbar navbar-expand-lg bg-warning">
    <div class="container">
        <a class="navbar-brand" href="/">PETSHOP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                {{-- HOME --}}
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/admin">Home</a>
                    </li>
                @endcan
                @if (!auth()->check() || Gate::allows('customer'))
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
                    </li>
                @endif

                {{-- MENU ADMIN --}}
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pelanggan*') ? 'active' : '' }}" href="/pelanggan">Pelanggan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pets*') ? 'active' : '' }}" href="/pets">Pets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('service*') ? 'active' : '' }}" href="/service">Service</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('bookings*') ? 'active' : '' }}" href="/bookings">Pemesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('bills*') ? 'active' : '' }}" href="/bills">Transaksi</a>
                    </li>
                @endcan

                {{-- MENU CUSTOMER - Tampil selalu, redirect ke login jika belum login --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('ourservice*') ? 'active' : '' }}" href="/ourservice">
                        Our Service
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('mypet*') ? 'active' : '' }}"
                        href="{{ auth()->check() && Gate::allows('customer') ? '/mypet' : route('login') }}">
                        My Pet
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('mybooking*') ? 'active' : '' }}"
                        href="{{ auth()->check() && Gate::allows('customer') ? '/mybooking' : route('login') }}">
                        Pemesanan Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('mybill*') ? 'active' : '' }}"
                        href="{{ auth()->check() && Gate::allows('customer') ? '/mybill' : route('login') }}">
                        Transaksi Saya
                    </a>
                </li>
            </ul>

            {{-- AUTH SECTION --}}
            <ul class="navbar-nav ms-auto align-items-center">
                @guest
                    {{-- Tombol Login --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                @else
                    {{-- Link Profile --}}
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                    </li>
                    {{-- Tombol Logout --}}
                    <li class="nav-item">
                        <form action="/logout" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link"
                                style="border: none; padding: 0; margin-left: 10px;">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
