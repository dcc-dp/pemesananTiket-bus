@extends('layouts.landing.app', ['menu' => 'home'])

@section('content')
    {{-- HERO --}}
    <div class="hero-area" style="background: linear-gradient(160deg, #0B1F3A 0%, #0d2847 40%, #1a4a7a 70%, #1E5AA8 100%); padding: 80px 0 120px; position: relative; overflow: hidden;">
        {{-- Decorative Elements --}}
        <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: rgba(255,255,255,0.03); border-radius: 50%; pointer-events: none;"></div>
        <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: rgba(255,255,255,0.02); border-radius: 50%; pointer-events: none;"></div>
        <div style="position: absolute; top: 20%; left: 50%; transform: translateX(-50%); width: 800px; height: 800px; background: radial-gradient(circle, rgba(30,90,168,0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-7 mx-auto text-center">
                    <div style="display: inline-block; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 6px 20px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.15); margin-bottom: 24px;">
                        <span style="color: rgba(255,255,255,0.8); font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-bus" style="margin-right: 8px;"></i> #1 Platform Pemesanan Tiket Bus
                        </span>
                    </div>
                    <h1 style="color: #ffffff; font-size: 3.2rem; font-weight: 800; line-height: 1.2; margin-bottom: 16px; letter-spacing: -0.5px;">
                        Perjalanan Nyaman<br>
                        <span style="color: #c8c3c3;">Dimulai dari Sini</span>
                    </h1>
                    <p style="color: rgba(255,255,255,0.75); font-size: 1.15rem; max-width: 560px; margin: 0 auto 0; line-height: 1.7;">
                        Temukan jadwal keberangkatan, pilih kursi favorit, dan dapatkan tiket digital instan — semua dalam satu platform.
                    </p>
                    <div style="display: flex; gap: 12px; justify-content: center; margin-top: 28px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.6); font-size: 0.9rem;">
                            <i class="fas fa-check-circle" style="color: #4CAF50;"></i> Tanpa Antri
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.6); font-size: 0.9rem;">
                            <i class="fas fa-check-circle" style="color: #4CAF50;"></i> Pembayaran Aman
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.6); font-size: 0.9rem;">
                            <i class="fas fa-check-circle" style="color: #4CAF50;"></i> Tiket Digital
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SEARCH BOX --}}
    <div style="margin-top: -60px; position: relative; z-index: 10;">
        <div class="container">
            <div class="card border-0 rounded-4 shadow-lg" style="background: #ffffff; box-shadow: 0 20px 60px rgba(11,31,58,0.15) !important;">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('tiket.search') }}" method="GET">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="text-muted small fw-semibold mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fas fa-map-pin text-primary me-1"></i> Dari
                                </label>
                                <select name="terminal_asal" class="form-select form-select-lg border-0 bg-light rounded-3" style="padding: 12px 16px; font-size: 0.95rem; background: #f5f7fa !important;" required>
                                    <option value="">Pilih Terminal Asal</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}">{{ $terminal->kota }} - {{ $terminal->nama_terminal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted small fw-semibold mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fas fa-location-dot text-danger me-1"></i> Ke
                                </label>
                                <select name="terminal_tujuan" class="form-select form-select-lg border-0 bg-light rounded-3" style="padding: 12px 16px; font-size: 0.95rem; background: #f5f7fa !important;" required>
                                    <option value="">Pilih Terminal Tujuan</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}">{{ $terminal->kota }} - {{ $terminal->nama_terminal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="text-muted small fw-semibold mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fas fa-calendar-day me-1"></i> Tanggal
                                </label>
                                <input type="date" name="tanggal" class="form-control form-control-lg border-0 bg-light rounded-3" style="padding: 12px 16px; font-size: 0.95rem; background: #f5f7fa !important;" min="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="text-muted small fw-semibold mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fas fa-user me-1"></i> Penumpang
                                </label>
                                <input type="number" name="penumpang" class="form-control form-control-lg border-0 bg-light rounded-3" style="padding: 12px 16px; font-size: 0.95rem; background: #f5f7fa !important;" min="1" max="5" value="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-semibold" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none; padding: 12px; font-size: 1rem; transition: all 0.3s ease;">
                                    <i class="fas fa-search me-2"></i> Cari Tiket
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <section class="py-4" style="border-bottom: 1px solid #f0f2f5;">
        <div class="container">
            <div class="row text-center">
                <div class="col-4 col-md-3 mx-auto">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #0B1F3A;">50+</div>
                    <div style="font-size: 0.85rem; color: #6C757D;">Rute Tersedia</div>
                </div>
                <div class="col-4 col-md-3 mx-auto">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #0B1F3A;">100+</div>
                    <div style="font-size: 0.85rem; color: #6C757D;">Armada Bus</div>
                </div>
                <div class="col-4 col-md-3 mx-auto">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #0B1F3A;">10K+</div>
                    <div style="font-size: 0.85rem; color: #6C757D;">Pelanggan Puas</div>
                </div>
            </div>
        </div>
    </section>

    {{-- KENAPA MEMILIH KAMI --}}
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span style="display: inline-block; background: #e8f0fe; color: #1E5AA8; font-size: 0.8rem; font-weight: 600; padding: 4px 16px; border-radius: 50px; letter-spacing: 0.5px; text-transform: uppercase;">Keunggulan</span>
                <h2 style="color: #0B1F3A; font-weight: 700; margin-top: 12px;">Kenapa Memilih <span style="color: #1E5AA8;">BusTicket?</span></h2>
                <p style="color: #6C757D; max-width: 500px; margin: 8px auto 0;">Nikmati pengalaman pemesanan tiket bus yang cepat, aman, dan nyaman</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 h-100 rounded-4" style="background: #ffffff; border: 1px solid #f0f2f5; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.03);" onmouseenter="this.style.boxShadow='0 12px 40px rgba(30,90,168,0.12)'" onmouseleave="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.03)'">
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #e8f0fe, #d4e2f7); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <i class="fas fa-chair" style="font-size: 1.5rem; color: #1E5AA8;"></i>
                        </div>
                        <h5 class="fw-bold" style="color: #0B1F3A;">Pilih Kursi Sendiri</h5>
                        <p style="color: #6C757D; font-size: 0.95rem; margin-bottom: 0;">Pilih kursi favorit Anda secara visual sebelum memesan, bebas menentukan posisi duduk.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 h-100 rounded-4" style="background: #ffffff; border: 1px solid #f0f2f5; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.03);" onmouseenter="this.style.boxShadow='0 12px 40px rgba(30,90,168,0.12)'" onmouseleave="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.03)'">
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #e8f0fe, #d4e2f7); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <i class="fas fa-shield-alt" style="font-size: 1.5rem; color: #1E5AA8;"></i>
                        </div>
                        <h5 class="fw-bold" style="color: #0B1F3A;">Pembayaran Aman</h5>
                        <p style="color: #6C757D; font-size: 0.95rem; margin-bottom: 0;">Pembayaran terintegrasi dengan gateway pembayaran terpercaya dan terenkripsi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 h-100 rounded-4" style="background: #ffffff; border: 1px solid #f0f2f5; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.03);" onmouseenter="this.style.boxShadow='0 12px 40px rgba(30,90,168,0.12)'" onmouseleave="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.03)'">
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #e8f0fe, #d4e2f7); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <i class="fas fa-qrcode" style="font-size: 1.5rem; color: #1E5AA8;"></i>
                        </div>
                        <h5 class="fw-bold" style="color: #0B1F3A;">Tiket Digital</h5>
                        <p style="color: #6C757D; font-size: 0.95rem; margin-bottom: 0;">Tiket dengan QR Code langsung bisa diakses dan dicetak kapan saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- OPERATOR --}}
    <section class="py-5" style="background: #f8fafc;">
        <div class="container">
            <div class="text-center mb-5">
                <span style="display: inline-block; background: #e8f0fe; color: #1E5AA8; font-size: 0.8rem; font-weight: 600; padding: 4px 16px; border-radius: 50px; letter-spacing: 0.5px; text-transform: uppercase;">Mitra Kami</span>
                <h2 style="color: #0B1F3A; font-weight: 700; margin-top: 12px;">Operator Bus Terpercaya</h2>
            </div>
            <div class="row g-3 justify-content-center">
                @foreach ($operators as $operator)
                    <div class="col-md-3 col-lg-2">
                        <div class="card border-0 rounded-4 text-center p-3 h-100" style="background: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.04); transition: all 0.3s ease;" onmouseenter="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseleave="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.04)'">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #e8f0fe, #d4e2f7); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                                <i class="fas fa-bus" style="font-size: 1.3rem; color: #1E5AA8;"></i>
                            </div>
                            <h6 class="fw-bold mb-0" style="color: #0B1F3A; font-size: 0.9rem;">{{ $operator->nama_operator }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $operator->buses_count ?? '' }} armada</small>
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
                <span style="display: inline-block; background: #e8f0fe; color: #1E5AA8; font-size: 0.8rem; font-weight: 600; padding: 4px 16px; border-radius: 50px; letter-spacing: 0.5px; text-transform: uppercase;">Rute Favorit</span>
                <h2 style="color: #0B1F3A; font-weight: 700; margin-top: 12px;">Rute Populer</h2>
                <p style="color: #6C757D; max-width: 500px; margin: 8px auto 0;">Rute yang paling sering dipesan oleh pelanggan setia kami</p>
            </div>
            <div class="row g-3">
                @foreach ($popularRoutes as $route)
                    <div class="col-md-4">
                        <div class="card border-0 rounded-4 p-3" style="background: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.04); transition: all 0.3s ease;" onmouseenter="this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseleave="this.style.boxShadow='0 2px 12px rgba(0,0,0,0.04)'">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-weight: 600; color: #0B1F3A;">{{ $route->terminalAsal->kota }}</span>
                                        <span style="color: #1E5AA8;"><i class="fas fa-arrow-right"></i></span>
                                        <span style="font-weight: 600; color: #0B1F3A;">{{ $route->terminalTujuan->kota }}</span>
                                    </div>
                                    <div style="font-size: 0.8rem; color: #6C757D; margin-top: 4px;">
                                        <i class="fas fa-route me-1"></i> {{ $route->jarak ?? '-' }} km 
                                        &middot; <i class="far fa-clock me-1"></i> {{ gmdate('H:i', ($route->estimasi_durasi ?? 0) * 60) }}
                                    </div>
                                </div>
                                <a href="{{ route('tiket.search', ['terminal_asal' => $route->terminal_asal_id, 'terminal_tujuan' => $route->terminal_tujuan_id, 'tanggal' => now()->addDay()->format('Y-m-d'), 'penumpang' => 1]) }}"
                                   class="btn btn-sm rounded-3 fw-semibold" style="background: #e8f0fe; color: #1E5AA8; border: none; padding: 6px 18px;">
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
                <span style="display: inline-block; background: #e8f0fe; color: #1E5AA8; font-size: 0.8rem; font-weight: 600; padding: 4px 16px; border-radius: 50px; letter-spacing: 0.5px; text-transform: uppercase;">Panduan</span>
                <h2 style="color: #0B1F3A; font-weight: 700; margin-top: 12px;">Cara Pemesanan</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <div style="position: relative; display: inline-block;">
                        <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #123E73, #1E5AA8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.5rem; margin: 0 auto; box-shadow: 0 8px 24px rgba(30,90,168,0.25);">1</div>
                    </div>
                    <h6 class="fw-bold mt-3" style="color: #0B1F3A;">Cari Jadwal</h6>
                    <p style="color: #6C757D; font-size: 0.9rem; max-width: 200px; margin: 4px auto 0;">Masukkan asal, tujuan, dan tanggal</p>
                </div>
                <div class="col-md-3 text-center">
                    <div style="position: relative; display: inline-block;">
                        <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #123E73, #1E5AA8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.5rem; margin: 0 auto; box-shadow: 0 8px 24px rgba(30,90,168,0.25);">2</div>
                    </div>
                    <h6 class="fw-bold mt-3" style="color: #0B1F3A;">Pilih Kursi</h6>
                    <p style="color: #6C757D; font-size: 0.9rem; max-width: 200px; margin: 4px auto 0;">Pilih kursi dan isi data penumpang</p>
                </div>
                <div class="col-md-3 text-center">
                    <div style="position: relative; display: inline-block;">
                        <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #123E73, #1E5AA8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.5rem; margin: 0 auto; box-shadow: 0 8px 24px rgba(30,90,168,0.25);">3</div>
                    </div>
                    <h6 class="fw-bold mt-3" style="color: #0B1F3A;">Bayar</h6>
                    <p style="color: #6C757D; font-size: 0.9rem; max-width: 200px; margin: 4px auto 0;">Lakukan pembayaran secara online</p>
                </div>
                <div class="col-md-3 text-center">
                    <div style="position: relative; display: inline-block;">
                        <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #123E73, #1E5AA8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.5rem; margin: 0 auto; box-shadow: 0 8px 24px rgba(30,90,168,0.25);">4</div>
                    </div>
                    <h6 class="fw-bold mt-3" style="color: #0B1F3A;">Dapatkan Tiket</h6>
                    <p style="color: #6C757D; font-size: 0.9rem; max-width: 200px; margin: 4px auto 0;">Tiket digital + QR Code siap cetak</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span style="display: inline-block; background: #e8f0fe; color: #1E5AA8; font-size: 0.8rem; font-weight: 600; padding: 4px 16px; border-radius: 50px; letter-spacing: 0.5px; text-transform: uppercase;">Tanya Jawab</span>
                <h2 style="color: #0B1F3A; font-weight: 700; margin-top: 12px;">Pertanyaan yang Sering Diajukan</h2>
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
                            <div class="card border-0 rounded-4 mb-2" style="background: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.04); overflow: hidden;">
                                <div class="card-header" style="background: #ffffff; border: none; padding: 16px 20px;" id="faq{{ $i }}">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link fw-semibold w-100 text-start d-flex justify-content-between align-items-center" type="button" data-toggle="collapse"
                                            data-target="#faqCollapse{{ $i }}" aria-expanded="{{ $i == 0 ? 'true' : 'false' }}"
                                            aria-controls="faqCollapse{{ $i }}" style="color: #0B1F3A; text-decoration: none; padding: 0;">
                                            {{ $faq['q'] }}
                                            <span style="color: #1E5AA8; font-size: 1rem;">
                                                <i class="fas fa-chevron-down" style="transition: transform 0.3s ease;" id="faqIcon{{ $i }}"></i>
                                            </span>
                                        </button>
                                    </h6>
                                </div>
                                <div id="faqCollapse{{ $i }}" class="collapse {{ $i == 0 ? 'show' : '' }}"
                                    aria-labelledby="faq{{ $i }}" data-parent="#faqAccordion">
                                    <div class="card-body pt-0 pb-4 px-20" style="color: #6C757D; padding: 0 20px 20px;">
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

{{-- Script untuk interaksi FAQ --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle FAQ icon
        document.querySelectorAll('[data-toggle="collapse"]').forEach(function(button) {
            button.addEventListener('click', function() {
                var icon = this.querySelector('.fa-chevron-down');
                if (icon) {
                    icon.style.transition = 'transform 0.3s ease';
                    var isExpanded = this.getAttribute('aria-expanded') === 'true';
                    icon.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            });
        });

        // Hover effect for cards
        document.querySelectorAll('.card-hover').forEach(function(card) {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endpush