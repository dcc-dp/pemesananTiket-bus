<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    private $menu = 'booking';

    protected $bookingService;
    protected $paymentService;

    public function __construct(BookingService $bookingService, PaymentService $paymentService)
    {
        $this->bookingService = $bookingService;
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $menu = $this->menu;

        $query = Booking::with(['user', 'jadwal.bus.operator', 'jadwal.rute.terminalAsal', 'jadwal.rute.terminalTujuan']);

        if ($request->filled('status_booking')) {
            $query->where('status_booking', $request->status_booking);
        }

        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        if ($request->filled('kode_booking')) {
            $search = $request->kode_booking;
            $query->where(function ($q) use ($search) {
                $q->where('kode_booking', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jadwal.bus', function ($bq) use ($search) {
                        $bq->where('nama_bus', 'like', '%' . $search . '%')
                            ->orWhere('nomor_polisi', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jadwal.rute.terminalAsal', function ($tq) use ($search) {
                        $tq->where('kota', 'like', '%' . $search . '%')
                            ->orWhere('nama_terminal', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jadwal.rute.terminalTujuan', function ($tq) use ($search) {
                        $tq->where('kota', 'like', '%' . $search . '%')
                            ->orWhere('nama_terminal', 'like', '%' . $search . '%');
                    });
            });
        }

        $datas = $query->latest()->paginate(15)->withQueryString();

        return view('pages.admin.booking.index', [
            'menu' => $menu,
            'datas' => $datas,
            'filter' => $request->only(['status_booking', 'status_pembayaran', 'kode_booking']),
        ]);
    }

    public function show(Booking $booking)
    {
        $menu = $this->menu;
        $data = $booking->load([
            'user',
            'jadwal.bus.operator',
            'jadwal.rute.terminalAsal',
            'jadwal.rute.terminalTujuan',
            'bookingSeats.kursi',
            'payment',
        ]);

        return view('pages.admin.booking.show', compact('data', 'menu'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status_booking' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        try {
            $this->bookingService->updateBookingStatus($booking, $request->status_booking);

            if (in_array($request->status_booking, ['cancelled'])) {
                $booking->status_pembayaran = 'failed';
                $booking->save();
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.booking.show', $booking->id)->with('message', 'update');
    }

    public function confirmPayment(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_method' => 'required|string|max:50',
        ]);

        try {
            $this->paymentService->confirmManually($booking, $request->payment_method);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.booking.show', $booking->id)->with('message', 'update');
    }

    public function cancel(Booking $booking)
    {
        $this->bookingService->updateBookingStatus($booking, 'cancelled');
        $booking->status_pembayaran = 'failed';
        $booking->save();

        return redirect()->route('admin.booking.index')->with('message', 'update');
    }
}