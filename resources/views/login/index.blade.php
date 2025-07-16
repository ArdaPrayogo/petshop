<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Aura Petshop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: "MuseoModerno", sans-serif;
            font-optical-sizing: auto;
            font-weight: normal;
            font-style: normal;

            background-color: #F3E8EE;
            background-image: url('/img/bg_login.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Overlay gelap */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .login-container {
            margin-top: 8rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .login-title {
            font-weight: 700;
            color: #fff;
        }

        .login-img {
            max-width: 100px;
            margin-bottom: 1rem;
        }

        .btn-primary {
            background-color: #ff914d;
            border-color: #ff914d;
        }

        .btn-primary:hover {
            background-color: #ff7a26;
            border-color: #ff7a26;
        }

        .form-control:focus {
            border-color: #ff914d;
            box-shadow: 0 0 0 0.2rem rgba(255, 145, 77, 0.25);
        }

        .motto-box {
            margin-top: 25rem;
            color: #fff;
            padding: 2rem;
            border-radius: 1rem;
        }

        .motto-box h3 {
            font-weight: 700;
        }

        .motto-box p {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .motto-box {
                text-align: center;
                margin-top: 2rem;
            }

            .login-container {
                margin-top: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row align-items-center">

            <div class="mt-5">
                <button onclick="window.history.back()" class="btn btn-warning btn-sm">
                    <i class="bi bi-arrow-bar-left"></i>Kembali
                </button>
            </div>

            <!-- Login Card -->
            <div class="col-md-5">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                        {{ session('loginError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="login-container text-center text-white">
                    <img src="/img/logopet.png" alt="Pet Paw" class="login-img" />
                    <h3 class="login-title mb-4">Masuk ke Aura Petshop</h3>

                    <form action="/login" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" id="email"
                                placeholder="name@example.com" value="{{ old('email') }}" required />
                            <label for="email" class="text-black">Email</label>
                            @error('email')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Password" required />
                            <label for="password" class="text-black">Kata Sandi</label>
                        </div>

                        <button class="btn btn-primary w-100 mb-3" type="submit">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </button>

                        <small class="d-block text-light">Belum punya akun?
                            <a href="/register" class="text-decoration-none text-warning">Daftar Sekarang</a>
                        </small>
                    </form>
                </div>
            </div>

            <!-- Moto / Quote -->
            <div class="col-md-7">
                <div class="motto-box">
                    {{-- <img src="/img/logopet.png" alt="Pet Paw" class="login-img" /> --}}
                    <h3 class="fw-bold">"Merawat dengan Hati,<br />Menyayangi Sepenuh Jiwa."</h3>
                    <p class="mt-3">Bersama Aura Petshop, setiap hewan adalah bagian dari keluarga. ❤️</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
