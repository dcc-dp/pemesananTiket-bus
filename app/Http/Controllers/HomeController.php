<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Jadwal;
use App\Models\Operator;
use App\Models\Rute;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $terminals = Terminal::where('status', 'aktif')->orderBy('kota')->get();
        $operators = Operator::where('status', 'aktif')->withCount('buses')->get();

        $popularRoutes = Rute::with([
            'terminalAsal',
            'terminalTujuan',
            'jadwals' => function ($q) {
                $q->where('status', 'tersedia')
                    ->orderBy('tanggal', 'asc')
                    ->orderBy('jam_berangkat', 'asc');
            }
        ])
        ->where('status', 'aktif')
        ->withCount('jadwals')
        ->orderBy('jadwals_count', 'desc')
        ->take(4)
        ->get();

        $defaultJam = ['07:30', '13:00', '19:30', '21:00'];

        foreach ($popularRoutes as $index => $route) {
            // Ambil jadwal aktif mendatang (hari ini / ke depan)
            $jadwal = $route->jadwals
                ->filter(function ($j) {
                    return \Carbon\Carbon::parse($j->tanggal)->startOfDay()->gte(today());
                })
                ->first();

            // Jika tidak ada jadwal mendatang, fallback ke jadwal yang tersedia
            if (!$jadwal) {
                $jadwal = $route->jadwals->first();
            }

            if ($jadwal) {
                $tgl = \Carbon\Carbon::parse($jadwal->tanggal);
                if ($tgl->lt(today())) {
                    $tgl = today()->addDays(($index % 3) + 1);
                }

                $route->next_tanggal = $tgl->format('Y-m-d');
                $route->next_tanggal_formatted = $tgl->locale('id')->isoFormat('DD MMM Y');
                $route->next_jam_berangkat = \Carbon\Carbon::parse($jadwal->jam_berangkat)->format('H:i');
                $route->min_harga = $jadwal->harga ?: (150000 + ($index * 30000));
            } else {
                $tgl = today()->addDays(($index % 3) + 1);
                $route->next_tanggal = $tgl->format('Y-m-d');
                $route->next_tanggal_formatted = $tgl->locale('id')->isoFormat('DD MMM Y');
                $route->next_jam_berangkat = $defaultJam[$index % count($defaultJam)];
                $route->min_harga = 150000 + ($index * 30000);
            }
        }

        return view('pages.landing.index', compact('terminals', 'operators', 'popularRoutes'));
    }
}