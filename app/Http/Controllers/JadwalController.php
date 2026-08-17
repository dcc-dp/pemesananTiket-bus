<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Jadwal;
use App\Models\Rute;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    private $menu = 'jadwal';

    public function index(Request $request)
    {
        $menu = $this->menu;

        $query = Jadwal::with(['bus.operator', 'rute.terminalAsal', 'rute.terminalTujuan']);

        if ($request->filled('rute')) {
            $query->where('id_rute', $request->rute);
        }

        if ($request->filled('bus')) {
            $query->where('id_bus', $request->bus);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $datas = $query->orderByDesc('tanggal')->orderBy('jam_berangkat')->get();
        $buses = Bus::orderBy('nama_bus')->get();
        $rutes = Rute::with(['terminalAsal', 'terminalTujuan'])->get();

        return view('pages.admin.jadwal.index', compact('datas', 'menu', 'buses', 'rutes'));
    }

    public function create()
    {
        $menu = $this->menu;
        $buses = Bus::where('status', 'aktif')->orderBy('nama_bus')->get();
        $rutes = Rute::with(['terminalAsal', 'terminalTujuan'])->where('status', 'aktif')->get();

        return view('pages.admin.jadwal.create', compact('menu', 'buses', 'rutes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bus' => 'required|exists:buses,id_bus',
            'id_rute' => 'required|exists:rutes,id_rute',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'nullable',
            'harga' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,penuh,berangkat,selesai,dibatalkan',
        ]);

        Jadwal::create($request->only([
            'id_bus', 'id_rute', 'tanggal', 'jam_berangkat', 'jam_tiba', 'harga', 'status',
        ]));

        return redirect()->route('admin.jadwal.index')->with('message', 'store');
    }

    public function edit(Jadwal $jadwal)
    {
        $menu = $this->menu;
        $data = $jadwal;
        $buses = Bus::where('status', 'aktif')->orderBy('nama_bus')->get();
        $rutes = Rute::with(['terminalAsal', 'terminalTujuan'])->where('status', 'aktif')->get();

        return view('pages.admin.jadwal.edit', compact('data', 'menu', 'buses', 'rutes'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'id_bus' => 'required|exists:buses,id_bus',
            'id_rute' => 'required|exists:rutes,id_rute',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'nullable',
            'harga' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,penuh,berangkat,selesai,dibatalkan',
        ]);

        $jadwal->update($request->only([
            'id_bus', 'id_rute', 'tanggal', 'jam_berangkat', 'jam_tiba', 'harga', 'status',
        ]));

        return redirect()->route('admin.jadwal.index')->with('message', 'update');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('message', 'hapus');
    }
}