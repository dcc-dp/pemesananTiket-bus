@extends('layouts.landing.app')
@section('content')
@push('styles')
<style>
    /* ============================================================
       KONTAK PAGE STYLES - Premium Gradient Biru Landing Page
       ============================================================ */
    
    /* ===== ROOT VARIABLES ===== */
    :root {
        --navy-dark: #0B1F3A;
        --navy-medium: #123E73;
        --navy-light: #1E5AA8;
        --navy-gradient: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%);
    }

    /* ===== BANNER AREA ===== */
    .banner-area {
        position: relative;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 350px;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .banner-area::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(11, 31, 58, 0.85) 0%, rgba(18, 62, 115, 0.75) 50%, rgba(30, 90, 168, 0.65) 100%);
        z-index: 1;
    }

    .banner-area::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0B1F3A, #1E5AA8, #0B1F3A);
        z-index: 2;
    }

    .banner-text {
        position: relative;
        z-index: 2;
        width: 100%;
        padding: 80px 0;
        text-align: center;
    }

    .banner-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: #FFFFFF;
        letter-spacing: -0.02em;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
    }

    .banner-title .highlight {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.6));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #FFFFFF;
    }

    .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.5);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.4);
        content: "›";
        font-size: 1.2rem;
        padding: 0 0.5rem;
    }

    /* ===== SECTION TITLE ===== */
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #0B1F3A;
        letter-spacing: -0.02em;
        margin-bottom: 0.5rem;
    }

    .section-title .highlight {
        background: var(--navy-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-sub-title {
        font-size: 1.1rem;
        font-weight: 400;
        color: #6C757D;
        margin-bottom: 2.5rem;
    }

    .section-badge {
        display: inline-block;
        background: rgba(11, 31, 58, 0.06);
        color: #123E73;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 0.4rem 1.2rem;
        border-radius: 50px;
        margin-bottom: 1rem;
    }

    /* ===== CONTACT CARDS ===== */
    .ts-service-box-bg {
        background: #FFFFFF;
        border-radius: 16px;
        padding: 2.5rem 1.5rem;
        box-shadow: 0 4px 20px rgba(11, 31, 58, 0.06);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border: 1px solid rgba(0, 0, 0, 0.02);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .ts-service-box-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--navy-gradient);
        opacity: 0;
        transition: all 0.4s ease;
    }

    .ts-service-box-bg:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(11, 31, 58, 0.12);
        border-color: rgba(18, 62, 115, 0.08);
    }

    .ts-service-box-bg:hover::before {
        opacity: 1;
    }

    .ts-service-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(18, 62, 115, 0.08);
        color: #123E73;
        font-size: 1.8rem;
        margin-bottom: 1.2rem;
        transition: all 0.4s ease;
    }

    .ts-service-box-bg:hover .ts-service-icon {
        background: var(--navy-gradient);
        color: #FFFFFF;
        transform: scale(1.05) rotate(-5deg);
        box-shadow: 0 8px 25px rgba(18, 62, 115, 0.3);
    }

    .ts-service-box-content h4 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0B1F3A;
        margin-bottom: 0.5rem;
    }

    .ts-service-box-content p {
        font-size: 0.95rem;
        color: #6C757D;
        line-height: 1.6;
        margin: 0;
    }

    .ts-service-box-content p a {
        color: #123E73;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .ts-service-box-content p a:hover {
        color: #1E5AA8;
        text-decoration: underline;
    }

    /* ===== GOOGLE MAP ===== */
    .google-map {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(11, 31, 58, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: all 0.4s ease;
    }

    .google-map:hover {
        box-shadow: 0 12px 50px rgba(11, 31, 58, 0.12);
        transform: scale(1.002);
    }

    .google-map iframe {
        display: block;
        width: 100%;
        height: 450px;
        border: none;
    }

    .map-wrapper {
        position: relative;
    }

    .map-wrapper .map-overlay {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 0.8rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .map-wrapper .map-overlay i {
        color: #123E73;
        font-size: 1rem;
    }

    .map-wrapper .map-overlay span {
        font-size: 0.85rem;
        color: #0B1F3A;
        font-weight: 500;
    }

    /* ===== CTA SECTION ===== */
    .contact-cta {
        background: var(--navy-gradient);
        padding: 60px 0;
        border-radius: 16px;
        margin-top: 40px;
        position: relative;
        overflow: hidden;
    }

    .contact-cta::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(ellipse at 70% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    .contact-cta h3 {
        color: #FFFFFF;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .contact-cta p {
        color: rgba(255, 255, 255, 0.75);
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .btn-cta-premium {
        background: #FFFFFF;
        color: #0B1F3A;
        border: none;
        padding: 0.85rem 2.4rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        display: inline-block;
        text-decoration: none;
    }

    .btn-cta-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        color: #0B1F3A;
        text-decoration: none;
    }

    .btn-cta-outline {
        background: transparent;
        color: #FFFFFF;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.8rem 2.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        margin-left: 0.5rem;
    }

    .btn-cta-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #FFFFFF;
        transform: translateY(-3px);
        color: #FFFFFF;
        text-decoration: none;
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 991.98px) {
        .banner-title {
            font-size: 2.8rem;
        }

        .section-title {
            font-size: 2.2rem;
        }

        .ts-service-box-bg {
            padding: 2rem 1.2rem;
        }

        .google-map iframe {
            height: 350px;
        }

        .contact-cta h3 {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 767.98px) {
        .banner-area {
            min-height: 280px;
        }

        .banner-text {
            padding: 60px 0;
        }

        .banner-title {
            font-size: 2.2rem;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .section-sub-title {
            font-size: 1rem;
        }

        .ts-service-box-bg {
            padding: 1.8rem 1rem;
            margin-bottom: 1.5rem;
        }

        .ts-service-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .google-map iframe {
            height: 280px;
        }

        .map-wrapper .map-overlay {
            bottom: 10px;
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            width: 90%;
            justify-content: center;
        }

        .contact-cta {
            padding: 40px 20px;
        }

        .contact-cta h3 {
            font-size: 1.5rem;
        }

        .contact-cta p {
            font-size: 0.95rem;
        }

        .btn-cta-premium,
        .btn-cta-outline {
            display: block;
            width: 100%;
            text-align: center;
            margin: 0 0 0.75rem 0;
        }

        .btn-cta-outline {
            margin-left: 0;
        }
    }

    @media (max-width: 575.98px) {
        .banner-title {
            font-size: 1.8rem;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .breadcrumb-item {
            font-size: 0.85rem;
        }

        .ts-service-box-content h4 {
            font-size: 1rem;
        }

        .ts-service-box-content p {
            font-size: 0.85rem;
        }

        .google-map iframe {
            height: 220px;
        }
    }
</style>
@endpush

<!-- ============================================================
    BANNER AREA
    ============================================================ -->
<div id="banner-area" class="banner-area" style="background-image:url({{ asset('landing/images/slider-main/dek1.webp') }})">
    <div class="banner-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center" data-aos="fade-up" data-aos-duration="800">
                    <span class="section-badge" style="background: rgba(255,255,255,0.12); color: rgba(255,255,255,0.8);">
                        <i class="fas fa-phone-alt me-1"></i> Hubungi Kami
                    </span>
                    <h1 class="banner-title">Kontak <span class="highlight">Kami</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hubungi Kami</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
    MAIN CONTENT
    ============================================================ -->
<section id="main-container" class="main-container" style="padding: 60px 0 40px 0;">
    <div class="container">
        <!-- Section Title -->
        <div class="row text-center">
            <div class="col-12" data-aos="fade-up" data-aos-duration="800">
                <span class="section-badge"><i class="fas fa-map-pin me-1"></i> Informasi Kontak</span>
                <h2 class="section-title">Kunjungi <span class="highlight">Kami</span></h2>
                <h3 class="section-sub-title">Temukan lokasi dan hubungi kami melalui berbagai saluran</h3>
            </div>
        </div>

        <!-- Contact Cards -->
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="ts-service-box-bg text-center">
                    <span class="ts-service-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <div class="ts-service-box-content">
                        <h4>Kunjungi Lokasi</h4>
                        <p>Jalan, Bonto Jai, Kec. Bissappu,<br> Kabupaten Bantaeng, Sulawesi Selatan 92451</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="ts-service-box-bg text-center">
                    <span class="ts-service-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <div class="ts-service-box-content">
                        <h4>Email Kami</h4>
                        <p><a href="mailto:dekranasda@gmail.com">dekranasda@gmail.com</a></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="ts-service-box-bg text-center">
                    <span class="ts-service-icon">
                        <i class="fas fa-phone-alt"></i>
                    </span>
                    <div class="ts-service-box-content">
                        <h4>Hubungi Kami</h4>
                        <p><a href="tel:0411000000">(0411) 000000</a><br><a href="tel:080808">080808</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="gap-60" style="height: 40px;"></div>

        <!-- Google Map -->
        <div class="map-wrapper" data-aos="fade-up" data-aos-duration="800">
            <div class="google-map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3970.9453552202244!2d119.90444747498528!3d-5.575097694405471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x42888dfc6316d653%3A0x75546e815f267f0c!2sKantor%20Imigrasi%20Kelas%20III%20Non%20TPI%20Bantaeng!5e0!3m2!1sid!2sid!4v1782699706522!5m2!1sid!2sid" 
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Peta Lokasi Kantor Imigrasi Bantaeng">
                </iframe>
            </div>
            <div class="map-overlay">
                <i class="fas fa-map-pin"></i>
                <span>Kantor Imigrasi Kelas III Non TPI Bantaeng</span>
            </div>
        </div>

        <div class="gap-40" style="height: 40px;"></div>

        <!-- CTA Section -->
        <div class="contact-cta" data-aos="fade-up" data-aos-duration="800">
            <div class="row align-items-center text-center">
                <div class="col-lg-12">
                    <h3>Siap Bekerja Sama <span style="color: rgba(255,255,255,0.8);">Dengan Kami?</span></h3>
                    <p>Hubungi kami sekarang untuk informasi lebih lanjut tentang layanan kami.</p>
                    <div>
                        <a href="mailto:dekranasda@gmail.com" class="btn-cta-premium">
                            <i class="fas fa-envelope me-2"></i> Email Kami
                        </a>
                        <a href="tel:0411000000" class="btn-cta-outline">
                            <i class="fas fa-phone-alt me-2"></i> Telepon Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection