@extends('layouts.landing.app', ['menu' => 'booking'])

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">
        
        <!-- STEPPER (Horizontal 4-Step Header) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-3 sm:p-5 shadow-xs">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 sm:gap-4 items-center">
                
                <!-- Step 1: Checked -->
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm shadow-xs shrink-0">
                        <span class="material-symbols-outlined text-base">check</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">LANGKAH 1</p>
                        <p class="text-xs sm:text-sm font-bold text-slate-900 truncate">Pilih Bus</p>
                    </div>
                </div>

                <!-- Step 2: Checked -->
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm shadow-xs shrink-0">
                        <span class="material-symbols-outlined text-base">check</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">LANGKAH 2</p>
                        <p class="text-xs sm:text-sm font-bold text-slate-900 truncate">Pilih Kursi</p>
                    </div>
                </div>

                <!-- Step 3: Active -->
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-sm shadow-xs ring-4 ring-brand-100 shrink-0">
                        3
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-[11px] font-bold text-brand-600 uppercase tracking-wider truncate">LANGKAH 3</p>
                        <p class="text-xs sm:text-sm font-bold text-brand-600 truncate">Data Pemesan</p>
                    </div>
                </div>

                <!-- Step 4: Pending -->
                <div class="flex items-center gap-2 sm:gap-3 opacity-60 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm border border-slate-200 shrink-0">
                        4
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">LANGKAH 4</p>
                        <p class="text-xs sm:text-sm font-semibold text-slate-600 truncate">Pembayaran</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- FORM BOOKING & PASSENGER INPUTS -->
        <form method="POST" action="{{ route('booking.store') }}" id="formBooking">
            @csrf
            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Passenger Cards -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-6 shadow-xs">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-brand-600 text-xl">badge</span>
                            Langkah 3: Informasi Kontak &amp; Data Penumpang
                        </h3>
                        <p class="text-xs text-slate-500 font-body mb-6">
                            Pastikan data penumpang sesuai dengan KTP/identitas resmi untuk verifikasi keberangkatan.
                        </p>

                        <div class="space-y-6">
                            @foreach ($kursis as $i => $kursi)
                                <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-3.5 sm:p-5 space-y-4">
                                    <div class="flex items-center justify-between pb-3 border-b border-slate-200/80">
                                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs">
                                                {{ $i + 1 }}
                                            </span>
                                            Penumpang {{ $i + 1 }}
                                        </h4>
                                        <div class="flex items-center gap-1.5">
                                            @php
                                                $kPrice = ($kursi->harga !== null && (int) $kursi->harga > 0) ? (int) $kursi->harga : (int) $jadwal->harga;
                                                $kKelas = ucfirst($kursi->kelas ?? $jadwal->bus->kelas ?? 'Ekonomi');
                                            @endphp
                                            <span class="px-2.5 py-1 bg-amber-500 text-white text-xs font-bold rounded-lg shadow-2xs">
                                                Kursi {{ $kursi->nomor_kursi }} ({{ $kKelas }})
                                            </span>
                                            <span class="text-xs font-bold text-slate-700 bg-white border border-slate-200 px-2 py-0.5 rounded-lg shadow-2xs">
                                                Rp {{ number_format($kPrice, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    <input type="hidden" name="penumpang[{{ $i }}][id_kursi]" value="{{ $kursi->id_kursi }}">

                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                            Nama Lengkap (Sesuai KTP) <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="penumpang[{{ $i }}][nama]" required maxlength="150"
                                               value="{{ old("penumpang.{$i}.nama") }}" placeholder="Contoh: Rangga Aditya"
                                               class="w-full text-xs py-2.5 px-3.5 rounded-xl border border-slate-200 bg-white text-slate-800 font-medium focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all" />
                                        @error("penumpang.{$i}.nama")
                                            <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                NIK / No. KTP (16 Digit) <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="penumpang[{{ $i }}][nik]" required maxlength="16" pattern="[0-9]{16}"
                                                   value="{{ old("penumpang.{$i}.nik") }}" placeholder="7371xxxxxxxxxxxx"
                                                   class="w-full text-xs py-2.5 px-3.5 rounded-xl border border-slate-200 bg-white text-slate-800 font-medium focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all" />
                                            @error("penumpang.{$i}.nik")
                                                <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="penumpang[{{ $i }}][no_hp]" required maxlength="30"
                                                   value="{{ old("penumpang.{$i}.no_hp") }}" placeholder="08xxxxxxxxxx"
                                                   class="w-full text-xs py-2.5 px-3.5 rounded-xl border border-slate-200 bg-white text-slate-800 font-medium focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all" />
                                            @error("penumpang.{$i}.no_hp")
                                                <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Jenis Kelamin <span class="text-rose-500">*</span>
                                            </label>
                                            <select name="penumpang[{{ $i }}][jenis_kelamin]" required
                                                    class="w-full text-xs py-2.5 px-3.5 rounded-xl border border-slate-200 bg-white text-slate-800 font-medium focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L" {{ old("penumpang.{$i}.jenis_kelamin") == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old("penumpang.{$i}.jenis_kelamin") == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error("penumpang.{$i}.jenis_kelamin")
                                                <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Tanggal Lahir <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="date" name="penumpang[{{ $i }}][tanggal_lahir]" required
                                                   value="{{ old("penumpang.{$i}.tanggal_lahir") }}"
                                                   class="w-full text-xs py-2.5 px-3.5 rounded-xl border border-slate-200 bg-white text-slate-800 font-medium focus:border-brand-600 focus:ring-2 focus:ring-brand-600/15 outline-none transition-all" />
                                            @error("penumpang.{$i}.tanggal_lahir")
                                                <span class="text-rose-500 text-[10px]">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- Right Column: Summary & Submit Action -->
                <div class="lg:col-span-5 space-y-6">
                    
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-5">
                        
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h3 class="text-base font-bold text-slate-900">Ringkasan Pesanan</h3>
                            <span class="bg-amber-100 text-amber-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                                {{ $kursis->count() }} Kursi
                            </span>
                        </div>

                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-base font-bold text-slate-900">{{ $jadwal->bus->nama_bus }}</h4>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-brand-50 text-brand-600">
                                    {{ ucfirst($jadwal->bus->kelas) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 font-body mt-0.5">{{ $jadwal->bus->operator->nama_operator }}</p>
                        </div>

                        <!-- Schedule Timeline -->
                        <div class="space-y-3 bg-slate-50/70 p-3.5 rounded-xl border border-slate-100 text-xs">
                            <div class="flex items-start gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-brand-600 mt-1"></div>
                                <div>
                                    <span class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->format('H:i') }} WITA</span>
                                    <p class="text-slate-500 font-body">{{ $jadwal->rute->terminalAsal->kota }} — {{ $jadwal->rute->terminalAsal->nama_terminal }}</p>
                                </div>
                            </div>
                            <div class="pl-1 -my-2">
                                <div class="w-0.5 h-4 bg-slate-200 ml-0.5"></div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-900 mt-1"></div>
                                <div>
                                    <span class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->addMinutes(($jadwal->rute->estimasi_durasi ?? 8) * 60)->format('H:i') }} WITA</span>
                                    <p class="text-slate-500 font-body">{{ $jadwal->rute->terminalTujuan->kota }} — {{ $jadwal->rute->terminalTujuan->nama_terminal }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Kursi List -->
                        <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-100">
                            <span class="text-slate-500 font-body">Kursi Dipilih:</span>
                            <div class="flex gap-1.5">
                                @foreach ($kursis as $k)
                                    <span class="px-2.5 py-1 bg-amber-500 text-white font-bold text-xs rounded-md shadow-2xs">
                                        {{ $k->nomor_kursi }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        @php
                            $totalTiket = $kursis->sum(function ($k) use ($jadwal) {
                                return ($k->harga !== null && (int) $k->harga > 0) ? (int) $k->harga : (int) $jadwal->harga;
                            });
                            $firstPrice = ($kursis[0]->harga !== null && (int) $kursis[0]->harga > 0) ? (int) $kursis[0]->harga : (int) $jadwal->harga;
                            $allSamePrice = $kursis->every(function ($k) use ($jadwal, $firstPrice) {
                                $currPrice = ($k->harga !== null && (int) $k->harga > 0) ? (int) $k->harga : (int) $jadwal->harga;
                                return $currPrice === $firstPrice;
                            });
                        @endphp

                        <!-- Price Breakdown -->
                        <div class="space-y-2 pt-3 border-t border-slate-100 text-xs font-body">
                            <div class="flex justify-between text-slate-600">
                                @if ($allSamePrice)
                                    <span>Tiket Bus ({{ $kursis->count() }}x Rp {{ number_format($firstPrice, 0, ',', '.') }})</span>
                                @else
                                    <span>Tiket Bus ({{ $kursis->count() }} Kursi)</span>
                                @endif
                                <span class="font-semibold text-slate-900">
                                    Rp {{ number_format($totalTiket, 0, ',', '.') }}
                                </span>
                            </div>

                            @if (! $allSamePrice)
                                <div class="bg-slate-50 p-2.5 rounded-lg space-y-1 text-[11px] text-slate-600 border border-slate-100">
                                    @foreach ($kursis as $k)
                                        @php
                                            $seatP = ($k->harga !== null && (int) $k->harga > 0) ? (int) $k->harga : (int) $jadwal->harga;
                                            $seatK = ucfirst($k->kelas ?? $jadwal->bus->kelas ?? 'Ekonomi');
                                        @endphp
                                        <div class="flex justify-between">
                                            <span>Kursi {{ $k->nomor_kursi }} ({{ $seatK }})</span>
                                            <span class="font-semibold text-slate-800">Rp {{ number_format($seatP, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

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
                                    Rp {{ number_format($totalTiket, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- CTA Button to Step 4 -->
                        <button type="submit" class="w-full py-3 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold flex items-center justify-center gap-2 shadow-xs transition-all active:scale-98 cursor-pointer">
                            <span>Lanjut ke Pembayaran</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </main>
@endsection