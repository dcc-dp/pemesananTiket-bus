<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RuteController extends Controller
{
    private $menu = 'rute';

    public function index()
    {
        $menu = $this->menu;
        $datas = Rute::with(['terminalAsal', 'terminalTujuan'])->orderBy('id_rute', 'desc')->get();

        return view('pages.admin.rute.index', compact('datas', 'menu'));
    }

    public function create()
    {
        $menu = $this->menu;
        $terminals = Terminal::where('status', 'aktif')->orderBy('kota')->get();

        return view('pages.admin.rute.create', compact('menu', 'terminals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'terminal_asal_id' => 'required|exists:terminals,id_terminal',
            'terminal_tujuan_id' => 'required|exists:terminals,id_terminal|different:terminal_asal_id',
            'jarak' => 'nullable|numeric|min:0',
            'estimasi_durasi' => 'nullable|integer|min:1',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Rute::create($request->only([
            'terminal_asal_id',
            'terminal_tujuan_id',
            'jarak',
            'estimasi_durasi',
            'status',
        ]));

        return redirect()->route('admin.rute.index')->with('message', 'store');
    }

    public function edit(Rute $rute)
    {
        $menu = $this->menu;
        $data = $rute;
        $terminals = Terminal::where('status', 'aktif')->orderBy('kota')->get();

        return view('pages.admin.rute.edit', compact('data', 'menu', 'terminals'));
    }

    public function update(Request $request, Rute $rute)
    {
        $request->validate([
            'terminal_asal_id' => 'required|exists:terminals,id_terminal',
            'terminal_tujuan_id' => 'required|exists:terminals,id_terminal|different:terminal_asal_id',
            'jarak' => 'nullable|numeric|min:0',
            'estimasi_durasi' => 'nullable|integer|min:1',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $rute->update($request->only([
            'terminal_asal_id',
            'terminal_tujuan_id',
            'jarak',
            'estimasi_durasi',
            'status',
        ]));

        return redirect()->route('admin.rute.index')->with('message', 'update');
    }

    public function calculateDistance(Request $request)
    {
        $request->validate([
            'asal' => 'required|exists:terminals,id_terminal',
            'tujuan' => 'required|exists:terminals,id_terminal|different:asal',
        ]);

        $asal = Terminal::findOrFail($request->asal);
        $tujuan = Terminal::findOrFail($request->tujuan);

        if (is_null($asal->latitude) || is_null($asal->longitude)) {
            return response()->json([
                'success' => false,
                'message' => 'Koordinat terminal asal belum tersedia.'
            ], 422);
        }

        if (is_null($tujuan->latitude) || is_null($tujuan->longitude)) {
            return response()->json([
                'success' => false,
                'message' => 'Koordinat terminal tujuan belum tersedia.'
            ], 422);
        }

        $url = "https://router.project-osrm.org/route/v1/driving/"
            . $asal->longitude . ','
            . $asal->latitude . ';'
            . $tujuan->longitude . ','
            . $tujuan->latitude;

        $response = Http::timeout(15)->get($url, [
            'overview' => 'false',
        ]);

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungi layanan perhitungan rute.'
            ], 500);
        }

        $data = $response->json();

        if (($data['code'] ?? null) !== 'Ok' || empty($data['routes'])) {
            return response()->json([
                'success' => false,
                'message' => 'Rute jalan tidak ditemukan.'
            ], 422);
        }

        $route = $data['routes'][0];

        // Jarak jalan dalam kilometer
        $jarak = $route['distance'] / 1000;

        // ==========================================
        // ESTIMASI DURASI BUS
        // ==========================================

        // Kecepatan rata-rata bus 55 km/jam
        $kecepatanBus = 55;

        // Jarak ÷ kecepatan × 60 = menit
        $durasi = ($jarak / $kecepatanBus) * 60;

        // Bulatkan ke menit terdekat
        $durasi = round($durasi);

        return response()->json([
            'success' => true,
            'jarak' => round($jarak, 2),
            'estimasi_durasi' => $durasi,
        ]);
    }
    public function destroy(Rute $rute)
    {
        $rute->delete();

        return redirect()->route('admin.rute.index')->with('message', 'hapus');
    }
}
