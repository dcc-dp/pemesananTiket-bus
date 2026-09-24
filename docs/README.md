# 📚 DOKUMENTASI RESMI REKAYASA SISTEM PEMESANAN TIKET BUS
### *Katalog Dokumentasi Teknis, Desain Perangkat Lunak, & Petunjuk Pengembangan*

Selamat datang di repositori dokumentasi resmi sistem **Pemesanan Tiket Bus (AKAP / Pariwisata)**. Seluruh dokumen di direktori ini dirancang secara terstruktur untuk tim pengembang, arsitek sistem, manajer produk, QA engineer, dan agen pengembang AI (**Google Antigravity**).

---

## 🗂️ Indeks Dokumen

| No | Dokumen | Berkas | Deskripsi Utama |
|---|---|---|---|
| 1 | **Changelog Resmi Proyek** | [`CHANGELOG.md`](file:///C:/laragon/www/rap/CHANGELOG.md) | Rekam jejak seluruh riwayat rilis, penambahan fitur, perbaikan bug, dan perubahan teknis. |
| 2 | **Product Requirements Document (PRD)** | [`docs/PRD.md`](file:///C:/laragon/www/rap/docs/PRD.md) | Kebutuhan produk, profil pengguna, user stories, acceptance criteria, dan metrik keberhasilan. |
| 3 | **System Architecture Document (SAD)** | [`docs/ARCHITECTURE.md`](file:///C:/laragon/www/rap/docs/ARCHITECTURE.md) | Pola arsitektur (MVC + Service Layer), diagram komponen, mekanisme concurrency locking, dan keamanan. |
| 4 | **Database Specification & Data Dictionary** | [`docs/DATABASE.md`](file:///C:/laragon/www/rap/docs/DATABASE.md) | Diagram ERD lengkap, kamus data seluruh tabel, relasi PK/FK, state machine enum status, dan indeks performa. |
| 5 | **Software Design & Service Layer (SDS)** | [`docs/SOFTWARE_DESIGN.md`](file:///C:/laragon/www/rap/docs/SOFTWARE_DESIGN.md) | Spesifikasi modul kode, kontrak service layer, controller flow, validasi request, dan struktur UI Stisla. |
| 6 | **API Integration & Gateway Specification** | [`docs/API_INTEGRATION.md`](file:///C:/laragon/www/rap/docs/API_INTEGRATION.md) | Spesifikasi webhook Midtrans Snap, keamanan notifikasi IPN, dan cetak biru REST API Mobile (Sanctum). |
| 7 | **Testing & Deployment Runbook** | [`docs/TESTING_AND_DEPLOYMENT.md`](file:///C:/laragon/www/rap/docs/TESTING_AND_DEPLOYMENT.md) | Panduan unit/feature testing, skenario simulasi pembayaran, deployment checklist ke server Linux, dan resolusi gotchas. |
| 8 | **Audit Fitur & Rekomendasi Roadmap** | [`docs/FEATURE_AUDIT_AND_RECOMMENDATIONS.md`](file:///C:/laragon/www/rap/docs/FEATURE_AUDIT_AND_RECOMMENDATIONS.md) | Audit mendalam seluruh skrip eksisting, identifikasi 4 temuan celah teknis/bug, matriks kematangan fitur, dan roadmap prioritas masa depan. |
| 9 | **Development Guide & Antigravity Playbook** | [`DEVELOPMENT.md`](file:///C:/laragon/www/rap/DEVELOPMENT.md) | Panduan cepat harian developer dan resep slash commands Antigravity AI assistant. |

---

## 🧭 Panduan Kontribusi & Rekam Jejak
1. **Pencatatan Changelog (Wajib)**: Setiap penambahan berkas, fitur baru, perbaikan bug, atau perubahan skema database **WAJIB dicatat** di [`CHANGELOG.md`](file:///C:/laragon/www/rap/CHANGELOG.md) pada bagian `[Unreleased]`.
2. **Pemeliharaan Kode & Sinkronisasi Dokumen**: Setiap kali terjadi perubahan skema basis data (`database/migrations`), relasi model, atau penambahan endpoint baru, pengembang wajib memperbarui [`docs/DATABASE.md`](file:///C:/laragon/www/rap/docs/DATABASE.md) dan [`docs/ARCHITECTURE.md`](file:///C:/laragon/www/rap/docs/ARCHITECTURE.md).
3. **Format Dokumen**: Seluruh dokumen menggunakan format GitHub Flavored Markdown dilengkapi diagram visual **Mermaid**.
4. **Penggunaan bersama Google Antigravity**: Agen Antigravity menggunakan referensi dokumen ini bersama [`AGENTS.md`](file:///C:/laragon/www/rap/AGENTS.md) sebagai basis pengetahuan saat merancang dan mengimplementasikan fitur baru.
