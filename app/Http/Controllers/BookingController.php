<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\User;
use App\Services\BookingService;
use App\Services\PaymentService;
use App\Services\TicketService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;

    protected $paymentService;

    protected $ticketService;

    public function __construct(
        BookingService $bookingService,
        PaymentService $paymentService,
        TicketService $ticketService
    ) {
        $this->bookingService = $bookingService;
        $this->paymentService = $paymentService;
        $this->ticketService = $ticketService;
    }

    public function passengerForm($id, Request $request)
    {
        $jadwal = Jadwal::with(['bus.kursis', 'rute.terminalAsal', 'rute.terminalTujuan', 'bus.operator'])
            ->findOrFail($id);

        $seatIds = array_values(array_filter(
            (array) $request->query('seats', []),
            fn ($v) => is_numeric($v)
        ));

        if (empty($seatIds)) {
            return redirect()->route('tiket.seats', $jadwal->id_jadwal)
                ->with('error', 'Pilih minimal satu kursi terlebih dahulu.');
        }

        $kursis = Kursi::whereIn('id_kursi', $seatIds)->where('id_bus', $jadwal->id_bus)->get();

        if ($kursis->count() !== count($seatIds)) {
            return back()->with('error', 'Kursi yang dipilih tidak valid.');
        }

        foreach ($kursis as $kursi) {
            if (! $this->bookingService->isSeatAvailable($jadwal, $kursi)) {
                return redirect()->route('tiket.seats', $jadwal->id_jadwal)
                    ->with('error', "Kursi {$kursi->nomor_kursi} sudah dipesan orang lain. Silakan pilih kursi lain.");
            }
        }

        return view('pages.booking.form', [
            'menu' => 'booking',
            'jadwal' => $jadwal,
            'kursis' => $kursis,
        ]);
    }

    public function store(Request $request)
    {
        $jadwal = Jadwal::findOrFail($request->id_jadwal);

        $request->validate([
            'id_jadwal' => 'required|exists:jadwals,id_jadwal',
            'penumpang' => 'required|array|min:1|max:5',
            'penumpang.*.id_kursi' => 'required|exists:kursis,id_kursi',
            'penumpang.*.nama' => 'required|string|max:150',
            'penumpang.*.nik' => 'required|digits:16',
            'penumpang.*.no_hp' => 'required|string|max:30',
            'penumpang.*.jenis_kelamin' => 'required|in:L,P',
            'penumpang.*.tanggal_lahir' => 'required|date|before:today',
        ]);

        $passengers = collect($request->penumpang)->map(function ($p) {
            return [
                'id_kursi' => (int) $p['id_kursi'],
                'nama_penumpang' => $p['nama'],
                'nik' => $p['nik'],
                'no_hp' => $p['no_hp'],
                'jenis_kelamin' => $p['jenis_kelamin'],
                'tanggal_lahir' => $p['tanggal_lahir'],
            ];
        })->toArray();

        $user = User::findOrFail(Session('user_id'));

        try {
            $booking = $this->bookingService->createBooking($user, $jadwal, $passengers);
        } catch (\Exception $e) {
            return redirect()->route('tiket.seats', $jadwal->id_jadwal)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('customer.booking.detail', $booking->id)
            ->with('message', 'booking dibuat');
    }

    public function pay(Booking $booking)
    {
        $this->authorizeOwnership($booking);

        $this->paymentService->checkStatus($booking);

        if ($booking->status_pembayaran === 'paid') {
            return redirect()->route('customer.booking.detail', $booking->id);
        }

        if ($booking->expired_at && now()->gt($booking->expired_at) && $booking->status_booking === 'pending') {
            $this->bookingService->updateBookingStatus($booking, 'expired');
            $booking->status_pembayaran = 'expired';
            $booking->save();

            return redirect()->route('customer.booking.detail', $booking->id)
                ->with('error', 'Waktu pembayaran telah habis. Silakan lakukan pemesanan ulang.');
        }

        $result = $this->paymentService->createPayment($booking);

        return view('pages.booking.payment', [
            'menu' => 'booking',
            'booking' => $booking,
            'snapToken' => $result['snap_token'] ?? null,
            'payment' => $result['payment'],
            'midtransConfigured' => $this->paymentService->isConfigured(),
        ]);
    }

    public function callback()
    {
        $this->paymentService->handleNotification();

        return response()->json(['status' => 'ok']);
    }

    public function detail(Booking $booking)
    {
        $this->authorizeOwnership($booking);

        $this->paymentService->checkStatus($booking);

        return view('pages.booking.detail', [
            'menu' => 'booking',
            'booking' => $booking->load(['jadwal.bus.operator', 'jadwal.rute.terminalAsal', 'jadwal.rute.terminalTujuan', 'bookingSeats.kursi', 'payment']),
        ]);
    }

    public function ticket(Booking $booking)
    {
        $this->authorizeOwnership($booking);

        if ($booking->status_pembayaran !== 'paid') {
            return redirect()->route('customer.booking.detail', $booking->id)
                ->with('error', 'Tiket hanya tersedia setelah pembayaran berhasil.');
        }

        $data = $this->ticketService->getTicketData($booking);
        $qr = $this->ticketService->qrCode($booking);

        return view('pages.booking.ticket', [
            'menu' => 'tiket',
            'booking' => $booking,
            'ticket' => $data,
            'qr' => $qr,
        ]);
    }

    private function authorizeOwnership(Booking $booking): void
    {
        if (Session('role') === 'admin') {
            return;
        }

        if ($booking->user_id != Session('user_id')) {
            abort(403, 'Anda tidak berhak mengakses booking ini.');
        }
    }
}
