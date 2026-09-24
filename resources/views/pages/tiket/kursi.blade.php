@extends('layouts.landing.app', ['menu' => 'tiket'])

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">
        
        <!-- STEPPER (Horizontal 4-Step Header) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 items-center">
                
                <!-- Step 1: Checked -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('tiket.search') }}" class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm shadow-xs hover:bg-slate-700 transition-colors">
                        <span class="material-symbols-outlined text-base">check</span>
                    </a>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">LANGKAH 1</p>
                        <p class="text-sm font-bold text-slate-900">Pilih Bus</p>
                    </div>
                </div>

                <!-- Step 2: Active -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-sm shadow-xs ring-4 ring-brand-100">
                        2
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-brand-600 uppercase tracking-wider">LANGKAH 2</p>
                        <p class="text-sm font-bold text-brand-600">Pilih Kursi</p>
                    </div>
                </div>

                <!-- Step 3: Pending -->
                <div class="flex items-center gap-3 opacity-60">
                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm border border-slate-200">
                        3
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">LANGKAH 3</p>
                        <p class="text-sm font-semibold text-slate-600">Data Pemesan</p>
                    </div>
                </div>

                <!-- Step 4: Pending -->
                <div class="flex items-center gap-3 opacity-60">
                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm border border-slate-200">
                        4
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">LANGKAH 4</p>
                        <p class="text-sm font-semibold text-slate-600">Pembayaran</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- TRIP INFO BANNER -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center border border-brand-100">
                    <span class="material-symbols-outlined text-xl">directions_bus</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">
                        {{ $jadwal->bus->nama_bus }} &middot; <span class="text-brand-600">{{ $jadwal->bus->operator->nama_operator }}</span>
                    </h3>
                    <p class="text-xs text-slate-400 font-body">
                        {{ $jadwal->rute->terminalAsal->kota }} &rarr; {{ $jadwal->rute->terminalTujuan->kota }} &middot; {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} ({{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->format('H:i') }} WITA)
                    </p>
                </div>
            </div>
            <a href="{{ route('tiket.search') }}" class="text-xs font-bold text-brand-600 hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Ganti Jadwal
            </a>
        </div>

        <!-- STEP 2 SECTION: PILIH NOMOR KURSI BUS ANDA (PROTOTYPE DESIGN SYSTEM) -->
        <section class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs space-y-6">
            
            <!-- Header & Legend Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-600 text-xl">airline_seat_recline_extra</span>
                        Langkah 2: Pilih Nomor Kursi Bus Anda
                    </h3>
                    <p class="text-xs text-slate-500 font-body mt-0.5">
                        Konfigurasi {{ ucfirst($jadwal->bus->kelas) }} (Maksimal pemilihan: {{ $penumpang }} kursi)
                    </p>
                </div>

                <!-- Legend -->
                <div class="flex flex-wrap items-center gap-4 text-xs font-medium">
                    <div class="flex items-center gap-1.5">
                        <div class="w-4 h-4 rounded-md bg-white border border-slate-300"></div>
                        <span class="text-slate-600">Tersedia</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-4 h-4 rounded-md bg-amber-500 text-white flex items-center justify-center font-bold text-[10px]">✓</div>
                        <span class="text-amber-600 font-bold">Dipilih</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-4 h-4 rounded-md bg-slate-200 border border-slate-300 text-slate-400 flex items-center justify-center text-[10px]">✕</div>
                        <span class="text-slate-400">Terisi</span>
                    </div>
                </div>
            </div>

            <!-- Seat Grid & Summary Dual-Column -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                
                <!-- Left Deck Graphic (2+2 Bus Layout) -->
                <div class="md:col-span-7 bg-slate-50/80 border border-slate-200/80 rounded-2xl p-5">
                    
                    <!-- Front Deck Header -->
                    <div class="flex justify-between items-center pb-3 mb-5 border-b border-slate-200/80">
                        <div class="flex items-center gap-1.5 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                            <span class="material-symbols-outlined text-base text-brand-600">arrow_upward</span>
                            DEPAN
                        </div>
                        <div class="flex items-center gap-1.5 bg-slate-200/70 px-3 py-1 rounded-lg text-xs font-bold text-slate-700">
                            <span class="material-symbols-outlined text-sm text-brand-600">sports_motorsports</span>
                            Sopir 🚌
                        </div>
                    </div>

                    @php
                        $availableIds = $available->pluck('id_kursi')->all();
                        $unavailableIds = $unavailable->pluck('id_kursi')->all();
                        $rows = collect($jadwal->bus->kursis)->sortBy(function ($k) {
                            preg_match('/^(\d+)([A-Z])$/', $k->nomor_kursi, $m);
                            return isset($m[1]) ? ((int)$m[1] * 10 + (ord($m[2] ?? 'A') - 65)) : $k->id_kursi;
                        })->groupBy(function ($k) {
                            preg_match('/^(\d+)([A-Z])$/', $k->nomor_kursi, $m);
                            return isset($m[1]) ? (int)$m[1] : 1;
                        });
                    @endphp

                    <!-- Rows of Seats -->
                    <div class="space-y-3" id="seatMatrix">
                        @foreach ($rows as $rowNum => $kursis)
                            @php
                                $leftSeats = $kursis->filter(fn($k) => preg_match('/[AB]$/', $k->nomor_kursi))->values();
                                $rightSeats = $kursis->filter(fn($k) => preg_match('/[CD]$/', $k->nomor_kursi))->values();
                                if ($leftSeats->isEmpty() && $rightSeats->isEmpty()) {
                                    $chunked = $kursis->chunk(ceil($kursis->count() / 2));
                                    $leftSeats = $chunked->get(0, collect());
                                    $rightSeats = $chunked->get(1, collect());
                                }
                            @endphp

                            <div class="flex items-center justify-between gap-2 p-1 rounded-xl transition-all row-container">
                                <!-- Left Seats (e.g. A, B) -->
                                <div class="flex gap-2">
                                    @foreach ($leftSeats as $kursi)
                                        @php
                                            $isUnavail = in_array($kursi->id_kursi, $unavailableIds);
                                        @endphp
                                        <button type="button"
                                                class="seat-btn w-12 h-12 sm:w-13 sm:h-13 rounded-xl border-2 transition-all shadow-2xs flex flex-col items-center justify-center font-bold text-xs {{ $isUnavail ? 'bg-slate-200 border-slate-300 text-slate-400 cursor-not-allowed' : 'bg-white border-slate-200 text-slate-800 hover:border-brand-600' }}"
                                                data-id="{{ $kursi->id_kursi }}"
                                                data-nomor="{{ $kursi->nomor_kursi }}"
                                                data-harga="{{ $jadwal->harga }}"
                                                {{ $isUnavail ? 'disabled' : '' }}>
                                            <span>{{ $kursi->nomor_kursi }}</span>
                                            <span class="text-[9px] font-normal {{ $isUnavail ? 'text-slate-400' : 'text-slate-400' }}">
                                                {{ $isUnavail ? 'Terisi' : 'Rp' . number_format($jadwal->harga / 1000, 0) . 'k' }}
                                            </span>
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Center Aisle -->
                                <div class="text-[10px] font-bold text-slate-300 tracking-widest uppercase px-1">
                                    LORONG
                                </div>

                                <!-- Right Seats (e.g. C, D) -->
                                <div class="flex gap-2">
                                    @foreach ($rightSeats as $kursi)
                                        @php
                                            $isUnavail = in_array($kursi->id_kursi, $unavailableIds);
                                        @endphp
                                        <button type="button"
                                                class="seat-btn w-12 h-12 sm:w-13 sm:h-13 rounded-xl border-2 transition-all shadow-2xs flex flex-col items-center justify-center font-bold text-xs {{ $isUnavail ? 'bg-slate-200 border-slate-300 text-slate-400 cursor-not-allowed' : 'bg-white border-slate-200 text-slate-800 hover:border-brand-600' }}"
                                                data-id="{{ $kursi->id_kursi }}"
                                                data-nomor="{{ $kursi->nomor_kursi }}"
                                                data-harga="{{ $jadwal->harga }}"
                                                {{ $isUnavail ? 'disabled' : '' }}>
                                            <span>{{ $kursi->nomor_kursi }}</span>
                                            <span class="text-[9px] font-normal {{ $isUnavail ? 'text-slate-400' : 'text-slate-400' }}">
                                                {{ $isUnavail ? 'Terisi' : 'Rp' . number_format($jadwal->harga / 1000, 0) . 'k' }}
                                            </span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Deck Footer Info -->
                    <div class="flex justify-between items-center pt-4 mt-5 border-t border-slate-200/80 text-xs text-slate-500 font-medium">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-brand-600">airline_seat_recline_normal</span>
                            Bus AC {{ ucfirst($jadwal->bus->kelas) }}
                        </div>
                        <div class="flex items-center gap-1.5 bg-slate-200/60 px-2.5 py-1 rounded-md text-[11px] font-bold text-slate-600">
                            <span class="material-symbols-outlined text-sm">wc</span>
                            Toilet Penumpang
                        </div>
                    </div>

                </div>

                <!-- Right Seat Selection Summary Panel (Form to Passenger Details) -->
                <div class="md:col-span-5 bg-slate-50/90 rounded-2xl p-5 border border-slate-200/80 space-y-4">
                    
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-bold text-slate-900">Rincian Kursi Dipilih</h4>
                        <span class="bg-amber-100 text-amber-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full" id="seatCountBadge">
                            0 Kursi
                        </span>
                    </div>

                    <div class="bg-white rounded-xl p-4 border border-slate-200/80 space-y-3 text-xs">
                        
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-body">Kursi dipilih:</span>
                            <div class="flex flex-wrap gap-1.5 justify-end" id="selectedSeatsList">
                                <span class="text-slate-400 italic">Belum ada kursi dipilih</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-body">Harga per kursi:</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-body">Jumlah kursi:</span>
                            <span class="font-bold text-slate-800" id="seatCountText">0</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-body">Biaya layanan:</span>
                            <span class="font-semibold text-slate-800">Rp 7.500</span>
                        </div>

                        <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                            <span class="font-bold text-slate-900 text-sm">Total:</span>
                            <span class="text-xl font-black text-brand-600" id="totalPriceText">Rp 0</span>
                        </div>

                    </div>

                    <!-- Reservation Expiry Banner -->
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs p-3 rounded-xl flex items-center gap-2 font-medium">
                        <span class="material-symbols-outlined text-emerald-600 text-base" style="font-variation-settings: 'FILL' 1;">lock</span>
                        <span>Kursi tersimpan untuk pemesanan Anda selama 15 menit.</span>
                    </div>

                    <!-- Next Action Form -->
                    <form action="{{ route('booking.form', $jadwal->id_jadwal) }}" method="GET" id="proceedBookingForm">
                        <div id="hiddenSeatInputs"></div>
                        <button type="submit" id="submitSeatBtn" disabled
                                class="w-full py-3.5 px-4 rounded-xl bg-slate-300 text-slate-500 text-xs font-bold flex items-center justify-center gap-2 transition-all cursor-not-allowed">
                            <span>Lanjut ke Data Pemesan (Langkah 3)</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </button>
                    </form>

                </div>

            </div>

        </section>

    </main>

    <style>
        .w-13 { width: 3.25rem; }
        .h-13 { height: 3.25rem; }
    </style>

    <!-- Interactive Seat Selection Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const maxPassengers = {{ $penumpang }};
            const unitPrice = {{ (int) $jadwal->harga }};
            const serviceFee = 7500;
            let selectedSeats = [];

            const seatCountBadge = document.getElementById('seatCountBadge');
            const selectedSeatsList = document.getElementById('selectedSeatsList');
            const seatCountText = document.getElementById('seatCountText');
            const totalPriceText = document.getElementById('totalPriceText');
            const hiddenInputs = document.getElementById('hiddenSeatInputs');
            const submitBtn = document.getElementById('submitSeatBtn');

            function updateUI() {
                const count = selectedSeats.length;
                seatCountBadge.textContent = `${count} Kursi`;
                seatCountText.textContent = count;

                if (count === 0) {
                    selectedSeatsList.innerHTML = '<span class="text-slate-400 italic">Belum ada kursi dipilih</span>';
                    totalPriceText.textContent = 'Rp 0';
                    submitBtn.disabled = true;
                    submitBtn.className = 'w-full py-3.5 px-4 rounded-xl bg-slate-300 text-slate-500 text-xs font-bold flex items-center justify-center gap-2 transition-all cursor-not-allowed';
                } else {
                    selectedSeatsList.innerHTML = selectedSeats.map(s => 
                        `<span class="px-2.5 py-1 bg-amber-500 text-white font-bold text-xs rounded-md shadow-xs">${s.nomor}</span>`
                    ).join('');

                    const total = (count * unitPrice) + serviceFee;
                    totalPriceText.textContent = `Rp ${total.toLocaleString('id-ID')}`;
                    submitBtn.disabled = false;
                    submitBtn.className = 'w-full py-3.5 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-brand-600/25 transition-all cursor-pointer active:scale-98';
                }

                // Update hidden inputs for GET form (seats[]=...)
                hiddenInputs.innerHTML = selectedSeats.map(s => 
                    `<input type="hidden" name="seats[]" value="${s.id}">`
                ).join('');
            }

            document.querySelectorAll('.seat-btn').forEach(btn => {
                if (btn.disabled) return;

                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const nomor = btn.dataset.nomor;
                    const index = selectedSeats.findIndex(s => s.id === id);

                    if (index > -1) {
                        // Unselect
                        selectedSeats.splice(index, 1);
                        btn.className = 'seat-btn w-12 h-12 sm:w-13 sm:h-13 rounded-xl border-2 transition-all shadow-2xs flex flex-col items-center justify-center font-bold text-xs bg-white border-slate-200 text-slate-800 hover:border-brand-600';
                        btn.innerHTML = `<span>${nomor}</span><span class="text-[9px] font-normal text-slate-400">Rp${Math.round(unitPrice/1000)}k</span>`;
                    } else {
                        // Check limit
                        if (selectedSeats.length >= maxPassengers) {
                            Swal.fire({
                                title: "Batas Terpenuhi",
                                text: `Anda hanya memesan untuk ${maxPassengers} penumpang.`,
                                icon: "info",
                                confirmButtonColor: "#006194"
                            });
                            return;
                        }

                        // Select
                        selectedSeats.push({ id, nomor });
                        btn.className = 'seat-btn w-12 h-12 sm:w-13 sm:h-13 rounded-xl border-2 transition-all shadow-sm flex flex-col items-center justify-center font-bold text-xs bg-amber-500 text-white border-amber-500 scale-105';
                        btn.innerHTML = `<span>${nomor} ✓</span><span class="text-[9px] font-normal text-amber-100">Rp${Math.round(unitPrice/1000)}k</span>`;
                    }

                    updateUI();
                });
            });
        });
    </script>
@endsection