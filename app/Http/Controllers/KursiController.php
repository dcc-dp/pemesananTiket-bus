<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Kursi;
use Illuminate\Http\Request;

class KursiController extends Controller
{
    private $menu = 'kursi';

    public function index(Request $request)
    {
        $menu = $this->menu;
        $busId = $request->query('bus', Bus::first()?->id_bus);

        $bus = $busId ? Bus::findOrFail($busId) : null;
        $buses = Bus::orderBy('nama_bus')->get();

        // $datas = $bus ? Kursi::where('id_bus', $bus->id_bus)->orderBy('nomor_kursi')->get() : collect();
        $datas = $bus ? Kursi::where('id_bus', $bus->id_bus)->orderByRaw('LENGTH(nomor_kursi), nomor_kursi')->get() : collect();

        return view('pages.admin.kursi.index', compact('menu', 'buses', 'bus', 'datas'));
    }

    public function create()
    {
        $menu = $this->menu;
        $buses = Bus::orderBy('nama_bus')->get();

        return view('pages.admin.kursi.create', compact('menu', 'buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bus' => 'required|exists:buses,id_bus',
            'nomor_kursi' => 'required|string|max:10',
            'kelas' => 'required|in:ekonomi,bisnis,executive,sleeper',
            'harga' => 'required|integer|min:0',
            'posisi' => 'nullable|string|max:20',
            'status' => 'required|in:tersedia,rusak',
        ]);

        $exists = Kursi::where('id_bus', $request->id_bus)
            ->where('nomor_kursi', $request->nomor_kursi)
            ->exists();

        if ($exists) {
            return back()->with('message', 'kursi sudah ada');
        }

        $data = $request->only(['id_bus', 'nomor_kursi', 'kelas', 'harga', 'posisi', 'status']);
        if (empty($data['posisi'])) {
            $col = strtoupper(substr($request->nomor_kursi, -1));
            $data['posisi'] = in_array($col, ['A', 'D']) ? 'jendela' : 'lorong';
        }

        Kursi::create($data);

        return redirect()->route('admin.kursi.index', ['bus' => $request->id_bus])->with('message', 'store');
    }

    public function edit(Kursi $kursi)
    {
        $menu = $this->menu;
        $data = $kursi;

        return view('pages.admin.kursi.edit', compact('data', 'menu'));
    }

    public function update(Request $request, Kursi $kursi)
    {
        $request->validate([
            'nomor_kursi' => 'required|string|max:10',
            'posisi' => 'nullable|string|max:20',
            'kelas' => 'required|in:ekonomi,bisnis,executive,sleeper',
            'harga' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,rusak',
        ]);

        $exists = Kursi::where('id_bus', $kursi->id_bus)
            ->where('nomor_kursi', $request->nomor_kursi)
            ->where('id_kursi', '!=', $kursi->id_kursi)
            ->exists();

        if ($exists) {
            return back()->with('message', 'kursi sudah ada');
        }

        $data = $request->only(['nomor_kursi', 'kelas', 'harga', 'posisi', 'status']);
        if (empty($data['posisi'])) {
            $col = strtoupper(substr($request->nomor_kursi, -1));
            $data['posisi'] = in_array($col, ['A', 'D']) ? 'jendela' : 'lorong';
        }

        $kursi->update($data);

        return redirect()->route('admin.kursi.index', ['bus' => $kursi->id_bus])->with('message', 'update');
    }

    public function destroy(Kursi $kursi)
    {
        $busId = $kursi->id_bus;
        $kursi->delete();

        return redirect()->route('admin.kursi.index', ['bus' => $busId])->with('message', 'hapus');
    }
}