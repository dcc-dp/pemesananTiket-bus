# 🌐 API & GATEWAY INTEGRATION SPECIFICATION
## Spesifikasi Integrasi Payment Gateway & Cetak Biru REST API Mobile

---

## 1. Integrasi Payment Gateway (Midtrans Snap)

Sistem menggunakan **Midtrans Snap PHP SDK** (`midtrans/midtrans-php`) untuk memproses pembayaran digital multi-kanal.

### 1.1. Konfigurasi Lingkungan (`.env`)
```env
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```
Konfigurasi ini dibaca melalui file [`config/midtrans.php`](file:///C:/laragon/www/rap/config/midtrans.php).

### 1.2. Alur Permintaan Token Snap (Snap Token Request)
Saat pengguna mengakses halaman bayar, [`PaymentService::createPayment()`](file:///C:/laragon/www/rap/app/Services/PaymentService.php#L37) menyusun parameter payload berikut:

```json
{
  "transaction_details": {
    "order_id": "MID-BUS-20260923-ABC123",
    "gross_amount": 250000
  },
  "customer_details": {
    "first_name": "Budi Santoso",
    "email": "budi@example.com",
    "phone": "081234567890"
  },
  "item_details": [
    {
      "id": "KURSI-15",
      "price": 125000,
      "quantity": 1,
      "name": "Tiket Bus 1A"
    },
    {
      "id": "KURSI-16",
      "price": 125000,
      "quantity": 1,
      "name": "Tiket Bus 1B"
    }
  ],
  "callbacks": {
    "finish": "http://localhost:8000/booking/10"
  }
}
```

Token yang dikembalikan oleh Midtrans Snap (`Snap::getSnapToken($params)`) diteruskan ke Blade view untuk memicu modal pembayaran popup:
```javascript
window.snap.pay(snapToken, {
    onSuccess: function(result){ window.location.reload(); },
    onPending: function(result){ window.location.reload(); },
    onError: function(result){ alert('Pembayaran gagal'); }
});
```

---

## 2. Spesifikasi Webhook IPN (Instant Payment Notification)

### 2.1. Endpoint Kontrak
- **URL**: `POST /payment/callback`
- **Controller**: [`BookingController@callback`](file:///C:/laragon/www/rap/app/Http/Controllers/BookingController.php#L136)
- **Service Handler**: [`PaymentService@handleNotification`](file:///C:/laragon/www/rap/app/Services/PaymentService.php#L109)
- **CSRF Protection**: Dikecualikan pada [`VerifyCsrfToken.php`](file:///C:/laragon/www/rap/app/Http/Middleware/VerifyCsrfToken.php).

### 2.2. Contoh Payload Notifikasi dari Midtrans
```json
{
  "transaction_time": "2026-09-23 19:40:00",
  "transaction_status": "settlement",
  "transaction_id": "9a1843b2-6548-4e89-a5c2-f1d7a9b0c1e3",
  "status_message": "midtrans payment notification",
  "status_code": "200",
  "signature_key": "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855",
  "payment_type": "qris",
  "order_id": "MID-BUS-20260923-ABC123",
  "gross_amount": "250000.00",
  "fraud_status": "accept",
  "currency": "IDR"
}
```

### 2.3. Matriks Resolusi Status Pembayaran

| Status Notifikasi Midtrans | Fraud Status | Status Pembayaran Sistem | Status Booking Sistem | Keterangan |
|---|---|---|---|---|
| `capture` | `accept` | `paid` | `confirmed` | Pembayaran kartu kredit berhasil dan aman |
| `capture` | `challenge` | `pending` | `pending` | Perlu review manual di dashboard Midtrans |
| `settlement` | - | `paid` | `confirmed` | Pembayaran berhasil lunas (QRIS, VA, E-Wallet) |
| `pending` | - | `pending` | `pending` | Menunggu transfer pengguna |
| `deny` / `cancel` | - | `failed` | `cancelled` | Transaksi ditolak atau dibatalkan pengguna |
| `expire` | - | `failed` | `cancelled` | Batas waktu bayar terlewati |

---

## 3. Cetak Biru REST API Mobile (Future Roadmap - Laravel Sanctum)

Berikut arsitektur endpoint RESTful API yang dirancang untuk mendukung aplikasi mobile (Flutter / React Native) di masa depan:

### 3.1. Autentikasi Pengguna
- `POST /api/v1/auth/register`
  - Input: `name`, `username`, `email`, `phone`, `password`, `password_confirmation`
  - Output: Token bearer Sanctum & data pengguna.
- `POST /api/v1/auth/login`
  - Input: `identity` (email/username), `password`
  - Output: Token bearer Sanctum.
- `GET /api/v1/auth/me` [Protected: `auth:sanctum`]
  - Output: Profil pengguna aktif.

### 3.2. Pencarian & Jadwal
- `GET /api/v1/terminals`
  - Output: Daftar terminal aktif (ID, nama, kota, provinsi, latitude, longitude).
- `GET /api/v1/schedules/search`
  - Query Params: `origin_terminal_id`, `destination_terminal_id`, `date`
  - Output: Array jadwal bus beserta detail armada, kelas, fasilitas, harga, dan sisa kursi.
- `GET /api/v1/schedules/{id}/seats`
  - Output: Denah kursi bus (nomor kursi, kelas, status ketersediaan: `available` / `booked`).

### 3.3. Transaksi Reservasi & E-Tiket
- `POST /api/v1/bookings` [Protected: `auth:sanctum`]
  - Input: `id_jadwal`, array `passengers` (`id_kursi`, `nama`, `nik`, `no_hp`, `jenis_kelamin`, `tanggal_lahir`)
  - Output: Data pesanan, total harga, kode booking, dan Snap Token pembayaran.
- `GET /api/v1/bookings` [Protected: `auth:sanctum`]
  - Output: Riwayat seluruh pesanan customer aktif.
- `GET /api/v1/bookings/{id}` [Protected: `auth:sanctum`]
  - Output: Rincian pesanan, status pembayaran, dan data penumpang.
- `GET /api/v1/bookings/{id}/ticket` [Protected: `auth:sanctum`]
  - Output: Data e-tiket lengkap dengan QR Code string untuk ditampilkan di layar mobile.
