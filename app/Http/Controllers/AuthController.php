<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login', ['menu' => 'login']);
    }

    public function register()
    {
        return view('pages.auth.register', ['menu' => 'register']);
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->identity)
            ->orWhere('email', $request->identity)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->route('login')
                ->with('message', 'gagal login');
        }

        Session::put('user_id', $user->id);
        Session::put('name', $user->name);
        Session::put('username', $user->username);
        Session::put('role', $user->role);
        Session::put('cek', true);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('message', 'sukses login');
        }

        return redirect()->route('customer.dashboard')
            ->with('message', 'sukses login');
    }

    public function register_action(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        return redirect()->route('login')
            ->with('message', 'register sukses');
    }

    public function logout()
    {
        Session::flush();

        return redirect()->route('home')
            ->with('message', 'sukses logout');
    }
}