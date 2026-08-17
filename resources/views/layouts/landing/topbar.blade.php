<header id="header" class="header-one">
        <div class="bg-white" style="background: #ffffff !important; border-bottom: 1px solid rgba(0,0,0,0.04);">
            <div class="container">
                <div style="padding:15px 0;" class="logo-area">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-12 text-center text-lg-left mb-3 mb-md-4 mb-lg-0">
                            <a class="d-inline-block" href="{{ route('home') }}">
                                <span style="font-size: 1.6rem; font-weight: 800; color: #123E73;">
                                    <i class="fas fa-bus" style="color: #1E5AA8;"></i> Bus<span style="color: #1E5AA8;">Ticket</span>
                                </span>
                            </a>
                        </div>

                        <div class="col-lg-8 col-md-12">
                            <ul class="top-info-box" style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; justify-content: flex-end; gap: 1rem; flex-wrap: wrap;">
                                <li>
                                    <div class="info-box" style="display: flex; align-items: center; gap: 0.8rem;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(11,31,58,0.06); display: flex; align-items: center; justify-content: center; color: #123E73; font-size: 1rem;">
                                            <i class="fas fa-phone-alt"></i>
                                        </div>
                                        <div class="info-box-content">
                                            <p class="info-box-title" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6C757D; margin: 0;">Hubungi Kami</p>
                                            <p class="info-box-subtitle" style="font-size: 0.95rem; font-weight: 600; color: #0B1F3A; margin: 0;">(0411) 123-4567</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="last">
                                    <div class="info-box last" style="display: flex; align-items: center; gap: 0.8rem;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(11,31,58,0.06); display: flex; align-items: center; justify-content: center; color: #123E73; font-size: 1rem;">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="info-box-content">
                                            <p class="info-box-title" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6C757D; margin: 0;">Email</p>
                                            <p class="info-box-subtitle" style="font-size: 0.95rem; font-weight: 600; color: #0B1F3A; margin: 0;">cs@busticket.test</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="site-navigation" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg navbar-dark p-0" style="background: transparent !important;">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                                aria-label="Toggle navigation" style="border-color: rgba(255,255,255,0.2); padding: 0.5rem 0.8rem;">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div id="navbar-collapse" class="collapse navbar-collapse">
                                <ul class="nav navbar-nav mr-auto" style="display: flex; flex-wrap: wrap; gap: 0.2rem;">
                                    <li class="nav-item {{ $menu == 'home' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('home') }}" style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.8rem 1.2rem; transition: all 0.3s ease; border-radius: 8px; font-size: 0.95rem;">
                                            <i class="fas fa-home" style="margin-right: 0.4rem;"></i> Beranda
                                        </a>
                                    </li>
                                    <li class="nav-item {{ $menu == 'tiket' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('tiket.search') }}" style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.8rem 1.2rem; transition: all 0.3s ease; border-radius: 8px; font-size: 0.95rem;">
                                            <i class="fas fa-ticket-alt" style="margin-right: 0.4rem;"></i> Cari Tiket
                                        </a>
                                    </li>
                                </ul>

                                <ul class="nav navbar-nav" style="display: flex; flex-wrap: wrap; gap: 0.2rem;">
                                    @if (Session('cek'))
                                        @if (Session('role') == 'admin')
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.dashboard') }}" style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.8rem 1.2rem; border-radius: 8px; font-size: 0.95rem;">
                                                    <i class="fas fa-tachometer-alt" style="margin-right: 0.4rem;"></i> Dashboard
                                                </a>
                                            </li>
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('customer.dashboard') }}" style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.8rem 1.2rem; border-radius: 8px; font-size: 0.95rem;">
                                                    <i class="fas fa-tachometer-alt" style="margin-right: 0.4rem;"></i> Dashboard
                                                </a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('logout') }}" style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.8rem 1.2rem; border-radius: 8px; font-size: 0.95rem;">
                                                <i class="fas fa-sign-out-alt" style="margin-right: 0.4rem;"></i> Logout
                                            </a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}" style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.8rem 1.2rem; transition: all 0.3s ease; border-radius: 8px; font-size: 0.95rem;">
                                                <i class="fas fa-sign-in-alt" style="margin-right: 0.4rem;"></i> Login
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}" style="color: #ffffff; font-weight: 600; padding: 0.8rem 1.2rem; border-radius: 8px; font-size: 0.95rem; background: rgba(255,255,255,0.12);">
                                                <i class="fas fa-user-plus" style="margin-right: 0.4rem;"></i> Daftar
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>