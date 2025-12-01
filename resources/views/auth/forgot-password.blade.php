<x-guest-layout>
    <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body p-5">
            <!-- Header -->
            <div class="text-center mb-4">
                <div class="forgot-icon mb-3">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h1 class="h4 text-gray-900 font-weight-bold mb-2">Lupa Kata Sandi?</h1>
                <p class="text-muted small">Tidak masalah! Masukkan email Anda dan kami akan mengirimkan link untuk reset kata sandi.</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" 
                           class="form-control form-control-user"
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           placeholder="Masukkan Email Anda...">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Kirim Link Reset Password
                </button>
            </form>

            <hr>
            <div class="text-center">
                <a class="small text-decoration-none" href="{{ route('login') }}">
                    Kembali ke Halaman Login
                </a>
            </div>
            <div class="text-center">
                <a class="small text-decoration-none" href="{{ route('register') }}">
                    Buat Akun Baru!
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Forgot Icon */
        .forgot-icon {
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

        /* Alert Styling */
        .alert-success {
            border-radius: 10px;
            border: none;
            background-color: #d4edda;
            color: #155724;
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