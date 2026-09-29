@extends('layouts.user.app', ['title' => 'Profil Saya', 'menu' => 'profile'])

@section('user-content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-600">person</span>
                Profil Saya
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-body mt-1">Kelola data profil akun dan keamanan kata sandi Anda</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
            <!-- User Info Badge -->
            <div class="flex items-center gap-4 pb-6 mb-6 border-b border-slate-100">
                <div class="w-14 h-14 rounded-2xl bg-brand-50 border border-brand-100 text-brand-700 flex items-center justify-center font-bold text-xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">{{ $user->name }}</h2>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-slate-500 font-body">{{ $user->email }}</span>
                        <span class="text-slate-300">&middot;</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-brand-50 text-brand-700">Customer</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-6">
                @csrf

                <!-- Basic Info -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Informasi Dasar</h3>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="text-xs font-semibold text-slate-700 mb-1.5 block">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" class="w-full rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all py-2.5 px-3.5 @error('name') border-rose-300 ring-2 ring-rose-500/10 @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1 font-body">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username & Email (Disabled) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-slate-700 mb-1.5 block">Username</label>
                            <input type="text" class="w-full rounded-xl border border-slate-200 bg-slate-100 text-slate-500 text-sm cursor-not-allowed py-2.5 px-3.5" value="{{ $user->username }}" disabled>
                            <span class="text-[11px] text-slate-400 mt-1 block">Username tidak dapat diubah</span>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-700 mb-1.5 block">Email</label>
                            <input type="email" class="w-full rounded-xl border border-slate-200 bg-slate-100 text-slate-500 text-sm cursor-not-allowed py-2.5 px-3.5" value="{{ $user->email }}" disabled>
                            <span class="text-[11px] text-slate-400 mt-1 block">Email akun terdaftar</span>
                        </div>
                    </div>

                    <!-- No. HP -->
                    <div>
                        <label class="text-xs font-semibold text-slate-700 mb-1.5 block">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" class="w-full rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all py-2.5 px-3.5 @error('phone') border-rose-300 ring-2 ring-rose-500/10 @enderror" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890">
                        @error('phone')
                            <p class="text-xs text-rose-500 mt-1 font-body">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-slate-100 pt-6 space-y-4">
                    <div>
                        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Ganti Kata Sandi</h3>
                        <p class="text-xs text-slate-500 font-body mt-0.5">Biarkan kosong jika Anda tidak ingin mengubah kata sandi.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-slate-700 mb-1.5 block">Password Baru</label>
                            <input type="password" name="password" class="w-full rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all py-2.5 px-3.5 @error('password') border-rose-300 ring-2 ring-rose-500/10 @enderror" placeholder="Minimal 8 karakter">
                            @error('password')
                                <p class="text-xs text-rose-500 mt-1 font-body">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-700 mb-1.5 block">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="w-full rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all py-2.5 px-3.5" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-semibold shadow-xs transition-all active:scale-98">
                        <span class="material-symbols-outlined text-base">save</span>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection