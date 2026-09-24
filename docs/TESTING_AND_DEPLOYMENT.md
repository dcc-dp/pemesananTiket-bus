# 🧪 TESTING & DEPLOYMENT RUNBOOK
## Panduan Pengujian Otomatis & Prosedur Deployment Produksi

---

## 1. Arsitektur Pengujian (Testing Suite)

Proyek ini telah dilengkapi dengan rangkaian pengujian fitur terintegrasi (**Feature Tests**) yang mensimulasikan skenario end-to-end pengguna nyata dan validasi aturan bisnis kritis.

### 1.1. Bedah Skenario Pengujian pada `BookingFlowTest.php`
Pengujian berlokasi di [`tests/Feature/BookingFlowTest.php`](file:///C:/laragon/www/rap/tests/Feature/BookingFlowTest.php) dan menggunakan trait `DatabaseTransactions` sehingga tidak mengotori database operasional Anda:

| Kasus Uji | Skenario yang Diuji | Verifikasi Asersi |
|---|---|---|
| `test_guest_redirected_to_login_when_booking` | Pengunjung yang belum login mencoba melakukan booking kursi. | Di-redirect ke halaman `/auth/login`. |
| `test_customer_can_create_booking` | Customer yang terautentikasi membuat pesanan dengan data penumpang lengkap. | Record booking terbuat dengan status `pending`, harga sesuai, dan kursi teralokasi. |
| `test_double_booking_same_seat_is_rejected` | Dua permintaan mencoba memesan kursi yang sama pada jadwal yang sama. | Permintaan kedua ditolak dan hanya 1 pesanan yang tersimpan di basis data (Anti-Race Condition). |
| `test_customer_cannot_view_other_users_booking` | Customer A mencoba membuka URL detail booking / tiket milik Customer B. | Akses ditolak dengan HTTP 403 Forbidden (Anti-IDOR). |
| `test_ticket_not_available_before_payment` | Customer mencoba mengakses e-tiket sebelum melakukan pembayaran. | Di-redirect kembali dengan status belum lunas. |
| `test_admin_can_confirm_payment_and_ticket_becomes_available` | Admin loket mengonfirmasi pembayaran tunai (`cash`) dan tiket langsung aktif untuk customer. | Status berubah menjadi `paid` & `confirmed`, dan e-tiket dapat diakses (HTTP 200 OK). |

### 1.2. Menjalankan Pengujian
```bash
# Menjalankan seluruh test suite
php artisan test

# Menjalankan spesifik test flow booking
php artisan test --filter BookingFlowTest
```

> [!WARNING]
> **Penyebab Gagal Uji Saat Ini & Solusinya**:
> Saat ini `BookingFlowTest` gagal karena kolom `kelas` pada tabel `buses` tidak ditemukan (`SQLSTATE[42S22]: Column not found: 1054 Unknown column 'kelas'`).
> **Solusi**: Aktifkan kembali baris migrasi `kelas` di `database/migrations/2026_07_18_232021_create_buses_table.php` atau jalankan migrasi penambahan kolom:
> ```bash
> php artisan make:migration add_kelas_to_buses_table --table=buses
> ```

---

## 2. Pengujian Integrasi Gateway (Midtrans Sandbox di Localhost)

Untuk menguji alur webhook pembayaran tanpa deploy ke internet:

1. **Jalankan Aplikasi Lokal**:
   ```bash
   php artisan serve --port=8000
   ```
2. **Buka Tunneling via Ngrok**:
   ```bash
   ngrok http 8000
   ```
   Salin URL forwarding HTTPS publik, misalnya: `https://abcd-1234.ngrok-free.app`.
3. **Konfigurasi Notifikasi di Midtrans**:
   - Masuk ke [Dashboard Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/).
   - Buka menu **Settings > Configuration**.
   - Isi **Payment Notification URL** dengan: `https://abcd-1234.ngrok-free.app/payment/callback`.
4. **Simulasi Transaksi**:
   - Buka aplikasi lokal, lakukan pemesanan kursi hingga masuk ke halaman pembayaran.
   - Pilih metode bayar (misal BCA Virtual Account).
   - Salin nomor VA test ke [Midtrans Simulator](https://simulator.sandbox.midtrans.com/bca/va/index).
   - Lakukan simulasi pembayaran berhasil. Dalam hitungan detik, webhook akan memanggil endpoint lokal Anda dan status pesanan otomatis berubah menjadi `paid`.

---

## 3. Prosedur Deployment ke Server Produksi (Linux Ubuntu / Nginx)

Berikut *checklist* langkah-demi-langkah saat merilis aplikasi ke server VPS / Cloud Linux:

### 3.1. Kebutuhan Server (Prerequisites)
- OS: Ubuntu 22.04 LTS / Debian 11+
- PHP 8.1 atau 8.2 (ekstensi: `php-fpm`, `php-mysql`, `php-xml`, `php-mbstring`, `php-curl`, `php-zip`, `php-gd`, `php-bcmath`)
- Web Server: Nginx
- DBMS: MySQL 8.0+ / MariaDB 10.6+
- Composer 2.x & Node.js 18+

### 3.2. Penanganan Case-Sensitivity Model (Wajib di Linux)
Ubah nama berkas model pada direktori `app/Models/` menjadi **PascalCase**:
```bash
git mv app/Models/bus.php app/Models/Bus.php
git mv app/Models/kursi.php app/Models/Kursi.php
git mv app/Models/rute.php app/Models/Rute.php
git mv app/Models/terminal.php app/Models/Terminal.php
```

### 3.3. Instalasi & Kompilasi Aset di Server
```bash
# 1. Clone repository
cd /var/www/
git clone https://github.com/dcc-dp/pemesananTiket-bus.git bus-ticket
cd bus-ticket

# 2. Setup dependensi PHP
composer install --no-dev --optimize-autoloader

# 3. Setup file konfigurasi produksi
cp .env.example .env
nano .env
# Set APP_ENV=production, APP_DEBUG=false, DB credentials, dan Midtrans Production Keys

# 4. Generate Application Key
php artisan key:generate

# 5. Jalankan migrasi database
php artisan migrate --force

# 6. Kompilasi aset frontend via Laravel Mix
npm install --omit=dev
npx mix --production

# 7. Optimasi performa Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3.4. Hak Akses Direktori (Permissions)
```bash
chown -R www-data:www-data /var/www/bus-ticket
chmod -R 775 /var/www/bus-ticket/storage /var/www/bus-ticket/bootstrap/cache
```

### 3.5. Konfigurasi Nginx Virtual Host
```nginx
server {
    listen 80;
    server_name tiketbus.example.com;
    root /var/www/bus-ticket/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 3.6. Konfigurasi Cron Job (Laravel Task Scheduler)
Buka crontab dengan `crontab -e -u www-data` dan tambahkan baris berikut:
```bash
* * * * * cd /var/www/bus-ticket && php artisan schedule:run >> /dev/null 2>&1
```
Cron ini penting untuk menjalankan pembersihan booking kedaluwarsa secara terjadwal.
