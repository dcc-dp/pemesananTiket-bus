<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Operator;
use App\Models\Terminal;
use App\Services\BookingService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function search(Request $request)
    {
        $terminals = Terminal::where('status', 'aktif')->orderBy('kota')->get();

        if (!$request->has(['terminal_asal', 'terminal_tujuan', 'tanggal', 'penumpang'])) {
            return view('pages.tiket.search', [
                'menu' => 'tiket',
                'jadwals' => collect(),
                'terminals' => $terminals,
                'operators' => collect(),
                'params' => null,
            ]);
        }

        $validated = $request->validate([
            'terminal_asal' => 'required|exists:terminals,id_terminal',
            'terminal_tujuan' => 'required|exists:terminals,id_terminal|different:terminal_asal',
            'tanggal' => 'required|date|after_or_equal:today',
            'penumpang' => 'required|integer|min:1|max:5',
        ]);

        $query = Jadwal::with(['bus.operator', 'rute.terminalAsal', 'rute.terminalTujuan', 'bus.kursis'])
            ->where('status', 'tersedia')
            ->whereDate('tanggal', $validated['tanggal'])
            ->whereHas('rute', function ($q) use ($validated) {
                $q->where('terminal_asal_id', $validated['terminal_asal'])
                    ->where('terminal_tujuan_id', $validated['terminal_tujuan']);
            });

        if ($request->filled('kelas')) {
            $query->whereHas('bus', fn ($q) => $q->where('kelas', $request->kelas));
        }

        if ($request->filled('operator_id')) {
            $query->whereHas('bus', fn ($q) => $q->where('operator_id', $request->operator_id));
        }

        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', (int) $request->harga_max);
        }

        if ($request->filled('jam_mulai')) {
            $query->whereTime('jam_berangkat', '>=', $request->jam_mulai);
        }

        $jadwals = $query->orderBy('jam_berangkat')->get();

        $jadwals = $jadwals->map(function (Jadwal $jadwal) {
            $jadwal->available_seats = $this->bookingService->seatCount($jadwal);

            return $jadwal;
        })->filter(fn (Jadwal $jadwal) => $jadwal->available_seats > 0);

        $operators = Operator::where('status', 'aktif')->orderBy('nama_operator')->get();

        return view('pages.tiket.search', [
            'menu' => 'tiket',
            'jadwals' => $jadwals,
            'terminals' => $terminals,
            'operators' => $operators,
            'params' => $validated,
        ]);
    }

    public function seats($id, Request $request)
    {
        $jadwal = Jadwal::with(['bus.kursis', 'rute.terminalAsal', 'rute.terminalTujuan', 'bus.operator'])
            ->findOrFail($id);

        if ($jadwal->status != 'tersedia') {
            return back()->with('error', 'Jadwal ini tidak tersedia.');
        }

        $available = $this->bookingService->getAvailableSeats($jadwal);
        $unavailable = $this->bookingService->getUnavailableSeats($jadwal);

        $penumpang = max(1, min((int) $request->penumpang, $available->count()));

        return view('pages.tiket.kursi', [
            'menu' => 'tiket',
            'jadwal' => $jadwal,
            'available' => $available,
            'unavailable' => $unavailable,
            'penumpang' => $penumpang,
        ]);
    }
}