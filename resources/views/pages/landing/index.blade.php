@extends('layouts.landing.app')

@section('content')
@push('styles')
<style>
    /* ===== ROOT VARIABLES ===== */
    :root {
        --navy-dark: #0B1F3A;
        --navy-medium: #123E73;
        --navy-light: #1E5AA8;
        --navy-gradient: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%);
        --white: #FFFFFF;
        --light-gray: #F8F9FA;
        --gray: #6C757D;
        --shadow-sm: 0 4px 20px rgba(11, 31, 58, 0.08);
        --shadow-md: 0 8px 40px rgba(11, 31, 58, 0.12);
        --shadow-lg: 0 16px 60px rgba(11, 31, 58, 0.15);
        --shadow-xl: 0 24px 80px rgba(11, 31, 58, 0.18);
        --radius-sm: 12px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* ===== TYPOGRAPHY ===== */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: #1A1A2E;
        background: var(--white);
        overflow-x: hidden;
    }

    .section-padding {
        padding: 100px 0;
    }

    .section-padding-sm {
        padding: 70px 0;
    }

    .section-title {
        font-size: 2.75rem;
        font-weight: 700;
        color: var(--navy-dark);
        letter-spacing: -0.02em;
        line-height: 1.15;
        margin-bottom: 0.5rem;
    }

    .section-subtitle {
        font-size: 1.15rem;
        font-weight: 400;
        color: var(--gray);
        max-width: 600px;
        margin: 0 auto 2.5rem auto;
        line-height: 1.7;
    }

    .section-subtitle-left {
        font-size: 1.1rem;
        font-weight: 400;
        color: var(--gray);
        max-width: 580px;
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .section-badge {
        display: inline-block;
        background: rgba(11, 31, 58, 0.06);
        color: var(--navy-medium);
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 0.4rem 1.2rem;
        border-radius: 50px;
        margin-bottom: 1rem;
    }

    .text-navy {
        color: var(--navy-dark);
    }

    .text-navy-light {
        color: var(--navy-light);
    }

    /* ===== BUTTONS ===== */
    .btn-premium {
        background: var(--navy-gradient);
        color: var(--white);
        border: none;
        padding: 0.9rem 2.4rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        box-shadow: 0 8px 30px rgba(18, 62, 115, 0.3);
        letter-spacing: 0.01em;
    }

    .btn-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(18, 62, 115, 0.4);
        color: var(--white);
        background: var(--navy-gradient);
    }

    .btn-outline-premium {
        background: transparent;
        color: var(--navy-dark);
        border: 2px solid var(--navy-dark);
        padding: 0.85rem 2.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        letter-spacing: 0.01em;
    }

    .btn-outline-premium:hover {
        background: var(--navy-dark);
        color: var(--white);
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(11, 31, 58, 0.2);
    }

    .btn-premium-sm {
        padding: 0.65rem 1.8rem;
        font-size: 0.85rem;
    }

    /* ===== HERO SECTION ===== */
    #hero {
        min-height: 90vh;
        display: flex;
        align-items: center;
        position: relative;
        background: var(--white);
        overflow: hidden;
        padding: 40px 0 20px 0;
    }

    #hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 70%;
        height: 140%;
        background: radial-gradient(ellipse at 70% 50%, rgba(18, 62, 115, 0.04) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-badge {
        display: inline-block;
        background: rgba(11, 31, 58, 0.06);
        color: var(--navy-medium);
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 50px;
        margin-bottom: 1.2rem;
        letter-spacing: 0.05em;
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        color: var(--navy-dark);
        letter-spacing: -0.03em;
        line-height: 1.1;
        margin-bottom: 1.2rem;
    }

    .hero-title .highlight {
        background: var(--navy-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-description {
        font-size: 1.15rem;
        color: var(--gray);
        line-height: 1.8;
        max-width: 500px;
        margin-bottom: 2rem;
    }

    .hero-buttons .btn {
        margin-right: 1rem;
        margin-bottom: 0.5rem;
    }

    /* Hero Floating Cards */
    .hero-floating-cards {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .hero-floating-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        box-shadow: var(--shadow-sm);
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--navy-dark);
        transition: var(--transition);
    }

    .hero-floating-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        background: rgba(255, 255, 255, 0.9);
    }

    .hero-floating-card .icon {
        color: var(--navy-light);
        font-size: 1rem;
    }

    /* Hero Image */
    .hero-image-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .hero-image-wrapper img {
        max-width: 100%;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        position: relative;
        z-index: 2;
    }

    .hero-image-wrapper::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 80%;
        height: 80%;
        background: var(--navy-gradient);
        border-radius: var(--radius-lg);
        opacity: 0.08;
        z-index: 0;
    }

    /* ===== STATISTICS ===== */
    #statistics {
        background: var(--light-gray);
        padding: 60px 0;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid rgba(0, 0, 0, 0.02);
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-md);
        border-color: rgba(18, 62, 115, 0.08);
    }

    .stat-number {
        font-size: 2.75rem;
        font-weight: 800;
        color: var(--navy-dark);
        line-height: 1.1;
    }

    .stat-label {
        font-size: 0.95rem;
        color: var(--gray);
        font-weight: 500;
        margin-top: 0.3rem;
    }

    .stat-icon {
        font-size: 2rem;
        color: var(--navy-light);
        margin-bottom: 0.5rem;
        display: block;
        opacity: 0.7;
    }

    /* ===== ABOUT SECTION ===== */
    #about {
        background: var(--white);
    }

    .about-image-wrapper {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .about-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-height: 400px;
    }

    .about-image-wrapper .about-badge {
        position: absolute;
        bottom: 2rem;
        left: 2rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        padding: 1rem 1.5rem;
        border-radius: var(--radius-sm);
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .about-image-wrapper .about-badge .badge-icon {
        font-size: 1.8rem;
        color: var(--navy-light);
    }

    .about-image-wrapper .about-badge .badge-text {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--navy-dark);
        margin: 0;
        line-height: 1.3;
    }

    .about-image-wrapper .about-badge .badge-text small {
        font-weight: 400;
        color: var(--gray);
        font-size: 0.75rem;
    }

    .about-checklist {
        list-style: none;
        padding: 0;
        margin-top: 1.5rem;
    }

    .about-checklist li {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.6rem 0;
        font-size: 0.95rem;
        color: #1A1A2E;
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    }

    .about-checklist li:last-child {
        border-bottom: none;
    }

    .about-checklist li .check-icon {
        color: var(--navy-light);
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
        flex-shrink: 0;
    }

    /* ===== FEATURES ===== */
    #features {
        background: var(--light-gray);
    }

    .feature-card {
        background: var(--white);
        border-radius: var(--radius-md);
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid rgba(0, 0, 0, 0.02);
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(18, 62, 115, 0.06);
    }

    .feature-icon {
        width: 68px;
        height: 68px;
        background: rgba(18, 62, 115, 0.08);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.2rem auto;
        font-size: 1.8rem;
        color: var(--navy-light);
        transition: var(--transition);
    }

    .feature-card:hover .feature-icon {
        background: var(--navy-gradient);
        color: var(--white);
        transform: scale(1.05);
    }

    .feature-card h4 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--navy-dark);
        margin-bottom: 0.5rem;
    }

    .feature-card p {
        font-size: 0.9rem;
        color: var(--gray);
        line-height: 1.6;
        margin: 0;
    }

    /* ===== TIMELINE / FLOW ===== */
    #flow {
        background: var(--white);
    }

    .flow-steps {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        padding: 2rem 0;
        flex-wrap: wrap;
    }

    .flow-steps::before {
        content: '';
        position: absolute;
        top: 4.5rem;
        left: 10%;
        right: 10%;
        height: 3px;
        background: var(--navy-gradient);
        opacity: 0.2;
        border-radius: 2px;
    }

    .flow-step {
        text-align: center;
        flex: 1;
        min-width: 100px;
        position: relative;
        z-index: 2;
        padding: 0 0.5rem;
    }

    .flow-step .step-icon {
        width: 72px;
        height: 72px;
        background: var(--white);
        border: 2px solid rgba(18, 62, 115, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem auto;
        font-size: 1.6rem;
        color: var(--navy-light);
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        position: relative;
    }

    .flow-step .step-icon .step-number {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 28px;
        height: 28px;
        background: var(--navy-gradient);
        border-radius: 50%;
        color: var(--white);
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .flow-step:hover .step-icon {
        border-color: var(--navy-light);
        transform: scale(1.08);
        box-shadow: var(--shadow-md);
    }

    .flow-step h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--navy-dark);
        margin-bottom: 0.2rem;
    }

    .flow-step p {
        font-size: 0.8rem;
        color: var(--gray);
        margin: 0;
    }

    /* ===== ADVANTAGES (Dark Navy Section) ===== */
    #advantages {
        background: var(--navy-gradient);
        padding: 100px 0;
        color: var(--white);
    }

    #advantages .section-title {
        color: var(--white);
    }

    #advantages .section-subtitle {
        color: rgba(255, 255, 255, 0.7);
    }

    .advantage-card {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-md);
        padding: 2rem 1.5rem;
        text-align: center;
        transition: var(--transition);
        height: 100%;
    }

    .advantage-card:hover {
        transform: translateY(-6px);
        background: rgba(255, 255, 255, 0.10);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .advantage-card .adv-icon {
        font-size: 2.2rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 1rem;
        display: block;
    }

    .advantage-card h5 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--white);
    }

    .advantage-card p {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
        margin: 0;
    }

    /* ===== PREVIEW ===== */
    #preview {
        background: var(--light-gray);
    }

    .preview-mockup {
        border-radius: var(--radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        border: 1px solid rgba(0, 0, 0, 0.04);
        background: var(--white);
    }

    .preview-mockup:hover {
        transform: scale(1.01);
        box-shadow: var(--shadow-xl);
    }

    .preview-mockup img {
        width: 100%;
        height: auto;
        display: block;
    }

    .preview-mockup .mockup-label {
        padding: 1.2rem 1.5rem;
        background: var(--white);
        border-top: 1px solid rgba(0, 0, 0, 0.04);
    }

    .preview-mockup .mockup-label h5 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--navy-dark);
        margin: 0;
    }

    .preview-mockup .mockup-label p {
        font-size: 0.85rem;
        color: var(--gray);
        margin: 0.2rem 0 0 0;
    }

    /* ===== FAQ ===== */
    #faq {
        background: var(--white);
    }

    .faq-accordion .card {
        border: none;
        border-radius: var(--radius-sm) !important;
        margin-bottom: 0.75rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .faq-accordion .card:hover {
        box-shadow: var(--shadow-md);
    }

    .faq-accordion .card-header {
        background: var(--white);
        border: none;
        padding: 0;
        border-radius: var(--radius-sm) !important;
    }

    .faq-accordion .card-header .btn-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 1.2rem 1.5rem;
        text-align: left;
        font-weight: 600;
        color: var(--navy-dark);
        text-decoration: none;
        font-size: 1rem;
        border: none;
        background: transparent;
        border-radius: var(--radius-sm);
        transition: var(--transition);
    }

    .faq-accordion .card-header .btn-link:hover {
        color: var(--navy-light);
    }

    .faq-accordion .card-header .btn-link .fa-chevron-down {
        transition: var(--transition);
        font-size: 0.8rem;
        color: var(--gray);
        flex-shrink: 0;
        margin-left: 1rem;
    }

    .faq-accordion .card-header .btn-link[aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
        color: var(--navy-light);
    }

    .faq-accordion .card-body {
        padding: 0 1.5rem 1.5rem 1.5rem;
        color: var(--gray);
        line-height: 1.7;
        font-size: 0.95rem;
        border-top: 1px solid rgba(0, 0, 0, 0.04);
    }

    /* ===== CTA SECTION ===== */
    #cta {
        background: var(--navy-gradient);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    #cta::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(ellipse at 70% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    #cta h2 {
        font-size: 2.75rem;
        font-weight: 700;
        color: var(--white);
        letter-spacing: -0.02em;
        margin-bottom: 0.5rem;
    }

    #cta p {
        font-size: 1.15rem;
        color: rgba(255, 255, 255, 0.75);
        max-width: 500px;
        margin: 0 auto 2rem auto;
    }

    #cta .btn-cta-primary {
        background: var(--white);
        color: var(--navy-dark);
        border: none;
        padding: 0.85rem 2.4rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        margin: 0 0.5rem 0.5rem 0;
    }

    #cta .btn-cta-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        background: var(--white);
        color: var(--navy-dark);
    }

    #cta .btn-cta-outline {
        background: transparent;
        color: var(--white);
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.8rem 2.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        margin: 0 0.5rem 0.5rem 0;
    }

    #cta .btn-cta-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--white);
        transform: translateY(-3px);
        color: var(--white);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991.98px) {
        .hero-title {
            font-size: 2.75rem;
        }

        .section-title {
            font-size: 2.25rem;
        }

        .section-padding {
            padding: 70px 0;
        }

        .flow-steps::before {
            display: none;
        }

        .flow-step {
            flex: 0 0 33.33%;
            margin-bottom: 2rem;
        }

        #hero {
            min-height: auto;
            padding: 60px 0 40px 0;
        }

        .hero-image-wrapper {
            margin-top: 2.5rem;
        }

        .hero-image-wrapper::after {
            display: none;
        }
    }

    @media (max-width: 767.98px) {
        .hero-title {
            font-size: 2.25rem;
        }

        .section-title {
            font-size: 1.85rem;
        }

        .section-padding {
            padding: 50px 0;
        }

        #advantages {
            padding: 60px 0;
        }

        #cta {
            padding: 50px 0;
        }

        #cta h2 {
            font-size: 2rem;
        }

        .flow-step {
            flex: 0 0 50%;
        }

        .hero-floating-cards {
            justify-content: center;
        }

        .hero-buttons .btn {
            margin-right: 0.5rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .about-image-wrapper .about-badge {
            left: 1rem;
            bottom: 1rem;
            padding: 0.75rem 1rem;
        }

        .about-image-wrapper .about-badge .badge-icon {
            font-size: 1.2rem;
        }

        .about-image-wrapper .about-badge .badge-text {
            font-size: 0.75rem;
        }

        .about-image-wrapper img {
            min-height: 250px;
        }
    }

    @media (max-width: 575.98px) {
        .hero-title {
            font-size: 1.85rem;
        }

        .hero-description {
            font-size: 1rem;
        }

        .flow-step {
            flex: 0 0 100%;
        }

        .hero-buttons .btn {
            display: block;
            width: 100%;
            margin-right: 0;
            margin-bottom: 0.75rem;
        }

        .hero-floating-cards {
            flex-direction: column;
            align-items: stretch;
        }

        .hero-floating-card {
            justify-content: center;
        }

        .section-subtitle {
            font-size: 1rem;
        }

        .stat-card {
            padding: 1.5rem 1rem;
        }

        .feature-card {
            padding: 1.5rem 1rem;
        }

        .advantage-card {
            padding: 1.5rem 1rem;
        }

        .faq-accordion .card-header .btn-link {
            font-size: 0.9rem;
            padding: 1rem 1.2rem;
        }

        .faq-accordion .card-body {
            padding: 0 1.2rem 1.2rem 1.2rem;
            font-size: 0.9rem;
        }

        #cta .btn-cta-primary,
        #cta .btn-cta-outline {
            display: block;
            width: 100%;
            margin: 0 0 0.75rem 0;
        }
    }

    /* ===== UTILITY ===== */
    .gap-2 {
        gap: 0.5rem;
    }
    .gap-3 {
        gap: 1rem;
    }
    .gap-4 {
        gap: 1.5rem;
    }

    .bg-light-custom {
        background: var(--light-gray);
    }

    .border-radius-lg {
        border-radius: var(--radius-lg);
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: var(--light-gray);
    }
    ::-webkit-scrollbar-thumb {
        background: var(--navy-gradient);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        opacity: 0.8;
    }
</style>
@endpush

<!-- ============================================================
    HERO SECTION
    ============================================================ -->
<section id="hero">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Column -->
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">
                <span class="hero-badge">
                    <i class="fas fa-rocket me-1"></i> Sistem RAP Kementerian
                </span>
                <h1 class="hero-title">
                    Rencana Aksi Perubahan<br>
                    <span class="highlight">Modern & Terintegrasi</span>
                </h1>
                <p class="hero-description">
                    Sistem informasi terintegrasi untuk perencanaan, pelaksanaan, pemantauan, 
                    dan evaluasi program perubahan di lingkungan Kementerian Imigrasi dan Pemasyarakatan.
                </p>
                <div class="hero-buttons d-flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="btn btn-premium">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk
                    </a>
                    <a href="#about" class="btn btn-outline-premium">
                        <i class="fas fa-chevron-right me-2"></i> Pelajari Lebih Lanjut
                    </a>
                </div>
                <div class="hero-floating-cards">
                    <span class="hero-floating-card">
                        <span class="icon"><i class="fas fa-check-circle"></i></span> Sistem Modern
                    </span>
                    <span class="hero-floating-card">
                        <span class="icon"><i class="fas fa-shield-alt"></i></span> Aman
                    </span>
                    <span class="hero-floating-card">
                        <span class="icon"><i class="fas fa-bolt"></i></span> Cepat
                    </span>
                    </div>
            </div>
            <!-- Right Column -->
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                <div class="hero-image-wrapper">
                    <img src="{{ asset('landing/images/slider-main/rap.jpeg') }}" 
                         alt="Sistem RAP Kementerian" 
                         class="img-fluid rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
    STATISTICS SECTION
    ============================================================ -->
<section id="statistics" data-aos="fade-up" data-aos-duration="800">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-card">
                    <span class="stat-icon"><i class="fas fa-users"></i></span>
                    <div class="stat-number" data-count="1500">1.500+</div>
                    <div class="stat-label">Pengguna Aktif</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-card">
                    <span class="stat-icon"><i class="fas fa-file-alt"></i></span>
                    <div class="stat-number" data-count="850">850+</div>
                    <div class="stat-label">Dokumen RAP</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-card">
                    <span class="stat-icon"><i class="fas fa-building"></i></span>
                    <div class="stat-number" data-count="45">45</div>
                    <div class="stat-label">Instansi Terlibat</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                <div class="stat-card">
                    <span class="stat-icon"><i class="fas fa-chart-line"></i></span>
                    <div class="stat-number" data-count="320">320+</div>
                    <div class="stat-label">Laporan Tersusun</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
    ABOUT SECTION
    ============================================================ -->
<section id="about" class="section-padding" data-aos="fade-up" data-aos-duration="800">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Left: Image -->
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">
                <div class="about-image-wrapper">
                    <img src="{{ asset('landing/images/slider-main/rap.jpeg') }}" 
                         alt="Tentang Sistem RAP" 
                         class="img-fluid">
                    <div class="about-badge">
                        <span class="badge-icon"><i class="fas fa-medal"></i></span>
                        <div class="badge-text">
                            Terakreditasi &amp; Terpercaya
                            <br><small>Standar Kementerian</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right: Content -->
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">
                <span class="section-badge"><i class="fas fa-info-circle me-1"></i> Tentang Sistem</span>
                <h2 class="section-title text-left">Sistem Rencana Aksi Perubahan <br><span class="text  -navy-light">Kementerian</span></h2>
                <p class="section-subtitle-left">
                    Aplikasi Sistem Rencana Aksi Perubahan (RAP) merupakan sistem informasi berbasis web 
                    yang mendukung proses perencanaan, pelaksanaan, pemantauan, dan evaluasi program perubahan 
                    di lingkungan Kementerian Imigrasi dan Pemasyarakatan.
                </p>
                <ul class="about-checklist">
                    <li>
                        <span class="check-icon"><i class="fas fa-check-circle"></i></span>
                        Perencanaan program perubahan yang sistematis dan terstruktur
                    </li>
                    <li>
                        <span class="check-icon"><i class="fas fa-check-circle"></i></span>
                        Pemantauan real-time dan evaluasi berbasis indikator
                    </li>
                    <li>
                        <span class="check-icon"><i class="fas fa-check-circle"></i></span>
                        Dokumentasi digital yang aman dan mudah diakses
                    </li>
                    <li>
                        <span class="check-icon"><i class="fas fa-check-circle"></i></span>
                        Koordinasi terintegrasi antar unit kerja
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
    FEATURES SECTION
    ============================================================ -->
<section id="features" class="section-padding" data-aos="fade-up" data-aos-duration="800">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <span class="section-badge"><i class="fas fa-cogs me-1"></i> Fitur Unggulan</span>
                <h2 class="section-title">Fitur Sistem <span class="text-navy-light">RAP</span></h2>
                <p class="section-subtitle">
                    Berbagai fitur dirancang untuk mendukung kelancaran program perubahan Anda.
                </p>
            </div>
        </div>
        <div class="row g-4 mt-2">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-file-pdf"></i></div>
                    <h4>Manajemen Dokumen</h4>
                    <p>Kelola dokumen RAP secara digital dengan sistem penyimpanan yang terstruktur dan mudah diakses.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-pie"></i></div>
                    <h4>Dashboard Analitik</h4>
                    <p>Pantau capaian program melalui dashboard interaktif dengan visualisasi data yang informatif.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-user-shield"></i></div>
                    <h4>Multi User &amp; Role</h4>
                    <p>Mendukung berbagai peran pengguna dengan akses dan hak yang sesuai dengan kebutuhan masing-masing.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-lock"></i></div>
                    <h4>Keamanan Terjamin</h4>
                    <p>Sistem dilengkapi dengan keamanan berlapis untuk melindungi data dan informasi penting.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-eye"></i></div>
                    <h4>Monitoring &amp; Evaluasi</h4>
                    <p>Lacak perkembangan program secara real-time dan lakukan evaluasi berbasis data.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-archive"></i></div>
                    <h4>Arsip Digital</h4>
                    <p>Simpan dan kelola arsip dokumen dengan sistem pencarian yang cepat dan akurat.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
    FLOW / TIMELINE SECTION
    ============================================================ -->
<section id="flow" class="section-padding" data-aos="fade-up" data-aos-duration="800">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <span class="section-badge"><i class="fas fa-route me-1"></i> Alur Penggunaan</span>
                <h2 class="section-title">Bagaimana <span class="text-navy-light">Alur Kerja</span></h2>
                <p class="section-subtitle">
                    Proses yang sederhana dan efisien untuk mengelola Rencana Aksi Perubahan.
                </p>
            </div>
        </div>
        <div class="flow-steps">
            <div class="flow-step" data-aos="zoom-in" data-aos-delay="100">
                <div class="step-icon">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="step-number">1</span>
                </div>
                <h5>Login</h5>
                <p>Akses sistem dengan akun terdaftar</p>
            </div>
            <div class="flow-step" data-aos="zoom-in" data-aos-delay="150">
                <div class="step-icon">
                    <i class="fas fa-edit"></i>
                    <span class="step-number">2</span>
                </div>
                <h5>Input Data</h5>
                <p>Isi data RAP secara lengkap</p>
            </div>
            <div class="flow-step" data-aos="zoom-in" data-aos-delay="200">
                <div class="step-icon">
                    <i class="fas fa-check-double"></i>
                    <span class="step-number">3</span>
                </div>
                <h5>Verifikasi</h5>
                <p>Validasi oleh mentor/admin</p>
            </div>
            <div class="flow-step" data-aos="zoom-in" data-aos-delay="250">
                <div class="step-icon">
                    <i class="fas fa-file-alt"></i>
                    <span class="step-number">4</span>
                </div>
                <h5>Laporan</h5>
                <p>Hasil akhir terdokumentasi</p>
            </div>
            <div class="flow-step" data-aos="zoom-in" data-aos-delay="300">
                <div class="step-icon">
                    <i class="fas fa-flag-checkered"></i>
                    <span class="step-number">5</span>
                </div>
                <h5>Selesai</h5>
                <p>Program terimplementasi</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
    ADVANTAGES SECTION (Dark Navy Background)
    ============================================================ -->
<section id="advantages" data-aos="fade-up" data-aos-duration="800">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <span class="section-badge" style="background:rgba(255,255,255,0.12); color:rgba(255,255,255,0.8);">
                    <i class="fas fa-star me-1"></i> Keunggulan Sistem
                </span>
                <h2 class="section-title">Kenapa Memilih <span style="color:rgba(255,255,255,0.8);">Sistem RAP</span></h2>
                <p class="section-subtitle" style="color:rgba(255,255,255,0.7);">
                    Solusi terbaik untuk pengelolaan program perubahan yang profesional dan terintegrasi.
                </p>
            </div>
        </div>
        <div class="row g-4 mt-2">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="advantage-card">
                    <span class="adv-icon"><i class="fas fa-rocket"></i></span>
                    <h5>Inovatif</h5>
                    <p>Mengadopsi teknologi terbaru untuk mendukung transformasi digital.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="150">
                <div class="advantage-card">
                    <span class="adv-icon"><i class="fas fa-shield-alt"></i></span>
                    <h5>Aman &amp; Terpercaya</h5>
                    <p>Standar keamanan tinggi dengan enkripsi data dan akses terbatas.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="advantage-card">
                    <span class="adv-icon"><i class="fas fa-sync-alt"></i></span>
                    <h5>Terintegrasi</h5>
                    <p>Terhubung dengan berbagai unit kerja untuk koordinasi yang efektif.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="250">
                <div class="advantage-card">
                    <span class="adv-icon"><i class="fas fa-chart-line"></i></span>
                    <h5>Berbasis Data</h5>
                    <p>Pengambilan keputusan didukung oleh data yang akurat dan real-time.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
    FAQ SECTION
    ============================================================ -->
<section id="faq" class="section-padding" data-aos="fade-up" data-aos-duration="800">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <span class="section-badge"><i class="fas fa-question-circle me-1"></i> FAQ</span>
                <h2 class="section-title">Pertanyaan <span class="text-navy-light">Umum</span></h2>
                <p class="section-subtitle">
                    Temukan jawaban atas pertanyaan yang sering diajukan tentang sistem RAP.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="faq-accordion" id="faqAccordion">
                    <div class="card" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-header" id="faq1">
                            <button class="btn-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                Apa itu Sistem RAP?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div id="collapse1" class="collapse show" aria-labelledby="faq1" data-parent="#faqAccordion">
                            <div class="card-body">
                                Sistem RAP (Rencana Aksi Perubahan) adalah aplikasi berbasis web yang dirancang untuk 
                                mendukung proses perencanaan, pelaksanaan, pemantauan, dan evaluasi program perubahan 
                                di lingkungan Kementerian Imigrasi dan Pemasyarakatan.
                            </div>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="150">
                        <div class="card-header" id="faq2">
                            <button class="btn-link collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                Siapa yang dapat menggunakan sistem ini?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div id="collapse2" class="collapse" aria-labelledby="faq2" data-parent="#faqAccordion">
                            <div class="card-body">
                                Sistem ini dapat digunakan oleh berbagai pihak di lingkungan Kementerian Imigrasi dan Pemasyarakatan, 
                                termasuk peserta pelatihan kepemimpinan, pejabat, mentor, dan administrator.
                            </div>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-header" id="faq3">
                            <button class="btn-link collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Bagaimana cara mengakses sistem?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div id="collapse3" class="collapse" aria-labelledby="faq3" data-parent="#faqAccordion">
                            <div class="card-body">
                                Pengguna dapat mengakses sistem melalui halaman login menggunakan akun yang telah didaftarkan 
                                oleh administrator. Setelah login, pengguna akan masuk ke dashboard sesuai dengan peran masing-masing.
                            </div>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="250">
                        <div class="card-header" id="faq4">
                            <button class="btn-link collapsed" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                Apakah data aman di sistem ini?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div id="collapse4" class="collapse" aria-labelledby="faq4" data-parent="#faqAccordion">
                            <div class="card-body">
                                Ya, sistem ini dilengkapi dengan keamanan berlapis termasuk enkripsi data, autentikasi multi-faktor, 
                                dan sistem audit untuk memastikan keamanan dan integritas data.
                            </div>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-header" id="faq5">
                            <button class="btn-link collapsed" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                Bagaimana cara mendapatkan bantuan teknis?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div id="collapse5" class="collapse" aria-labelledby="faq5" data-parent="#faqAccordion">
                            <div class="card-body">
                                Pengguna dapat menghubungi tim dukungan teknis melalui layanan helpdesk yang tersedia, 
                                atau melalui kontak yang tercantum di halaman kontak kami.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // ============================================================
    // ANIMATE STATISTICS COUNTER
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const statNumbers = document.querySelectorAll('.stat-number');
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const text = el.textContent.trim();
                    const number = parseInt(text.replace(/[^0-9]/g, ''));
                    if (number) {
                        animateNumber(el, number, 2000);
                    }
                    observer.unobserve(el);
                }
            });
        }, observerOptions);

        statNumbers.forEach(el => observer.observe(el));
    });

    function animateNumber(el, target, duration) {
        let start = 0;
        const step = Math.ceil(target / 60);
        const interval = duration / 60;

        const timer = setInterval(() => {
            start += step;
            if (start >= target) {
                start = target;
                clearInterval(timer);
            }
            el.textContent = formatNumber(start);
        }, interval);
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
@endpush

@endsection