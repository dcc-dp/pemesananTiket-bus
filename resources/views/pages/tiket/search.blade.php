@extends('layouts.landing.app', ['menu' => 'tiket'])

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        
        <!-- STEPPER (Horizontal 4-Step Header) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs mb-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 items-center">
                
                <!-- Step 1: Active -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-sm shadow-xs ring-4 ring-brand-100">
                        1
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-brand-600 uppercase tracking-wider">LANGKAH 1</p>
                        <p class="text-sm font-bold text-brand-600">Pilih Bus</p>
                    </div>
                </div>

                <!-- Step 2: Next -->
                <div class="flex items-center gap-3 opacity-60">
                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm border border-slate-200">
                        2
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">LANGKAH 2</p>
                        <p class="text-sm font-semibold text-slate-600">Pilih Kursi</p>
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

        <!-- MAIN GRID LAYOUT (Left Sidebar Filter + Right Main Content) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT SIDEBAR: FILTERS -->
            <aside class="lg:col-span-3 space-y-6">
                
                <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-6">
                    
                    <form action="{{ route('tiket.search') }}" method="GET" id="searchFilterForm" class="space-y-5">
                        
                        <!-- Header -->
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <span class="material-symbols-outlined text-brand-600 text-lg">filter_list</span>
                                Filter
                            </h3>
                            <a href="{{ route('tiket.search') }}" class="text-xs font-semibold text-brand-600 hover:underline">Reset</a>
                        </div>

                        <!-- Rute & Tanggal Form Fields -->
                        <div class="space-y-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Dari</label>
                                <select name="terminal_asal" class="w-full text-xs py-2 px-3 rounded-lg border border-slate-200 bg-slate-50 text-slate-800 font-semibold focus:border-brand-600 outline-none" required>
                                    <option value="">Pilih Terminal Asal</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}" {{ ($params['terminal_asal'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                            {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Ke</label>
                                <select name="terminal_tujuan" class="w-full text-xs py-2 px-3 rounded-lg border border-slate-200 bg-slate-50 text-slate-800 font-semibold focus:border-brand-600 outline-none" required>
                                    <option value="">Pilih Terminal Tujuan</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}" {{ ($params['terminal_tujuan'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                            {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal</label>
                                    <input type="date" name="tanggal" min="{{ now()->format('Y-m-d') }}" value="{{ $params['tanggal'] ?? now()->addDay()->format('Y-m-d') }}" class="w-full text-xs py-2 px-2.5 rounded-lg border border-slate-200 bg-slate-50 text-slate-800 font-semibold focus:border-brand-600 outline-none" required />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Penumpang</label>
                                    <select name="penumpang" class="w-full text-xs py-2 px-2.5 rounded-lg border border-slate-200 bg-slate-50 text-slate-800 font-semibold focus:border-brand-600 outline-none">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ ($params['penumpang'] ?? 1) == $i ? 'selected' : '' }}>{{ $i }} Penumpang</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Kelas Bus -->
                        <div class="pt-3 border-t border-slate-100">
                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">Kelas Bus</h4>
                            <div class="space-y-2">
                                <label class="flex items-center justify-between text-xs font-medium cursor-pointer">
                                    <span class="flex items-center gap-2 text-slate-700">
                                        <input type="radio" name="kelas" value="" {{ empty(request('kelas')) ? 'checked' : '' }} onchange="this.form.submit()" class="text-brand-600 focus:ring-brand-600 h-4 w-4" />
                                        Semua Kelas
                                    </span>
                                </label>
                                <label class="flex items-center justify-between text-xs font-medium cursor-pointer">
                                    <span class="flex items-center gap-2 text-slate-700">
                                        <input type="radio" name="kelas" value="sleeper" {{ request('kelas') == 'sleeper' ? 'checked' : '' }} onchange="this.form.submit()" class="text-brand-600 focus:ring-brand-600 h-4 w-4" />
                                        Sleeper Suite
                                    </span>
                                </label>
                                <label class="flex items-center justify-between text-xs font-medium cursor-pointer">
                                    <span class="flex items-center gap-2 text-slate-700">
                                        <input type="radio" name="kelas" value="executive" {{ request('kelas') == 'executive' ? 'checked' : '' }} onchange="this.form.submit()" class="text-brand-600 focus:ring-brand-600 h-4 w-4" />
                                        Executive Class
                                    </span>
                                </label>
                                <label class="flex items-center justify-between text-xs font-medium cursor-pointer">
                                    <span class="flex items-center gap-2 text-slate-700">
                                        <input type="radio" name="kelas" value="bisnis" {{ request('kelas') == 'bisnis' ? 'checked' : '' }} onchange="this.form.submit()" class="text-brand-600 focus:ring-brand-600 h-4 w-4" />
                                        Super VIP (Bisnis)
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Operator Bus Filter -->
                        @if ($operators->count() > 0)
                            <div class="pt-3 border-t border-slate-100">
                                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">Operator Bus</h4>
                                <select name="operator_id" onchange="this.form.submit()" class="w-full text-xs py-2 px-3 rounded-lg border border-slate-200 bg-slate-50 text-slate-800 font-semibold focus:border-brand-600 outline-none">
                                    <option value="">Semua Operator</option>
                                    @foreach ($operators as $op)
                                        <option value="{{ $op->id }}" {{ request('operator_id') == $op->id ? 'selected' : '' }}>
                                            {{ $op->nama_operator }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <button type="submit" class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold shadow-sm transition-all">
                            Terapkan Filter
                        </button>
                    </form>

                </div>

                <!-- Garansi Kursi Pasti Ada Box -->
                <div class="bg-brand-50/60 rounded-2xl p-4 border border-brand-100 flex items-start gap-3">
                    <span class="material-symbols-outlined text-brand-600 text-2xl" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                    <div>
                        <h5 class="text-xs font-bold text-slate-900">Garansi Kursi Pasti Ada</h5>
                        <p class="text-[11px] text-slate-500 font-body mt-0.5 leading-relaxed">
                            Tiket diterbitkan langsung oleh operator mitra resmi dengan QR terverifikasi.
                        </p>
                    </div>
                </div>

            </aside>

            <!-- RIGHT FEED: STEP 1 (PILIH ARMADA BUS YANG TERSEDIA) -->
            <div class="lg:col-span-9 space-y-6">
                
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-brand-600 rounded-full inline-block"></span>
                        Langkah 1: Pilih Armada Bus yang Tersedia
                    </h2>
                    <span class="text-xs text-slate-400 font-medium font-body">
                        Menampilkan {{ $jadwals->count() }} bus tersedia
                    </span>
                </div>

                @if (is_null($params))
                    <!-- Empty State: Not searched yet -->
                    <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                        <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-3xl">search</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Mulai Pencarian Tiket Bus</h3>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1 font-body">
                            Pilih terminal asal, tujuan, dan tanggal perjalanan di panel sebelah kiri untuk melihat jadwal armada yang tersedia.
                        </p>
                    </div>
                @elseif ($jadwals->count() === 0)
                    <!-- Empty State: No results -->
                    <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs">
                        <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-3xl">directions_bus</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Tidak Ada Jadwal Bus Tersedia</h3>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1 font-body">
                            Maaf, belum ada jadwal bus aktif untuk rute dan tanggal yang Anda pilih. Coba sesuaikan tanggal atau pilihan filter.
                        </p>
                    </div>
                @else
                    <!-- Bus Cards List (Matching Image 2 Prototype) -->
                    <div class="space-y-4">
                        @foreach ($jadwals as $jadwal)
                            <div class="bg-white border {{ $loop->first ? 'border-2 border-brand-600 shadow-sm' : 'border-slate-200/90 shadow-xs' }} rounded-2xl p-5 sm:p-6 relative overflow-hidden transition-all hover:border-brand-600">
                                
                                @if ($loop->first)
                                    <!-- Highlight Ribbon Badge -->
                                    <div class="absolute top-0 right-0 bg-brand-600 text-white text-[11px] font-bold px-3 py-1 rounded-bl-xl flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">thumb_up</span>
                                        Armada Terpilih
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-center">
                                    
                                    <!-- PO Name & Class -->
                                    <div class="md:col-span-4">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-lg font-bold text-slate-900">{{ $jadwal->bus->nama_bus }}</h3>
                                        </div>
                                        <p class="text-xs font-semibold text-brand-600 mt-0.5">
                                            {{ $jadwal->bus->operator->nama_operator }} &middot; {{ ucfirst($jadwal->bus->kelas) }}
                                        </p>
                                        @if ($jadwal->bus->fasilitas)
                                            <div class="flex flex-wrap gap-1 mt-2 text-[10px] text-slate-500 font-body">
                                                @foreach (explode(',', $jadwal->bus->fasilitas) as $fasilitas)
                                                    <span class="bg-slate-100 px-2 py-0.5 rounded">{{ trim($fasilitas) }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Departure Schedule Timeline -->
                                    <div class="md:col-span-5 flex items-center justify-between px-2">
                                        <div class="text-left">
                                            <div class="text-lg font-black text-slate-900">{{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->format('H:i') }}</div>
                                            <div class="text-xs text-slate-400 font-body">{{ $jadwal->rute->terminalAsal->kota }}</div>
                                        </div>

                                        <div class="flex-1 flex flex-col items-center px-4">
                                            <span class="text-[10px] font-semibold text-slate-400 mb-1">
                                                {{ $jadwal->rute->estimasi_durasi ? gmdate('H:i', $jadwal->rute->estimasi_durasi * 60) . ' Jam' : '8j 30m' }}
                                            </span>
                                            <div class="w-full flex items-center">
                                                <div class="w-2 h-2 rounded-full bg-brand-600"></div>
                                                <div class="flex-1 h-0.5 bg-brand-200"></div>
                                                <span class="material-symbols-outlined text-brand-600 text-sm -mx-1">directions_bus</span>
                                                <div class="flex-1 h-0.5 bg-brand-200"></div>
                                                <div class="w-2 h-2 rounded-full bg-brand-600"></div>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <div class="text-lg font-black text-slate-900">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->addMinutes(($jadwal->rute->estimasi_durasi ?? 8) * 60)->format('H:i') }}
                                            </div>
                                            <div class="text-xs text-slate-400 font-body">{{ $jadwal->rute->terminalTujuan->kota }}</div>
                                        </div>
                                    </div>

                                    <!-- Price & CTA -->
                                    <div class="md:col-span-3 md:border-l md:border-slate-100 md:pl-5 flex md:flex-col justify-between items-end">
                                        <div class="text-right">
                                            <span class="text-[11px] text-slate-400 block">Mulai dari</span>
                                            <div class="text-xl font-black text-brand-600">
                                                Rp {{ number_format($jadwal->harga, 0, ',', '.') }}
                                            </div>
                                            <span class="text-[11px] font-bold {{ $jadwal->available_seats <= 5 ? 'text-rose-500' : 'text-emerald-600' }} block">
                                                Tersisa {{ $jadwal->available_seats }} Kursi
                                            </span>
                                        </div>
                                        <a href="{{ route('tiket.seats', $jadwal->id_jadwal) }}?penumpang={{ $params['penumpang'] ?? 1 }}"
                                           class="mt-2.5 w-full py-2.5 px-4 rounded-xl {{ $loop->first ? 'bg-brand-600 hover:bg-brand-700 text-white' : 'border border-brand-600 text-brand-600 hover:bg-brand-50' }} text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm transition-all">
                                            <span>Pilih Kursi</span>
                                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                        </a>
                                    </div>

                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>

    </main>
@endsection