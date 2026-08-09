<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Wi-Fi Billing') }}</title>

    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-adminlte.css') }}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline shadow-lg overflow-hidden">
            <div class="row no-gutters">
                <div class="col-lg-6 login-hero">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h2>{{ config('app.name', 'Wi-Fi Billing') }}</h2>
                        <p>Kelola tagihan, pelanggan, dan pemantauan jaringan dengan tampilan yang lebih rapi dan profesional.</p>
                        <ul class="hero-list">
                            <li><i class="fas fa-check-circle"></i> Pantau pelanggan secara real-time</li>
                            <li><i class="fas fa-check-circle"></i> Kelola tagihan dan pembayaran</li>
                            <li><i class="fas fa-check-circle"></i> Lacak aktivitas operasional lebih cepat</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card-body login-card-body">
                        <div class="text-center mb-4">
                            <div class="brand-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h3 class="mb-1">Selamat Datang</h3>
                            <p class="text-muted mb-0">Masuk untuk melanjutkan ke dashboard</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="input-group mb-3">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-lock"></span></div>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-6">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember" name="remember">
                                        <label for="remember">Ingat saya</label>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">Lupa password?</a>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </form>

                        @if (Route::has('register'))
                            <p class="mb-0 mt-3 text-center">
                                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
