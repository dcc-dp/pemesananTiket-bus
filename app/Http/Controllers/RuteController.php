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
        $datas = Rute::with(['terminalAsal', 'terminalTujuan'])->orderBy('id_rute','DESC')->get();

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

        // 1. Cek jika rute sudah pernah tersimpan di database
        $existingRute = Rute::where(function ($q) use ($asal, $tujuan) {
            $q->where('terminal_asal_id', $asal->id_terminal)
              ->where('terminal_tujuan_id', $tujuan->id_terminal);
        })->orWhere(function ($q) use ($asal, $tujuan) {
            $q->where('terminal_asal_id', $tujuan->id_terminal)
              ->where('terminal_tujuan_id', $asal->id_terminal);
        })->whereNotNull('jarak')->where('jarak', '>', 0)->first();

        if ($existingRute && $existingRute->jarak > 0 && $existingRute->estimasi_durasi > 0) {
            return response()->json([
                'success' => true,
                'jarak' => (float) $existingRute->jarak,
                'estimasi_durasi' => (int) $existingRute->estimasi_durasi,
            ]);
        }

        // 2. Dapatkan koordinat asal & tujuan (dengan auto-resolve dan update DB)
        [$latAsal, $lonAsal] = $this->resolveCoordinates($asal);
        [$latTujuan, $lonTujuan] = $this->resolveCoordinates($tujuan);

        if (is_null($latAsal) || is_null($lonAsal)) {
            return response()->json([
                'success' => false,
                'message' => 'Koordinat untuk terminal asal (' . $asal->nama_terminal . ') tidak ditemukan.'
            ], 422);
        }

        if (is_null($latTujuan) || is_null($lonTujuan)) {
            return response()->json([
                'success' => false,
                'message' => 'Koordinat untuk terminal tujuan (' . $tujuan->nama_terminal . ') tidak ditemukan.'
            ], 422);
        }

        // 3. Hitung jarak berkendara via OSRM, fallback ke Haversine
        $jarak = null;
        try {
            $url = "https://router.project-osrm.org/route/v1/driving/{$lonAsal},{$latAsal};{$lonTujuan},{$latTujuan}";
            $response = Http::timeout(6)->get($url, ['overview' => 'false']);

            if ($response->successful()) {
                $data = $response->json();
                if (($data['code'] ?? null) === 'Ok' && !empty($data['routes'])) {
                    $jarak = $data['routes'][0]['distance'] / 1000;
                }
            }
        } catch (\Exception $e) {
            // Lanjut ke fallback
        }

        // Fallback jarak darat jika OSRM tidak menemukan rute langsung
        if (is_null($jarak) || $jarak <= 0) {
            $jarak = $this->calculateHaversineDistance($latAsal, $lonAsal, $latTujuan, $lonTujuan);
        }

        // Kecepatan rata-rata bus 55 km/jam
        $kecepatanBus = 55;
        $durasi = max(15, (int) round(($jarak / $kecepatanBus) * 60));

        return response()->json([
            'success' => true,
            'jarak' => round($jarak, 2),
            'estimasi_durasi' => $durasi,
        ]);
    }

    private function resolveCoordinates(Terminal $terminal): array
    {
        if (!is_null($terminal->latitude) && !is_null($terminal->longitude)) {
            return [(float) $terminal->latitude, (float) $terminal->longitude];
        }

        // Kamus koordinat terminal & kota se-Indonesia
        $known = [
            'TML-DAYA' => [-5.109722, 119.509722],
            'TML-MALENGKERI' => [-5.176389, 119.436389],
            'TML-MACCINI' => [-5.163000, 119.412000],
            'TML-PAREPARE' => [-4.015000, 119.635000],
            'TML-PALOPO' => [-2.994444, 120.198611],
            'TML-PALU' => [-0.835000, 119.885000],
            'TML-KENDARI' => [-4.011667, 122.502778],
            'TML-GORONTALO' => [0.540000, 123.060000],
            'TML-MANADO' => [1.455000, 124.825000],
            'TML-TERNATE' => [0.783333, 127.366667],
            'TML-AMBON' => [-3.695833, 128.183333],
            'TML-SAMARINDA' => [-0.502106, 117.153709],
            'TML-BANJARMASIN' => [-3.319384, 114.590755],
            'TML-BALIKPAPAN' => [-1.265386, 116.831200],
            'TML-PONTIANAK' => [-0.026330, 109.342504],
            'TML-DEPOK' => [-6.402484, 106.794241],
            'TML-KPR' => [-6.310500, 106.877000],
            'TML-PULOGEBANG' => [-6.212000, 106.953000],
            'TML-BUNGURASIH' => [-7.354000, 112.726000],
            'TML-PURABAYA' => [-7.354000, 112.726000],
        ];

        // 1. Cek berdasarkan kode_terminal
        if (!empty($terminal->kode_terminal) && isset($known[$terminal->kode_terminal])) {
            $coords = $known[$terminal->kode_terminal];
            $terminal->update(['latitude' => $coords[0], 'longitude' => $coords[1]]);
            return $coords;
        }

        // 2. Cek berdasarkan nama kota
        $kotaKey = strtoupper(trim($terminal->kota));
        $cityCoords = [
            'MAKASSAR' => [-5.147665, 119.432731],
            'PAREPARE' => [-4.015000, 119.635000],
            'PALOPO' => [-2.994444, 120.198611],
            'PALU' => [-0.835000, 119.885000],
            'KENDARI' => [-4.011667, 122.502778],
            'GORONTALO' => [0.540000, 123.060000],
            'MANADO' => [1.455000, 124.825000],
            'TERNATE' => [0.783333, 127.366667],
            'AMBON' => [-3.695833, 128.183333],
            'SAMARINDA' => [-0.502106, 117.153709],
            'BANJARMASIN' => [-3.319384, 114.590755],
            'BALIKPAPAN' => [-1.265386, 116.831200],
            'PONTIANAK' => [-0.026330, 109.342504],
            'DEPOK' => [-6.402484, 106.794241],
            'JAKARTA' => [-6.208800, 106.845600],
            'SIDOARJO' => [-7.447800, 112.718300],
            'SURABAYA' => [-7.257472, 112.752088],
        ];

        foreach ($cityCoords as $city => $coords) {
            if (str_contains($kotaKey, $city)) {
                $terminal->update(['latitude' => $coords[0], 'longitude' => $coords[1]]);
                return $coords;
            }
        }

        // 3. Coba geocoding via Nominatim jika belum ditemukan
        try {
            $query = trim(($terminal->alamat ? $terminal->alamat . ', ' : '') . $terminal->kota . ', Indonesia');
            $response = Http::withHeaders(['User-Agent' => 'BusTicket Laravel Application'])
                ->timeout(4)
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $query,
                    'format' => 'json',
                    'limit' => 1,
                    'countrycodes' => 'id',
                ]);

            if ($response->successful() && !empty($response->json())) {
                $item = $response->json()[0];
                $lat = (float) $item['lat'];
                $lon = (float) $item['lon'];
                $terminal->update(['latitude' => $lat, 'longitude' => $lon]);
                return [$lat, $lon];
            }
        } catch (\Exception $e) {
            // Lanjut
        }

        return [null, null];
    }

    private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $straight = $earthRadius * $c;

        // Faktor kelokan jalan darat bus Indonesia rata-rata 1.35x
        return round($straight * 1.35, 2);
    }

    public function destroy(Rute $rute)
    {
        $rute->delete();

        return redirect()->route('admin.rute.index')->with('message', 'hapus');
    }
}
