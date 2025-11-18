<x-guest-layout>
    <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body p-5">
            <!-- Header -->
            <div class="text-center mb-4">
                <div class="login-icon mb-3">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h1 class="h4 text-gray-900 font-weight-bold mb-2">Selamat Datang!</h1>
                <p class="text-muted small">Silakan masuk ke akun Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <input id="email" class="form-control form-control-user"
                        type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="Masukkan Email...">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <input id="password" class="form-control form-control-user"
                        type="password" name="password" required
                        placeholder="Kata Sandi">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="remember" id="remember_me"
                            class="custom-control-input">
                        <label class="custom-control-label" for="remember_me">Ingat Saya</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Masuk
                </button>
            </form>

            <hr>
            <div class="text-center">
                @if (Route::has('password.request'))
                    <a class="small text-decoration-none" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                @endif
            </div>
            <div class="text-center">
                <a class="small text-decoration-none" href="{{ route('register') }}">Buat Akun Baru!</a>
            </div>
        </div>
    </div>

    <style>
        /* Login Icon */
        .login-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        }

        /* Card Styling */
        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-body {
            background: #fff;
        }

        /* Form Control */
        .form-control-user {
            font-size: 0.9rem;
            border-radius: 10rem;
            padding: 1.25rem 1.5rem;
            border: 1px solid #e3e6f0;
            transition: all 0.3s ease;
        }

        .form-control-user:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
        }

        /* Button Styling */
        .btn-user {
            font-size: 0.95rem;
            border-radius: 10rem;
            padding: 0.85rem 1rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #224abe 0%, #1a3a9e 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Checkbox Custom */
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        /* Links */
        a.small {
            color: #4e73df;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        a.small:hover {
            color: #224abe;
        }

        /* HR Divider */
        hr {
            border-top: 1px solid #e3e6f0;
            margin: 1.5rem 0;
        }

        /* Text Colors */
        .text-gray-900 {
            color: #3a3b45;
        }

        /* Shadow */
        .shadow-lg {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .card-body {
                padding: 2rem !important;
            }
        }
    </style>
</x-guest-layout>