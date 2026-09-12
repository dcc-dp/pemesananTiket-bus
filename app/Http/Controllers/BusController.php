<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Operator;
use Illuminate\Http\Request;

class BusController extends Controller
{
    private $menu = 'bus';

    public function index()
    {
        $menu = $this->menu;
        $datas = Bus::with('operator')->orderBy('nama_bus','asc')->get();

        return view('pages.admin.bus.index', compact('datas', 'menu'));
    }

    public function create()
    {
        $menu = $this->menu;
        $operators = Operator::where('status', 'aktif')->orderBy('nama_operator')->get();

        return view('pages.admin.bus.create', compact('menu', 'operators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'nomor_polisi' => 'required|string|max:20|unique:buses,nomor_polisi',
            'kode_bus' => 'required|string|max:30|unique:buses,kode_bus',
            'nama_bus' => 'required|string|max:100',
            'kelas' => 'required|in:ekonomi,bisnis,executive,sleeper',
            'kapasitas' => 'required|integer|min:1|max:60',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif,perbaikan',
        ]);

        $bus = Bus::create($request->only([
            'operator_id', 'nomor_polisi', 'kode_bus', 'nama_bus', 'kelas', 'kapasitas', 'fasilitas', 'status',
        ]));

        $this->generateSeats($bus);

        return redirect()->route('admin.bus.index')->with('message', 'store');
    }

    public function edit(Bus $bus)
    {
        $menu = $this->menu;
        $data = $bus;
        $operators = Operator::where('status', 'aktif')->orderBy('nama_operator')->get();

        return view('pages.admin.bus.edit', compact('data', 'menu', 'operators'));
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'nomor_polisi' => 'required|string|max:20|unique:buses,nomor_polisi,' . $bus->id_bus,
            'kode_bus' => 'required|string|max:30|unique:buses,kode_bus,' . $bus->id_bus,
            'nama_bus' => 'required|string|max:100',
            'kelas' => 'required|in:ekonomi,bisnis,executive,sleeper',
            'kapasitas' => 'required|integer|min:1|max:60',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif,perbaikan',
        ]);

        $bus->update($request->only([
            'operator_id', 'nomor_polisi', 'kode_bus', 'nama_bus', 'kelas', 'kapasitas', 'fasilitas', 'status',
        ]));

        return redirect()->route('admin.bus.index')->with('message', 'update');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();

        return redirect()->route('admin.bus.index')->with('message', 'hapus');
    }

    public function generateSeats(Bus $bus): void
    {
        $rows = intdiv($bus->kapasitas, 4);

        foreach (range(1, $rows) as $row) {
            foreach (['A', 'B', 'C', 'D'] as $col) {
                $bus->kursis()->firstOrCreate(
                    ['nomor_kursi' => $row . $col],
                    ['posisi' => 'jendela', 'status' => 'tersedia']
                );
            }
        }
    }
}