    <!-- Header start -->
    <header id="header" class="header-one">
        <!-- Logo Area -->
        <div class="bg-white" style="background: #ffffff !important; border-bottom: 1px solid rgba(0,0,0,0.04);">
            <div class="container">
                <div style="padding:15px 0;" class="logo-area">
                    <div class="row align-items-center">
                        <!-- Logo Section - 2 Logo Berdampingan -->
                        <div class="col-lg-2 col-md-12 text-center text-lg-left mb-3 mb-md-4 mb-lg-0">
                            <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-4" style="gap: 1rem;">
                                <!-- Logo 1 -->
                                <a class="d-block" href="/">
                                    <img style="width: auto; height: 70px;" src="{{ asset('landing/images/footer/rapp.png') }}" alt="RAP Kementerian">
                                </a>
                                <!-- Divider -->
                                <div style="width: 1px; height: 50px; background: rgba(0,0,0,0.08);"></div>
                                <!-- Logo 2 -->
                                <a class="d-block" href="/">
                                    <img style="width: auto; height: 70px;" src="{{ asset('landing/images/footer/logoimig.png') }}" alt="RAP Kementerian">
                                </a>
                            </div>
                        </div><!-- logo end -->

                        <!-- Info Box -->
                        <div class="col-lg-10 col-md-12">
                            <ul class="top-info-box" style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; justify-content: flex-end; gap: 1rem; flex-wrap: wrap;">
                                <li>
                                    <div class="info-box" style="display: flex; align-items: center; gap: 0.8rem;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(11,31,58,0.06); display: flex; align-items: center; justify-content: center; color: #123E73; font-size: 1rem;">
                                            <i class="fas fa-phone-alt"></i>
                                        </div>
                                        <div class="info-box-content">
                                            <p class="info-box-title" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6C757D; margin: 0;">Hubungi</p>
                                            <p class="info-box-subtitle" style="font-size: 0.95rem; font-weight: 600; color: #0B1F3A; margin: 0;">(0411) 0889 0992 009</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="last">
                                    <div class="info-box last" style="display: flex; align-items: center; gap: 0.8rem;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(11,31,58,0.06); display: flex; align-items: center; justify-content: center; color: #123E73; font-size: 1rem;">
                                            <i class="fas fa-fax"></i>
                                        </div>
                                        <div class="info-box-content">
                                            <p class="info-box-title" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6C757D; margin: 0;">Fax</p>
                                            <p class="info-box-subtitle" style="font-size: 0.95rem; font-weight: 600; color: #0B1F3A; margin: 0;">0411-8890098</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="info-box" style="display: flex; align-items: center; gap: 0.8rem;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(11,31,58,0.06); display: flex; align-items: center; justify-content: center; color: #123E73; font-size: 1rem;">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="info-box-content">
                                            <p class="info-box-title" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6C757D; margin: 0;">Email</p>
                                            <p class="info-box-subtitle" style="font-size: 0.95rem; font-weight: 600; color: #0B1F3A; margin: 0;">imigrasibantaeng@gmail.com</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div><!-- header right end -->
                    </div><!-- logo area end -->
                </div><!-- Row end -->
            </div><!-- Container end -->
        </div>

        <!-- Navigation with Gradient -->
        <div class="site-navigation" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); border-top: 1px solid rgba(255,255,255,0.05);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg navbar-dark p-0" style="background: transparent !important;">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target=".navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                                aria-label="Toggle navigation" style="border-color: rgba(255,255,255,0.2); padding: 0.5rem 0.8rem;">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div id="navbar-collapse" class="collapse navbar-collapse">
                                <ul class="nav navbar-nav mr-auto" style="display: flex; flex-wrap: wrap; gap: 0.2rem;">
                                    <li class="nav-item {{ $menu == 'profil' ? 'active' : '' }}">
                                        <a class="nav-link" href="/" style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.8rem 1.2rem; transition: all 0.3s ease; border-radius: 8px; font-size: 0.95rem;">
                                            <i class="fas fa-home" style="margin-right: 0.4rem; font-size: 0.85rem;"></i> Profil
                                        </a>
                                    </li>

                                    <li class="nav-item {{ $menu == 'kontak' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('user.kontak') }}" style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.8rem 1.2rem; transition: all 0.3s ease; border-radius: 8px; font-size: 0.95rem;">
                                            <i class="fas fa-phone" style="margin-right: 0.4rem; font-size: 0.85rem;"></i> Kontak
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}" style="color: rgba(255,255,255,0.8); font-weight: 500; padding: 0.8rem 1.2rem; transition: all 0.3s ease; border-radius: 8px; font-size: 0.95rem;">
                                            <i class="fas fa-sign-in-alt" style="margin-right: 0.4rem; font-size: 0.85rem;"></i> Login
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Search Button -->
                            <div class="nav-search" style="margin-left: 1rem;">
                                <span id="search" style="color: rgba(255,255,255,0.6); cursor: pointer; transition: all 0.3s ease; padding: 0.5rem;">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </nav>
                    </div>
                    <!--/ Col end -->
                </div>
                <!--/ Row end -->

                <div class="search-block" style="display: none; position: absolute; right: 0; top: 100%; background: #ffffff; padding: 1rem; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); width: 300px; z-index: 1000;">
                    <label for="search-field" class="w-100 mb-0" style="display: flex; align-items: center;">
                        <input type="text" class="form-control" id="search-field"
                            placeholder="Type what you want and enter" style="border-radius: 8px; border: 1px solid #e0e0e0; padding: 0.6rem 1rem;">
                    </label>
                    <span class="search-close" style="position: absolute; top: 0.5rem; right: 1rem; cursor: pointer; color: #6C757D; font-size: 1.2rem;">&times;</span>
                </div><!-- Site search end -->
            </div>
            <!--/ Container end -->
        </div>
        <!--/ Navigation end -->
    </header>
    <!--/ Header end -->

    @push('styles')
    <style>
        /* ============================================================
        HEADER STYLES - Premium Gradient Biru Landing Page
        ============================================================ */
        
        /* ===== LOGO SECTION ===== */
        .logo-area .d-flex {
            display: flex !important;
            align-items: center !important;
        }

        .logo-area .d-flex .gap-4 {
            gap: 1.5rem;
        }

        .logo-area .d-flex img {
            transition: all 0.3s ease;
            object-fit: contain;
        }

        .logo-area .d-flex img:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }

        .logo-area .d-flex .divider {
            width: 1px;
            height: 50px;
            background: rgba(0, 0, 0, 0.08);
            flex-shrink: 0;
        }

        /* ===== NAVIGATION LINK HOVER ===== */
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-1px);
        }

        .navbar-dark .navbar-nav .nav-item.active .nav-link {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.12);
        }

        /* ===== SEARCH BUTTON HOVER ===== */
        .nav-search #search:hover {
            color: #ffffff !important;
        }

        /* ===== TOP SOCIAL HOVER ===== */
        .top-social li a:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .top-info-box {
                justify-content: center !important;
            }
            
            .navbar-collapse {
                background: rgba(11, 31, 58, 0.95);
                padding: 1rem;
                border-radius: 12px;
                margin-top: 0.5rem;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }

            .navbar-nav {
                flex-direction: column;
                gap: 0.3rem;
            }

            .navbar-nav .nav-link {
                padding: 0.6rem 1rem !important;
                border-radius: 6px;
            }

            /* Logo adjustment for tablet */
            .logo-area .d-flex img {
                height: 50px !important;
            }

            .logo-area .d-flex .divider {
                height: 40px;
            }
        }

        @media (max-width: 767.98px) {
            .top-info {
                justify-content: center !important;
            }

            .top-info li {
                font-size: 0.75rem !important;
            }

            .top-social {
                justify-content: center !important;
                margin-top: 0.3rem;
            }

            .top-social li a {
                width: 28px !important;
                height: 28px !important;
            }

            .top-social li a i {
                font-size: 0.7rem !important;
            }

            .info-box {
                flex-direction: column;
                text-align: center;
                gap: 0.3rem !important;
            }

            .info-box .info-box-title {
                font-size: 0.6rem !important;
            }

            .info-box .info-box-subtitle {
                font-size: 0.8rem !important;
            }

            .header-get-a-quote {
                width: 100%;
                text-align: center;
                margin-top: 0.5rem;
            }

            .header-get-a-quote .btn-premium {
                width: 100%;
                text-align: center;
            }

            .search-block {
                width: 250px !important;
                right: -50px !important;
            }

            /* Logo adjustment for mobile */
            .logo-area .d-flex {
                justify-content: center !important;
            }

            .logo-area .d-flex img {
                height: 45px !important;
            }

            .logo-area .d-flex .divider {
                height: 35px;
            }
        }

        @media (max-width: 575.98px) {
            .top-info li {
                font-size: 0.65rem !important;
            }

            .top-info li span {
                display: none;
            }

            .top-info li i {
                font-size: 0.8rem;
            }

            .logo-area .logo img {
                height: 40px !important;
            }

            .top-info-box {
                gap: 0.5rem !important;
            }

            .info-box {
                flex-direction: row !important;
                gap: 0.5rem !important;
            }

            .info-box .info-box-title {
                font-size: 0.5rem !important;
            }

            .info-box .info-box-subtitle {
                font-size: 0.7rem !important;
            }

            .info-box > div:first-child {
                width: 30px !important;
                height: 30px !important;
                font-size: 0.7rem !important;
            }

            .search-block {
                width: 200px !important;
                right: -30px !important;
            }

            /* Logo adjustment for small mobile */
            .logo-area .d-flex img {
                height: 35px !important;
            }

            .logo-area .d-flex .divider {
                height: 30px;
            }

            .logo-area .d-flex .gap-4 {
                gap: 0.8rem !important;
            }
        }

        /* ===== ANIMATION FOR LOGO ===== */
        @keyframes fadeInLogo {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-area .d-flex a {
            animation: fadeInLogo 0.6s ease forwards;
        }

        .logo-area .d-flex a:nth-child(1) {
            animation-delay: 0.1s;
        }

        .logo-area .d-flex a:nth-child(3) {
            animation-delay: 0.2s;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // ============================================================
        // SEARCH TOGGLE
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            const searchBtn = document.getElementById('search');
            const searchBlock = document.querySelector('.search-block');
            const searchClose = document.querySelector('.search-close');

            if (searchBtn && searchBlock) {
                searchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const isVisible = searchBlock.style.display === 'block';
                    searchBlock.style.display = isVisible ? 'none' : 'block';
                    if (!isVisible) {
                        const input = searchBlock.querySelector('#search-field');
                        if (input) setTimeout(() => input.focus(), 100);
                    }
                });

                if (searchClose) {
                    searchClose.addEventListener('click', function() {
                        searchBlock.style.display = 'none';
                    });
                }

                document.addEventListener('click', function(e) {
                    if (!searchBlock.contains(e.target) && e.target !== searchBtn && !searchBtn.contains(e.target)) {
                        searchBlock.style.display = 'none';
                    }
                });
            }
        });
    </script>
    @endpush