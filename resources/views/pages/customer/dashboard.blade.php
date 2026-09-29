@extends('layouts.user.app', ['title' => 'Dashboard Customer'])

@section('user-content')
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-brand-700 to-brand-600 rounded-2xl p-6 sm:p-8 text-white shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight">Halo, {{ $user->name }}!</h1>
            <p class="text-xs sm:text-sm text-brand-100 font-body mt-1">Selamat datang di akun BusTicket. Siap untuk perjalanan berikutnya?</p>
        </div>
        <a href="{{ route('tiket.search') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white text-brand-700 text-xs sm:text-sm font-semibold hover:bg-brand-50 shadow-xs transition-all active:scale-98 self-start sm:self-center">
            <span class="material-symbols-outlined text-base">search</span>
            <span>Cari Tiket Sekarang</span>
        </a>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Stat 1 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tiket Terbayar</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $paidBookings }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">confirmation_number</span>
            </div>
        </div>

        <!-- Stat 2 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Perjalanan</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalPerjalanan }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">directions_bus</span>
            </div>
        </div>

        <!-- Stat 3 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Booking Aktif</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $activeBookings->count() }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">receipt_long</span>
            </div>
        </div>
    </div>

    <!-- Booking Terbaru Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-600 text-lg">history</span>
                Booking Terbaru
            </h2>
            <a href="{{ route('customer.bookings') }}" class="text-xs font-semibold text-brand-600 hover:underline">
                Lihat Semua
            </a>
        </div>

        @if ($activeBookings->count() === 0)
            <div class="text-center py-12 px-4">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined text-2xl">confirmation_number</span>
                </div>
                <h3 class="text-sm font-bold text-slate-800">Belum Ada Pemesanan</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 font-body">Anda belum memiliki tiket aktif saat ini. Mulai cari jadwal bus untuk perjalanan Anda.</p>
                <a href="{{ route('tiket.search') }}" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-all">
                    <span>Cari Tiket</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-4">Kode</th>
                            <th class="py-3 px-4">Rute</th>
                            <th class="py-3 px-4">Jadwal</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($activeBookings as $booking)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-mono font-bold text-slate-800">
                                    {{ $booking->kode_booking }}
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">
                                    {{ $booking->jadwal->rute->terminalAsal->kota }} &rarr; {{ $booking->jadwal->rute->terminalTujuan->kota }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-600 font-body">
                                    {{ $booking->jadwal->tanggal->format('d M Y') }} &middot; {{ $booking->jadwal->jam_berangkat->format('H:i') }} WITA
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($booking->status_pembayaran == 'paid')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">Lunas</span>
                                    @elseif ($booking->status_pembayaran == 'pending')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700">Pending</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">{{ $booking->status_booking }}</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ route('customer.booking.detail', $booking->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:border-brand-600 hover:text-brand-600 text-xs font-semibold transition-all">
                                        <span>Detail</span>
                                        <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection