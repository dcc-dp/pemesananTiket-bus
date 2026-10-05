@extends('layouts.landing.app', ['menu' => 'tiket'])

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">
        
        <!-- STEPPER (Horizontal 4-Step Header) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-3 sm:p-5 shadow-xs">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 sm:gap-4 items-center">
                
                <!-- Step 1: Checked -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('tiket.search') }}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-xs hover:bg-slate-700 transition-colors shrink-0">
                        <span class="material-symbols-outlined text-sm sm:text-base">check</span>
                    </a>
                    <div class="min-w-0">
                        <p class="text-[9.5px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">LANGKAH 1</p>
                        <p class="text-xs sm:text-sm font-bold text-slate-900 truncate">Pilih Bus</p>
                    </div>
                </div>

                <!-- Step 2: Active -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-xs ring-4 ring-brand-100 shrink-0">
                        2
                    </div>
                    <div class="min-w-0">
                        <p class="text-[9.5px] sm:text-[11px] font-bold text-brand-600 uppercase tracking-wider truncate">LANGKAH 2</p>
                        <p class="text-xs sm:text-sm font-bold text-brand-600 truncate">Pilih Kursi</p>
                    </div>
                </div>

                <!-- Step 3: Pending -->
                <div class="flex items-center gap-2 sm:gap-3 opacity-60">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs sm:text-sm border border-slate-200 shrink-0">
                        3
                    </div>
                    <div class="min-w-0">
                        <p class="text-[9.5px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">LANGKAH 3</p>
                        <p class="text-xs sm:text-sm font-semibold text-slate-600 truncate">Data Pemesan</p>
                    </div>
                </div>

                <!-- Step 4: Pending -->
                <div class="flex items-center gap-2 sm:gap-3 opacity-60">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs sm:text-sm border border-slate-200 shrink-0">
                        4
                    </div>
                    <div class="min-w-0">
                        <p class="text-[9.5px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">LANGKAH 4</p>
                        <p class="text-xs sm:text-sm font-semibold text-slate-600 truncate">Pembayaran</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- TRIP INFO BANNER -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-3.5 sm:p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center border border-brand-100 shrink-0">
                    <span class="material-symbols-outlined text-lg sm:text-xl">directions_bus</span>
                </div>
                <div class="min-w-0">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 truncate">
                        {{ $jadwal->bus->nama_bus }} &middot; <span class="text-brand-600">{{ $jadwal->bus->operator->nama_operator }}</span>
                    </h3>
                    <p class="text-xs text-slate-400 font-body truncate">
                        {{ $jadwal->rute->terminalAsal->kota }} &rarr; {{ $jadwal->rute->terminalTujuan->kota }} &middot; {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }} ({{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->format('H:i') }} WITA)
                    </p>
                </div>
            </div>
            <a href="{{ route('tiket.search') }}" class="text-xs font-bold text-brand-600 hover:underline flex items-center gap-1 shrink-0 self-start sm:self-center">
                <span class="material-symbols-outlined text-sm sm:text-base">arrow_back</span>
                Ganti Jadwal
            </a>
        </div>

        <!-- STEP 2 SECTION: PILIH NOMOR KURSI BUS ANDA (PROTOTYPE DESIGN SYSTEM) -->
        <section class="bg-white border border-slate-200/90 rounded-2xl p-3.5 sm:p-6 shadow-xs space-y-5 sm:space-y-6">
            
            <!-- Header & Legend Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-600 text-lg sm:text-xl">airline_seat_recline_extra</span>
                        Langkah 2: Pilih Nomor Kursi Bus Anda
                    </h3>
                    <p class="text-xs text-slate-500 font-body mt-0.5">
                        Konfigurasi {{ ucfirst($jadwal->bus->kelas) }} (Maksimal pemilihan: {{ $penumpang }} kursi)
                    </p>
                </div>

                <!-- Legend -->
                <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs font-medium">
                    <div class="flex items-center gap-1.5">
                        <div class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-md bg-white border border-slate-300"></div>
                        <span class="text-slate-600">Tersedia</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-md bg-amber-500 text-white flex items-center justify-center font-bold text-[10px]">✓</div>
                        <span class="text-amber-600 font-bold">Dipilih</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-md bg-slate-200 border border-slate-300 text-slate-400 flex items-center justify-center text-[10px]">✕</div>
                        <span class="text-slate-400">Terisi</span>
                    </div>
                </div>
            </div>

            <!-- Seat Grid & Summary Dual-Column -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 items-start">
                
                <!-- Left Deck Graphic (2+2 Bus Layout) -->
                <div class="md:col-span-7 bg-slate-50/80 border border-slate-200/80 rounded-2xl p-3 sm:p-5 overflow-x-auto">
                    
                    <!-- Front Deck Header -->
                    <div class="flex justify-between items-center pb-3 mb-4 sm:mb-5 border-b border-slate-200/80">
                        <div class="flex items-center gap-1.5 text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                            <span class="material-symbols-outlined text-sm sm:text-base text-brand-600">arrow_upward</span>
                            DEPAN
                        </div>
                        <div class="flex items-center gap-1.5 bg-slate-200/70 px-2.5 sm:px-3 py-1 rounded-lg text-xs font-bold text-slate-700">
                            <span class="material-symbols-outlined text-sm text-brand-600">airline_seat_recline_normal</span>
                            Sopir
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
                    <div class="space-y-2.5 sm:space-y-3" id="seatMatrix">
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

                            <div class="flex items-center justify-between sm:justify-center sm:gap-6 md:gap-8 p-0.5 sm:p-1 rounded-xl transition-all row-container min-w-max mx-auto">
                                <!-- Left Seats (e.g. A, B) -->
                                <div class="flex gap-1.5 sm:gap-2.5">
                                    @foreach ($leftSeats as $kursi)
                                        @php
                                            $isUnavail = in_array($kursi->id_kursi, $unavailableIds);
                                            $kursiKelasRaw = !empty($kursi->kelas) ? $kursi->kelas : ($jadwal->bus->kelas ?? 'Ekonomi');
                                            $kursiKelas = ucwords(str_replace('_', ' ', $kursiKelasRaw));
                                            $kursiHarga = ($kursi->harga && (int) $kursi->harga > 0) ? (int) $kursi->harga : (int) $jadwal->harga;
                                            $formattedHarga = 'Rp' . number_format($kursiHarga, 0, ',', '.');
                                        @endphp
                                        <button type="button"
                                                class="seat-btn w-[3.65rem] sm:w-[5.15rem] md:w-[5.35rem] min-w-[3.65rem] sm:min-w-[5.15rem] py-1.5 sm:py-2 px-0.5 sm:px-1 rounded-xl sm:rounded-2xl border-2 transition-all shadow-2xs flex flex-col items-center justify-center text-center {{ $isUnavail ? 'bg-slate-200/80 border-slate-300 text-slate-400 cursor-not-allowed' : 'bg-white border-slate-200 text-slate-800 hover:border-brand-500 hover:shadow-xs cursor-pointer' }}"
                                                data-id="{{ $kursi->id_kursi }}"
                                                data-nomor="{{ $kursi->nomor_kursi }}"
                                                data-kelas="{{ $kursiKelas }}"
                                                data-harga="{{ $kursiHarga }}"
                                                data-formatted-harga="{{ $formattedHarga }}"
                                                {{ $isUnavail ? 'disabled' : '' }}>
                                            <span class="seat-nomor font-bold text-[10px] sm:text-xs leading-none {{ $isUnavail ? 'text-slate-400' : 'text-slate-800' }}">
                                                {{ $kursi->nomor_kursi }}
                                            </span>
                                            <span class="seat-kelas text-[7px] sm:text-[8.5px] font-medium leading-none mt-1 truncate max-w-full px-0.5 {{ $isUnavail ? 'text-slate-400' : 'text-slate-500' }}">
                                                {{ $kursiKelas }}
                                            </span>
                                            <span class="seat-harga text-[7.5px] sm:text-[9px] font-semibold leading-none mt-1 {{ $isUnavail ? 'text-slate-400' : 'text-slate-700' }}">
                                                {{ $isUnavail ? 'Terisi' : $formattedHarga }}
                                            </span>
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Center Aisle -->
                                <div class="text-[9px] sm:text-[11px] font-bold text-slate-300 tracking-wider uppercase px-1 sm:px-2 text-center select-none flex-shrink-0">
                                    LORONG
                                </div>

                                <!-- Right Seats (e.g. C, D) -->
                                <div class="flex gap-1.5 sm:gap-2.5">
                                    @foreach ($rightSeats as $kursi)
                                        @php
                                            $isUnavail = in_array($kursi->id_kursi, $unavailableIds);
                                            $kursiKelasRaw = !empty($kursi->kelas) ? $kursi->kelas : ($jadwal->bus->kelas ?? 'Ekonomi');
                                            $kursiKelas = ucwords(str_replace('_', ' ', $kursiKelasRaw));
                                            $kursiHarga = ($kursi->harga && (int) $kursi->harga > 0) ? (int) $kursi->harga : (int) $jadwal->harga;
                                            $formattedHarga = 'Rp' . number_format($kursiHarga, 0, ',', '.');
                                        @endphp
                                        <button type="button"
                                                class="seat-btn w-[3.65rem] sm:w-[5.15rem] md:w-[5.35rem] min-w-[3.65rem] sm:min-w-[5.15rem] py-1.5 sm:py-2 px-0.5 sm:px-1 rounded-xl sm:rounded-2xl border-2 transition-all shadow-2xs flex flex-col items-center justify-center text-center {{ $isUnavail ? 'bg-slate-200/80 border-slate-300 text-slate-400 cursor-not-allowed' : 'bg-white border-slate-200 text-slate-800 hover:border-brand-500 hover:shadow-xs cursor-pointer' }}"
                                                data-id="{{ $kursi->id_kursi }}"
                                                data-nomor="{{ $kursi->nomor_kursi }}"
                                                data-kelas="{{ $kursiKelas }}"
                                                data-harga="{{ $kursiHarga }}"
                                                data-formatted-harga="{{ $formattedHarga }}"
                                                {{ $isUnavail ? 'disabled' : '' }}>
                                            <span class="seat-nomor font-bold text-[10px] sm:text-xs leading-none {{ $isUnavail ? 'text-slate-400' : 'text-slate-800' }}">
                                                {{ $kursi->nomor_kursi }}
                                            </span>
                                            <span class="seat-kelas text-[7px] sm:text-[8.5px] font-medium leading-none mt-1 truncate max-w-full px-0.5 {{ $isUnavail ? 'text-slate-400' : 'text-slate-500' }}">
                                                {{ $kursiKelas }}
                                            </span>
                                            <span class="seat-harga text-[7.5px] sm:text-[9px] font-semibold leading-none mt-1 {{ $isUnavail ? 'text-slate-400' : 'text-slate-700' }}">
                                                {{ $isUnavail ? 'Terisi' : $formattedHarga }}
                                            </span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <!-- Right Seat Selection Summary Panel (Form to Passenger Details) -->
                <div class="md:col-span-5 bg-white rounded-2xl p-4 sm:p-6 border border-slate-200/80 shadow-xs space-y-4">
                    
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h4 class="text-sm font-bold text-slate-900">Rincian Kursi Dipilih</h4>
                        <span class="bg-amber-100 text-amber-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full" id="seatCountBadge">
                            0 Kursi
                        </span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-start justify-between gap-2">
                            <span class="text-slate-500 font-body flex-shrink-0 pt-0.5">Kursi dipilih:</span>
                            <div class="flex flex-wrap gap-1.5 justify-end" id="selectedSeatsList">
                                <span class="text-slate-400 italic">Belum ada kursi dipilih</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-body">Harga per kursi:</span>
                            <span class="font-bold text-slate-800" id="seatUnitPriceText">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-body">Jumlah penumpang:</span>
                            <span class="font-bold text-slate-800" id="seatCountText">0</span>
                        </div>

                        <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
                            <span class="font-bold text-slate-900 text-sm">Total:</span>
                            <span class="text-xl font-black text-brand-600" id="totalPriceText">Rp 0</span>
                        </div>
                    </div>

                    <!-- Next Action Form -->
                    <form action="{{ route('booking.form', $jadwal->id_jadwal) }}" method="GET" id="proceedBookingForm" class="pt-2">
                        <div id="hiddenSeatInputs"></div>
                        <button type="submit" id="submitSeatBtn" disabled
                                class="w-full py-3 px-4 rounded-xl bg-slate-200 text-slate-400 text-xs font-semibold flex items-center justify-center gap-2 transition-all cursor-not-allowed">
                            <span>Lanjut ke Data Pemesan</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </button>
                    </form>

                </div>

            </div>

        </section>

    </main>

    <!-- Interactive Seat Selection Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const maxPassengers = {{ $penumpang }};
            const defaultUnitPrice = {{ (int) $jadwal->harga }};
            let selectedSeats = [];

            const seatCountBadge = document.getElementById('seatCountBadge');
            const selectedSeatsList = document.getElementById('selectedSeatsList');
            const seatUnitPriceText = document.getElementById('seatUnitPriceText');
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
                    if (seatUnitPriceText) {
                        seatUnitPriceText.textContent = 'Rp {{ number_format($jadwal->harga, 0, ',', '.') }}';
                    }
                    totalPriceText.textContent = 'Rp 0';
                    submitBtn.disabled = true;
                    submitBtn.className = 'w-full py-3 px-4 rounded-xl bg-slate-200 text-slate-400 text-xs font-semibold flex items-center justify-center gap-2 transition-all cursor-not-allowed';
                } else {
                    selectedSeatsList.innerHTML = selectedSeats.map(s => 
                        `<span class="px-2 py-0.5 bg-amber-500 text-white font-bold text-[11px] rounded-lg shadow-2xs flex items-center gap-1">
                            <span>${s.nomor}</span>
                            <span class="text-[9px] font-normal text-amber-100">(${s.kelas})</span>
                            <span class="text-[9px] font-bold text-white bg-amber-600/60 px-1 py-0.5 rounded leading-none">${s.formattedHarga}</span>
                        </span>`
                    ).join('');

                    const total = selectedSeats.reduce((sum, s) => sum + s.harga, 0);

                    if (seatUnitPriceText) {
                        const allSame = selectedSeats.every(s => s.harga === selectedSeats[0].harga);
                        if (allSame) {
                            seatUnitPriceText.textContent = selectedSeats[0].formattedHarga;
                        } else {
                            seatUnitPriceText.textContent = selectedSeats.map(s => `${s.nomor}: ${s.formattedHarga}`).join(' • ');
                        }
                    }

                    totalPriceText.textContent = `Rp ${total.toLocaleString('id-ID')}`;
                    submitBtn.disabled = false;
                    submitBtn.className = 'w-full py-3 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold flex items-center justify-center gap-2 shadow-xs transition-all cursor-pointer active:scale-98';
                }

                // Update hidden inputs for GET form (seats[]=...)
                hiddenInputs.innerHTML = selectedSeats.map(s => 
                    `<input type="hidden" name="seats[]" value="${s.id}">`
                ).join('');
            }

            function setSeatUnselected(targetBtn) {
                const n = targetBtn.dataset.nomor;
                const k = targetBtn.dataset.kelas;
                const p = targetBtn.dataset.formattedHarga || `Rp${(parseInt(targetBtn.dataset.harga, 10) || defaultUnitPrice).toLocaleString('id-ID')}`;
                targetBtn.className = 'seat-btn w-[3.65rem] sm:w-[5.15rem] md:w-[5.35rem] min-w-[3.65rem] sm:min-w-[5.15rem] py-1.5 sm:py-2 px-0.5 sm:px-1 rounded-xl sm:rounded-2xl border-2 transition-all shadow-2xs flex flex-col items-center justify-center text-center bg-white border-slate-200 text-slate-800 hover:border-brand-500 hover:shadow-xs cursor-pointer';
                targetBtn.innerHTML = `
                    <span class="seat-nomor font-bold text-[10px] sm:text-xs leading-none text-slate-800">${n}</span>
                    <span class="seat-kelas text-[7px] sm:text-[8.5px] font-medium leading-none mt-1 truncate max-w-full px-0.5 text-slate-500">${k}</span>
                    <span class="seat-harga text-[7.5px] sm:text-[9px] font-semibold leading-none mt-1 text-slate-700">${p}</span>
                `;
            }

            function setSeatSelected(targetBtn) {
                const n = targetBtn.dataset.nomor;
                const k = targetBtn.dataset.kelas;
                const p = targetBtn.dataset.formattedHarga || `Rp${(parseInt(targetBtn.dataset.harga, 10) || defaultUnitPrice).toLocaleString('id-ID')}`;
                targetBtn.className = 'seat-btn w-[3.65rem] sm:w-[5.15rem] md:w-[5.35rem] min-w-[3.65rem] sm:min-w-[5.15rem] py-1.5 sm:py-2 px-0.5 sm:px-1 rounded-xl sm:rounded-2xl border-2 transition-all shadow-sm flex flex-col items-center justify-center text-center bg-amber-500 border-amber-500 text-white scale-102 cursor-pointer';
                targetBtn.innerHTML = `
                    <span class="seat-nomor font-bold text-[10px] sm:text-xs text-white leading-none flex items-center justify-center gap-0.5 sm:gap-1">${n} <span class="text-[8.5px] sm:text-[9.5px] text-amber-100 font-bold">✓</span></span>
                    <span class="seat-kelas text-[7px] sm:text-[8.5px] font-medium leading-none text-amber-100 mt-1 truncate max-w-full px-0.5">${k}</span>
                    <span class="seat-harga text-[7.5px] sm:text-[9px] font-bold leading-none mt-1 text-white">${p}</span>
                `;
            }

            document.querySelectorAll('.seat-btn').forEach(btn => {
                if (btn.disabled) return;

                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const nomor = btn.dataset.nomor;
                    const kelas = btn.dataset.kelas;
                    const harga = parseInt(btn.dataset.harga, 10) || defaultUnitPrice;
                    const formattedHarga = btn.dataset.formattedHarga || `Rp${harga.toLocaleString('id-ID')}`;
                    const index = selectedSeats.findIndex(s => s.id === id);

                    if (index > -1) {
                        // Kursi yang sama diklik lagi -> Batalkan pilihan (Unselect)
                        selectedSeats.splice(index, 1);
                        setSeatUnselected(btn);
                    } else {
                        // Jika kuota kursi sudah penuh (seperti sistem bioskop XXI/TIX ID):
                        // Gantikan kursi yang dipilih sebelumnya secara otomatis
                        if (selectedSeats.length >= maxPassengers) {
                            const removedSeat = selectedSeats.shift();
                            const prevBtn = document.querySelector(`.seat-btn[data-id="${removedSeat.id}"]`);
                            if (prevBtn) {
                                setSeatUnselected(prevBtn);
                            }
                        }

                        // Pilih kursi baru
                        selectedSeats.push({ id, nomor, kelas, harga, formattedHarga });
                        setSeatSelected(btn);
                    }

                    updateUI();
                });
            });
        });
    </script>
@endsection