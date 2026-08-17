<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KursiController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===================== PUBLIC =====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pencarian tiket
Route::get('/tiket', [TicketController::class, 'search'])->name('tiket.search.form');
Route::get('/tiket/search', [TicketController::class, 'search'])->name('tiket.search');

// ===================== AUTH =====================
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login_action'])->name('login_action');
    Route::post('/register', [AuthController::class, 'register_action'])->name('register_action');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Callback pembayaran (Midtrans) - tanpa CSRF
Route::post('/payment/callback', [BookingController::class, 'callback'])->name('payment.callback');

// ===================== CUSTOMER =====================
Route::group(['middleware' => ['ValidasiUser', 'CheckRole:customer']], function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    // Pemilihan kursi & booking
    Route::get('/tiket/{jadwal}/kursi', [TicketController::class, 'seats'])->name('tiket.seats');
    Route::get('/booking/{jadwal}/form', [BookingController::class, 'passengerForm'])->name('booking.form');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

    Route::get('/booking/{booking}', [BookingController::class, 'detail'])->name('customer.booking.detail');
    Route::get('/booking/{booking}/bayar', [BookingController::class, 'pay'])->name('customer.booking.pay');
    Route::get('/booking/{booking}/tiket', [BookingController::class, 'ticket'])->name('customer.booking.ticket');

    Route::get('/customer/bookings', [CustomerController::class, 'bookings'])->name('customer.bookings');
    Route::get('/customer/tickets', [CustomerController::class, 'tickets'])->name('customer.tickets');
    Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::post('/customer/profile/update', [CustomerController::class, 'profileUpdate'])->name('customer.profile.update');
});

// ===================== ADMIN =====================
Route::group(['prefix' => 'admin', 'middleware' => ['ValidasiUser', 'CheckRole:admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Master Data
    Route::prefix('operators')->group(function () {
        Route::get('/', [OperatorController::class, 'index'])->name('admin.operator.index');
        Route::get('/create', [OperatorController::class, 'create'])->name('admin.operator.create');
        Route::post('/store', [OperatorController::class, 'store'])->name('admin.operator.store');
        Route::get('/edit/{operator}', [OperatorController::class, 'edit'])->name('admin.operator.edit');
        Route::put('/update/{operator}', [OperatorController::class, 'update'])->name('admin.operator.update');
        Route::post('/hapus/{operator}', [OperatorController::class, 'destroy'])->name('admin.operator.destroy');
    });

    Route::prefix('buses')->group(function () {
        Route::get('/', [BusController::class, 'index'])->name('admin.bus.index');
        Route::get('/create', [BusController::class, 'create'])->name('admin.bus.create');
        Route::post('/store', [BusController::class, 'store'])->name('admin.bus.store');
        Route::get('/edit/{bus}', [BusController::class, 'edit'])->name('admin.bus.edit');
        Route::put('/update/{bus}', [BusController::class, 'update'])->name('admin.bus.update');
        Route::post('/hapus/{bus}', [BusController::class, 'destroy'])->name('admin.bus.destroy');
    });

    Route::prefix('kursi')->group(function () {
        Route::get('/', [KursiController::class, 'index'])->name('admin.kursi.index');
        Route::get('/create', [KursiController::class, 'create'])->name('admin.kursi.create');
        Route::post('/store', [KursiController::class, 'store'])->name('admin.kursi.store');
        Route::get('/edit/{kursi}', [KursiController::class, 'edit'])->name('admin.kursi.edit');
        Route::put('/update/{kursi}', [KursiController::class, 'update'])->name('admin.kursi.update');
        Route::post('/hapus/{kursi}', [KursiController::class, 'destroy'])->name('admin.kursi.destroy');
    });

    Route::prefix('terminals')->group(function () {
        Route::get('/', [TerminalController::class, 'index'])->name('admin.terminal.index');
        Route::get('/create', [TerminalController::class, 'create'])->name('admin.terminal.create');
        Route::post('/store', [TerminalController::class, 'store'])->name('admin.terminal.store');
        Route::get('/edit/{terminal}', [TerminalController::class, 'edit'])->name('admin.terminal.edit');
        Route::put('/update/{terminal}', [TerminalController::class, 'update'])->name('admin.terminal.update');
        Route::post('/hapus/{terminal}', [TerminalController::class, 'destroy'])->name('admin.terminal.destroy');
    });

    Route::prefix('rutes')->group(function () {
        Route::get('/', [RuteController::class, 'index'])->name('admin.rute.index');
        Route::get('/create', [RuteController::class, 'create'])->name('admin.rute.create');
        Route::post('/store', [RuteController::class, 'store'])->name('admin.rute.store');
        Route::get('/edit/{rute}', [RuteController::class, 'edit'])->name('admin.rute.edit');
        Route::put('/update/{rute}', [RuteController::class, 'update'])->name('admin.rute.update');
        Route::post('/hapus/{rute}', [RuteController::class, 'destroy'])->name('admin.rute.destroy');
    });

    Route::prefix('jadwals')->group(function () {
        Route::get('/', [JadwalController::class, 'index'])->name('admin.jadwal.index');
        Route::get('/create', [JadwalController::class, 'create'])->name('admin.jadwal.create');
        Route::post('/store', [JadwalController::class, 'store'])->name('admin.jadwal.store');
        Route::get('/edit/{jadwal}', [JadwalController::class, 'edit'])->name('admin.jadwal.edit');
        Route::put('/update/{jadwal}', [JadwalController::class, 'update'])->name('admin.jadwal.update');
        Route::post('/hapus/{jadwal}', [JadwalController::class, 'destroy'])->name('admin.jadwal.destroy');
    });

    // Transaksi
    Route::prefix('bookings')->group(function () {
        Route::get('/', [AdminBookingController::class, 'index'])->name('admin.booking.index');
        Route::get('/{booking}', [AdminBookingController::class, 'show'])->name('admin.booking.show');
        Route::post('/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('admin.booking.status');
        Route::post('/{booking}/confirm-payment', [AdminBookingController::class, 'confirmPayment'])->name('admin.booking.confirm-payment');
        Route::post('/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('admin.booking.cancel');
    });

    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('admin.payment.index');
        Route::get('/{payment}', [PaymentController::class, 'show'])->name('admin.payment.show');
    });

    Route::prefix('customers')->group(function () {
        Route::get('/', [AdminCustomerController::class, 'index'])->name('admin.customer.index');
    });

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.report.index');

    // Pengaturan
    Route::prefix('akun')->group(function () {
        Route::get('/', [AkunController::class, 'index'])->name('admin.akun.index');
        Route::get('/create', [AkunController::class, 'create'])->name('admin.akun.create');
        Route::post('/store', [AkunController::class, 'store'])->name('admin.akun.store');
        Route::get('/edit/{user}', [AkunController::class, 'edit'])->name('admin.akun.edit');
        Route::put('/update/{user}', [AkunController::class, 'update'])->name('admin.akun.update');
        Route::post('/hapus/{user}', [AkunController::class, 'destroy'])->name('admin.akun.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
});