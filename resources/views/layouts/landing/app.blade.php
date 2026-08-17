<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>BusTicket - Pesan Tiket Bus dengan Mudah</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Aplikasi pemesanan tiket bus online - BusTicket">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('landing/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('landing/plugins/fontawesome/css/all.min.css') }}">
    <!-- Animation -->
    <link rel="stylesheet" href="{{ asset('landing/plugins/animate-css/animate.css') }}">
    <!-- slick Carousel -->
    <link rel="stylesheet" href="{{ asset('landing/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/plugins/slick/slick-theme.css') }}">
    <!-- Template styles -->
    <link rel="stylesheet" href="{{ asset('landing/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/custome.css') }}">

    @stack('styles')
</head>

<body>
    <div class="body-inner">

        @include('layouts.landing.header')
        @include('layouts.landing.topbar')

        @yield('content')

        @include('layouts.landing.footer')

        <!-- initialize jQuery Library -->
        <script src="{{ asset('landing/plugins/jQuery/jquery.min.js') }}"></script>
        <!-- Bootstrap jQuery -->
        <script src="{{ asset('landing/plugins/bootstrap/bootstrap.min.js') }}" defer></script>
        <!-- Slick Carousel -->
        <script src="{{ asset('landing/plugins/slick/slick.min.js') }}"></script>
        <script src="{{ asset('landing/plugins/slick/slick-animation.min.js') }}"></script>
        <!-- Template custom -->
        <script src="{{ asset('landing/js/script.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @stack('scripts')

        @if (session('message') == 'sukses login')
            <script>
                Swal.fire("Berhasil", "Berhasil Login", "success");
            </script>
        @endif

        @if (session('message') == 'sukses logout')
            <script>
                Swal.fire("Berhasil", "Anda Telah Logout", "success");
            </script>
        @endif

        @if (session('message') == 'register sukses')
            <script>
                Swal.fire("Berhasil", "Registrasi berhasil, silakan login", "success");
            </script>
        @endif

        @if (session('message') == 'gagal login')
            <script>
                Swal.fire("Warning", "Periksa kembali username/email dan password anda", "error");
            </script>
        @endif

        @if (session('message') == 'need login')
            <script>
                Swal.fire("Warning", "Anda harus login terlebih dahulu", "error");
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire("Error", "{{ session('error') }}", "error");
            </script>
        @endif
    </div>
</body>

</html>