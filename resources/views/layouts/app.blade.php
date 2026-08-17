<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} &mdash; BusTicket</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->
    @stack('styles')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
</head>

<body>

    <div id="app">
        <div class="main-wrapper">

            {{-- Header and Sidebar --}}
            @include('components.default.header')
            @include('components.default.sidebar')

            <!-- Main Content -->
            @yield('content')

            {{-- Footer --}}
            @include('components.footer')

        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    @stack('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @if (session('message') == 'store')
        <script>swal("Berhasil", "Berhasil tambah data", "success");</script>
    @endif
    @if (session('message') == 'update')
        <script>swal("Berhasil", "Berhasil update data", "success");</script>
    @endif
    @if (session('message') == 'hapus')
        <script>swal("Berhasil", "Berhasil hapus data", "success");</script>
    @endif
    @if (session('message') == 'kursi sudah ada')
        <script>swal("Warning", "Nomor kursi sudah ada pada bus ini", "error");</script>
    @endif
    @if (session('message') == 'sukses login')
        <script>swal("Berhasil", "Berhasil Login", "success");</script>
    @endif
    @if (session('message') == 'sukses logout')
        <script>swal("Berhasil", "Anda Telah Logout", "success");</script>
    @endif
    @if (session('message') == 'gagal login')
        <script>swal("Warning", "Periksa kembali username/email dan password anda", "error");</script>
    @endif
    @if (session('message') == 'need login')
        <script>swal("Warning", "Anda harus login terlebih dahulu", "error");</script>
    @endif
    @if (session('message') == 'update profile')
        <script>swal("Berhasil", "Profil berhasil diperbarui", "success");</script>
    @endif
    @if (session('error'))
        <script>swal("Error", "{{ session('error') }}", "error");</script>
    @endif
</body>

</html>