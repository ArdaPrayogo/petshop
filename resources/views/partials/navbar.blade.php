<nav class="navbar navbar-expand-lg bg-warning">
    <div class="container">
        <a class="navbar-brand" href="/">PETSHOP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page"
                            href="/">Home</a>
                    </li>
                @endcan
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pelanggan*') ? 'active' : '' }}" href="/pelanggan">Pelanggan</a>
                    </li>
                @endcan
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pets*') ? 'active' : '' }}" href="/pets">Pets</a>
                    </li>
                @endcan
                @can('customer')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('mypet*') ? 'active' : '' }}" href="/mypet">My Pet</a>
                    </li>
                @endcan
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('service*') ? 'active' : '' }}" href="/service">Service</a>
                    </li>
                @endcan
                @can('customer')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('ourservice*') ? 'active' : '' }}" href="/ourservice">our
                            service</a>
                    </li>
                @endcan
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('bookings*') ? 'active' : '' }}" href="/bookings">Pemesanan</a>
                    </li>
                @endcan
                @can('customer')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('mybooking*') ? 'active' : '' }}" href="/mybooking">Pemesanan</a>
                    </li>
                @endcan
                @can('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('bills*') ? 'active' : '' }}" href="/bills">Transaksi</a>
                    </li>
                @endcan
                @can('customer')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('mybill*') ? 'active' : '' }}" href="/mybill">Transaksi Saya</a>
                    </li>
                @endcan
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Welcome back, {{ auth()->user()->name }}
                        </a>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-in-right"></i>
                                Logout</button>
                        </form>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-layout-sidebar-reverse"></i> My
                                    dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-in-right"></i>
                                        Logout</button>
                                </form>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
