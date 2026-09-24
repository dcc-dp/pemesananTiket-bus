<!-- FOOTER (PROTOTYPE DESIGN SYSTEM) -->
<footer class="bg-slate-900 text-slate-300 mt-auto border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-slate-800">
            
            <!-- Col 1: Brand & Desc -->
            <div class="md:col-span-4 space-y-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">directions_bus</span>
                    </div>
                    <span class="text-xl font-extrabold text-white tracking-tight">BusTicket</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-400 font-body leading-relaxed max-w-sm">
                    Platform pemesanan tiket bus online terdepan di Indonesia. Nikmati kemudahan mencari rute, memilih kursi nyaman, dan pembayaran instan dengan kepastian berangkat.
                </p>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 pt-1">
                    <span class="material-symbols-outlined text-brand-500 text-base">support_agent</span>
                    <span>Layanan Pelanggan Siaga 24/7</span>
                </div>
            </div>

            <!-- Col 2: Navigasi Cepat -->
            <div class="md:col-span-2 space-y-3">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Navigasi Cepat</h4>
                <ul class="space-y-2 text-xs font-body text-slate-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('tiket.search') }}" class="hover:text-white transition-colors">Pesan Tiket</a></li>
                    <li><a href="{{ route('home') }}#rute-populer" class="hover:text-white transition-colors">Rute Populer</a></li>
                    @if (Session('cek'))
                        <li><a href="{{ route('customer.bookings') }}" class="hover:text-white transition-colors">Pesanan Saya</a></li>
                        <li><a href="{{ route('customer.tickets') }}" class="hover:text-white transition-colors">Tiket Saya</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk Akun</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Daftar Akun</a></li>
                    @endif
                </ul>
            </div>

            <!-- Col 3: Bantuan & Hubungi Kami -->
            <div class="md:col-span-3 space-y-3">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Bantuan &amp; Hubungi Kami</h4>
                <ul class="space-y-2 text-xs font-body text-slate-400">
                    <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Mitra Operator</a></li>
                    <li><span class="text-slate-400">info@busticket.id</span></li>
                    <li><span class="text-slate-300 font-medium">+62 811-8800-0007</span></li>
                </ul>
            </div>

            <!-- Col 4: Mitra & Pembayaran Resmi -->
            <div class="md:col-span-3 space-y-3">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Mitra &amp; Pembayaran Resmi</h4>
                <p class="text-xs text-slate-400 font-body">
                    Keamanan pembayaran didukung oleh sistem Payment Gateway Midtrans.
                </p>
                <div class="grid grid-cols-3 gap-2 pt-2">
                    <div class="bg-slate-800/80 border border-slate-700/60 rounded-md py-1.5 px-2 text-center text-[10px] font-bold text-slate-300">QRIS</div>
                    <div class="bg-slate-800/80 border border-slate-700/60 rounded-md py-1.5 px-2 text-center text-[10px] font-bold text-slate-300">BCA VA</div>
                    <div class="bg-slate-800/80 border border-slate-700/60 rounded-md py-1.5 px-2 text-center text-[10px] font-bold text-slate-300">Mandiri</div>
                    <div class="bg-slate-800/80 border border-slate-700/60 rounded-md py-1.5 px-2 text-center text-[10px] font-bold text-slate-300">GoPay</div>
                    <div class="bg-slate-800/80 border border-slate-700/60 rounded-md py-1.5 px-2 text-center text-[10px] font-bold text-slate-300">ShopeePay</div>
                    <div class="bg-slate-800/80 border border-slate-700/60 rounded-md py-1.5 px-2 text-center text-[10px] font-bold text-slate-300">Midtrans</div>
                </div>
            </div>

        </div>

        <!-- Copyright Bottom Bar -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-body">
            <p>&copy; {{ date('Y') }} BusTicket Platform. Hak Cipta Dilindungi Undang-Undang.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-slate-400 transition-colors">Ketentuan Tiket</a>
                <a href="#" class="hover:text-slate-400 transition-colors">Privasi</a>
                <span class="flex items-center gap-1.5 text-emerald-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Status Server: Normal
                </span>
            </div>
        </div>

    </div>
</footer>