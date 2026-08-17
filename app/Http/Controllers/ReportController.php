<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Operator;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private $menu = 'report';

    public function index(Request $request)
    {
        $menu = $this->menu;

        $query = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('jadwals', 'bookings.id_jadwal', '=', 'jadwals.id_jadwal')
            ->join('buses', 'jadwals.id_bus', '=', 'buses.id_bus')
            ->join('operators', 'buses.operator_id', '=', 'operators.id')
            ->join('rutes', 'jadwals.id_rute', '=', 'rutes.id_rute')
            ->join('terminals as asal', 'rutes.terminal_asal_id', '=', 'asal.id_terminal')
            ->join('terminals as tujuan', 'rutes.terminal_tujuan_id', '=', 'tujuan.id_terminal')
            ->select(
                'bookings.*',
                'users.name as customer',
                'jadwals.tanggal',
                'jadwals.jam_berangkat',
                'jadwals.harga as harga_jadwal',
                'buses.nama_bus',
                'buses.kelas',
                'operators.nama_operator',
                'asal.kota as kota_asal',
                'tujuan.kota as kota_tujuan',
                'asal.nama_terminal as terminal_asal',
                'tujuan.nama_terminal as terminal_tujuan'
            );

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('jadwals.tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('jadwals.tanggal', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('operator_id')) {
            $query->where('buses.operator_id', $request->operator_id);
        }

        if ($request->filled('bus_id')) {
            $query->where('jadwals.id_bus', $request->bus_id);
        }

        if ($request->filled('terminal_asal')) {
            $query->where('rutes.terminal_asal_id', $request->terminal_asal);
        }

        if ($request->filled('terminal_tujuan')) {
            $query->where('rutes.terminal_tujuan_id', $request->terminal_tujuan);
        }

        if ($request->filled('status_booking')) {
            $query->where('bookings.status_booking', $request->status_booking);
        }

        if ($request->filled('status_pembayaran')) {
            $query->where('bookings.status_pembayaran', $request->status_pembayaran);
        }

        $query->orderBy('jadwals.tanggal');

        if ($request->has('cetak')) {
            $datas = $query->get();

            return view('pages.admin.report.cetak', [
                'menu' => $menu,
                'datas' => $datas,
                'filter' => $request->all(),
                'title' => 'Laporan Transaksi BusTicket',
            ]);
        }

        $datas = $query->paginate(15)->withQueryString();

        $totalTransaksi = $query->get()->count();
        $totalTiket = DB::table('booking_seats')
            ->join('bookings', 'booking_seats.booking_id', '=', 'bookings.id')
            ->join('jadwals', 'bookings.id_jadwal', '=', 'jadwals.id_jadwal')
            ->when($request->filled('tanggal_mulai'), fn ($q) => $q->whereDate('jadwals.tanggal', '>=', $request->tanggal_mulai))
            ->when($request->filled('tanggal_akhir'), fn ($q) => $q->whereDate('jadwals.tanggal', '<=', $request->tanggal_akhir))
            ->where('bookings.status_pembayaran', 'paid')
            ->count();

        $totalPendapatan = $query->where('bookings.status_pembayaran', 'paid')->sum('bookings.total_harga');

        $operators = Operator::where('status', 'aktif')->orderBy('nama_operator')->get();
        $buses = Bus::orderBy('nama_bus')->get();
        $terminals = Terminal::where('status', 'aktif')->orderBy('kota')->get();

        return view('pages.admin.report.index', [
            'menu' => $menu,
            'datas' => $datas,
            'filter' => $request->all(),
            'totalTransaksi' => $totalTransaksi,
            'totalTiket' => $totalTiket,
            'totalPendapatan' => $totalPendapatan,
            'operators' => $operators,
            'buses' => $buses,
            'terminals' => $terminals,
        ]);
    }
}