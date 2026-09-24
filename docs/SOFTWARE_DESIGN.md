# 💻 SOFTWARE DESIGN SPECIFICATION (SDS)
## Desain Perangkat Lunak, Pola Kode, & Service Layer

---

## 1. Pola Desain (Design Patterns Applied)

Aplikasi dibangun dengan mematuhi prinsip-prinsip desain berorientasi objek (OOP) dan *Clean Architecture* sederhana:

1. **Service Layer Pattern**:
   - Memisahkan Controller (yang hanya bertindak sebagai orkestrator HTTP) dari logika bisnis domain murni.
   - Seluruh logika kompleks terisolasi di [`app/Services/`](file:///C:/laragon/www/rap/app/Services/).
2. **Active Record Pattern**:
   - Disediakan oleh Laravel Eloquent ORM. Tiap kelas model memetakan satu tabel database lengkap dengan relasi, scopes, dan mutators.
3. **Pipeline / Middleware Pattern**:
   - Memfilter request HTTP sebelum mencapai controller untuk memastikan autentikasi sesi dan kecocokan peran (*Role-Based Access Control*).
4. **Template Method & Layout Inheritance Pattern**:
   - Menggunakan Blade templating engine (`@extends`, `@section`, `@include`) untuk membungkus antarmuka admin Stisla secara konsisten.

---

## 2. Spesifikasi Layanan Inti (Service Layer Contracts)

### 2.1. `App\Services\BookingService`
Bertanggung jawab atas ketersediaan kursi, pembuatan pesanan atomic, dan penguncian concurrency.

```php
namespace App\Services;

class BookingService
{
    /**
     * Mengambil daftar kursi yang belum dipesan pada jadwal tertentu.
     */
    public function getAvailableSeats(Jadwal $jadwal): \Illuminate\Support\Collection;

    /**
     * Mengambil daftar kursi yang sudah dipesan (status pending/confirmed/completed).
     */
    public function getUnavailableSeats(Jadwal $jadwal): \Illuminate\Support\Collection;

    /**
     * Memeriksa apakah satu kursi tertentu dapat dipesan pada jadwal tersebut.
     */
    public function isSeatAvailable(Jadwal $jadwal, Kursi $kursi): bool;

    /**
     * Menghasilkan kode booking acak yang unik.
     * Format: BUS-YYYYMMDD-XXXXXX (misal: BUS-20260923-A7K92M)
     */
    public function generateKodeBooking(): string;

    /**
     * Membuat record booking dan alokasi kursi beserta data penumpang.
     * Menggunakan DB::transaction() dan lockForUpdate() untuk mencegah double booking.
     * 
     * @param User $user
     * @param Jadwal $jadwal
     * @param array $passengers [{id_kursi, nama_penumpang, nik, no_hp, jenis_kelamin, tanggal_lahir}]
     * @return Booking
     * @throws \Exception Jika jadwal/kursi tidak valid atau sudah dipesan
     */
    public function createBooking(User $user, Jadwal $jadwal, array $passengers): Booking;

    /**
     * Memperbarui status booking beserta seluruh relasi booking_seats-nya.
     * 
     * @param Booking $booking
     * @param string $status 'pending'|'confirmed'|'completed'|'cancelled'|'expired'
     */
    public function updateBookingStatus(Booking $booking, string $status): void;
}
```

### 2.2. `App\Services\PaymentService`
Bertanggung jawab atas interaksi dengan SDK Midtrans Snap, rekonsiliasi status, dan konfirmasi tunai loket.

```php
namespace App\Services;

class PaymentService
{
    /**
     * Memeriksa apakah server key dan client key Midtrans telah terisi di .env.
     */
    public function isConfigured(): bool;

    /**
     * Membuat record Payment dan merequest Snap Token dari Midtrans API.
     * 
     * @return array{snap_token?: string, payment: Payment}
     */
    public function createPayment(Booking $booking): array;

    /**
     * Memproses asynchronous webhook IPN callback dari Midtrans.
     * Mencocokkan nominal gross_amount dan memperbarui status pesanan secara otomatis.
     */
    public function handleNotification(): void;

    /**
     * Konfirmasi pembayaran tunai secara manual oleh staf admin loket terminal.
     * 
     * @param Booking $booking
     * @param string $method default 'cash'
     */
    public function confirmManually(Booking $booking, string $method = 'cash'): void;

    /**
     * Melakukan polling aktif status transaksi ke Midtrans Transaction Status API.
     */
    public function checkStatus(Booking $booking): void;
}
```

### 2.3. `App\Services\TicketService`
Bertanggung jawab menyusun struktur data e-tiket dan merender QR Code dinamis.

```php
namespace App\Services;

class TicketService
{
    /**
     * Mengompilasi data ringkasan e-tiket dari relasi jadwal, rute, bus, dan penumpang.
     * 
     * @return array{
     *   kode_booking: string,
     *   status: string,
     *   operator: string,
     *   bus: string,
     *   nomor_polisi: string,
     *   kelas: string,
     *   fasilitas: string,
     *   asal: string,
     *   tujuan: string,
     *   tanggal: Carbon,
     *   jam_berangkat: Carbon,
     *   total_harga: int,
     *   booking_seats: array
     * }
     */
    public function getTicketData(Booking $booking): array;

    /**
     * Menghasilkan string Data URI SVG QR Code berdasarkan kode booking.
     * Format: 'data:image/svg+xml;base64,...'
     */
    public function qrCode(Booking $booking, int $size = 160): string;
}
```

---

## 3. Spesifikasi Controller & Flow Request

### 3.1. `BookingController`
- `passengerForm($id, Request $request)`:
  - Validasi query parameter `seats` (array ID kursi).
  - Memverifikasi apakah kursi milik bus pada jadwal terkait.
  - Memeriksa ketersediaan via `BookingService::isSeatAvailable()`.
  - Merender view [`pages.booking.form`](file:///C:/laragon/www/rap/resources/views/pages/booking/form.blade.php).
- `store(Request $request)`:
  - Validasi input payload formulir penumpang:
    ```php
    $request->validate([
        'id_jadwal' => 'required|exists:jadwals,id_jadwal',
        'penumpang' => 'required|array|min:1|max:5',
        'penumpang.*.id_kursi' => 'required|exists:kursis,id_kursi',
        'penumpang.*.nama' => 'required|string|max:150',
        'penumpang.*.nik' => 'required|digits:16',
        'penumpang.*.no_hp' => 'required|string|max:30',
        'penumpang.*.jenis_kelamin' => 'required|in:L,P',
        'penumpang.*.tanggal_lahir' => 'required|date|before:today',
    ]);
    ```
  - Memanggil `BookingService::createBooking()`.
  - Redirect ke `customer.booking.detail`.
- `pay(Booking $booking)`:
  - Proteksi IDOR via `authorizeOwnership($booking)`.
  - Sinkronisasi status via `PaymentService::checkStatus($booking)`.
  - Memanggil `PaymentService::createPayment($booking)` untuk memperoleh `snapToken`.
  - Merender view [`pages.booking.payment`](file:///C:/laragon/www/rap/resources/views/pages/booking/payment.blade.php).
- `callback()`:
  - Endpoint bebas CSRF untuk menerima notifikasi IPN Midtrans.
  - Memanggil `PaymentService::handleNotification()` dan merespons JSON `['status' => 'ok']`.

### 3.2. `TicketController`
- `search(Request $request)`:
  - Menerima filter `terminal_asal`, `terminal_tujuan`, dan `tanggal`.
  - Melakukan query jadwal aktif yang memiliki rute dan tanggal cocok.
- `seats(Jadwal $jadwal)`:
  - Membaca layout denah kursi bus dari jadwal.
  - Mengambil daftar kursi terpesan via `$jadwal->kursiTerpesan()`.
  - Mengirimkan data kursi ke Blade view denah kursi interaktif.

### 3.3. `RuteController`
- `calculateDistance(Request $request)`:
  - Menerima `terminal_asal_id` dan `terminal_tujuan_id`.
  - Menghitung jarak garis lurus / jarak jalan dan estimasi durasi otomatis berdasarkan koordinat latitude & longitude kedua terminal.
  - Mengembalikan JSON `{jarak: float, durasi: int}` untuk mengisi field form admin secara dinamis.

---

## 4. Arsitektur Antarmuka (Front-End & Blade Structure)

Aplikasi memiliki 3 hierarki layout utama:

```
resources/views/layouts/
├── app.blade.php              # Layout Admin (Stisla Admin Dashboard)
│   ├── components/            # Header, Sidebar navigasi master & transaksi
│   └── footer.blade.php
├── user/
│   └── app.blade.php          # Layout Area Customer Terautentikasi
└── landing/
    ├── app.blade.php          # Layout Pengunjung Publik
    └── navbar.blade.php       # Navigasi publik (Cari Tiket, Cek Pesanan, Login)
```

### Visualisasi Denah Kursi (Interactive Seat Layout)
- Denah bus dirender dalam grid berbasis kolom A-B (kiri/jendela-lorong) dan C-D (kanan/lorong-jendela).
- Status kursi diwakili oleh CSS class:
  - `.seat-available` (Hijau / Biru): Kursi dapat diklik untuk dipilih.
  - `.seat-selected` (Kuning / Oranye): Kursi yang sedang dipilih oleh pengguna saat ini.
  - `.seat-booked` (Abu-abu / Merah Disabled): Kursi yang telah dipesan oleh orang lain.
- Interaktivitas diatur melalui JavaScript/jQuery yang memperbarui input tersembunyi `seats[]` sebelum formulir disubmit ke backend.
