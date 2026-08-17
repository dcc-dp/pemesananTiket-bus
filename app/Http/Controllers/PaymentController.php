<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $menu = 'payment';

    public function index(Request $request)
    {
        $menu = $this->menu;

        $query = Payment::with(['booking.user', 'booking.jadwal.bus']);

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        $datas = $query->latest()->paginate(15)->withQueryString();

        return view('pages.admin.payment.index', [
            'menu' => $menu,
            'datas' => $datas,
            'filter' => $request->only(['payment_status', 'payment_type']),
        ]);
    }

    public function show(Payment $payment)
    {
        $menu = $this->menu;
        $data = $payment->load(['booking.user', 'booking.jadwal.bus', 'booking.jadwal.rute.terminalAsal', 'booking.jadwal.rute.terminalTujuan']);

        return view('pages.admin.payment.show', compact('data', 'menu'));
    }
}