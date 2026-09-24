@extends('layouts.landing.app', ['menu' => 'login'])

@section('content')
<main class="py-10 sm:py-16 px-4 sm:px-6 relative overflow-hidden bg-slate-50/60 min-h-[calc(100vh-80px-300px)] flex items-center justify-center">
    <!-- Subtle Travel Background Gradients -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none bg-[radial-gradient(#006194_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-blue-200/40 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl w-full grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10 mx-auto">
        
        <!-- LEFT HERO INFOGRAPHIC (Desktop) -->
        <div class="lg:col-span-5 hidden lg:flex flex-col justify-center space-y-6 pr-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-xs font-bold w-fit">
                <span class="material-symbols-outlined text-sm">verified_user</span>
                Akun Resmi BusTicket
            </div>

            <div>
                <h1 class="font-sans text-3xl font-extrabold text-slate-900 leading-tight">
                    Satu Akun untuk Semua Perjalanan Bus Anda
                </h1>
                <p class="text-slate-600 text-sm mt-3 leading-relaxed">
                    Dapatkan kemudahan akses e-tiket digital, riwayat transaksi tanpa kertas, dan pemesanan kursi lebih cepat.
                </p>
            </div>

            <div class="space-y-4 pt-2">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                        <span class="material-symbols-outlined text-lg">qr_code_2</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">E-Tiket & Boarding Pass Instan</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Tunjukkan QR code langsung ke petugas terminal tanpa perlu cetak tiket fisik.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-brand-600 flex items-center justify-center shrink-0 border border-sky-100">
                        <span class="material-symbols-outlined text-lg">event_seat</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Pilih Kursi Favorit Anda</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Peta kursi interaktif 2+2 dengan ketersediaan real-time.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                        <span class="material-symbols-outlined text-lg">history_edu</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Riwayat & Invoice Terpusat</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Semua bukti pembayaran Midtrans dan tiket lama tersimpan rapi selamanya.</p>
                    </div>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-xl">star</span>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-slate-900">Dipercaya 50.000+ Penumpang</p>
                    <p class="text-slate-500 mt-0.5">Mitra resmi PO Primadona, Borlindo, Litha & Co, Bintang Prima.</p>
                </div>
            </div>
        </div>

        <!-- RIGHT CARD: LOGIN FORM -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-brand-600/5 border border-slate-200/80 transition-all">
            
            <!-- Tab Navigation Buttons -->
            <div class="flex rounded-2xl bg-slate-100 p-1.5 mb-6 border border-slate-200/70">
                <a href="{{ route('login') }}" class="flex-1 py-2.5 rounded-xl font-sans text-sm font-bold transition-all shadow-xs bg-white text-brand-600 text-center">
                    Masuk ke Akun
                </a>
                <a href="{{ route('register') }}" class="flex-1 py-2.5 rounded-xl font-sans text-sm font-medium transition-all text-slate-600 hover:text-slate-900 text-center">
                    Daftar Akun Baru
                </a>
            </div>

            <!-- Form Content -->
            <div class="space-y-4">
                <div class="mb-5">
                    <h2 class="font-sans text-2xl font-bold text-slate-900">Selamat Datang Kembali!</h2>
                    <p class="text-xs text-slate-500 mt-1">Masukkan username atau email Anda untuk mengakses tiket.</p>
                </div>

                {{-- Alert Error Message --}}
                @if (session('message') == 'gagal login')
                    <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl flex items-center gap-2.5 text-xs text-rose-700">
                        <span class="material-symbols-outlined text-lg shrink-0">error</span>
                        <span>Username/Email atau password salah. Silakan coba lagi.</span>
                    </div>
                @endif

                @if (session('message') == 'need login')
                    <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-2.5 text-xs text-amber-800">
                        <span class="material-symbols-outlined text-lg shrink-0">warning</span>
                        <span>Anda harus masuk terlebih dahulu untuk melanjutkan pemesanan.</span>
                    </div>
                @endif

                @if (session('message') == 'register sukses')
                    <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-2.5 text-xs text-emerald-800">
                        <span class="material-symbols-outlined text-lg shrink-0">check_circle</span>
                        <span>Pendaftaran berhasil! Silakan masuk dengan akun baru Anda.</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm shrink-0">close</span>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login_action') }}" class="space-y-4" id="loginForm">
                    @csrf
                    <div>
                        <label for="identity" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            Username atau Email
                        </label>
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">mail</span>
                            <input 
                                id="identity" 
                                name="identity" 
                                type="text" 
                                value="{{ old('identity', 'customer@busticket.test') }}" 
                                required 
                                autofocus
                                class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20 transition-all outline-none"
                                placeholder="contoh: customer@busticket.test atau username"
                            />
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Kata Sandi
                            </label>
                            <a href="javascript:void(0)" onclick="alert('Fitur reset kata sandi dapat menghubungi admin operasional.')" class="text-xs text-brand-600 font-semibold hover:underline">
                                Lupa Sandi?
                            </a>
                        </div>
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">lock</span>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                value="password"
                                required
                                class="w-full pl-11 pr-11 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20 transition-all outline-none"
                                placeholder="Masukkan kata sandi"
                            />
                            <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3.5 text-slate-400 hover:text-slate-700" title="Lihat Kata Sandi">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600">
                            <input type="checkbox" name="remember" checked class="rounded border-slate-300 text-brand-600 focus:ring-brand-500 w-4 h-4"/>
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-sans text-sm font-bold flex items-center justify-center gap-2 shadow-md shadow-brand-600/20 hover:shadow-lg transition-all active:scale-[0.99] cursor-pointer">
                        <span>Masuk Sekarang</span>
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </button>
                </form>

                <!-- Quick Demo Login Helper -->
                <div class="p-3 bg-sky-50 rounded-2xl border border-sky-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 text-xs text-sky-900 mt-2">
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base text-brand-600 shrink-0">key</span>
                        <span><strong>Akun Cepat:</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="fillCredentials('customer@busticket.test', 'password')" class="px-2.5 py-1.5 rounded-lg bg-white border border-sky-200 text-sky-800 font-semibold hover:bg-sky-100 transition-colors shadow-2xs cursor-pointer">
                            Customer
                        </button>
                        <button type="button" onclick="fillCredentials('admin@busticket.test', 'password')" class="px-2.5 py-1.5 rounded-lg bg-white border border-sky-200 text-sky-800 font-semibold hover:bg-sky-100 transition-colors shadow-2xs cursor-pointer">
                            Admin
                        </button>
                    </div>
                </div>

                <!-- Footer Link -->
                <div class="pt-4 text-center border-t border-slate-100">
                    <p class="text-xs text-slate-500">
                        Belum memiliki akun BusTicket? 
                        <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:underline">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    function togglePasswordVisibility(id, btn) {
        const input = document.getElementById(id);
        const icon = btn.querySelector('.material-symbols-outlined');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }

    function fillCredentials(identity, password) {
        document.getElementById('identity').value = identity;
        document.getElementById('password').value = password;
        
        // Visual feedback
        const form = document.getElementById('loginForm');
        form.classList.add('ring-2', 'ring-brand-500/20', 'rounded-2xl', 'p-1');
        setTimeout(() => {
            form.classList.remove('ring-2', 'ring-brand-500/20', 'rounded-2xl', 'p-1');
        }, 500);
    }
</script>
@endpush