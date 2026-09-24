<!-- TOPBAR / NAVBAR (PROTOTYPE DESIGN SYSTEM) -->
<header class="bg-white sticky top-0 z-40 border-b border-slate-200/80 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white shadow-md shadow-brand-600/20">
                <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">directions_bus</span>
            </div>
            <span class="text-2xl font-extrabold tracking-tight text-slate-900">BusTicket</span>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-8 text-[15px] font-medium text-slate-600">
            <a href="{{ route('home') }}" class="{{ ($menu ?? '') == 'home' ? 'text-brand-600 font-bold border-b-2 border-brand-600 py-1' : 'hover:text-brand-600 transition-colors' }}">
                Beranda
            </a>
            <a href="{{ route('tiket.search') }}" class="{{ in_array($menu ?? '', ['tiket', 'booking']) ? 'text-brand-600 font-bold border-b-2 border-brand-600 py-1' : 'hover:text-brand-600 transition-colors' }}">
                Pesan Tiket
            </a>
            <a href="{{ route('home') }}#rute-populer" class="hover:text-brand-600 transition-colors">
                Rute
            </a>
            <a href="{{ route('home') }}#faq-section" class="hover:text-brand-600 transition-colors">
                Bantuan
            </a>
        </nav>

        <!-- Auth Actions -->
        <div class="flex items-center gap-3">
            @if (Session('cek'))
                <div class="flex items-center gap-2">
                    @if (Session('role') == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-brand-50 text-brand-700 hover:bg-brand-100 text-xs font-bold flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-base">dashboard</span>
                            <span>Admin Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-brand-50 text-brand-700 hover:bg-brand-100 text-xs font-bold flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-base">dashboard</span>
                            <span>Dashboard</span>
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
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold {{ ($menu ?? '') == 'login' ? 'text-brand-600 font-bold' : 'text-slate-700 hover:text-brand-600' }} transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl {{ ($menu ?? '') == 'register' ? 'bg-brand-700 ring-2 ring-brand-300' : 'bg-brand-600 hover:bg-brand-700' }} text-white text-sm font-semibold shadow-sm transition-all duration-150 active:scale-95">
                    Daftar
                </a>
            @endif
        </div>
    </div>
</header>