@extends('layouts.landing.app', ['menu' => 'register'])

@section('content')
<main class="py-12 sm:py-16 px-4 sm:px-6 min-h-[calc(100vh-80px-240px)] flex items-center justify-center">
    <div class="max-w-lg w-full mx-auto">
        
        <!-- Brand Icon & Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center mb-3">
                <img src="{{ asset('img/logo-bustiket.png') }}" alt="Logo BUSTIKET" class="w-14 h-14 object-contain">
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Akun BusTicket</h1>
            <p class="text-xs text-slate-500 mt-1 font-body">Lengkapi data diri untuk kemudahan pemesanan tiket bus</p>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80">
            
            <!-- Tab Navigation Buttons -->
            <div class="flex rounded-xl bg-slate-100 p-1 mb-6 border border-slate-200/60">
                <a href="{{ route('login') }}" class="flex-1 py-2 rounded-lg text-xs font-medium transition-all text-slate-600 hover:text-slate-900 text-center">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="flex-1 py-2 rounded-lg text-xs font-bold transition-all shadow-xs bg-white text-brand-600 text-center">
                    Daftar
                </a>
            </div>

            <!-- Alerts -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm shrink-0">close</span>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('register_action') }}" class="space-y-4" id="formRegister">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">
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
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all"
                            placeholder="Nama lengkap Anda"
                        />
                    </div>
                </div>

                <!-- Username & Email Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">
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
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('username') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all"
                                placeholder="Username unik"
                            />
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">mail</span>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                value="{{ old('email') }}" 
                                required
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all"
                                placeholder="nama@email.com"
                            />
                        </div>
                    </div>
                </div>

                <!-- Nomor WhatsApp / HP -->
                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nomor HP / WhatsApp (Opsional)
                    </label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-lg">phone</span>
                        <input 
                            id="phone" 
                            name="phone" 
                            type="tel" 
                            value="{{ old('phone') }}"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('phone') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all"
                            placeholder="08xxxxxxxxxx"
                        />
                    </div>
                </div>

                <!-- Kata Sandi & Konfirmasi Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
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
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-200' }} bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all"
                                placeholder="Min. 6 karakter"
                            />
                            <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 text-slate-400 hover:text-slate-600" title="Lihat Sandi">
                                <span class="material-symbols-outlined text-base">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">
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
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all"
                                placeholder="Ulangi sandi"
                            />
                            <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute right-3 text-slate-400 hover:text-slate-600" title="Lihat Sandi">
                                <span class="material-symbols-outlined text-base">visibility</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Syarat & Ketentuan -->
                <div class="pt-1">
                    <label class="flex items-start gap-2.5 cursor-pointer select-none text-xs text-slate-600">
                        <input type="checkbox" required checked class="mt-0.5 rounded border-slate-300 text-brand-600 focus:ring-brand-500 w-4 h-4"/>
                        <span>Saya menyetujui Ketentuan Layanan &amp; Kebijakan Privasi BusTicket</span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full py-3 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold flex items-center justify-center gap-2 shadow-xs transition-all active:scale-98 cursor-pointer">
                    <span>Daftar Akun</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </form>

            <!-- Footer Link -->
            <div class="pt-5 mt-5 text-center border-t border-slate-100">
                <p class="text-xs text-slate-500">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:underline">
                        Masuk di sini
                    </a>
                </p>
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