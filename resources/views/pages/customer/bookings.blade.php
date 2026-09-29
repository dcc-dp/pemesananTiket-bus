@extends('layouts.user.app', ['title' => 'Booking Saya', 'menu' => 'bookings'])

@section('user-content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-600">receipt_long</span>
                    Booking Saya
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-body mt-1">Daftar riwayat dan status pemesanan tiket Anda</p>
            </div>
            <a href="{{ route('tiket.search') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs sm:text-sm font-semibold shadow-xs transition-all active:scale-98 self-start sm:self-center">
                <span class="material-symbols-outlined text-base">add</span>
                <span>Booking Baru</span>
            </a>
        </div>

        <!-- Filter Tabs & Content Card -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <!-- Filter Pills -->
            <div class="p-4 border-b border-slate-100 flex flex-wrap items-center gap-2">
                <a href="{{ route('customer.bookings') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ !$filter ? 'bg-brand-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua
                </a>
                <a href="{{ route('customer.bookings', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter == 'pending' ? 'bg-brand-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Pending
                </a>
                <a href="{{ route('customer.bookings', ['status' => 'confirmed']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter == 'confirmed' ? 'bg-brand-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Confirmed
                </a>
                <a href="{{ route('customer.bookings', ['status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter == 'completed' ? 'bg-brand-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Completed
                </a>
                <a href="{{ route('customer.bookings', ['status' => 'cancelled']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $filter == 'cancelled' ? 'bg-brand-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Batal
                </a>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-4">Kode Booking</th>
                            <th class="py-3.5 px-4">Rute & Bus</th>
                            <th class="py-3.5 px-4">Jadwal</th>
                            <th class="py-3.5 px-4">Kursi</th>
                            <th class="py-3.5 px-4">Total</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($bookings as $booking)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-mono font-bold text-brand-700">
                                    {{ $booking->kode_booking }}
                                    <div class="text-[10px] text-slate-400 font-sans font-normal mt-0.5">{{ $booking->tanggal_booking->format('d M Y H:i') }}</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-800">
                                        {{ $booking->jadwal->rute->terminalAsal->kota }} &rarr; {{ $booking->jadwal->rute->terminalTujuan->kota }}
                                    </div>
                                    <div class="text-[11px] text-slate-500">{{ $booking->jadwal->bus->nama_bus }} &middot; {{ ucfirst($booking->jadwal->bus->kelas) }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-slate-700 font-body">
                                    <div>{{ $booking->jadwal->tanggal->format('d M Y') }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $booking->jadwal->jam_berangkat->format('H:i') }} WITA</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($booking->bookingSeats as $seat)
                                            <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-700 font-bold text-[10px] border border-amber-200">
                                                {{ $seat->kursi->nomor_kursi }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-1 items-start">
                                        @if ($booking->status_booking == 'confirmed' || $booking->status_booking == 'completed')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">{{ $booking->status_booking_label }}</span>
                                        @elseif ($booking->status_booking == 'pending')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700">{{ $booking->status_booking_label }}</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">{{ $booking->status_booking_label }}</span>
                                        @endif

                                        @if ($booking->status_pembayaran == 'paid')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">Lunas</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700">{{ $booking->status_pembayaran_label }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <a href="{{ route('customer.booking.detail', $booking->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:border-brand-600 hover:text-brand-600 text-xs font-semibold transition-all">
                                            <span>Detail</span>
                                        </a>
                                        @if ($booking->status_pembayaran == 'pending')
                                            <a href="{{ route('customer.booking.pay', $booking->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold shadow-xs transition-all">
                                                <span>Bayar</span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 px-4">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <span class="material-symbols-outlined text-2xl">inbox</span>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Belum ada booking</p>
                                    <p class="text-xs text-slate-500 mt-0.5 font-body">Pemesanan tiket Anda akan muncul di sini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection