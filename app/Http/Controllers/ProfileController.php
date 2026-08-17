<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    private $menu = 'profile';

    public function index()
    {
        $menu = $this->menu;
        $user = User::findOrFail(Session('user_id'));

        return view('pages.admin.profile.index', compact('menu', 'user'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Session('user_id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        Session::put('name', $user->name);

        return back()->with('message', 'update profile');
    }
}