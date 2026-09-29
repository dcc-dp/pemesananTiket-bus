@extends('layouts.user.app', ['title' => 'Tiket Saya', 'menu' => 'tickets'])

@section('user-content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-600">confirmation_number</span>
                    Tiket Saya
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-body mt-1">Daftar e-tiket perjalanan Anda yang aktif dan telah lunas</p>
            </div>
            <a href="{{ route('tiket.search') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-semibold shadow-xs transition-all active:scale-98 self-start sm:self-center">
                <span class="material-symbols-outlined text-base">add</span>
                <span>Booking Baru</span>
            </a>
        </div>

        <!-- Ticket Cards List -->
        <div class="space-y-4">
            @forelse ($bookings as $booking)
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden transition-all hover:border-slate-300">
                    <!-- Ticket Header Strip -->
                    <div class="bg-slate-50 border-b border-slate-100 px-5 py-3 flex flex-wrap items-center justify-between gap-2">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-brand-600 text-lg">directions_bus</span>
                            <span class="font-mono font-bold text-slate-800 text-xs sm:text-sm">{{ $booking->kode_booking }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">Lunas</span>
                        </div>
                        <div class="text-xs text-slate-500">
                            <span class="font-bold text-slate-700">{{ $booking->jadwal->bus->nama_bus }}</span> &middot; {{ ucfirst($booking->jadwal->bus->kelas) }}
                        </div>
                    </div>

                    <!-- Ticket Body -->
                    <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <!-- Route & Schedule Details -->
                        <div class="flex-1 space-y-3">
                            <div class="flex items-center gap-4 sm:gap-6">
                                <!-- Origin -->
                                <div class="text-left min-w-[70px]">
                                    <div class="text-lg sm:text-xl font-black text-slate-900">{{ $booking->jadwal->jam_berangkat->format('H:i') }}</div>
                                    <div class="text-xs font-semibold text-slate-700">{{ $booking->jadwal->rute->terminalAsal->kota }}</div>
                                    <div class="text-[11px] text-slate-400 font-body">{{ $booking->jadwal->rute->terminalAsal->nama_terminal }}</div>
                                </div>

                                <!-- Route Line -->
                                <div class="flex-1 flex flex-col items-center">
                                    <span class="text-[11px] font-medium text-slate-400 mb-1 font-body">{{ $booking->jadwal->tanggal->format('d M Y') }}</span>
                                    <div class="w-full flex items-center gap-1.5">
                                        <div class="w-2 h-2 rounded-full bg-brand-600"></div>
                                        <div class="h-0.5 flex-1 border-t-2 border-dashed border-slate-200"></div>
                                        <span class="material-symbols-outlined text-brand-600 text-sm">directions_bus</span>
                                        <div class="h-0.5 flex-1 border-t-2 border-dashed border-slate-200"></div>
                                        <div class="w-2 h-2 rounded-full bg-brand-600"></div>
                                    </div>
                                </div>

                                <!-- Destination -->
                                <div class="text-right min-w-[70px]">
                                    <div class="text-lg sm:text-xl font-black text-slate-900">
                                        {{ \Carbon\Carbon::parse($booking->jadwal->jam_berangkat)->addMinutes($booking->jadwal->rute->estimasi_durasi ?? 0)->format('H:i') }}
                                    </div>
                                    <div class="text-xs font-semibold text-slate-700">{{ $booking->jadwal->rute->terminalTujuan->kota }}</div>
                                    <div class="text-[11px] text-slate-400 font-body">{{ $booking->jadwal->rute->terminalTujuan->nama_terminal }}</div>
                                </div>
                            </div>

                            <!-- Seats info -->
                            <div class="flex items-center gap-2 pt-2 border-t border-slate-100 text-xs text-slate-600">
                                <span class="font-medium">Kursi:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($booking->bookingSeats as $s)
                                        <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200 font-bold text-xs">
                                            {{ $s->kursi->nomor_kursi }}
                                        </span>
                                    @endforeach
                                </div>
                                <span class="text-slate-400">&middot;</span>
                                <span class="text-slate-500 font-body">{{ $booking->bookingSeats->count() }} Penumpang</span>
                            </div>
                        </div>

                        <!-- Right CTA Block -->
                        <div class="md:text-right border-t md:border-t-0 pt-4 md:pt-0 border-slate-100 flex md:flex-col justify-between items-center md:items-end gap-3">
                            <div>
                                <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Pembayaran</div>
                                <div class="text-base sm:text-lg font-black text-brand-600">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </div>
                            </div>
                            <a href="{{ route('customer.booking.ticket', $booking->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-all active:scale-98">
                                <span class="material-symbols-outlined text-base">confirmation_number</span>
                                <span>Lihat E-Tiket</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-12 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-3xl">confirmation_number</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Tiket</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 font-body">Anda belum memiliki tiket yang lunas. Silakan pesan tiket untuk rencana bepergian Anda.</p>
                    <a href="{{ route('tiket.search') }}" class="inline-flex items-center gap-1.5 mt-5 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-all">
                        <span>Cari Tiket Sekarang</span>
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection