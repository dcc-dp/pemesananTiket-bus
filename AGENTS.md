# AGENTS.md

Laravel 10 (PHP 8.1) bus-ticket booking app built on the Stisla admin template. In transitional state: the bus domain (Bus, Penumpang, Terminal, Rute, Supir, Kursi, Jadwal, Tiket) is new, while a lot of legacy scaffolding from a prior Kemenkumham UMKM/agenda app is still present.

## Setup & commands

- `composer install` → `npm install` → `npx mix` → `cp .env.example .env` → `php artisan key:generate` → `php artisan migrate --seed` → `php artisan serve`
- `npx mix` (laravel-mix, `webpack.mix.js`) is the real asset pipeline: it copies `node_modules/*` into `public/library/` which layouts reference via `asset('library/...')`. `public/library/` is committed.
- Vite config (`vite.config.js`) exists but is NOT wired into any layout (no `@vite` directives). Ignore `npm run dev`/`build`.
- DB is MySQL (`DB_DATABASE=malam_rabu`), and `phpunit.xml` also targets MySQL (sqlite is commented out) — feature tests hit the real DB.
- Formatter: `vendor/bin/pint`. Only default `ExampleTest` fixtures exist in `tests/`.

## Auth

Custom session-based auth, not Laravel Breeze/Jetstream. `AuthController` checks `Admin` AND `User` models by `username` + `role`, then sets `Session('cek')`. The `ValidasiUser` middleware alias guards all admin routes by checking that session flag. Seeded default admin: `admin` / `admin`.

## Gotchas

- Model files use lowercase names while classes are properly cased (e.g. `app/Models/bus.php` defines `class Bus`, `tiket.php` defines `class Tiket`). Works on case-insensitive filesystems (Windows/macOS) but PSR-4 autoloading breaks on Linux/CI. Don't "fix" the casing without confirming the OS/CI.
- Schema drift exists: `Tiket` model declares `protected $table = 'tickets'` but the migration creates `tikets`; its `$fillable` also lists `nama_pemesan`/`no_hp_pemesan` which the migration doesn't define.
- Several routes in `routes/web.php` reference controllers that don't exist and will 500: `KegiatanController`, `IndicatorsController`, `PenilaianController`, `GuruController`, `AbsensiController`. Verify the controller exists before relying on a route.
- `config/midtrans.php` reads `MIDTRANS_CLIENT_KEY`, `MIDTRANS_SERVER_KEY`, `MIDTRANS_IS_PRODUCTION` — these are absent from `.env.example`.

## Conventions

- Routes use string controller syntax (`'BusController@index'`) inside `Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => 'ValidasiUser'])` — match this style for new admin routes. A few routes mix in `[Controller::class, 'method']` array syntax.
- Admin CRUD pattern: views in `resources/views/pages/admin/<Feature>/{index,create,edit}.blade.php`; controllers pass `compact('datas', 'menu')` with a `private $menu` property; forms post to `store`/`update` routes, deletes via `POST /hapus/{id}` (not DELETE).
- Models use custom primary keys (`id_bus`, `id_tiket`, `id_kursi`, ...); relations must pass the explicit FK/local columns (e.g. `hasMany(Jadwal::class, 'id_bus', 'id_bus')`).
- Layouts: `layouts/app.blade.php` (admin), `layouts/user/app.blade.php`, `layouts/landing/*` (public pages).
