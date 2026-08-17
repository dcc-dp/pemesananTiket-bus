<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    private $menu = 'customer';

    public function index(Request $request)
    {
        $menu = $this->menu;

        $query = User::where('role', 'customer')
            ->withCount('bookings');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $datas = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('pages.admin.customer.index', [
            'menu' => $menu,
            'datas' => $datas,
        ]);
    }
}