@extends('layouts.landing.app', ['menu' => 'register'])

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
                Pendaftaran Akun Resmi
            </div>

            <div>
                <h1 class="font-sans text-3xl font-extrabold text-slate-900 leading-tight">
                    Mulai Perjalanan Anda Bersama BusTicket
                </h1>
                <p class="text-slate-600 text-sm mt-3 leading-relaxed">
                    Daftar akun gratis sekarang dan nikmati kemudahan reservasi bus antar kota dengan sistem modern dan terpercaya.
                </p>
            </div>

            <div class="space-y-4 pt-2">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                        <span class="material-symbols-outlined text-lg">electric_bolt</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Reservasi Cepat & Aman</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Booking kursi dalam hitungan detik tanpa antre di terminal.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-brand-600 flex items-center justify-center shrink-0 border border-sky-100">
                        <span class="material-symbols-outlined text-lg">credit_card</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Pembayaran Otomatis Midtrans</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Mendukung QRIS, GoPay, ShopeePay, dan Transfer Bank 24 jam.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                        <span class="material-symbols-outlined text-lg">airplane_ticket</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">E-Tiket Siap Pakai</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Dapatkan tiket digital ber-barcode yang langsung aktif setelah pembayaran.</p>
                    </div>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-xl">verified</span>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-slate-900">100% Bebas Biaya Admin Tambahan</p>
                    <p class="text-slate-500 mt-0.5">Harga tiket transparan sesuai dengan tarif resmi operator bus.</p>
                </div>
            </div>
        </div>

        <!-- RIGHT CARD: REGISTER FORM -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-brand-600/5 border border-slate-200/80 transition-all">
            
            <!-- Tab Navigation Buttons -->
            <div class="flex rounded-2xl bg-slate-100 p-1.5 mb-6 border border-slate-200/70">
                <a href="{{ route('login') }}" class="flex-1 py-2.5 rounded-xl font-sans text-sm font-medium transition-all text-slate-600 hover:text-slate-900 text-center">
                    Masuk ke Akun
                </a>
                <a href="{{ route('register') }}" class="flex-1 py-2.5 rounded-xl font-sans text-sm font-bold transition-all shadow-xs bg-white text-brand-600 text-center">
                    Daftar Akun Baru
                </a>
            </div>

            <!-- Form Content -->
            <div class="space-y-4">
                <div class="mb-5">
                    <h2 class="font-sans text-2xl font-bold text-slate-900">Buat Akun BusTicket</h2>
                    <p class="text-xs text-slate-500 mt-1">Daftar dalam 1 menit untuk kemudahan pemesanan tiket bus antar kota.</p>
                </div>

                {{-- Alert Error Message --}}
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

                <form method="POST" action="{{ route('register_action') }}" class="space-y-3.5" id="formRegister">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            Nama Lengkap Sesuai KTP <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">person</span>
                            <input 
                                id="name" 
                                name="name" 
                                type="text" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20 transition-all outline-none"
                                placeholder="contoh: Andi Muh. Fikri"
                            />
                        </div>
                        @error('name')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username & Email Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="username" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Username <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">alternate_email</span>
                                <input 
                                    id="username" 
                                    name="username" 
                                    type="text" 
                                    value="{{ old('username') }}" 
                                    required
                                    class="w-full pl-11 pr-4 py-2.5 rounded-xl border {{ $errors->has('username') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20 transition-all outline-none"
                                    placeholder="contoh: fikri123"
                                />
                            </div>
                            @error('username')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Email Aktif <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">mail</span>
                                <input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    value="{{ old('email') }}" 
                                    required
                                    class="w-full pl-11 pr-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20 transition-all outline-none"
                                    placeholder="fikri@gmail.com"
                                />
                            </div>
                            @error('email')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor WhatsApp / HP -->
                    <div>
                        <label for="phone" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            Nomor WhatsApp / HP (Opsional)
                        </label>
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">phone</span>
                            <input 
                                id="phone" 
                                name="phone" 
                                type="tel" 
                                value="{{ old('phone') }}"
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl border {{ $errors->has('phone') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20 transition-all outline-none"
                                placeholder="081234567890"
                            />
                        </div>
                        @error('phone')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kata Sandi & Konfirmasi Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">lock</span>
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    required
                                    minlength="6"
                                    class="w-full pl-11 pr-10 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20 transition-all outline-none"
                                    placeholder="Min. 6 karakter"
                                />
                                <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 text-slate-400 hover:text-slate-700" title="Lihat Sandi">
                                    <span class="material-symbols-outlined text-base">visibility</span>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                Konfirmasi Sandi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">lock_reset</span>
                                <input 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    type="password" 
                                    required
                                    minlength="6"
                                    class="w-full pl-11 pr-10 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/20 transition-all outline-none"
                                    placeholder="Ulangi sandi"
                                />
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute right-3 text-slate-400 hover:text-slate-700" title="Lihat Sandi">
                                    <span class="material-symbols-outlined text-base">visibility</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Syarat & Ketentuan -->
                    <div class="pt-1">
                        <label class="flex items-start gap-2.5 cursor-pointer select-none text-xs text-slate-600">
                            <input type="checkbox" required checked class="mt-0.5 rounded border-slate-300 text-brand-600 focus:ring-brand-500 w-4 h-4"/>
                            <span>Saya menyetujui <a href="javascript:void(0)" class="text-brand-600 font-semibold hover:underline">Syarat & Ketentuan</a> serta <a href="javascript:void(0)" class="text-brand-600 font-semibold hover:underline">Kebijakan Privasi</a> BusTicket.</span>
                        </label>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-sans text-sm font-bold flex items-center justify-center gap-2 shadow-md shadow-brand-600/20 hover:shadow-lg transition-all active:scale-[0.99] cursor-pointer">
                        <span>Daftar Akun Sekarang</span>
                        <span class="material-symbols-outlined text-base">check_circle</span>
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="pt-4 text-center border-t border-slate-100">
                    <p class="text-xs text-slate-500">
                        Sudah memiliki akun BusTicket? 
                        <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:underline">
                            Masuk di sini
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

    // Client-side quick validation before submission
    document.getElementById('formRegister').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;
        
        if (password.length < 6) {
            e.preventDefault();
            Swal.fire({
                title: 'Password Terlalu Pendek',
                text: 'Password harus memiliki minimal 6 karakter demi keamanan akun Anda.',
                icon: 'warning',
                confirmButtonColor: '#006194'
            });
            return;
        }

        if (password !== confirm) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Password Tidak Cocok',
                text: 'Pastikan kata sandi dan konfirmasi kata sandi Anda sama persis.',
                icon: 'error',
                confirmButtonColor: '#006194'
            });
            return;
        }
    });
</script>
@endpush