<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    private $menu = 'akun';

    public function index(Request $request)
    {
        $menu = $this->menu;

        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        $datas = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('pages.admin.akun.index', [
            'menu' => $menu,
            'datas' => $datas,
        ]);
    }

    public function create()
    {
        $menu = $this->menu;

        return view('pages.admin.akun.create', compact('menu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,customer',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.akun.index')->with('message', 'store');
    }

    public function edit(User $user)
    {
        $menu = $this->menu;
        $data = $user;

        return view('pages.admin.akun.edit', compact('data', 'menu'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,customer',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.akun.index')->with('message', 'update');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.akun.index')->with('message', 'hapus');
    }
}