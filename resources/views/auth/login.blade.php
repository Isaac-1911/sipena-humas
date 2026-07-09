<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SIPENA HUMAS</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
        }

        .login-page {
            min-height: 100vh;
        }

        /* LEFT */

        .login-left {
            background:
                linear-gradient(
                    rgba(7,28,54,.92),
                    rgba(7,28,54,.92)
                ),
                url('../images/hero-fix.jpeg');

            background-size: cover;
            background-position: center;

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 50px;
        }

        .login-branding {
            max-width: 420px;
        }

        /* .login-logo {
            width: 68px;
            height: 68px;

            border-radius: 20px; */

            /* background: #d4af37; */
            /* background: #ffffff;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 24px;
        } */

        .login-logo img {
            width: 68px;
            height: 68px;
            object-fit: contain;
            padding-bottom: 10px;
        }

        .login-branding h1 {
            font-size: 36px;
            font-weight: 700;
            line-height: 1.3;

            margin-bottom: 16px;
        }

        .login-branding p {
            font-size: 13px;
            line-height: 2;

            color: rgba(255,255,255,.75);
        }

        /* RIGHT */

        .login-right {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;

            background: white;

            border-radius: 24px;

            padding: 36px;

            box-shadow: 0 10px 40px rgba(0,0,0,.05);
        }

        .login-card h2 {
            font-size: 28px;
            font-weight: 700;

            color: #0f172a;

            margin-bottom: 8px;
        }

        .login-card p {
            font-size: 14px;
            color: #64748b;

            margin-bottom: 28px;
        }

        /* FORM */

        .form-label {
            font-size: 14px;
            font-weight: 600;

            color: #334155;

            margin-bottom: 8px;
        }

        .form-control {
            height: 46px;

            border-radius: 14px;
            border: 1px solid #dbe2ea;

            font-size: 13px;

            padding: 0 16px;

            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #d4af37;
        }

        /* REMEMBER */

        .remember-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-top: 18px;
            margin-bottom: 24px;
        }

        .form-check-label {
            font-size: 13px;
            color: #64748b;
        }

        .forgot-link {
            font-size: 13px;
            color: #0f172a;

            text-decoration: none;
            font-weight: 600;
        }

        /* BUTTON */

        .login-btn {
            width: 100%;
            height: 48px;

            border: none;
            border-radius: 14px;

            background: #0f172a;
            color: white;

            font-size: 14px;
            font-weight: 600;

            transition: .3s ease;
        }

        .login-btn:hover {
            background: #1e293b;
        }

        /* ALERT */

        .alert {
            font-size: 11px;
            border-radius: 14px;
        }

        .invalid-feedback {
            font-size: 10px;
        }

        /* MOBILE */

        @media (max-width: 991px) {

            .login-left {
                display: none;
            }

            .login-right {
                padding: 20px;
            }

            .login-card {
                padding: 28px;
            }

        }

    </style>

</head>
<body>

<div class="container-fluid">

    <div class="row login-page">

        {{-- LEFT --}}
        <div class="col-lg-6 d-none d-lg-flex login-left">

            <div class="login-branding">

                <div class="login-logo">

                    <img src="{{ asset('images/logo-fixxx.png') }}"
                         alt="Logo">

                </div>

                <h1>
                    SIPENA HUMAS<br>
                    POLRES JEMBER
                </h1>

                <p>
                    Sistem Pelayanan dan Arsip HUMAS Polres Jember.

                    Portal informasi publik yang modern,
                    transparan, dan terpercaya.
                </p>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-6 login-right">

            <div class="login-card">

                <h2>
                    Login Admin
                </h2>

                <p>
                    Masuk ke dashboard SIPENA HUMAS.
                </p>

                {{-- Session Status --}}
                @if (session('status'))

                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>

                @endif

                <form method="POST"
                      action="{{ route('login') }}">

                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="admin@sipena.com"
                               required
                               autofocus>

                        @error('email')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••"
                               required>

                        @error('password')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    {{-- REMEMBER --}}
                    <div class="remember-wrapper">

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remember"
                                   id="remember">

                            <label class="form-check-label"
                                   for="remember">

                                Remember me

                            </label>

                        </div>

                        @if (Route::has('password.request'))

                            <a href="{{ route('password.request') }}"
                               class="forgot-link">

                                Lupa Password?

                            </a>

                        @endif

                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                            class="login-btn">

                        <i class="bi bi-box-arrow-in-right"></i>

                        Login

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>
