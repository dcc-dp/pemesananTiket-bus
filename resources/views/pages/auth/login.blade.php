@extends('layouts.landing.app', ['menu' => 'login'])

@section('content')
<main class="py-12 sm:py-16 px-4 sm:px-6 min-h-[calc(100vh-80px-240px)] flex items-center justify-center">
    <div class="max-w-md w-full mx-auto">
        
        <!-- Brand Icon & Header -->
        <div class="text-center mb-6">
            <div class="inline-flex w-12 h-12 rounded-2xl bg-brand-600 items-center justify-center text-white shadow-xs mb-3">
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">directions_bus</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Masuk ke BusTicket</h1>
            <p class="text-xs text-slate-500 mt-1 font-body">Akses tiket perjalanan dan riwayat pemesanan Anda</p>
        </div>

        <!-- Card Container -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80">
            
            <!-- Tab Navigation Buttons -->
            <div class="flex rounded-xl bg-slate-100 p-1 mb-6 border border-slate-200/60">
                <a href="{{ route('login') }}" class="flex-1 py-2 rounded-lg text-xs font-bold transition-all shadow-xs bg-white text-brand-600 text-center">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="flex-1 py-2 rounded-lg text-xs font-medium transition-all text-slate-600 hover:text-slate-900 text-center">
                    Daftar
                </a>
            </div>

            <!-- Alerts -->
            @if (session('message') == 'gagal login')
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl flex items-center gap-2 text-xs text-rose-700">
                    <span class="material-symbols-outlined text-base shrink-0">error</span>
                    <span>Username/Email atau password salah. Silakan coba lagi.</span>
                </div>
            @endif

            @if (session('message') == 'need login')
                <div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-2 text-xs text-amber-800">
                    <span class="material-symbols-outlined text-base shrink-0">warning</span>
                    <span>Anda harus masuk terlebih dahulu untuk melanjutkan pemesanan.</span>
                </div>
            @endif

            @if (session('message') == 'register sukses')
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-2 text-xs text-emerald-800">
                    <span class="material-symbols-outlined text-base shrink-0">check_circle</span>
                    <span>Pendaftaran berhasil! Silakan masuk dengan akun baru Anda.</span>
                </div>
            @endif

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
            <form method="POST" action="{{ route('login_action') }}" class="space-y-4" id="loginForm">
                @csrf
                <div>
                    <label for="identity" class="block text-xs font-semibold text-slate-700 mb-1.5">
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
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all"
                            placeholder="customer@busticket.test atau username"
                        />
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-700">
                            Kata Sandi
                        </label>
                        <a href="javascript:void(0)" onclick="alert('Silakan hubungi customer service kami untuk reset password.')" class="text-xs text-brand-600 font-semibold hover:underline">
                            Lupa sandi?
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
                            class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all"
                            placeholder="Masukkan kata sandi"
                        />
                        <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 text-slate-400 hover:text-slate-600" title="Lihat Kata Sandi">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-0.5">
                    <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600">
                        <input type="checkbox" name="remember" checked class="rounded border-slate-300 text-brand-600 focus:ring-brand-500 w-4 h-4"/>
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold flex items-center justify-center gap-2 shadow-xs transition-all active:scale-98 cursor-pointer">
                    <span>Masuk</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </form>

            <!-- Quick Demo Helper -->
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between gap-2 text-xs text-slate-600 mt-5">
                <span class="text-[11px] font-semibold text-slate-500">Demo Login:</span>
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="fillCredentials('customer@busticket.test', 'password')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 font-semibold hover:border-brand-600 hover:text-brand-600 transition-colors shadow-2xs">
                        Customer
                    </button>
                    <button type="button" onclick="fillCredentials('admin@busticket.test', 'password')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 font-semibold hover:border-brand-600 hover:text-brand-600 transition-colors shadow-2xs">
                        Admin
                    </button>
                </div>
            </div>

            <!-- Footer Link -->
            <div class="pt-5 mt-5 text-center border-t border-slate-100">
                <p class="text-xs text-slate-500">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:underline">
                        Daftar sekarang
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