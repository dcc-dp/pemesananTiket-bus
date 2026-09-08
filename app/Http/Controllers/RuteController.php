<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use App\Models\Terminal;
use Illuminate\Http\Request;

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

    public function destroy(Rute $rute)
    {
        $rute->delete();

        return redirect()->route('admin.rute.index')->with('message', 'hapus');
    }
}
