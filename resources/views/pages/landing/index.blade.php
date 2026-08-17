@extends('layouts.landing.app', ['menu' => 'home'])

@section('content')
    {{-- HERO --}}
    <div class="hero-area" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); padding: 90px 0 140px; position: relative;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 style="color: #ffffff; font-size: 2.8rem; font-weight: 800; line-height: 1.25;">
                        Pesan Tiket Bus dengan Mudah
                    </h1>
                    <p style="color: rgba(255,255,255,0.8); font-size: 1.1rem; margin-top: 1rem;">
                        Pilih jadwal keberangkatan, pilih kursi favorit, dan dapatkan tiket digital langsung di genggaman Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- SEARCH BOX --}}
    <div style="margin-top: -80px; position: relative; z-index: 10;">
        <div class="container">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('tiket.search') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="text-muted small font-weight-bold">Dari</label>
                                <select name="terminal_asal" class="form-control" required>
                                    <option value="">-- Pilih Terminal Asal --</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}">{{ $terminal->kota }} - {{ $terminal->nama_terminal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="text-muted small font-weight-bold">Ke</label>
                                <select name="terminal_tujuan" class="form-control" required>
                                    <option value="">-- Pilih Terminal Tujuan --</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}">{{ $terminal->kota }} - {{ $terminal->nama_terminal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="text-muted small font-weight-bold">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" min="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="text-muted small font-weight-bold">Penumpang</label>
                                <input type="number" name="penumpang" class="form-control" min="1" max="5" value="1" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none; padding: 0.6rem;">
                                    <i class="fas fa-search"></i> Cari Tiket
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- KENAPA MEMILIH KAMI --}}
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="color: #0B1F3A; font-weight: 700;">Kenapa Memilih <span style="color: #1E5AA8;">BusTicket?</span></h2>
                <p style="color: #6C757D;">Layanan terbaik untuk perjalanan bus Anda</p>
            </div>
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="p-4" style="border-radius: 12px; background: #f8fafc; height: 100%;">
                        <i class="fas fa-chair" style="font-size: 2.5rem; color: #1E5AA8;"></i>
                        <h5 class="mt-3 font-weight-bold" style="color: #0B1F3A;">Pilih Kursi Sendiri</h5>
                        <p style="color: #6C757D;">Pilih kursi favorit Anda secara visual sebelum memesan.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="p-4" style="border-radius: 12px; background: #f8fafc; height: 100%;">
                        <i class="fas fa-shield-alt" style="font-size: 2.5rem; color: #1E5AA8;"></i>
                        <h5 class="mt-3 font-weight-bold" style="color: #0B1F3A;">Pembayaran Aman</h5>
                        <p style="color: #6C757D;">Pembayaran terintegrasi dengan gateway pembayaran terpercaya.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="p-4" style="border-radius: 12px; background: #f8fafc; height: 100%;">
                        <i class="fas fa-qrcode" style="font-size: 2.5rem; color: #1E5AA8;"></i>
                        <h5 class="mt-3 font-weight-bold" style="color: #0B1F3A;">Tiket Digital</h5>
                        <p style="color: #6C757D;">Tiket dengan QR Code langsung bisa dicetak dan digunakan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- OPERATOR --}}
    <section class="py-5" style="background: #f8fafc;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="color: #0B1F3A; font-weight: 700;">Operator Bus Terpercaya</h2>
            </div>
            <div class="row">
                @foreach ($operators as $operator)
                    <div class="col-md-4 col-lg-2-4 col-lg-3 mb-3">
                        <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 12px;">
                            <i class="fas fa-bus" style="font-size: 1.8rem; color: #1E5AA8;"></i>
                            <h6 class="mt-2 mb-0 font-weight-bold" style="color: #0B1F3A;">{{ $operator->nama_operator }}</h6>
                            <small class="text-muted">{{ $operator->buses_count ?? '' }} armada</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- RUTE POPULER --}}
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="color: #0B1F3A; font-weight: 700;">Rute Populer</h2>
                <p style="color: #6C757D;">Rute yang paling sering dipesan oleh pelanggan</p>
            </div>
            <div class="row">
                @foreach ($popularRoutes as $route)
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 font-weight-bold" style="color: #0B1F3A;">
                                        {{ $route->terminalAsal->kota }} <i class="fas fa-arrow-right text-primary"></i> {{ $route->terminalTujuan->kota }}
                                    </h6>
                                    <small class="text-muted">{{ $route->jarak ?? '-' }} km &middot; {{ gmdate('H:i', ($route->estimasi_durasi ?? 0) * 60) }}</small>
                                </div>
                                <a href="{{ route('tiket.search', ['terminal_asal' => $route->terminal_asal_id, 'terminal_tujuan' => $route->terminal_tujuan_id, 'tanggal' => now()->addDay()->format('Y-m-d'), 'penumpang' => 1]) }}"
                                   class="btn btn-sm btn-primary" style="background: #1E5AA8; border: none;">
                                    Cari
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CARA PEMESANAN --}}
    <section class="py-5" style="background: #f8fafc;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="color: #0B1F3A; font-weight: 700;">Cara Pemesanan</h2>
            </div>
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: linear-gradient(135deg, #123E73, #1E5AA8); color: #fff; font-weight: 700; font-size: 1.3rem;">1</div>
                    <h6 class="mt-3 font-weight-bold" style="color: #0B1F3A;">Cari Jadwal</h6>
                    <small class="text-muted">Masukkan asal, tujuan, dan tanggal</small>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: linear-gradient(135deg, #123E73, #1E5AA8); color: #fff; font-weight: 700; font-size: 1.3rem;">2</div>
                    <h6 class="mt-3 font-weight-bold" style="color: #0B1F3A;">Pilih Kursi</h6>
                    <small class="text-muted">Pilih kursi dan isi data penumpang</small>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: linear-gradient(135deg, #123E73, #1E5AA8); color: #fff; font-weight: 700; font-size: 1.3rem;">3</div>
                    <h6 class="mt-3 font-weight-bold" style="color: #0B1F3A;">Bayar</h6>
                    <small class="text-muted">Lakukan pembayaran secara online</small>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: linear-gradient(135deg, #123E73, #1E5AA8); color: #fff; font-weight: 700; font-size: 1.3rem;">4</div>
                    <h6 class="mt-3 font-weight-bold" style="color: #0B1F3A;">Dapatkan Tiket</h6>
                    <small class="text-muted">Tiket digital + QR Code siap dicetak</small>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="color: #0B1F3A; font-weight: 700;">FAQ</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @php
                        $faqs = [
                            ['q' => 'Bagaimana cara memesan tiket bus?', 'a' => 'Pilih rute asal dan tujuan, tentukan tanggal keberangkatan, pilih jadwal, pilih kursi, isi data penumpang, lalu lakukan pembayaran.'],
                            ['q' => 'Apakah kursi yang sudah dipesan bisa dipilih orang lain?', 'a' => 'Tidak. Sistem kami mencegah kursi yang sama dipesan dua kali pada jadwal yang sama.'],
                            ['q' => 'Bagaimana cara mendapatkan tiket setelah bayar?', 'a' => 'Setelah pembayaran berhasil, tiket digital beserta QR Code akan tersedia di menu Tiket Saya dan bisa langsung dicetak.'],
                            ['q' => 'Apakah bisa membatalkan pemesanan?', 'a' => 'Ya, silakan menghubungi admin untuk pembatalan sebelum jadwal keberangkatan.'],
                        ];
                    @endphp
                    <div class="accordion" id="faqAccordion">
                        @foreach ($faqs as $i => $faq)
                            <div class="card border-0 shadow-sm mb-2" style="border-radius: 10px;">
                                <div class="card-header" style="background: #ffffff; border-radius: 10px;" id="faq{{ $i }}">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link font-weight-bold" type="button" data-toggle="collapse"
                                            data-target="#faqCollapse{{ $i }}" aria-expanded="{{ $i == 0 ? 'true' : 'false' }}"
                                            aria-controls="faqCollapse{{ $i }}" style="color: #0B1F3A; text-decoration: none;">
                                            {{ $faq['q'] }}
                                        </button>
                                    </h6>
                                </div>
                                <div id="faqCollapse{{ $i }}" class="collapse {{ $i == 0 ? 'show' : '' }}"
                                    aria-labelledby="faq{{ $i }}" data-parent="#faqAccordion">
                                    <div class="card-body" style="color: #6C757D;">
                                        {{ $faq['a'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection