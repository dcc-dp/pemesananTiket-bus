# AGENTS.md

Laravel 10 (PHP 8.1) bus-ticket booking app built on the Stisla admin template. Full domain: Operator, Bus, Kursi, Terminal, Rute, Jadwal, Booking, BookingSeat, Payment, User. Refer to `DEVELOPMENT.md` for full architectural guide and roadmaps.

## Changelog Policy (MANDATORY)

- **Setiap kali melakukan perubahan kode, skema basis data, konfigurasi, atau dokumentasi, Anda WAJIB mencatat perubahan tersebut di file `CHANGELOG.md` pada bagian `[Unreleased]` dengan kategori yang sesuai (`Added`, `Changed`, `Fixed`, `Removed`, `Security`).**

## Setup & Commands

- `composer install` → `npm install` → `npx mix` → `cp .env.example .env` → `php artisan key:generate` → `php artisan migrate --seed` → `php artisan serve`
- `npx mix` (laravel-mix, `webpack.mix.js`) is the real asset pipeline: it copies `node_modules/*` into `public/library/` which layouts reference via `asset('library/...')`. `public/library/` is committed.
- Vite config (`vite.config.js`) exists but is NOT wired into any layout (no `@vite` directives). Ignore `npm run dev`/`build`.
- DB is MySQL (`DB_DATABASE=malam_rabu`), and `phpunit.xml` targets MySQL — feature tests hit the database with `DatabaseTransactions`.
- Test command: `php artisan test` or `php artisan test --filter BookingFlowTest`.
- Formatter: `vendor/bin/pint`.

## Architecture & Service Layer

- Business logic resides in `app/Services/`:
  - `BookingService`: atomic seat reservation, `DB::transaction()` + `lockForUpdate()`, booking code generation (`BUS-YYYYMMDD-XXXXXX`), seat availability checks.
  - `PaymentService`: Midtrans Snap SDK integration, webhook verification, amount matching, status resolution, manual cash confirmation.
  - `TicketService`: E-ticket data compilation and dynamic SVG QR code generation (`simplesoftwareio/simple-qrcode`).

## Auth & Roles

Custom session-based auth (not Laravel Breeze/Jetstream/Bcrypt default guard). `AuthController` checks `User` model by username/email + `password`, then sets:
- `Session::put('user_id', $user->id)`
- `Session::put('role', $user->role)` (`admin` or `customer`)
- `Session::put('cek', true)`
Guarded via middleware `ValidasiUser` and `CheckRole:admin` / `CheckRole:customer`.
Default seeded credentials:
- Admin: `admin` / `password` (email: `admin@busticket.test`)
- Customer: `customer` / `password` (email: `customer@busticket.test`)

## Gotchas & Known Drifts

- **Column `kelas` in `buses`**: The migration `2026_07_18_232021_create_buses_table.php` has `$table->enum('kelas', ...)` commented out, while `BusController`, `Bus` model `$fillable`, and `BusFactory` require it. Any insert to `buses` without that column causes SQL error 1054.
- **Model filenames case-sensitivity**: Files `bus.php`, `kursi.php`, `rute.php`, `terminal.php` use lowercase filenames on disk while defining PascalCase classes (`Bus`, `Kursi`, etc.). Works on Windows/Laragon, but breaks PSR-4 autoloading on Linux/Docker/CI. Keep PascalCase convention when creating new models.
- **Primary key names**: Models use custom PKs (`id_bus`, `id_terminal`, `id_rute`, `id_kursi`, `id_jadwal`) while `User`, `Booking`, `BookingSeat`, `Payment`, `Operator` use `id`. Always pass explicit FK and PK parameters to Eloquent relationship methods.
- **Payment Webhook**: Endpoint `/payment/callback` is exempt from CSRF in `VerifyCsrfToken.php`.
- **Environment variables**: `config/midtrans.php` expects `MIDTRANS_CLIENT_KEY`, `MIDTRANS_SERVER_KEY`, and `MIDTRANS_IS_PRODUCTION` in `.env`.

## Conventions

- Routes use callable syntax (`[Controller::class, 'method']`) with named routes (`admin.*`, `customer.*`, `tiket.*`, `booking.*`).
- Admin CRUD views: `resources/views/pages/admin/<Feature>/{index,create,edit}.blade.php`.
- Controllers pass `compact('datas', 'menu')` with a `private $menu` property.
- Forms post to `store`/`update` routes; deletes use `POST /hapus/{id}` (or DELETE).
- Layouts: `layouts/app.blade.php` (admin), `layouts/user/app.blade.php`, `layouts/landing/*` (public pages).
