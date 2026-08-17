<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Jadwal;
use App\Models\Operator;
use App\Models\Rute;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOperator = Operator::count();
        $totalBus = Bus::count();
        $totalTerminal = Terminal::count();
        $totalRute = Rute::count();
        $totalJadwalAktif = Jadwal::where('status', 'tersedia')
            ->whereDate('tanggal', '>=', today())
            ->count();
        $totalCustomer = User::where('role', 'customer')->count();
        $totalBooking = Booking::count();
        $bookingPending = Booking::where('status_booking', 'pending')->count();
        $bookingBerhasil = Booking::where('status_pembayaran', 'paid')->count();
        $pendapatanHariIni = Booking::where('status_pembayaran', 'paid')
            ->whereDate('paid_at', today())
            ->sum('total_harga');
        $pendapatanBulanIni = Booking::where('status_pembayaran', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('total_harga');

        $pendapatanPerBulan = Booking::where('status_pembayaran', 'paid')
            ->whereYear('paid_at', now()->year)
            ->selectRaw('MONTH(paid_at) as bulan, SUM(total_harga) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->all();

        $chartLabels = [];
        $chartPendapatan = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = Carbon::create()->month($i)->format('M');
            $chartPendapatan[] = $pendapatanPerBulan[$i] ?? 0;
        }

        $bookingPerBulan = Booking::whereYear('tanggal_booking', now()->year)
            ->selectRaw('MONTH(tanggal_booking) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->all();

        $chartBooking = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartBooking[] = $bookingPerBulan[$i] ?? 0;
        }

        $ruteTerpopuler = Booking::join('jadwals', 'bookings.id_jadwal', '=', 'jadwals.id_jadwal')
            ->join('rutes', 'jadwals.id_rute', '=', 'rutes.id_rute')
            ->join('terminals as a', 'rutes.terminal_asal_id', '=', 'a.id_terminal')
            ->join('terminals as b', 'rutes.terminal_tujuan_id', '=', 'b.id_terminal')
            ->selectRaw('CONCAT(a.kota, " → ", b.kota) as rute, COUNT(*) as total')
            ->groupBy('rute')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $operatorTerbanyak = Booking::join('jadwals', 'bookings.id_jadwal', '=', 'jadwals.id_jadwal')
            ->join('buses', 'jadwals.id_bus', '=', 'buses.id_bus')
            ->join('operators', 'buses.operator_id', '=', 'operators.id')
            ->selectRaw('operators.nama_operator, COUNT(*) as total')
            ->groupBy('operators.nama_operator')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $bookingsTerbaru = Booking::with(['user', 'jadwal.bus.operator'])
            ->latest()
            ->take(8)
            ->get();

        $pembayaranTerbaru = \App\Models\Payment::with(['booking.user'])
            ->latest()
            ->take(8)
            ->get();

        return view('pages.admin.dashboard.index', [
            'menu' => 'dashboard',
            'totalOperator' => $totalOperator,
            'totalBus' => $totalBus,
            'totalTerminal' => $totalTerminal,
            'totalRute' => $totalRute,
            'totalJadwalAktif' => $totalJadwalAktif,
            'totalCustomer' => $totalCustomer,
            'totalBooking' => $totalBooking,
            'bookingPending' => $bookingPending,
            'bookingBerhasil' => $bookingBerhasil,
            'pendapatanHariIni' => $pendapatanHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'chartLabels' => $chartLabels,
            'chartPendapatan' => $chartPendapatan,
            'chartBooking' => $chartBooking,
            'ruteTerpopuler' => $ruteTerpopuler,
            'operatorTerbanyak' => $operatorTerbanyak,
            'bookingsTerbaru' => $bookingsTerbaru,
            'pembayaranTerbaru' => $pembayaranTerbaru,
        ]);
    }
}