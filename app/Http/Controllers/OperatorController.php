<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    private $menu = 'operator';

    public function index()
    {
        $menu = $this->menu;
        $datas = Operator::withCount('buses')->orderBy('nama_operator')->get();

        return view('pages.admin.operator.index', compact('datas', 'menu'));
    }

    public function create()
    {
        $menu = $this->menu;

        return view('pages.admin.operator.create', compact('menu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_operator' => 'required|string|max:150',
            'kode_operator' => 'required|string|max:30|unique:operators,kode_operator',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Operator::create($request->only([
            'nama_operator', 'kode_operator', 'alamat', 'telepon', 'email', 'status',
        ]));

        return redirect()->route('admin.operator.index')->with('message', 'store');
    }

    public function edit(Operator $operator)
    {
        $menu = $this->menu;
        $data = $operator;

        return view('pages.admin.operator.edit', compact('data', 'menu'));
    }

    public function update(Request $request, Operator $operator)
    {
        $request->validate([
            'nama_operator' => 'required|string|max:150',
            'kode_operator' => 'required|string|max:30|unique:operators,kode_operator,' . $operator->id,
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $operator->update($request->only([
            'nama_operator', 'kode_operator', 'alamat', 'telepon', 'email', 'status',
        ]));

        return redirect()->route('admin.operator.index')->with('message', 'update');
    }

    public function destroy(Operator $operator)
    {
        $operator->delete();

        return redirect()->route('admin.operator.index')->with('message', 'hapus');
    }
}