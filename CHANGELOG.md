# 📝 CHANGELOG
Semua perubahan penting pada proyek sistem **Pemesanan Tiket Bus** akan dicatat dalam dokumen ini.

Format dokumen ini mengacu pada [Keep a Changelog](https://keepachangelog.com/id/1.0.0/) dan menganut prinsip [Semantic Versioning](https://semver.org/lang/id/).

---

## 📌 ATURAN PENCATATAN (CHANGELOG PROTOCOL)
> [!IMPORTANT]
> **Setiap developer dan agen pengembang AI (Google Antigravity) WAJIB memperbarui berkas ini setiap kali melakukan perubahan pada kode sumber, basis data, atau konfigurasi.**
>
> Gunakan kategori berikut saat mencatat perubahan:
> - `Added`: untuk fitur atau berkas baru.
> - `Changed`: untuk perubahan fungsi, logika, atau alur yang sudah ada.
> - `Deprecated`: untuk fitur yang akan dihapus pada rilis mendatang.
> - `Removed`: untuk fitur atau berkas yang dihapus.
> - `Fixed`: untuk perbaikan bug atau galat.
> - `Security`: untuk pembaruan keamanan dan kerentanan.

---

## [Unreleased]
*Catatan perubahan yang sedang dikembangkan pada sesi aktif:*

### Added
- Prototipe interaktif Langkah 4 [`public/prototype/pembayaran.html`](public/prototype/pembayaran.html) yang mereplikasi tampilan Pembayaran Midtrans (QRIS, VA, Kartu Kredit, Gerai Retail), countdown timer otomatis, status verifikasi instan, serta pratinjau Boarding Pass / E-Tiket digital resmi dengan QR code verifikasi.
- Penambahan protokol wajib pencatatan changelog di `CHANGELOG.md` dan aturan workspace `AGENTS.md`.
- Berkas [`docs/FEATURE_AUDIT_AND_RECOMMENDATIONS.md`](docs/FEATURE_AUDIT_AND_RECOMMENDATIONS.md) berisi audit mendalam seluruh skrip controller/view/service eksisting, identifikasi 4 temuan celah teknis/bug, matriks kematangan fitur, serta roadmap rekomendasi fitur berprioritas (Auto-cancel cron, scanner boarding, PDF tiket resmi, WhatsApp gateway, PO multi-tenancy).

### Changed
- **Implementasi Desain Prototipe ke Seluruh Kode Sumber Laravel Project**:
  - [`resources/views/layouts/landing/app.blade.php`](resources/views/layouts/landing/app.blade.php): Mengintegrasikan design system prototipe dengan Google Fonts (*Plus Jakarta Sans*, *Inter*), Material Symbols Outlined, dan Tailwind CSS palette `brand` (`#006194`).
  - [`resources/views/layouts/landing/topbar.blade.php`](resources/views/layouts/landing/topbar.blade.php): Mengganti topbar legacy dengan navbar sticky modern berlogo resmi BusTicket, navigasi Beranda/Pesan Tiket/Rute/Bantuan, dan kontrol otentikasi dinamis (Admin/Customer Dashboard, Logout, Masuk, Daftar).
  - [`resources/views/layouts/landing/footer.blade.php`](resources/views/layouts/landing/footer.blade.php): Mengimplementasikan footer modern gelap (`#0f172a`) dengan kanal bantuan 24/7, navigasi cepat, dan lencana mitra resmi (*QRIS, Midtrans, VA, E-Wallet*).
  - [`resources/views/pages/landing/index.blade.php`](resources/views/pages/landing/index.blade.php): Transformasi halaman beranda utama agar 100% presisi dengan prototipe Desain 1; form pencarian dinamis terkoneksi data tabel `terminals`, tombol swap rute JS, kartu keunggulan, rute populer favorit dari data tabel `rutes`, alur 4 langkah pemesanan, dan FAQ accordion interaktif.
  - [`resources/views/pages/tiket/search.blade.php`](resources/views/pages/tiket/search.blade.php): Menerapkan alur Langkah 1 (Pilih Armada Bus) Desain 2 dengan stepper 4 tahap, sidebar filter lengkap (kelas bus, waktu, operator), kartu armada bus modern dengan garis rute dan durasi, serta tombol pemilihan kursi.
  - [`resources/views/pages/tiket/kursi.blade.php`](resources/views/pages/tiket/kursi.blade.php): Menerapkan denah kursi interaktif Langkah 2 Desain 2 formasi 2+2 (indikator sopir, toilet, lorong, status kursi Tersedia/Dipilih/Terisi), kalkulasi harga otomatis, dan panel rincian kursi terpilih terhubung ke form booking.
  - [`resources/views/pages/booking/form.blade.php`](resources/views/pages/booking/form.blade.php): Menerapkan form input data penumpang Langkah 3 dengan stepper dan ringkasan pesanan.
  - [`resources/views/pages/booking/payment.blade.php`](resources/views/pages/booking/payment.blade.php): Menerapkan tampilan pembayaran Langkah 4 Desain 3 dengan ribbon rute perjalanan, countdown timer aktif, metode pembayaran terintegrasi Midtrans Snap, dan rincian alokasi kursi penumpang.
  - [`resources/views/pages/booking/ticket.blade.php`](resources/views/pages/booking/ticket.blade.php): Menerapkan tampilan E-Tiket & Boarding Pass Resmi Desain 3 lengkap dengan strip biru resmi, rincian jadwal, daftar penumpang, QR code verifikasi gate, serta fitur cetak/PDF dan WhatsApp.
  - [`resources/views/pages/booking/detail.blade.php`](resources/views/pages/booking/detail.blade.php): Menyelaraskan tampilan detail pemesanan pelanggan dengan kartu status dan navigasi pembayaran.
- Pembaruan total berkas prototipe [`public/prototype/index.html`](public/prototype/index.html) (Halaman Beranda BusTicket) agar 100% sesuai dengan desain: hero section, form pencarian terintegrasi, fitur unggulan, rute populer Makassar-Toraja/Parepare/Palopo/Bulukumba, alur 4 langkah, dan FAQ accordion.
- Pembaruan berkas prototipe [`public/prototype/pemesanan.html`](public/prototype/pemesanan.html) mencakup Langkah 1 (Pilihan Armada Bus) & Langkah 2 (Denah Kursi Interaktif 2+2, alokasi kursi terpilih 2B dan 3D, serta rincian tarif).

---

## [1.1.0] - 2026-09-23
### Added
- **Suite Dokumentasi Rekayasa Perangkat Lunak Lengkap** pada folder [`docs/`](docs/):
  - [`docs/README.md`](docs/README.md): Master indeks dan katalog direktori dokumentasi.
  - [`docs/PRD.md`](docs/PRD.md): Product Requirements Document memuat persona, fitur, user stories Gherkin, dan metrik keberhasilan.
  - [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md): System Architecture Document memuat pola MVC + Service Layer, diagram komponen, *pessimistic row locking* anti *double-booking*, dan sequence diagram.
  - [`docs/DATABASE.md`](docs/DATABASE.md): Spesifikasi basis data & kamus data rinci untuk 10 tabel utama serta state machine status.
  - [`docs/SOFTWARE_DESIGN.md`](docs/SOFTWARE_DESIGN.md): Desain perangkat lunak, spesifikasi kontrak method Service Layer, dan alur Controller.
  - [`docs/API_INTEGRATION.md`](docs/API_INTEGRATION.md): Spesifikasi webhook Midtrans Snap, keamanan IPN, dan cetak biru REST API Mobile (Sanctum).
  - [`docs/TESTING_AND_DEPLOYMENT.md`](docs/TESTING_AND_DEPLOYMENT.md): Bedah test suite `BookingFlowTest`, simulasi Midtrans sandbox, dan checklist deployment Linux/Nginx.
  - [`DEVELOPMENT.md`](DEVELOPMENT.md): Panduan harian pengembang dan resep slash command Antigravity AI assistant.
- Berkas [`CHANGELOG.md`](CHANGELOG.md) sebagai berkas rekam jejak resmi riwayat perubahan proyek.

### Changed
- Pembaruan berkas [`AGENTS.md`](AGENTS.md):
  - Menghilangkan catatan legacy aplikasi lama (Kemenkumham UMKM).
  - Menyelaraskan referensi model terkini (`Booking`, `BookingSeat`, `Operator`, `Payment`, dll).
  - Memperbarui informasi kredensial seeder (`admin` / `password` dan `customer` / `password`).
  - Menambahkan aturan kepatuhan pembaruan `CHANGELOG.md` untuk setiap interaksi Antigravity.

---

## [1.0.0] - 2026-09-22
### Added
- **Domain Service Layer Architecture**:
  - `BookingService`: Penguncian atomik `DB::transaction()` + `lockForUpdate()`, generator kode booking unik `BUS-YYYYMMDD-XXXXXX`, dan kalkulasi batas kedaluwarsa reservasi.
  - `PaymentService`: Integrasi Midtrans Snap PHP SDK, verifikasi signature notifikasi webhook IPN, pencocokan nominal `gross_amount`, rekonsiliasi status, dan konfirmasi tunai loket (`cash`).
  - `TicketService`: Kompilasi data tiket digital dan generator SVG QR Code dinamis menggunakan `simplesoftwareio/simple-qrcode`.
- **Feature Test Suite**:
  - Berkas `tests/Feature/BookingFlowTest.php` menguji skenario end-to-end reservasi, pencegahan *double booking* kursi secara simultan, proteksi hak akses IDOR, serta konfirmasi pembayaran loket oleh admin.
- Integrasi konfigurasi Midtrans di `config/midtrans.php`.
- Pengecualian CSRF untuk endpoint webhook `/payment/callback` pada `VerifyCsrfToken.php`.

### Changed
- Modernisasi sintaks routing di `routes/web.php` menjadi callable array (`[Controller::class, 'method']`).
- Pembersihan rute-rute tak terpakai dan pemisahan middleware `ValidasiUser` dan `CheckRole:admin` / `CheckRole:customer`.

---

## [0.3.0] - 2026-09-19
### Added
- Form formulir data identitas penumpang multi-kursi (`pages.booking.form`).
- Antarmuka denah pemilihan kursi interaktif untuk customer (`pages.tiket.seats`).
- Fitur kalkulasi jarak dan estimasi durasi otomatis pada `RuteController` via AJAX request koordinat latitude & longitude terminal asal dan tujuan.
- Tampilan manajemen customer untuk admin pada `AdminCustomerController`.

### Changed
- Pembaruan tampilan denah kursi admin pada `KursiController`.
- Penyesuaian layout responsive navigasi publik dan customer.

---

## [0.2.0] - 2026-09-13
### Added
- CRUD Master Data Kursi bus (`KursiController` & `pages.admin.kursi`).
- Generator denah kursi dasar otomatis saat armada bus baru didaftarkan.
- CRUD Master Data Armada Bus (`BusController` & `pages.admin.Bus`).
- CRUD Master Data PO Bus Operator (`OperatorController` & `pages.admin.operator`).
- CRUD Master Data Terminal (`TerminalController` & `pages.admin.terminal`).

### Changed
- Pembaruan skema database tabel `buses`, `kursis`, dan relasi antar tabel.

---

## [0.1.0] - 2026-08-18
### Added
- Inisialisasi template admin **Stisla** (Bootstrap 4, jQuery, FontAwesome, Ionicons).
- Konfigurasi asset pipeline **Laravel Mix** (`webpack.mix.js` -> `public/library/`).
- Sistem autentikasi sesi mandiri berbasis `AuthController`, middleware `ValidasiUser`, dan `CheckRole`.
- Migrasi skema database awal: `users`, `operators`, `buses`, `terminals`, `rutes`, `kursis`, `jadwals`, `bookings`, `booking_seats`, `payments`.
- Database Seeders dan Factory data dummy untuk seluruh entitas.
