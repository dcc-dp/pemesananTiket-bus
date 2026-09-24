@extends('layouts.landing.app', ['menu' => 'tiket'])

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        #ticketPrint, #ticketPrint * { visibility: visible; }
        #ticketPrint { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none !important; border: 1px solid #ccc !important; }
        .no-print { display: none !important; }
    }
</style>
@endpush

@section('content')
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">
        
        <!-- Header Strip Actions (No Print) -->
        <div class="no-print bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                    <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">verified</span>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">E-Tiket &amp; Boarding Pass Resmi</h2>
                    <p class="text-xs text-slate-400 font-body">Status: <span class="font-bold text-emerald-600">Lunas &amp; Terverifikasi</span> &middot; Kode: <span class="font-mono font-bold text-slate-700">{{ $ticket['kode_booking'] }}</span></p>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-center">
                <button onclick="window.print()" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-sm transition-all">
                    <span class="material-symbols-outlined text-sm">print</span>
                    <span>Cetak Tiket</span>
                </button>
                <a href="{{ route('customer.bookings') }}" class="px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-xs font-bold transition-all">
                    Riwayat Pesanan
                </a>
            </div>
        </div>

        <!-- BOARDING PASS VOUCHER CARD (PROTOTYPE DESIGN SYSTEM) -->
        <div id="ticketPrint" class="bg-white rounded-3xl border border-slate-200/90 shadow-md overflow-hidden transition-all">
            
            <!-- Card Blue Top Header Strip -->
            <div class="bg-brand-600 text-white px-6 sm:px-8 py-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">verified</span>
                    <div>
                        <span class="text-xs sm:text-sm font-extrabold tracking-wide uppercase">BOARDING PASS RESMI - BUSTICKET</span>
                        <p class="text-[10px] text-brand-100 font-body">Tiket Elektronik Perjalanan Antar Kota Resmi</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-brand-200 uppercase tracking-widest block font-body">KODE BOOKING (PNR)</span>
                    <span class="font-mono text-base sm:text-lg font-black tracking-widest">{{ $ticket['kode_booking'] }}</span>
                </div>
            </div>

            <!-- Ticket Body with Perforation Division -->
            <div class="grid grid-cols-1 md:grid-cols-12 relative">
                
                <!-- Left: Trip & Passenger Details (col-span-8) -->
                <div class="md:col-span-8 p-6 sm:p-8 space-y-6">
                    
                    <!-- Operator & Date -->
                    <div class="flex flex-wrap items-center justify-between gap-2 pb-4 border-b border-slate-100">
                        <div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-brand-50 text-brand-700 tracking-wider">
                                BUS {{ strtoupper($ticket['kelas']) }}
                            </span>
                            <h3 class="text-xl font-black text-slate-900 mt-1">PO {{ $ticket['operator'] }}</h3>
                            <p class="text-xs text-slate-400 font-body">{{ $ticket['bus'] }} ({{ $ticket['nomor_polisi'] }})</p>
                        </div>
                        <div class="text-right">
                            <span class="text-[11px] text-slate-400 block font-body">Tanggal Keberangkatan</span>
                            <span class="text-xs font-bold text-slate-800">{{ $ticket['tanggal']->format('d F Y') }}</span>
                        </div>
                    </div>

                    <!-- Route Graph -->
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center bg-slate-50/70 p-4 rounded-2xl border border-slate-100">
                        <div class="sm:col-span-4 text-left">
                            <div class="text-xl font-black text-slate-900">
                                {{ \Carbon\Carbon::parse($ticket['jam_berangkat'])->format('H:i') }} <span class="text-xs font-semibold text-slate-500">WITA</span>
                            </div>
                            <div class="text-sm font-bold text-slate-800">{{ $ticket['asal'] }}</div>
                        </div>

                        <div class="sm:col-span-4 flex flex-col items-center px-2">
                            <span class="text-[10px] font-bold text-slate-400 mb-1">Perjalanan Langsung</span>
                            <div class="w-full flex items-center">
                                <div class="w-2 h-2 rounded-full bg-brand-600"></div>
                                <div class="flex-1 h-0.5 bg-brand-200"></div>
                                <span class="material-symbols-outlined text-brand-600 text-sm -mx-1">directions_bus</span>
                                <div class="flex-1 h-0.5 bg-brand-200"></div>
                                <div class="w-2 h-2 rounded-full bg-brand-600"></div>
                            </div>
                            <span class="text-[10px] font-bold text-brand-600 mt-1">Tanpa Transit</span>
                        </div>

                        <div class="sm:col-span-4 text-right">
                            <div class="text-xl font-black text-slate-900">
                                {{ \Carbon\Carbon::parse($ticket['jam_tiba'])->format('H:i') }} <span class="text-xs font-semibold text-slate-500">WITA</span>
                            </div>
                            <div class="text-sm font-bold text-slate-800">{{ $ticket['tujuan'] }}</div>
                        </div>
                    </div>

                    <!-- Passengers & Seats -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Daftar Penumpang</span>
                            <ol class="space-y-1 text-xs font-semibold text-slate-800 font-body">
                                @foreach ($ticket['penumpang'] as $idx => $p)
                                    <li>{{ $idx + 1 }}. {{ $p['nama_penumpang'] }} (NIK: {{ $p['nik'] }})</li>
                                @endforeach
                            </ol>
                        </div>

                        <div class="sm:text-right">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Nomor Kursi</span>
                            <div class="flex sm:justify-end gap-1.5 flex-wrap">
                                @foreach ($ticket['penumpang'] as $p)
                                    <span class="px-3 py-1 bg-brand-600 text-white font-black text-xs rounded-lg shadow-2xs">
                                        {{ $p['nomor_kursi'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <p class="text-[11px] text-slate-400 italic pt-2 border-t border-slate-100">
                        * Harap tiba di terminal minimal 30 menit sebelum jadwal keberangkatan bus.
                    </p>

                </div>

                <!-- Middle Perforated Divider (Dashed Border) -->
                <div class="md:col-span-4 border-t-2 md:border-t-0 md:border-l-2 border-dashed border-slate-200 p-6 sm:p-8 flex flex-col justify-between items-center text-center bg-slate-50/40">
                    
                    <div class="w-full space-y-3">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">PINDAI DI GATE KEBERANGKATAN</span>
                        
                        <!-- Official SVG QR Code Container -->
                        <div class="w-40 h-40 mx-auto bg-white border-2 border-slate-800 p-3 rounded-2xl shadow-xs flex items-center justify-center">
                            @if ($qr)
                                <div class="w-full h-full flex items-center justify-center">
                                    {!! $qr !!}
                                </div>
                            @else
                                <span class="material-symbols-outlined text-6xl text-slate-300">qr_code_2</span>
                            @endif
                        </div>

                        <div class="text-[10px] font-mono font-bold text-slate-600">
                            TIK: {{ $ticket['kode_booking'] }}
                        </div>

                        <p class="text-[11px] text-slate-400 font-body leading-tight">
                            Tunjukkan QR code ini kepada staf terminal atau kondektur sebelum menaiki armada bus.
                        </p>
                    </div>

                    <!-- Ticket Action Buttons (No Print) -->
                    <div class="no-print w-full space-y-2 pt-6">
                        <button type="button" onclick="window.print()" class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-sm">download</span>
                            <span>Unduh E-Tiket (PDF)</span>
                        </button>
                        <a href="https://wa.me/?text=Tiket%20BusTicket%20Resmi%20Kode%20Booking:%20{{ $ticket['kode_booking'] }}" target="_blank" class="w-full py-2.5 px-4 border border-brand-600 text-brand-600 hover:bg-brand-50 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 transition-all">
                            <span class="material-symbols-outlined text-sm">share</span>
                            <span>Kirim ke WhatsApp</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </main>
@endsection