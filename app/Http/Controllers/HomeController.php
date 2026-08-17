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
        $popularRoutes = Rute::with(['terminalAsal', 'terminalTujuan'])
            ->where('status', 'aktif')
            ->withCount('jadwals')
            ->orderBy('jadwals_count', 'desc')
            ->take(6)
            ->get();

        return view('pages.landing.index', compact('terminals', 'operators', 'popularRoutes'));
    }
}