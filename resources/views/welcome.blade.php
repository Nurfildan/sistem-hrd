<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Sistem Informasi Kepegawaian</title>

    <!-- SB Admin 2 Bootstrap & FontAwesome -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div
        class="container min-vh-100 d-flex flex-column justify-content-center align-items-center text-center text-white">
        <h1 class="mb-3 font-weight-bold">Sistem Informasi Kepegawaian</h1>
        <p class="mb-4">Selamat datang di portal kepegawaian. Silakan login atau daftar untuk melanjutkan.</p>

        @if (Route::has('login'))
            <div class="mt-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg mr-2">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                @endauth
            </div>
        @endif
    </div>

    <!-- SB Admin 2 JS -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>