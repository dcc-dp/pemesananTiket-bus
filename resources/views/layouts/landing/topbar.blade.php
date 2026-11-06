<!-- TOPBAR / NAVBAR -->
<header class="bg-white sticky top-0 z-40 border-b border-slate-200/80 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 sm:h-20 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
            <img src="{{ asset('img/logo-bustiket.png') }}" alt="Logo BUSTIKET" class="w-10 h-10 object-contain group-hover:scale-105 transition-transform">
            <span class="text-xl sm:text-2xl font-extrabold tracking-tight text-slate-900">BusTicket</span>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600" id="desktopNav">
            <a href="{{ route('home') }}#beranda" 
               data-nav="beranda" 
               class="nav-link border-b-2 py-1 transition-all {{ ($menu ?? '') == 'home' ? 'text-brand-600 font-bold border-brand-600' : 'text-slate-600 border-transparent hover:text-brand-600' }}">
                Beranda
            </a>
            <a href="{{ route('tiket.search') }}" 
               data-nav="tiket" 
               class="nav-link border-b-2 py-1 transition-all {{ in_array($menu ?? '', ['tiket', 'booking']) ? 'text-brand-600 font-bold border-brand-600' : 'text-slate-600 border-transparent hover:text-brand-600' }}">
                Pesan Tiket
            </a>
            <a href="{{ route('home') }}#rute-populer" 
               data-nav="rute" 
               class="nav-link border-b-2 py-1 transition-all text-slate-600 border-transparent hover:text-brand-600">
                Rute
            </a>
            <a href="{{ route('home') }}#faq-section" 
               data-nav="bantuan" 
               class="nav-link border-b-2 py-1 transition-all text-slate-600 border-transparent hover:text-brand-600">
                Bantuan
            </a>
        </nav>

        <!-- Right Side: Auth Actions + Mobile Menu Toggle -->
        <div class="flex items-center gap-2 sm:gap-3">
            @if (Session('cek'))
                <div class="flex items-center gap-2">
                    @if (Session('role') == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-brand-50 text-brand-700 hover:bg-brand-100 text-xs font-bold flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-base">dashboard</span>
                            <span class="hidden sm:inline">Admin Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-brand-50 text-brand-700 hover:bg-brand-100 text-xs font-bold flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-base">dashboard</span>
                            <span class="hidden sm:inline">Dashboard</span>
                        </a>
                        <a href="{{ route('customer.bookings') }}" class="hidden sm:flex px-3.5 py-2 rounded-xl text-slate-600 hover:text-brand-600 text-xs font-bold items-center gap-1 transition-colors">
                            <span class="material-symbols-outlined text-base">receipt_long</span>
                            <span>Pesanan Saya</span>
                        </a>
                    @endif
                    <a href="{{ route('logout') }}" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Logout">
                        <span class="material-symbols-outlined text-xl">logout</span>
                    </a>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-3.5 sm:px-4 py-2 text-xs sm:text-sm font-semibold {{ ($menu ?? '') == 'login' ? 'text-brand-600 font-bold' : 'text-slate-700 hover:text-brand-600' }} transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl {{ ($menu ?? '') == 'register' ? 'bg-brand-700' : 'bg-brand-600 hover:bg-brand-700' }} text-white text-xs sm:text-sm font-semibold shadow-xs transition-all active:scale-95">
                    Daftar
                </a>
            @endif

            <!-- Mobile Hamburger Toggle -->
            <button type="button" id="mobileMenuBtn" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 focus:outline-none" aria-label="Toggle navigation">
                <span class="material-symbols-outlined text-2xl" id="mobileMenuIcon">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobileMenuPanel" class="hidden md:hidden border-t border-slate-100 bg-white px-4 pt-3 pb-5 space-y-2">
        <a href="{{ route('home') }}#beranda" 
           data-nav-mobile="beranda" 
           class="mobile-nav-link block px-3 py-2.5 rounded-xl text-sm font-semibold {{ ($menu ?? '') == 'home' ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            Beranda
        </a>
        <a href="{{ route('tiket.search') }}" 
           data-nav-mobile="tiket" 
           class="mobile-nav-link block px-3 py-2.5 rounded-xl text-sm font-semibold {{ in_array($menu ?? '', ['tiket', 'booking']) ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            Pesan Tiket
        </a>
        <a href="{{ route('home') }}#rute-populer" 
           data-nav-mobile="rute" 
           class="mobile-nav-link block px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50">
            Rute Populer
        </a>
        <a href="{{ route('home') }}#faq-section" 
           data-nav-mobile="bantuan" 
           class="mobile-nav-link block px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50">
            Bantuan
        </a>
        @if (Session('cek') && Session('role') != 'admin')
            <a href="{{ route('customer.bookings') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Pesanan Saya
            </a>
            <a href="{{ route('customer.tickets') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Tiket Saya
            </a>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Mobile Menu Toggle
            const btn = document.getElementById('mobileMenuBtn');
            const panel = document.getElementById('mobileMenuPanel');
            const icon = document.getElementById('mobileMenuIcon');
            if (btn && panel) {
                btn.addEventListener('click', () => {
                    const isHidden = panel.classList.contains('hidden');
                    panel.classList.toggle('hidden', !isHidden);
                    if (icon) {
                        icon.textContent = isHidden ? 'close' : 'menu';
                    }
                });
            }

            // 2. Active State & Smooth Scrolling for Landing Page Sections
            const isHomePage = document.getElementById('rute-populer') !== null;
            const desktopLinks = document.querySelectorAll('.nav-link[data-nav]');
            const mobileLinks = document.querySelectorAll('.mobile-nav-link[data-nav-mobile]');

            function setActiveNav(navKey) {
                desktopLinks.forEach(link => {
                    if (link.getAttribute('data-nav') === navKey) {
                        link.classList.add('text-brand-600', 'font-bold', 'border-brand-600');
                        link.classList.remove('text-slate-600', 'border-transparent');
                    } else {
                        link.classList.remove('text-brand-600', 'font-bold', 'border-brand-600');
                        link.classList.add('text-slate-600', 'border-transparent');
                    }
                });

                mobileLinks.forEach(link => {
                    if (link.getAttribute('data-nav-mobile') === navKey) {
                        link.classList.add('bg-brand-50', 'text-brand-600', 'font-bold');
                        link.classList.remove('text-slate-700', 'hover:bg-slate-50');
                    } else {
                        link.classList.remove('bg-brand-50', 'text-brand-600', 'font-bold');
                        link.classList.add('text-slate-700', 'hover:bg-slate-50');
                    }
                });
            }

            function scrollToSection(targetId) {
                const el = document.getElementById(targetId);
                if (!el) return;

                const navbar = document.querySelector('header');
                const navbarHeight = navbar ? navbar.offsetHeight : 80;
                const targetPosition = el.getBoundingClientRect().top + window.pageYOffset - (navbarHeight + 12);

                window.scrollTo({
                    top: Math.max(0, targetPosition),
                    behavior: 'smooth'
                });
            }

            if (isHomePage) {
                const hashTargets = {
                    'beranda': 'beranda',
                    'rute': 'rute-populer',
                    'bantuan': 'faq-section'
                };

                const handleAnchorClick = (e, navKey) => {
                    const targetId = hashTargets[navKey];
                    if (targetId && document.getElementById(targetId)) {
                        e.preventDefault();
                        setActiveNav(navKey);
                        scrollToSection(targetId);
                        history.pushState(null, null, '#' + targetId);

                        if (panel && !panel.classList.contains('hidden')) {
                            panel.classList.add('hidden');
                            if (icon) icon.textContent = 'menu';
                        }
                    }
                };

                desktopLinks.forEach(link => {
                    const navKey = link.getAttribute('data-nav');
                    if (hashTargets[navKey]) {
                        link.addEventListener('click', (e) => handleAnchorClick(e, navKey));
                    }
                });

                mobileLinks.forEach(link => {
                    const navKey = link.getAttribute('data-nav-mobile');
                    if (hashTargets[navKey]) {
                        link.addEventListener('click', (e) => handleAnchorClick(e, navKey));
                    }
                });

                // Scrollspy
                const sections = [
                    { key: 'bantuan', id: 'faq-section' },
                    { key: 'rute', id: 'rute-populer' },
                    { key: 'beranda', id: 'beranda' }
                ];

                let isScrolling = false;
                window.addEventListener('scroll', () => {
                    if (isScrolling) return;
                    isScrolling = true;
                    requestAnimationFrame(() => {
                        const navbar = document.querySelector('header');
                        const offset = (navbar ? navbar.offsetHeight : 80) + 120;
                        const scrollPos = window.pageYOffset;

                        if (scrollPos < 250) {
                            setActiveNav('beranda');
                            isScrolling = false;
                            return;
                        }

                        for (const sec of sections) {
                            const el = document.getElementById(sec.id);
                            if (el) {
                                const top = el.offsetTop - offset;
                                const height = el.offsetHeight;
                                if (scrollPos >= top && scrollPos < top + height) {
                                    setActiveNav(sec.key);
                                    isScrolling = false;
                                    return;
                                }
                            }
                        }
                        isScrolling = false;
                    });
                }, { passive: true });

                // Check on initial load if hash is present
                if (window.location.hash) {
                    const hash = window.location.hash.substring(1);
                    for (const [key, id] of Object.entries(hashTargets)) {
                        if (hash === id) {
                            setActiveNav(key);
                            setTimeout(() => scrollToSection(id), 120);
                            break;
                        }
                    }
                }
            }
        });
    </script>
</header>