@push('styles')
    <style>
        /* ===== NAVBAR STYLES - Premium Gradient Biru ===== */
        .navbar-bg {
            background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%) !important;
            opacity: 0.95;
        }

        .main-navbar {
            background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(11, 31, 58, 0.2);
        }

        /* Navbar Links */
        .main-navbar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease;
        }

        .main-navbar .nav-link:hover {
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        .main-navbar .nav-link i {
            color: rgba(255, 255, 255, 0.7);
        }

        .main-navbar .nav-link:hover i {
            color: #ffffff;
        }

        /* Dropdown Toggle */
        .main-navbar .dropdown-toggle {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .main-navbar .dropdown-toggle:hover {
            color: #ffffff !important;
        }

        /* Avatar/Profile */
        .main-navbar .nav-link-user img {
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .main-navbar .nav-link-user:hover img {
            border-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.05);
        }

        /* Dropdown Menu */
        .main-navbar .dropdown-menu {
            background: #ffffff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 16px 60px rgba(11, 31, 58, 0.15);
            margin-top: 10px;
            padding: 0.5rem 0;
        }

        .main-navbar .dropdown-menu .dropdown-item {
            color: #0B1F3A;
            padding: 0.7rem 1.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .main-navbar .dropdown-menu .dropdown-item:hover {
            background: rgba(11, 31, 58, 0.05);
            color: #123E73;
        }

        .main-navbar .dropdown-menu .dropdown-item i {
            color: #123E73;
            width: 20px;
        }

        .main-navbar .dropdown-menu .dropdown-item.text-danger {
            color: #dc3545 !important;
        }

        .main-navbar .dropdown-menu .dropdown-item.text-danger i {
            color: #dc3545 !important;
        }

        .main-navbar .dropdown-menu .dropdown-item.text-danger:hover {
            background: rgba(220, 53, 69, 0.05);
            color: #c82333 !important;
        }

        .main-navbar .dropdown-menu .dropdown-divider {
            border-color: rgba(11, 31, 58, 0.08);
        }

        .main-navbar .dropdown-title {
            color: #6C757D;
            font-size: 0.75rem;
            padding: 0.7rem 1.5rem 0.3rem;
        }

        /* Search Form */
        .main-navbar .form-inline .nav-link {
            padding: 0.5rem 0.8rem;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .main-navbar {
                background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%) !important;
            }
        }

        @media (max-width: 767.98px) {
            .main-navbar .nav-link-user .d-lg-inline-block {
                color: rgba(255, 255, 255, 0.9);
            }
        }
    </style>
@endpush

<div class="navbar-bg" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%) !important; opacity: 0.95;"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Session('name') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <!--<div class="dropdown-title">Logged in 5 min ago</div>-->
                <a href="{{ route('profile.index', Session('user_id')) }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>