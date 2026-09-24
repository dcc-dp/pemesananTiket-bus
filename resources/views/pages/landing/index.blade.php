@extends('layouts.landing.app', ['menu' => 'home'])

@section('content')
    <!-- HERO SECTION (PROTOTYPE DESIGN SYSTEM) -->
    <section class="relative overflow-hidden pt-12 pb-20 lg:pt-16 lg:pb-24 hero-radial-glow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            
            <!-- Pill Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-50 border border-brand-100 text-brand-600 text-xs font-bold tracking-wider uppercase mb-6 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                Platform Reservasi Bus Resmi
            </div>

            <!-- Main Headline -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight max-w-3xl mx-auto mb-4">
                Pesan Tiket Bus dengan Mudah dan Cepat
            </h1>

            <!-- Subtitle -->
            <p class="text-base sm:text-lg text-slate-500 font-normal max-w-2xl mx-auto mb-10 leading-relaxed font-body">
                Cari rute, pilih bus, tentukan kursi, dan lakukan pembayaran secara online tanpa ribet.
            </p>

            <!-- SEARCH CARD COMPONENT -->
            <div class="max-w-5xl mx-auto bg-white rounded-2xl p-6 sm:p-7 shadow-xl shadow-slate-200/50 border border-slate-200/90 text-left">
                <form action="{{ route('tiket.search') }}" method="GET">
                    <!-- Top Row Inputs -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 items-center">
                        
                        <!-- Kota Asal -->
                        <div class="md:col-span-3">
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Kota Asal</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-brand-600 text-[20px] pointer-events-none">location_on</span>
                                <select name="terminal_asal" id="originSelect" required class="w-full pl-11 pr-8 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-semibold focus:bg-white focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all appearance-none cursor-pointer">
                                    <option value="">Pilih Asal</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}" {{ $loop->first ? 'selected' : '' }}>
                                            {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined absolute right-3 text-slate-400 text-[18px] pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Swap Button -->
                        <div class="md:col-span-1 flex justify-center -my-2 md:my-0 pt-3 md:pt-4">
                            <button type="button" id="swapRouteBtn" class="w-10 h-10 rounded-full border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center shadow-xs transition-transform duration-300 hover:rotate-180 active:scale-95" title="Tukar Rute">
                                <span class="material-symbols-outlined text-[20px]">sync_alt</span>
                            </button>
                        </div>

                        <!-- Kota Tujuan -->
                        <div class="md:col-span-3">
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Kota Tujuan</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-brand-600 text-[20px] pointer-events-none">pin_drop</span>
                                <select name="terminal_tujuan" id="destSelect" required class="w-full pl-11 pr-8 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-semibold focus:bg-white focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all appearance-none cursor-pointer">
                                    <option value="">Pilih Tujuan</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}" {{ ($loop->iteration == 2 || $loop->count == 1) ? 'selected' : '' }}>
                                            {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined absolute right-3 text-slate-400 text-[18px] pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Keberangkatan -->
                        <div class="md:col-span-3">
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Keberangkatan</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-brand-600 text-[20px] pointer-events-none">calendar_today</span>
                                <input type="date" name="tanggal" value="{{ now()->addDay()->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" required class="w-full pl-11 pr-3.5 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-semibold focus:bg-white focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all cursor-pointer" />
                            </div>
                        </div>

                        <!-- Tombol Cari Tiket -->
                        <div class="md:col-span-2 pt-3 md:pt-4">
                            <button type="submit" class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-md shadow-brand-600/25 transition-all active:scale-95">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                                <span>Cari Tiket</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Trust Badges Bar -->
            <div class="mt-8 flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-slate-500 text-xs sm:text-sm font-medium font-body">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-600 text-[18px]">verified</span>
                    <span>1.000.000+ Tiket Terjual</span>
                </div>
                <span class="hidden sm:inline text-slate-300">•</span>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-600 text-[18px]">shield</span>
                    <span>100% Pembayaran Aman &amp; Mudah</span>
                </div>
                <span class="hidden sm:inline text-slate-300">•</span>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-600 text-[18px]">confirmation_number</span>
                    <span>E-Tiket Resmi Langsung Terbit</span>
                </div>
            </div>

        </div>
    </section>

    <!-- KENAPA MEMILIH BUSTICKET SECTION -->
    <section class="py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
                    Kenapa Memilih BusTicket?
                </h2>
                <p class="text-sm sm:text-base text-slate-500 font-body">
                    Nikmati standar baru reservasi tiket perjalanan darat antar kota dengan kenyamanan dan kepastian penuh.
                </p>
            </div>

            <!-- 4 Value Proposition Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1 -->
                <div class="p-7 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                    <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-5 border border-brand-100/50">
                        <span class="material-symbols-outlined text-[26px]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Operator Bus Terpercaya</h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-body">
                        Bekerja sama dengan puluhan PO Bus berizin resmi dengan armada prima dan standar keselamatan teruji.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="p-7 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                    <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-5 border border-brand-100/50">
                        <span class="material-symbols-outlined text-[26px]" style="font-variation-settings: 'FILL' 1;">payments</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Harga Transparan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-body">
                        Tidak ada biaya tersembunyi. Harga yang tertera adalah tarif resmi yang Anda bayarkan tanpa tambahan aneh.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="p-7 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                    <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-5 border border-brand-100/50">
                        <span class="material-symbols-outlined text-[26px]" style="font-variation-settings: 'FILL' 1;">bolt</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pemesanan Mudah &amp; Cepat</h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-body">
                        Pesan tiket dan pilih nomor kursi kesukaan Anda secara visual hanya dalam hitungan kurang dari 3 menit.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="p-7 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                    <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-5 border border-brand-100/50">
                        <span class="material-symbols-outlined text-[26px]" style="font-variation-settings: 'FILL' 1;">lock</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pembayaran Aman</h3>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-body">
                        Didukung sistem pembayaran terlengkap dengan enkripsi standar perbankan via berbagai QRIS, VA, dan E-Wallet.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- RUTE POPULER FAVORIT PENUMPANG SECTION -->
    <section class="py-20 bg-slate-50/70 border-t border-slate-200/80" id="rute-populer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-bold text-brand-600 uppercase tracking-widest block mb-2">Destinasi Favorit</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Rute Populer Favorit Penumpang
                    </h2>
                </div>
                <p class="text-sm text-slate-500 font-body max-w-md">
                    Pilihan perjalanan darat paling sering dipesan dengan armada bus terbaik di kelasnya.
                </p>
            </div>

            <!-- Grid 4 Route Cards (From Database / Fallback) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($popularRoutes as $index => $route)
                    <div class="bg-white rounded-2xl border {{ $index == 2 ? 'border-2 border-brand-600/70 shadow-md' : 'border-slate-200/90 shadow-xs' }} overflow-hidden hover:shadow-lg transition-all duration-200 flex flex-col justify-between">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-brand-50 text-brand-600">
                                        {{ $index % 2 == 0 ? 'Executive 2+2' : 'Sleeper Suite' }}
                                    </span>
                                    @if ($index == 2)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-cyan-500 text-white tracking-wider">TERPOPULER</span>
                                    @endif
                                </div>

                            </div>

                            <!-- Route Stop Visual -->
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full border-2 border-brand-600 bg-white"></div>
                                    <span class="text-sm font-bold text-slate-800">{{ $route->terminalAsal->kota ?? 'Makassar' }}</span>
                                </div>
                                <div class="pl-1.5 -my-2.5">
                                    <div class="w-0.5 h-6 bg-slate-200 ml-1"></div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-brand-600"></div>
                                    <span class="text-sm font-bold text-slate-800">{{ $route->terminalTujuan->kota ?? 'Toraja' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 text-slate-500 text-xs font-body border-t border-slate-100 pt-3.5">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[17px] text-slate-400">schedule</span>
                                    <span>{{ $route->estimasi_durasi ? gmdate('H:i', $route->estimasi_durasi * 60) . ' Jam' : '~8 Jam' }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[17px] text-slate-400">route</span>
                                    <span>{{ $route->jarak ?? '-' }} km</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 {{ $index == 2 ? 'bg-brand-50/50 border-t border-brand-100' : 'bg-slate-50/80 border-t border-slate-100' }} flex items-center justify-between">
                            <div>
                                <span class="block text-[11px] text-slate-400">Mulai dari</span>
                                <span class="text-base font-extrabold {{ $index == 2 ? 'text-brand-700' : 'text-slate-900' }}">
                                    Rp {{ number_format(150000 + ($index * 30000), 0, ',', '.') }}
                                </span>
                            </div>
                            <a href="{{ route('tiket.search', ['terminal_asal' => $route->terminal_asal_id, 'terminal_tujuan' => $route->terminal_tujuan_id, 'tanggal' => now()->addDay()->format('Y-m-d'), 'penumpang' => 1]) }}"
                               class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg text-xs font-bold transition-all shadow-xs">
                                Lihat Tiket
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Fallback 4 Default Popular Routes if none configured in DB yet -->
                    <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-lg transition-all duration-200 flex flex-col justify-between">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-5">
                            </div>
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full border-2 border-brand-600 bg-white"></div>
                                    <span class="text-sm font-bold text-slate-800">Makassar</span>
                                </div>
                                <div class="pl-1.5 -my-2.5"><div class="w-0.5 h-6 bg-slate-200 ml-1"></div></div>
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-brand-600"></div>
                                    <span class="text-sm font-bold text-slate-800">Parepare</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-slate-500 text-xs font-body border-t border-slate-100 pt-3.5">
                                <span>~3.5 Jam</span><span>Tersedia 12 Kursi</span>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
                            <div><span class="block text-[11px] text-slate-400">Mulai dari</span><span class="text-base font-extrabold text-slate-900">Rp 95.000</span></div>
                            <a href="{{ route('tiket.search') }}" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg text-xs font-bold">Lihat Tiket</a>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- 4 LANGKAH MUDAH MEMESAN TIKET BUS SECTION -->
    <section class="py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold text-brand-600 uppercase tracking-widest block mb-2">Panduan Cepat</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
                    4 Langkah Mudah Memesan Tiket Bus
                </h2>
                <p class="text-sm sm:text-base text-slate-500 font-body">
                    Alur reservasi praktis dirancang agar perjalanan Anda terencana hanya dalam beberapa klik saja.
                </p>
            </div>

            <!-- 4 Circular Step Steps -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- Step 1 -->
                <div class="text-center flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full border-2 border-brand-600 text-brand-600 font-extrabold text-xl flex items-center justify-center mb-5 bg-white shadow-xs">
                        1
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Cari Rute</h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-body max-w-xs leading-relaxed">
                        Tentukan kota asal, destinasi, dan tanggal perjalanan impian Anda di form pencarian.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full border-2 border-brand-600 text-brand-600 font-extrabold text-xl flex items-center justify-center mb-5 bg-white shadow-xs">
                        2
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Pilih Bus &amp; Jadwal</h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-body max-w-xs leading-relaxed">
                        Bandingkan kelas armada, jadwal keberangkatan, fasilitas, dan harga tiket terbaik.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full border-2 border-brand-600 text-brand-600 font-extrabold text-xl flex items-center justify-center mb-5 bg-white shadow-xs">
                        3
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Pilih Kursi &amp; Isi Data</h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-body max-w-xs leading-relaxed">
                        Tentukan posisi kursi favorit pada denah bus interaktif dan lengkapi data pemesan.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="text-center flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full bg-brand-600 text-white font-extrabold text-xl flex items-center justify-center mb-5 shadow-md shadow-brand-600/30">
                        4
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Lakukan Pembayaran</h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-body max-w-xs leading-relaxed">
                        Bayar instan via Midtrans (QRIS, VA, E-Wallet) dan e-tiket langsung terbit ke email/WhatsApp.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- OPERATOR MITRA RESMI SECTION -->
    @if ($operators->count() > 0)
        <section class="py-16 bg-slate-50/70 border-t border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-xl mx-auto mb-10">
                    <span class="text-xs font-bold text-brand-600 uppercase tracking-widest block mb-1">Mitra Resmi</span>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Operator Bus Terpercaya</h2>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    @foreach ($operators as $operator)
                        <div class="bg-white border border-slate-200/90 rounded-2xl px-5 py-3.5 shadow-xs flex items-center gap-3 hover:border-brand-600 transition-all">
                            <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-xl">directions_bus</span>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">{{ $operator->nama_operator }}</h4>
                                <span class="text-[11px] text-slate-400 font-body">{{ $operator->buses_count ?? 'Armada prima' }} bus</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- PERTANYAAN YANG SERING DIAJUKAN (FAQ) SECTION -->
    <section class="py-20 bg-white border-t border-slate-100" id="faq-section">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-14">
                <span class="text-xs font-bold text-brand-600 uppercase tracking-widest block mb-2">Pusat Bantuan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="text-sm sm:text-base text-slate-500 font-body">
                    Segala hal yang perlu Anda ketahui mengenai pemesanan tiket, kebijakan bagasi, dan metode pembayaran.
                </p>
            </div>

            <!-- FAQ Accordion List -->
            <div class="space-y-4">
                
                <!-- Item 1 (Default Open) -->
                <div class="faq-item bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <button type="button" class="faq-toggle w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-sm sm:text-base text-slate-900 hover:text-brand-600 transition-colors">
                        <span>Bagaimana cara memesan tiket?</span>
                        <span class="material-symbols-outlined text-brand-600 text-xl transition-transform duration-300 transform -rotate-180 faq-icon">expand_more</span>
                    </button>
                    <div class="faq-body px-5 sm:px-6 pb-6 text-xs sm:text-sm text-slate-500 leading-relaxed font-body">
                        Proses pemesanan sangat sederhana: masukkan kota keberangkatan dan tujuan, pilih tanggal jalan, tentukan armada bus dan jadwal yang Anda inginkan. Kemudian pilih nomor kursi secara visual di layar denah, masukkan detail data diri penumpang, lalu selesaikan pembayaran. E-tiket resmi akan segera diterbitkan.
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="faq-item bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <button type="button" class="faq-toggle w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-sm sm:text-base text-slate-900 hover:text-brand-600 transition-colors">
                        <span>Apakah bisa memilih kursi sendiri?</span>
                        <span class="material-symbols-outlined text-slate-400 text-xl transition-transform duration-300 faq-icon">expand_more</span>
                    </button>
                    <div class="faq-body px-5 sm:px-6 pb-6 text-xs sm:text-sm text-slate-500 leading-relaxed font-body hidden">
                        Ya! Anda dapat memilih sendiri kursi yang masih tersedia melalui denah kursi bus interaktif yang kami sediakan secara real-time sebelum melanjutkan ke pengisian data penumpang.
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="faq-item bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <button type="button" class="faq-toggle w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-sm sm:text-base text-slate-900 hover:text-brand-600 transition-colors">
                        <span>Bagaimana cara pembayaran?</span>
                        <span class="material-symbols-outlined text-slate-400 text-xl transition-transform duration-300 faq-icon">expand_more</span>
                    </button>
                    <div class="faq-body px-5 sm:px-6 pb-6 text-xs sm:text-sm text-slate-500 leading-relaxed font-body hidden">
                        Kami menyediakan sistem pembayaran online instan dan aman terintegrasi dengan Payment Gateway Midtrans. Anda dapat membayar melalui QRIS (GoPay, OVO, ShopeePay, Dana, LinkAja), Virtual Account seluruh bank nasional, maupun Kartu Kredit / Debit.
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="faq-item bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <button type="button" class="faq-toggle w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-sm sm:text-base text-slate-900 hover:text-brand-600 transition-colors">
                        <span>Apakah tiket bisa dibatalkan atau reschedule?</span>
                        <span class="material-symbols-outlined text-slate-400 text-xl transition-transform duration-300 faq-icon">expand_more</span>
                    </button>
                    <div class="faq-body px-5 sm:px-6 pb-6 text-xs sm:text-sm text-slate-500 leading-relaxed font-body hidden">
                        Kebijakan pembatalan dan perubahan jadwal tiket mengikuti syarat dan ketentuan masing-masing operator PO bus mitra. Anda dapat menghubungi customer support 24/7 kami untuk panduan proses pembatalan atau perubahan tanggal.
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="faq-item bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
                    <button type="button" class="faq-toggle w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-sm sm:text-base text-slate-900 hover:text-brand-600 transition-colors">
                        <span>Bagaimana mendapatkan tiket setelah pembayaran?</span>
                        <span class="material-symbols-outlined text-slate-400 text-xl transition-transform duration-300 faq-icon">expand_more</span>
                    </button>
                    <div class="faq-body px-5 sm:px-6 pb-6 text-xs sm:text-sm text-slate-500 leading-relaxed font-body hidden">
                        Begitu pembayaran Anda terverifikasi (rata-rata di bawah 10 detik), e-tiket resmi beserta QR code boarding pass akan langsung terbit di layar Anda, terkirim ke alamat email, serta pesan WhatsApp yang terdaftar.
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Swap Route & FAQ JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Swap Origin & Destination
            const swapBtn = document.getElementById('swapRouteBtn');
            const originSelect = document.getElementById('originSelect');
            const destSelect = document.getElementById('destSelect');

            if (swapBtn && originSelect && destSelect) {
                swapBtn.addEventListener('click', () => {
                    const temp = originSelect.value;
                    originSelect.value = destSelect.value;
                    destSelect.value = temp;
                });
            }

            // FAQ Toggle functionality
            document.querySelectorAll('.faq-toggle').forEach(button => {
                button.addEventListener('click', () => {
                    const body = button.nextElementSibling;
                    const icon = button.querySelector('.faq-icon');
                    const isOpen = !body.classList.contains('hidden');

                    // Close all first
                    document.querySelectorAll('.faq-body').forEach(b => b.classList.add('hidden'));
                    document.querySelectorAll('.faq-icon').forEach(i => {
                        i.classList.remove('-rotate-180', 'text-brand-600');
                        i.classList.add('text-slate-400');
                    });

                    if (!isOpen) {
                        body.classList.remove('hidden');
                        icon.classList.add('-rotate-180', 'text-brand-600');
                        icon.classList.remove('text-slate-400');
                    }
                });
            });
        });
    </script>
@endsection