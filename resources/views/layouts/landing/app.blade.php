<!DOCTYPE html>
<html class="scroll-smooth" lang="id">

<head>
    <meta charset="utf-8">
    <title>BusTicket - Pesan Tiket Bus dengan Mudah dan Cepat</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Platform reservasi tiket bus online resmi di Indonesia - BusTicket">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: "#f0f7ff",
                            100: "#e0effe",
                            200: "#bae0fd",
                            500: "#0284c7",
                            600: "#006194",
                            700: "#004b73",
                            800: "#003554",
                            900: "#002237",
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        body: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome for fallback icons -->
    <link rel="stylesheet" href="{{ asset('landing/plugins/fontawesome/css/all.min.css') }}">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', Inter, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .hero-radial-glow {
            background: radial-gradient(circle 600px at 50% 150px, rgba(2, 132, 199, 0.08), transparent 70%);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50/70 text-slate-800 font-sans antialiased selection:bg-brand-100 selection:text-brand-800 min-h-screen flex flex-col">
    <div class="flex flex-col min-h-screen">

        @include('layouts.landing.topbar')

        <div class="flex-grow">
            @yield('content')
        </div>

        @include('layouts.landing.footer')

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @stack('scripts')

        @if (session('message') == 'sukses login')
            <script>
                Swal.fire({
                    title: "Berhasil",
                    text: "Berhasil Login ke BusTicket",
                    icon: "success",
                    confirmButtonColor: "#006194"
                });
            </script>
        @endif

        @if (session('message') == 'sukses logout')
            <script>
                Swal.fire({
                    title: "Berhasil",
                    text: "Anda Telah Logout",
                    icon: "success",
                    confirmButtonColor: "#006194"
                });
            </script>
        @endif

        @if (session('message') == 'register sukses')
            <script>
                Swal.fire({
                    title: "Registrasi Berhasil",
                    text: "Akun berhasil dibuat, silakan masuk",
                    icon: "success",
                    confirmButtonColor: "#006194"
                });
            </script>
        @endif

        @if (session('message') == 'gagal login')
            <script>
                Swal.fire({
                    title: "Gagal Masuk",
                    text: "Periksa kembali username/email dan password Anda",
                    icon: "error",
                    confirmButtonColor: "#006194"
                });
            </script>
        @endif

        @if (session('message') == 'need login')
            <script>
                Swal.fire({
                    title: "Perhatian",
                    text: "Anda harus masuk terlebih dahulu untuk melanjutkan",
                    icon: "warning",
                    confirmButtonColor: "#006194"
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    title: "Peringatan",
                    text: "{{ session('error') }}",
                    icon: "error",
                    confirmButtonColor: "#006194"
                });
            </script>
        @endif
        
        @if (session('success'))
            <script>
                Swal.fire({
                    title: "Sukses",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonColor: "#006194"
                });
            </script>
        @endif
    </div>
</body>

</html>