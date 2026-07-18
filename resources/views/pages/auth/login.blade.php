@extends('layouts.auth', ['title' => 'Login'])
@section('content')
@push('styles')
<style>
    /* ============================================================
       LOGIN PAGE STYLES - Premium Gradient Biru Landing Page
       ============================================================ */
    
    /* ===== ROOT VARIABLES ===== */
    :root {
        --navy-dark: #0B1F3A;
        --navy-medium: #123E73;
        --navy-light: #1E5AA8;
        --navy-gradient: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%);
        --white: #FFFFFF;
        --light-gray: #F8F9FA;
        --gray: #6C757D;
        --shadow-sm: 0 4px 20px rgba(11, 31, 58, 0.08);
        --shadow-md: 0 8px 40px rgba(11, 31, 58, 0.12);
        --shadow-lg: 0 16px 60px rgba(11, 31, 58, 0.15);
        --shadow-xl: 0 24px 80px rgba(11, 31, 58, 0.18);
        --radius-sm: 12px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* ===== BODY OVERRIDE ===== */
    body {
        background: var(--navy-gradient) !important;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        position: relative;
        overflow-x: hidden;
    }

    /* Background Decorative Elements */
    body::before {
        content: '';
        position: fixed;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        animation: floatOrb 20s ease-in-out infinite;
    }

    body::after {
        content: '';
        position: fixed;
        bottom: -30%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(11, 31, 58, 0.3) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        animation: floatOrb 25s ease-in-out infinite reverse;
    }

    @keyframes floatOrb {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -30px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    /* Pattern Overlay */
    body .pattern-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
    }

    /* ===== LOGIN CONTAINER ===== */
    .login-container {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 480px;
        margin: auto;
    }

    /* ===== LOGIN BRAND / LOGO ===== */
    .login-brand {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-brand .brand-logo {
        display: inline-block;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 20px 30px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
    }

    .login-brand .brand-logo:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 50px rgba(0, 0, 0, 0.15);
        border-color: rgba(255, 255, 255, 0.12);
    }

    .login-brand .brand-logo img {
        max-width: 160px;
        height: auto;
        filter: brightness(0) invert(1) opacity(0.95);
        transition: var(--transition);
    }

    .login-brand .brand-logo img:hover {
        filter: brightness(0) invert(1) opacity(1);
        transform: scale(1.02);
    }

    .login-brand .brand-title {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.85rem;
        font-weight: 400;
        margin-top: 0.5rem;
        letter-spacing: 0.05em;
    }

    .login-brand .brand-title strong {
        color: #ffffff;
        font-weight: 600;
    }

    /* ===== LOGIN CARD ===== */
    .login-card {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.2);
        padding: 2.5rem 2.5rem 2rem;
        transition: var(--transition);
    }

    .login-card:hover {
        box-shadow: 0 32px 100px rgba(0, 0, 0, 0.25);
        border-color: rgba(255, 255, 255, 0.12);
    }

    /* Card Header */
    .login-card .card-header {
        background: transparent;
        border: none;
        padding: 0 0 1.5rem 0;
        text-align: center;
    }

    .login-card .card-header h4 {
        color: #ffffff;
        font-size: 1.8rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        margin: 0;
    }

    .login-card .card-header .header-sub {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
        margin-top: 0.3rem;
        font-weight: 400;
    }

    .login-card .card-header .header-sub i {
        margin-right: 0.3rem;
    }

    /* Card Body */
    .login-card .card-body {
        padding: 0;
    }

    /* ===== FORM ELEMENTS ===== */
    .login-card .form-group {
        margin-bottom: 1.5rem;
    }

    .login-card .form-group label {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
        letter-spacing: 0.02em;
        display: block;
    }

    .login-card .form-group label .label-icon {
        margin-right: 0.5rem;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.8rem;
    }

    .login-card .form-control {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        color: #ffffff;
        padding: 0.9rem 1.2rem;
        font-size: 0.95rem;
        transition: var(--transition);
        height: auto;
        box-shadow: none;
    }

    .login-card .form-control:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.04);
        color: #ffffff;
    }

    .login-card .form-control::placeholder {
        color: rgba(255, 255, 255, 0.3);
        font-size: 0.9rem;
    }

    .login-card .form-control:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 30px rgba(11, 31, 58, 0.9) inset !important;
        -webkit-text-fill-color: #ffffff !important;
    }

    /* Select Dropdown */
    .login-card .form-control select {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='rgba(255,255,255,0.5)' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1.2rem center;
        padding-right: 3rem;
        cursor: pointer;
    }

    .login-card .form-control select option {
        background: #0B1F3A;
        color: #ffffff;
        padding: 0.5rem;
    }

    /* ===== LOGIN BUTTON ===== */
    .login-card .btn-login {
        background: #ffffff;
        color: var(--navy-dark);
        border: none;
        border-radius: 12px;
        padding: 0.9rem 2rem;
        font-weight: 700;
        font-size: 1rem;
        width: 100%;
        transition: var(--transition);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .login-card .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        background: #ffffff;
        color: var(--navy-dark);
    }

    .login-card .btn-login i {
        font-size: 1rem;
        transition: var(--transition);
    }

    .login-card .btn-login:hover i {
        transform: translateX(4px);
    }

    .login-card .btn-login:active {
        transform: scale(0.98);
    }

    /* ===== DIVIDER ===== */
    .login-card .divider {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
        color: rgba(255, 255, 255, 0.2);
        font-size: 0.8rem;
        font-weight: 300;
        letter-spacing: 0.05em;
    }

    .login-card .divider::before,
    .login-card .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255, 255, 255, 0.06);
    }

    .login-card .divider::before {
        margin-right: 1rem;
    }

    .login-card .divider::after {
        margin-left: 1rem;
    }

    /* ===== FOOTER LINKS ===== */
    .login-footer {
        text-align: center;
        margin-top: 1.5rem;
    }

    .login-footer a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 0.9rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .login-footer a:hover {
        color: #ffffff;
        transform: translateY(-1px);
    }

    .login-footer a i {
        font-size: 0.8rem;
        transition: var(--transition);
    }

    .login-footer a:hover i {
        transform: translateX(-4px);
    }

    .login-footer .footer-divider {
        color: rgba(255, 255, 255, 0.1);
        margin: 0 0.8rem;
    }

    /* ===== INVALID FEEDBACK ===== */
    .login-card .invalid-feedback {
        color: #ff6b6b;
        font-size: 0.8rem;
        margin-top: 0.3rem;
        display: none;
    }

    .login-card .is-invalid ~ .invalid-feedback {
        display: block;
    }

    .login-card .is-invalid {
        border-color: #ff6b6b !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991.98px) {
        .login-container {
            max-width: 400px;
            padding: 15px;
        }

        .login-card {
            padding: 2rem 2rem 1.5rem;
        }
    }

    @media (max-width: 767.98px) {
        body::before {
            width: 300px;
            height: 300px;
            top: -20%;
            right: -10%;
        }

        body::after {
            width: 300px;
            height: 300px;
            bottom: -20%;
            left: -10%;
        }

        .login-container {
            max-width: 100%;
            padding: 10px;
            margin: 10px auto;
        }

        .login-card {
            padding: 1.8rem 1.5rem 1.5rem;
            border-radius: 20px;
        }

        .login-card .card-header h4 {
            font-size: 1.5rem;
        }

        .login-brand .brand-logo {
            padding: 15px 20px;
            border-radius: 16px;
        }

        .login-brand .brand-logo img {
            max-width: 120px;
        }

        .login-brand .brand-title {
            font-size: 0.75rem;
        }

        .login-card .form-control {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .login-card .btn-login {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }

        .login-footer a {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 575.98px) {
        .login-card {
            padding: 1.5rem 1rem 1.2rem;
            border-radius: 16px;
        }

        .login-card .card-header h4 {
            font-size: 1.3rem;
        }

        .login-card .form-group {
            margin-bottom: 1rem;
        }

        .login-brand .brand-logo {
            padding: 12px 16px;
        }

        .login-brand .brand-logo img {
            max-width: 100px;
        }

        .login-card .btn-login {
            padding: 0.7rem 1.2rem;
            font-size: 0.85rem;
        }

        .login-footer a {
            font-size: 0.75rem;
        }
    }

    /* ===== SWEETALERT OVERRIDE ===== */
    .swal-overlay {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .swal-modal {
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.2);
        padding: 2rem;
    }

    .swal-title {
        color: #0B1F3A;
        font-weight: 700;
    }

    .swal-text {
        color: #6C757D;
    }

    .swal-button {
        background: var(--navy-gradient) !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 0.7rem 2rem !important;
        font-weight: 600 !important;
        transition: var(--transition) !important;
    }

    .swal-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(18, 62, 115, 0.3) !important;
    }

    .swal-button--cancel {
        background: #e9ecef !important;
        color: #6C757D !important;
    }
</style>
@endpush

<!-- ============================================================
    LOGIN CONTAINER
    ============================================================ -->
<div class="login-container">
    <!-- Pattern Overlay -->
    <div class="pattern-overlay"></div>


    <!-- Login Card -->
    <div class="login-card" >
        <div class="card-header">
            <h4>Selamat Datang</h4>
            <div class="header-sub">
                <i class="fas fa-lock"></i> Silakan login untuk melanjutkan
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login_action') }}" class="needs-validation" novalidate>
                @csrf
                <!-- Username -->
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-user label-icon"></i> Username
                    </label>
                    <input id="email" type="text" class="form-control" name="username" placeholder="Masukkan username Anda" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                        Silakan isi username Anda
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-key label-icon"></i> Password
                    </label>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Masukkan password Anda" tabindex="2" required>
                    <div class="invalid-feedback">
                        Silakan isi password Anda
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="form-group">
                    <label for="role">
                        <i class="fas fa-user-tag label-icon"></i> Login Sebagai
                    </label>
                    <select class="form-control selectric" name="role" id="role" tabindex="3">
                        <option value="">— Pilih Role —</option>
                        <option value="admin">Admin</option>
                        <option value="kepala">Kepala Kantor</option>
                        <option value="tu">Tata Usaha</option>
                        <option value="ti">TI & Inteldaktim</option>
                        <option value="kasubsi">Kasubsi Pelayanan & Verdokjal</option>
                    </select>
                </div>

                <!-- Login Button -->
                <div class="form-group" style="margin-bottom: 0;">
                    <button type="submit" class="btn btn-login" tabindex="4">
                        <span>Login</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="divider">atau</div>

            <!-- Register Link -->
            <div class="login-footer">
                <a href="{{ route('register') }}">
                    <i class="fas fa-chevron-left"></i> Belum Punya Akun? Regist
                </a>
                <span class="footer-divider">|</span>
                <a href="/">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
    SCRIPTS
    ============================================================ -->
<script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

@push('scripts')
<script>
    // ============================================================
    // FORM VALIDATION
    // ============================================================
    (function() {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // ============================================================
    // SWEETALERT NOTIFICATIONS
    // ============================================================
    // Success Login
    @if (session('message') == 'sukses login')
        swal({
            title: "Berhasil",
            text: "Anda berhasil login!",
            icon: "success",
            button: "OK",
            timer: 3000,
        });
    @endif

    // Failed Login
    @if (session('message') == 'gagal login')
        swal({
            title: "Gagal Login",
            text: "Periksa kembali username dan password Anda!",
            icon: "error",
            button: "Coba Lagi",
            dangerMode: true,
        });
    @endif

    // Need Login
    @if (session('message') == 'need login')
        swal({
            title: "Akses Ditolak",
            text: "Anda harus login terlebih dahulu!",
            icon: "warning",
            button: "OK",
        });
    @endif

    // Success Logout
    @if (session('message') == 'sukses logout')
        swal({
            title: "Berhasil Logout",
            text: "Anda telah berhasil logout!",
            icon: "success",
            button: "OK",
            timer: 3000,
        });
    @endif
</script>
@endpush
@endsection