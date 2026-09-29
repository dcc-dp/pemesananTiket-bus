@extends('layouts.landing.app', ['menu' => 'booking'])

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">
        
        <!-- STEPPER (Horizontal 4-Step Header) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 items-center">
                
                <!-- Step 1: Checked -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm shadow-xs">
                        <span class="material-symbols-outlined text-base">check</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">LANGKAH 1</p>
                        <p class="text-sm font-bold text-slate-900">Pilih Bus</p>
                    </div>
                </div>

                <!-- Step 2: Checked -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm shadow-xs">
                        <span class="material-symbols-outlined text-base">check</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">LANGKAH 2</p>
                        <p class="text-sm font-bold text-slate-900">Pilih Kursi</p>
                    </div>
                </div>

                <!-- Step 3: Checked -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm shadow-xs">
                        <span class="material-symbols-outlined text-base">check</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">LANGKAH 3</p>
                        <p class="text-sm font-bold text-slate-900">Data Pemesan</p>
                    </div>
                </div>

                <!-- Step 4: Active -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-sm shadow-xs ring-4 ring-brand-100">
                        4
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-brand-600 uppercase tracking-wider">LANGKAH 4</p>
                        <p class="text-sm font-bold text-brand-600">Pembayaran</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- TRIP SUMMARY & COUNTDOWN STRIP -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">
                        {{ $booking->jadwal->rute->terminalAsal->kota }} &rarr; {{ $booking->jadwal->rute->terminalTujuan->kota }}
                    </h2>
                    <span class="font-mono text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-700">
                        {{ $booking->kode_booking }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 font-body mt-1">
                    {{ \Carbon\Carbon::parse($booking->jadwal->tanggal)->format('d M Y') }} &middot; {{ \Carbon\Carbon::parse($booking->jadwal->jam_berangkat)->format('H:i') }} WITA &middot; {{ $booking->jadwal->bus->nama_bus }} ({{ $booking->bookingSeats->count() }} Penumpang)
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 self-start sm:self-center">
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                    <span class="material-symbols-outlined text-base">timer</span>
                    <span>Sisa Waktu:</span>
                    <span class="font-bold font-mono" id="countdownClock">
                        {{ $booking->expired_at ? max(0, now()->diffInSeconds($booking->expired_at)) : '900' }} detik
                    </span>
                </div>
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    Menunggu Pembayaran
                </span>
            </div>
        </div>

        <!-- TWO-COLUMN MAIN CONTENT (PAYMENT GATEWAY + ORDER SUMMARY) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: MIDTRANS PAYMENT METHODS -->
            <div class="lg:col-span-7 space-y-6">
                
                <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-xs space-y-5">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <span class="material-symbols-outlined text-brand-600 text-xl">credit_card</span>
                                Pembayaran Resmi Midtrans
                            </h3>
                            <p class="text-xs text-slate-500 font-body mt-0.5">Sistem pembayaran terverifikasi otomatis</p>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                <span class="material-symbols-outlined text-xs text-emerald-600">lock</span>
                                SSL Secured
                            </span>
                        </div>
                    </div>

                    @if ($midtransConfigured && $snapToken)
                        <!-- Live Midtrans Snap Option -->
                        <div class="border border-brand-200 rounded-xl p-5 bg-brand-50/20 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-brand-600 text-2xl">qr_code_scanner</span>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900">QRIS, Transfer Bank &amp; E-Wallet</h4>
                                        <p class="text-xs text-slate-500 font-body">GoPay, ShopeePay, BCA VA, BRI, BNI, Mandiri</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    Verifikasi Instan
                                </span>
                            </div>

                            <div class="pt-2">
                                <button type="button" id="pay-button" class="w-full py-3.5 px-6 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold flex items-center justify-center gap-2 shadow-xs transition-all active:scale-98 cursor-pointer">
                                    <span class="material-symbols-outlined text-base">lock</span>
                                    <span>Bayar Sekarang (Rp {{ number_format($booking->total_harga, 0, ',', '.') }})</span>
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Loket / Manual Verification Notice -->
                        <div class="border border-slate-200 rounded-xl p-6 bg-slate-50 text-center space-y-3">
                            <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto">
                                <span class="material-symbols-outlined text-2xl">payments</span>
                            </div>
                            <h4 class="text-sm font-bold text-slate-900">Pembayaran di Loket / Transfer Manual</h4>
                            <p class="text-xs text-slate-500 font-body max-w-md mx-auto leading-relaxed">
                                Tunjukkan Kode Booking <strong class="text-slate-800 font-mono">{{ $booking->kode_booking }}</strong> kepada petugas loket terminal atau hubungi admin untuk verifikasi pembayaran.
                            </p>
                            <a href="{{ route('customer.booking.detail', $booking->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-semibold transition-all shadow-xs">
                                <span>Lihat Detail Booking</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    @endif

                    <div class="pt-2 flex items-center gap-1.5 text-xs text-slate-400 font-body border-t border-slate-100">
                        <span class="material-symbols-outlined text-sm text-brand-600">verified</span>
                        Didukung sistem resmi Bank Indonesia &amp; Midtrans Payment Gateway
                    </div>

                </div>

            </div>

            <!-- RIGHT COLUMN: ORDER SUMMARY & PASSENGERS -->
            <div class="lg:col-span-5 space-y-6">
                
                <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-4">
                    
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h3 class="text-base font-bold text-slate-900">Ringkasan Pemesanan</h3>
                        <span class="bg-amber-100 text-amber-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                            {{ $booking->bookingSeats->count() }} Kursi
                        </span>
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-base font-bold text-slate-900">{{ $booking->jadwal->bus->nama_bus }}</h4>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-brand-50 text-brand-700">
                                {{ ucfirst($booking->jadwal->bus->kelas) }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 font-body mt-0.5">{{ $booking->jadwal->bus->operator->nama_operator }}</p>
                    </div>

                    <!-- Schedule Timeline -->
                    <div class="space-y-3 bg-slate-50 p-3.5 rounded-xl border border-slate-100 text-xs">
                        <div class="flex items-start gap-3">
                            <div class="w-2.5 h-2.5 rounded-full bg-brand-600 mt-1"></div>
                            <div>
                                <span class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($booking->jadwal->jam_berangkat)->format('H:i') }} WITA</span>
                                <p class="text-slate-500 font-body">{{ $booking->jadwal->rute->terminalAsal->kota }} — {{ $booking->jadwal->rute->terminalAsal->nama_terminal }}</p>
                            </div>
                        </div>
                        <div class="pl-1 -my-2">
                            <div class="w-0.5 h-4 bg-slate-200 ml-0.5"></div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2.5 h-2.5 rounded-full bg-slate-900 mt-1"></div>
                            <div>
                                <span class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($booking->jadwal->jam_berangkat)->addMinutes(($booking->jadwal->rute->estimasi_durasi ?? 8) * 60)->format('H:i') }} WITA</span>
                                <p class="text-slate-500 font-body">{{ $booking->jadwal->rute->terminalTujuan->kota }} — {{ $booking->jadwal->rute->terminalTujuan->nama_terminal }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Alokasi Penumpang & Kursi -->
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <h5 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Penumpang &amp; Kursi</h5>
                        <div class="space-y-1.5 text-xs">
                            @foreach ($booking->bookingSeats as $seat)
                                <div class="flex items-center justify-between bg-slate-50 px-3 py-2 rounded-lg">
                                    <span class="font-medium text-slate-800 flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-sm text-slate-400">person</span>
                                        {{ $seat->nama_penumpang }}
                                    </span>
                                    <span class="px-2 py-0.5 bg-amber-500 text-white font-bold rounded text-[11px]">
                                        Kursi {{ $seat->kursi->nomor_kursi }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-2 pt-3 border-t border-slate-100 text-xs font-body">
                        <div class="flex justify-between text-slate-600">
                            <span>Tiket Bus ({{ $booking->bookingSeats->count() }}x)</span>
                            <span class="font-semibold text-slate-900">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between text-slate-600">
                            <span>Asuransi Penumpang</span>
                            <span class="font-semibold text-emerald-600">Termasuk</span>
                        </div>

                        <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-slate-900 text-sm block">Total Tagihan</span>
                                <span class="text-[10px] text-slate-400">Harga resmi terverifikasi</span>
                            </div>
                            <span class="text-xl font-extrabold text-brand-600">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </main>

    @if ($midtransConfigured && $snapToken)
        @push('scripts')
            <script type="text/javascript"
                src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{ config('midtrans.client_key') }}"></script>
            <script type="text/javascript">
                document.getElementById('pay-button').onclick = function() {
                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function() { window.location.href = '{{ route("customer.booking.detail", $booking->id) }}'; },
                        onPending: function() { window.location.href = '{{ route("customer.booking.detail", $booking->id) }}'; },
                        onError: function() { Swal.fire('Gagal', 'Pembayaran gagal. Silakan coba kembali.', 'error'); },
                        onClose: function() {}
                    });
                };
            </script>
        @endpush
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if ($booking->expired_at)
                let remaining = {{ max(0, now()->diffInSeconds($booking->expired_at)) }};
                const clock = document.getElementById('countdownClock');
                if (clock && remaining > 0) {
                    const timer = setInterval(() => {
                        remaining--;
                        if (remaining <= 0) {
                            clearInterval(timer);
                            clock.textContent = 'Waktu Habis';
                            location.reload();
                        } else {
                            const m = Math.floor(remaining / 60);
                            const s = remaining % 60;
                            clock.textContent = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                        }
                    }, 1000);
                }
            @endif
        });
    </script>
@endsection