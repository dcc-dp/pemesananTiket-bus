@extends('layouts.landing.app', ['menu' => 'booking'])

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">
        
        <!-- Header Strip -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <a href="{{ Session('role') == 'admin' ? route('admin.booking.show', $booking->id) : route('customer.bookings') }}" class="w-9 h-9 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                </a>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Detail Pemesanan Tiket</h2>
                    <p class="text-xs text-slate-400 font-body">Kode Booking: <strong class="text-slate-700 font-mono">{{ $booking->kode_booking }}</strong></p>
                </div>
            </div>

            <!-- Status Pill Badge -->
            <div>
                @if ($booking->status_pembayaran == 'paid')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        LUNAS &amp; TERVERIFIKASI
                    </span>
                @elseif ($booking->status_pembayaran == 'pending')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        MENUNGGU PEMBAYARAN
                    </span>
                @elseif ($booking->status_pembayaran == 'failed')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                        GAGAL
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                        {{ strtoupper($booking->status_booking) }}
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Details -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Schedule Card -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-600 text-lg">route</span>
                        Jadwal &amp; Rute Perjalanan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center bg-slate-50/70 p-4 rounded-xl border border-slate-100 text-xs">
                        <div class="sm:col-span-4 text-left">
                            <div class="text-lg font-black text-slate-900">{{ \Carbon\Carbon::parse($booking->jadwal->jam_berangkat)->format('H:i') }} WITA</div>
                            <div class="font-bold text-slate-800">{{ $booking->jadwal->rute->terminalAsal->kota }}</div>
                            <div class="text-slate-400 font-body">{{ $booking->jadwal->rute->terminalAsal->nama_terminal }}</div>
                        </div>

                        <div class="sm:col-span-4 flex flex-col items-center px-2">
                            <span class="text-[10px] font-semibold text-slate-400 mb-1">
                                {{ \Carbon\Carbon::parse($booking->jadwal->tanggal)->format('d M Y') }}
                            </span>
                            <div class="w-full flex items-center">
                                <div class="w-2 h-2 rounded-full bg-brand-600"></div>
                                <div class="flex-1 h-0.5 bg-brand-200"></div>
                                <span class="material-symbols-outlined text-brand-600 text-sm -mx-1">directions_bus</span>
                                <div class="flex-1 h-0.5 bg-brand-200"></div>
                                <div class="w-2 h-2 rounded-full bg-brand-600"></div>
                            </div>
                            <span class="text-[10px] font-bold text-brand-600 mt-1">Perjalanan Langsung</span>
                        </div>

                        <div class="sm:col-span-4 text-right">
                            <div class="text-lg font-black text-slate-900">
                                {{ \Carbon\Carbon::parse($booking->jadwal->jam_berangkat)->addMinutes(($booking->jadwal->rute->estimasi_durasi ?? 8) * 60)->format('H:i') }} WITA
                            </div>
                            <div class="font-bold text-slate-800">{{ $booking->jadwal->rute->terminalTujuan->kota }}</div>
                            <div class="text-slate-400 font-body">{{ $booking->jadwal->rute->terminalTujuan->nama_terminal }}</div>
                        </div>
                    </div>
                </div>

                <!-- Passengers Card -->
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-600 text-lg">group</span>
                        Data Penumpang ({{ $booking->bookingSeats->count() }})
                    </h3>

                    <div class="divide-y divide-slate-100">
                        @foreach ($booking->bookingSeats as $seat)
                            <div class="py-3 flex flex-wrap items-center justify-between gap-3 text-xs">
                                <div>
                                    <div class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                        <span class="px-2 py-0.5 bg-brand-600 text-white font-bold rounded text-xs">
                                            Kursi {{ $seat->kursi->nomor_kursi }}
                                        </span>
                                        <span>{{ $seat->nama_penumpang }}</span>
                                    </div>
                                    <p class="text-slate-400 font-body mt-0.5">
                                        NIK: {{ $seat->nik }} &middot; {{ $seat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} &middot; Lahir: {{ $seat->tanggal_lahir->format('d M Y') }}
                                    </p>
                                </div>
                                <span class="font-bold text-slate-800">
                                    Rp {{ number_format($seat->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Right Column: Status & Actions -->
            <div class="lg:col-span-4 space-y-6">
                
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 pb-2 border-b border-slate-100">Ringkasan Tagihan</h3>
                    
                    <div class="space-y-2 text-xs font-body">
                        <div class="flex justify-between text-slate-500">
                            <span>Armada Bus</span>
                            <span class="font-bold text-slate-800">{{ $booking->jadwal->bus->nama_bus }}</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Operator</span>
                            <span class="font-bold text-slate-800">{{ $booking->jadwal->bus->operator->nama_operator }}</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Nomor Polisi</span>
                            <span class="font-mono text-slate-800">{{ $booking->jadwal->bus->nomor_polisi }}</span>
                        </div>
                        
                        <div class="border-t border-slate-100 pt-2 flex justify-between text-slate-500">
                            <span>Total Pembayaran</span>
                            <span class="text-lg font-black text-brand-600">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="pt-2">
                        @if ($booking->status_pembayaran == 'paid')
                            <a href="{{ route('customer.booking.ticket', $booking->id) }}" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm transition-all">
                                <span class="material-symbols-outlined text-base">confirmation_number</span>
                                <span>Lihat E-Tiket &amp; Boarding Pass</span>
                            </a>
                        @elseif ($booking->status_pembayaran == 'pending')
                            <a href="{{ route('customer.booking.pay', $booking->id) }}" class="w-full py-3 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 shadow-md shadow-brand-600/25 transition-all active:scale-98">
                                <span class="material-symbols-outlined text-base">credit_card</span>
                                <span>Bayar Sekarang</span>
                            </a>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </main>
@endsection