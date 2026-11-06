<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    private function getAuthenticatedUser(): ?User
    {
        $userId = Session('user_id');
        if (!$userId) {
            return null;
        }

        return User::find($userId);
    }

    public function dashboard()
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            return redirect()->route('login')->with('message', 'need login');
        }

        $terminals = Terminal::where('status', 'aktif')->orderBy('kota')->get();

        $activeBookings = $user->bookings()
            ->with('jadwal.bus', 'jadwal.rute.terminalAsal', 'jadwal.rute.terminalTujuan')
            ->whereIn('status_booking', ['pending', 'confirmed', 'completed'])
            ->latest()
            ->take(5)
            ->get();

        $paidBookings = $user->bookings()
            ->where('status_pembayaran', 'paid')
            ->count();

        $totalPerjalanan = $user->bookings()
            ->whereIn('status_booking', ['confirmed', 'completed'])
            ->count();

        return view('pages.customer.dashboard', [
            'menu' => 'dashboard',
            'user' => $user,
            'terminals' => $terminals,
            'activeBookings' => $activeBookings,
            'paidBookings' => $paidBookings,
            'totalPerjalanan' => $totalPerjalanan,
        ]);
    }

    public function bookings(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            return redirect()->route('login')->with('message', 'need login');
        }

        $status = $request->query('status');

        $query = $user->bookings()
            ->with('jadwal.bus', 'jadwal.rute.terminalAsal', 'jadwal.rute.terminalTujuan');

        if (in_array($status, ['pending', 'confirmed', 'completed', 'cancelled', 'expired'])) {
            $query->where('status_booking', $status);
        }

        $bookings = $query->latest('tanggal_booking')->paginate(10);

        return view('pages.customer.bookings', [
            'menu' => 'bookings',
            'bookings' => $bookings,
            'filter' => $status,
        ]);
    }

    public function tickets()
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            return redirect()->route('login')->with('message', 'need login');
        }

        $bookings = $user->bookings()
            ->with('jadwal.bus', 'jadwal.rute.terminalAsal', 'jadwal.rute.terminalTujuan', 'bookingSeats.kursi')
            ->where('status_pembayaran', 'paid')
            ->latest('tanggal_booking')
            ->get();

        return view('pages.customer.tickets', [
            'menu' => 'tickets',
            'bookings' => $bookings,
        ]);
    }

    public function profile()
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            return redirect()->route('login')->with('message', 'need login');
        }

        return view('pages.customer.profile', [
            'menu' => 'profile',
            'user' => $user,
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            return redirect()->route('login')->with('message', 'need login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        Session::put('name', $user->name);

        return back()->with('message', 'update profile');
    }
}
