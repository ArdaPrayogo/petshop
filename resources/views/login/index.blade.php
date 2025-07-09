<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Aura Petshop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Lexend', sans-serif;
            background-color: #fdfcf9;
        }

        .login-container {
            margin-top: 5rem;
            background: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .login-title {
            font-weight: 700;
            color: #4e4e4e;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                {{-- Alerts --}}
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

                {{-- Login Box --}}
                <div class="login-container text-center">
                    <img src="/img/logopet.jpg" alt="Pet Paw" class="login-img">
                    <h3 class="login-title mb-4">Masuk ke Alila Petcare</h3>

                    <form action="/login" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" id="email"
                                placeholder="name@example.com" value="{{ old('email') }}" required>
                            <label for="email">Alamat Email</label>
                            @error('email')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Password" required>
                            <label for="password">Kata Sandi</label>
                        </div>

                        <button class="btn btn-primary w-100 mb-3" type="submit">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </button>

                        <small class="d-block text-muted">Belum punya akun?
                            <a href="/register" class="text-decoration-none">Daftar Sekarang</a>
                        </small>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Bootstrap Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
