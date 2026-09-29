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

### Removed
- [`resources/views/pages/admin/dashboard/index.blade.php`](resources/views/pages/admin/dashboard/index.blade.php): Menghapus tombol "Refresh Data" di baris header dan teks/badge "Update: Real-time" pada heading Statistik Utama sesuai permintaan pengguna.
- [`resources/views/pages/admin/operator/{create,edit}.blade.php`](resources/views/pages/admin/operator/create.blade.php): Menghapus tombol "Kembali ke Daftar" di pojok kanan atas page header agar header berfokus penuh pada judul dan deskripsi halaman.

### Changed
- **Penyelarasan & Standardisasi UI Seluruh Halaman CRUD Admin Sesuai Acuan "Operator" (`resources/views/pages/admin/*`)**:
  - **Single Design System Terpadu**: Menerapkan hierarki visual yang sama dengan acuan Operator pada seluruh fitur CRUD:
    - **Header & Breadcrumb**: Page header seragam dengan breadcrumb navigasi halus, icon container biru 42x42px (`#2563eb`), judul halaman 19px bold `#0f172a`, dan subtitle deskriptif 12.5px `#64748b`.
    - **Container & Card Lebar**: Menghapus tombol "Kembali ke Daftar" pada header halaman form create/edit agar fokus pada konten, menggunakan card container penuh (`col-12`) tanpa sisa whitespace di sebelah kanan.
    - **Form Elements & Hierarchy**: Label konsisten dengan tanda bintang merah (`.req-star`), input dan select setinggi 44px dengan border `#cbd5e1`, hover state `#94a3b8`, focus ring subtle, textarea alamat proporsional, serta card footer berlatar lembut (`#fafbfc`) untuk tombol submit (`.adm-btn-submit`) dan batal (`.adm-btn-cancel`).
    - **Tabel Enterprise & Aksi CRUD**: Header tabel uppercase 9.5-10.5px `#64748b` berlatar `#f8fafc`, padding baris nyaman (10px 14px), badge status berindikator dot/pill modern, badge monospace untuk ID/kode, tombol aksi edit (`far fa-edit`) dan hapus (`far fa-trash-alt`) compact 28x28px, serta empty state ilustratif modern saat data kosong.
  - **Modul CRUD yang Distandardisasi**:
    - **Bus (`resources/views/pages/admin/Bus/{index,create,edit}.blade.php`)**: Standardisasi tabel armada dengan status badge dot, form tambah & edit 2 kolom simetris, dan preservasi dropdown `kelas` sesuai validasi controller.
    - **Terminal (`resources/views/pages/admin/terminal/{index,create,edit}.blade.php`)**: Standardisasi tabel terminal dengan status badge operasional, form tambah & edit koordinat (latitude & longitude) serta textarea alamat.
    - **Rute (`resources/views/pages/admin/rute/{index,create,edit}.blade.php`)**: Standardisasi tabel rute dengan badge asal & tujuan, form tambah & edit dengan kalkulasi jarak otomatis yang mempertahankan seluruh atribut `data-lat`, `data-lng`, `id="jarak"`, dan fungsi JavaScript kalkulasi jarak.
    - **Jadwal (`resources/views/pages/admin/jadwal/{index,create,edit}.blade.php`)**: Filter toolbar terpadu, tabel jadwal dengan format jam & tanggal keberangkatan modern, form tambah & edit jadwal keberangkatan dan penetapan bus/rute.
    - **Kursi (`resources/views/pages/admin/kursi/{index,create,edit}.blade.php`)**: Selector armada bus modern, tabel kursi dengan status badge ketersediaan (aktif/nonaktif), form tambah & edit nomor dan status kursi.
    - **Akun (`resources/views/pages/admin/akun/{index,create,edit}.blade.php`)**: Filter pencarian & role pengguna, tabel akun dengan avatar inisial dan badge role, form pendaftaran & edit profil akun administrator/customer.
    - **Customer (`resources/views/pages/admin/customer/index.blade.php`)**: Filter pencarian instan, tabel customer dengan avatar inisial, kontak no HP/email, badge counter pesanan tiket, dan pagination.
    - **Booking (`resources/views/pages/admin/booking/{index,show}.blade.php`)**: Filter kode booking, status booking & pembayaran, tabel pesanan tiket dengan badge monospace kode booking, manifest penumpang, serta halaman detail booking dengan timeline visual perjalanan rute terminal dan ringkasan pembayaran.
    - **Pembayaran (`resources/views/pages/admin/payment/{index,show}.blade.php`)**: Filter status bayar & metode transaksi gateway, tabel pembayaran dengan status pill modern, serta halaman detail transaksi pembayaran yang terstruktur rapi.
    - **Laporan (`resources/views/pages/admin/report/index.blade.php`)**: Filter parameter laporan terpadu dengan 8 parameter filter, 3 metric card statistik modern (Total Transaksi, Tiket Terjual, Total Pendapatan), tombol cetak PDF, dan tabel rekapitulasi transaksi.
  - **Zero Logic Impact**: 100% mempertahankan seluruh route, controller, query, method form, token CSRF, validasi, dan event handler tanpa modifikasi fungsionalitas.
- **Full-Width Layout & Polish Form Tambah & Edit Operator (`resources/views/pages/admin/operator/{create,edit}.blade.php` & `public/css/admin-modern.css`)**:
  - **Full-Width Form Card**: Container form card diperluas menjadi `col-12` penuh mengisi area konten utama dashboard secara optimal tanpa menyisakan ruang kosong besar di sisi kanan, selaras dengan tabel operator dan kartu dashboard.
  - **SaaS / Enterprise Form Card System**: Mengimplementasikan kelas form terpadu (`.adm-form-card`, `.adm-form-header`, `.adm-form-body`, `.adm-form-footer`, `.adm-input`, `.adm-textarea`, `.adm-select`, `.adm-btn-submit`, `.adm-btn-cancel`) untuk konsistensi desain premium modern.
  - **Form Header & Indicator**: Header form berpadding rapi dengan ikon clipboard dalam badge lembut dan indikator kolom bertanda `*` wajib diisi yang sejajar presisi secara vertikal.
  - **Input & Textarea Refinement**: Tinggi input dan select 44px dengan border `#cbd5e1`, hover state `#94a3b8`, focus ring biru subtle (`0 0 0 3px rgba(37, 99, 235, 0.12)`), typography 13.5px, serta textarea alamat yang nyaman (tinggi 90px).
  - **Symmetrical 2-Column Grid**: Kolom Telepon & Email proporsional simetris dengan gutter konsisten 18px pada desktop dan responsif 1 kolom pada mobile.
  - **Dedicated Action Footer**: Area tombol aksi dipisahkan menjadi card footer berlatar lembut (`#fafbfc`) dengan separator halus, tombol Simpan (tinggi 42px, primary blue `#1d4ed8`) dan tombol Batal (tinggi 42px, border `#cbd5e1`) dengan navigasi pembatalan yang aman.
  - **Zero Logic Impact**: Seluruh field, nama parameter, validasi `@error`, token CSRF, route, dan behavior submit/batal tetap 100% terjaga tanpa modifikasi logika.
- **Refactor UI Halaman Data Operator (`resources/views/pages/admin/operator/index.blade.php`)**:
  - **Page Header**: Memperbarui page header dengan hierarki breadcrumb yang rapi (`Home > Master Data > Operator`), icon box operator biru 38x38px, judul utama 18px bold, subtitle deskriptif, dan whitespace proporsional.
  - **Content Card**: Desain container modern dengan background putih bersih, border subtle `#e2e8f0`, shadow halus, badge counter total operator, dan tombol "+ Tambah Operator" bergaya compact enterprise.
  - **Table & Column Alignment**: Header tabel 9.5px uppercase bernuansa netral, padding row nyaman (10px 14px), pemisah baris halus, dan hover state ringan.
  - **Badges & Action Buttons**: Badge kode operator monospace modern ber-border tipis, badge jumlah bus rounded pill biru, badge status "Aktif" dengan indikator dot hijau, serta tombol aksi modern (`.btn-action-edit` & `.btn-action-delete`) dengan ikon outlined modern `far fa-edit` (amber) dan `far fa-trash-alt` (crimson red) yang compact (28x28px) dengan fungsionalitas dan form confirmation yang 100% terjaga.
- **Pembuatan & Penyelarasan Total Dashboard Admin BusTiket Berdasarkan Gambar Referensi**:
  - Mengimplementasikan stylesheet terpadu [`public/css/admin-modern.css`](public/css/admin-modern.css) dengan Google Fonts (*Plus Jakarta Sans* & *Inter*), palet biru royal (`#1d4ed8`), slate netral (`#0f172a`, `#f8fafc`, `#e2e8f0`), dan kartu latar putih ber-shadow lembut.
  - [`resources/views/layouts/app.blade.php`](resources/views/layouts/app.blade.php): Mengintegrasikan `admin-modern.css` ke master layout panel admin.
  - [`resources/views/components/default/header.blade.php`](resources/views/components/default/header.blade.php): Memodernisasi navbar atas menjadi putih bersih sesuai referensi gambar dengan tombol toggle hamburger, search box global ("Cari tiket, rute, atau penumpang..." dengan badge shortcut `⌘K`), tombol "Lihat Situs ↗", lonceng notifikasi dengan dot indikator aktif, dan profil user ("Hi, Administrator - Super Admin").
  - [`resources/views/components/default/sidebar.blade.php`](resources/views/components/default/sidebar.blade.php): Memodernisasi sidebar dengan logo resmi BUSTICKET (Transit Management), menu utama (Dashboard dengan pill aktif, Master Data, Jadwal Aktif, Transaksi dengan badge "Baru", Laporan), menu pengaturan (Data Akun, Profil Saya), serta tombol logout merah di bagian bawah.
  - [`resources/views/pages/admin/dashboard/index.blade.php`](resources/views/pages/admin/dashboard/index.blade.php): Rekonstruksi tampilan dashboard admin 100% presisi sesuai gambar referensi:
    - **Refactor UI Header Dashboard**: Merapikan seluruh elemen header dashboard secara proporsional dan enterprise-ready:
      - **Container Header**: Spacing dan padding konsisten dengan margin bawah 24px ke section berikutnya.
      - **Breadcrumb**: Font subtle (11.5px, `#64748b`), separator chevron proporsional, alignment horizontal presisi.
      - **Title Section**: Ikon 40x40px rounded 9px biru royal `#1d4ed8`, judul "Dashboard" 19px bold `#0f172a`, subtitle 12px tersusun rapi dengan jarak vertikal konsisten.
      - **Right Action Section**: Date pill dan tombol "Refresh Data" tersusun berdampingan secara horizontal dengan tinggi seragam 34px, gap 10px, dan layout nowrap (tidak stacking).
      - **Section Heading "Statistik Utama"**: Diberikan jarak vertikal proporsional (24px) dari header dengan badge status "Update: Real-time" yang selaras dengan grid utama.
      - **Cache Busting**: Penambahan parameter versi dinamis (`?v=filemtime`) pada pemanggilan `admin-modern.css` di `layouts/app.blade.php`.
    - **Refactor & Compact Text (Status Tiket, Pesanan Terbaru & Live Dispatch)**:
      - Merampingkan ukuran font judul kartu (`adm-card-title` 12.5px, `adm-card-sub` 10px) dan membungkus header kartu dengan ikon compact 28x28px.
      - Memperkecil tipografi mini bar status tiket (`adm-status-strip` 10.5px, pill status 9.5px, indikator operator/bus/terminal 10.5px) serta menambahkan utilitas gap dan spacing antar-pill (gap: 8px) dan antar-indikator (gap: 10px) dengan margin bawah 18px.
      - Mengoptimalkan tabel "Pesanan Terbaru" dengan header huruf kapital mikro 9px berjarak renggang, teks nama dan rute 11px, sub-info 9.5px, link kode booking mono 10.5px, badge status 9.5px, serta tombol aksi 24x24px.
      - Merapikan kartu "Jadwal Bus Hari Ini (Live Dispatch)": plat nomor tidak membungkus baris (`white-space: nowrap`, 8.5px), nama armada 11px, countdown 9px, rute 10px, dan occupancy 9.5px.
    - **Header**: Ikon kotak biru, judul, subtitle, pill tanggal dinamis bahasa Indonesia, dan tombol "Refresh Data".
    - **4 Statistik Utama (Compact Cards)**: Total Tiket Terjual, Total Pendapatan, Total Perjalanan, dan Total Penumpang dengan icon kecil, angka bold, dan label yang rapi.
    - **Status Tiket & Ringkasan Operasional**: Badge ringkas untuk status tiket (Lunas, Menunggu Pembayaran, Dibatalkan) beserta metrik pendukung.
    - **Grafik Penjualan**: Grafik garis minimalis modern (Chart.js) dengan filter periode interaktif (Harian, Mingguan, Bulanan) dan area gradient halus.
    - **Pesanan Terbaru (Maksimal 5 data)**: Tabel bersih dengan kolom Kode Booking, Nama Penumpang, Rute & Operator, Tanggal/Waktu, Status pill, dan tombol aksi detail.
    - **Jadwal Bus Hari Ini (Live Dispatch)**: Kartu armada bus dengan badge inisial operator, nomor bus & plat, countdown waktu keberangkatan, rute, bar progress keterisian kursi, dan status boarding.
    - **Penyesuaian Skala Tipografi & Keselarasan Komponen**: Merapikan ukuran font di seluruh aplikasi (base 12px, heading 14-16px, table 11px), merampingkan navbar (tinggi 52px), memperkecil lebar sidebar (220px) dengan logo anti-clipping dan submenu yang rapi, menghilangkan bar vertikal ganda Stisla pada menu aktif, serta merapikan header & search bar agar proporsional, compact, dan konsisten di seluruh halaman.
    - **Responsif**: Layout grid adaptif pada desktop, tablet, dan mobile tanpa menyebabkan horizontal scroll pada body.
- **Penyelarasan & Konsistensi Total Desain UI/UX Seluruh Halaman BusTicket**:
  - Menstandarkan seluruh halaman aplikasi dengan prinsip *clean, minimalist, and focused on core information* menggunakan palet utama konsisten (`#006194`), Google Fonts (*Plus Jakarta Sans* / *Inter*), radius seragam (`rounded-2xl` kartu utama, `rounded-xl` elemen interaktif), dan visual hierarchy yang tegas.
  - [`resources/views/layouts/landing/topbar.blade.php`](resources/views/layouts/landing/topbar.blade.php): Menambahkan drawer menu mobile responsif dengan hamburger toggle, link navigasi bersih, dan indikator status akun.
  - [`resources/views/pages/auth/login.blade.php`](resources/views/pages/auth/login.blade.php) & [`resources/views/pages/auth/register.blade.php`](resources/views/pages/auth/register.blade.php): Menghilangkan dekorasi latar belakang berat (blur balls, radial gradient berlebihan) menjadi kartu form elegan terpusat, field input seragam, pesan validasi ringkas, dan quick credentials helper yang rapi.
  - [`resources/views/pages/tiket/search.blade.php`](resources/views/pages/tiket/search.blade.php): Menyelaraskan tampilan kartu armada bus dengan informasi inti (nama bus, kelas, rute, jam, sisa kursi, harga, tombol "Pilih Kursi"), menghilangkan ketidakkonsistenan badge/button khusus pada item pertama, serta menyederhanakan sidebar filter pencarian.
  - [`resources/views/pages/tiket/kursi.blade.php`](resources/views/pages/tiket/kursi.blade.php): Menghilangkan nesting berlebihan (card-in-card) pada ringkasan pemilihan kursi, menghapus penambahan biaya admin statis palsu pada UI kalkulasi kursi agar 100% konsisten dengan perhitungan backend (`jumlah * harga_unit`), serta menyelaraskan badge kursi (`bg-amber-50 text-amber-700`).
  - [`resources/views/pages/booking/form.blade.php`](resources/views/pages/booking/form.blade.php): Merapikan form data pemesan & penumpang, menyelaraskan breakdown ringkasan pesanan dengan formula harga riil, serta tombol lanjut bergaya primary terpadu.
  - [`resources/views/pages/booking/payment.blade.php`](resources/views/pages/booking/payment.blade.php): Menggantikan 3 banner bertumpuk dengan ribbon rute ringkas terpadu, countdown timer terintegrasi, kalkulasi harga riil, dan tombol bayar Midtrans yang tegas.
  - [`resources/views/pages/booking/detail.blade.php`](resources/views/pages/booking/detail.blade.php) & [`resources/views/pages/booking/ticket.blade.php`](resources/views/pages/booking/ticket.blade.php): Menyelaraskan kartu status pemesanan, badge nomor kursi, alur tombol aksi (Cetak Tiket, Kirim WhatsApp), serta format cetak yang rapi.
  - [`resources/views/layouts/user/app.blade.php`](resources/views/layouts/user/app.blade.php): Mengintegrasikan customer layout ke design system modern Tailwind dengan sub-navigasi tab terpadu (Dashboard, Booking Saya, Tiket Saya, Profil Saya) menggantikan template legacy Stisla.
  - [`resources/views/pages/customer/dashboard.blade.php`](resources/views/pages/customer/dashboard.blade.php): Desain ulang customer dashboard dengan sambutan gradient modern, 3 kartu ringkasan metrik statistik, dan tabel riwayat pemesanan terkini.
  - [`resources/views/pages/customer/bookings.blade.php`](resources/views/pages/customer/bookings.blade.php): Desain ulang daftar booking dengan pill filter status (Semua, Pending, Confirmed, Completed, Batal), tabel riwayat responsif, lencana status pembayaran & booking yang jelas, serta tombol aksi konsisten.
  - [`resources/views/pages/customer/tickets.blade.php`](resources/views/pages/customer/tickets.blade.php): Desain ulang daftar e-tiket aktif dengan kartu boarding pass modern, garis visual rute, lencana kursi terpilih, dan tautan langsung ke e-tiket resmi.
  - [`resources/views/pages/customer/profile.blade.php`](resources/views/pages/customer/profile.blade.php): Desain ulang formulir profil pengguna & ubah kata sandi dengan kontrol input yang seragam, status akun customer yang jelas, dan penanganan feedback validasi.
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
