<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;

class TerminalController extends Controller
{
    private $menu = 'terminal';

    public function index()
    {
        $menu = $this->menu;
        $datas = Terminal::orderBy('kota')->get();

        return view('pages.admin.terminal.index', compact('datas', 'menu'));
    }

    public function create()
    {
        $menu = $this->menu;

        return view('pages.admin.terminal.create', compact('menu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_terminal' => 'required|string|max:150',
            'kode_terminal' => 'required|string|max:30|unique:terminals,kode_terminal',
            'alamat' => 'nullable|string|max:255',
            'kota' => 'required|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Terminal::create($request->only([
            'nama_terminal', 'kode_terminal', 'alamat', 'kota', 'provinsi', 'status',
        ]));

        return redirect()->route('admin.terminal.index')->with('message', 'store');
    }

    public function edit(Terminal $terminal)
    {
        $menu = $this->menu;
        $data = $terminal;

        return view('pages.admin.terminal.edit', compact('data', 'menu'));
    }

    public function update(Request $request, Terminal $terminal)
    {
        $request->validate([
            'nama_terminal' => 'required|string|max:150',
            'kode_terminal' => 'required|string|max:30|unique:terminals,kode_terminal,' . $terminal->id_terminal,
            'alamat' => 'nullable|string|max:255',
            'kota' => 'required|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $terminal->update($request->only([
            'nama_terminal', 'kode_terminal', 'alamat', 'kota', 'provinsi', 'status',
        ]));

        return redirect()->route('admin.terminal.index')->with('message', 'update');
    }

    public function destroy(Terminal $terminal)
    {
        $terminal->delete();

        return redirect()->route('admin.terminal.index')->with('message', 'hapus');
    }
}