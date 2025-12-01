<x-guest-layout>
    <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body p-5">
            <!-- Header -->
            <div class="text-center mb-4">
                <div class="register-icon mb-3">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h1 class="h4 text-gray-900 font-weight-bold mb-2">Buat Akun Baru</h1>
                <p class="text-muted small">Daftar untuk mengakses sistem</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <input id="name" 
                           class="form-control form-control-user"
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           placeholder="Nama Lengkap">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" 
                           class="form-control form-control-user"
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="username"
                           placeholder="Alamat Email">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <input id="password" 
                           class="form-control form-control-user"
                           type="password"
                           name="password"
                           required 
                           autocomplete="new-password"
                           placeholder="Kata Sandi">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <input id="password_confirmation" 
                           class="form-control form-control-user"
                           type="password"
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="Konfirmasi Kata Sandi">
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Daftar Sekarang
                </button>
            </form>

            <hr>
            <div class="text-center">
                <a class="small text-decoration-none" href="{{ route('login') }}">
                    Sudah punya akun? Masuk di sini!
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Register Icon */
        .register-icon {
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

        /* Error Text */
        .text-danger {
            display: block;
            margin-top: 0.5rem;
            margin-left: 1.5rem;
            font-size: 0.85rem;
        }

        /* Form Group Spacing */
        .form-group {
            margin-bottom: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .card-body {
                padding: 2rem !important;
            }
        }
    </style>
</x-guest-layout>