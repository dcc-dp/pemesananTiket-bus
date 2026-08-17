<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = (bool) config('midtrans.is_production', false);
        Config::$isSanitized = (bool) config('midtrans.is_sanitized', true);
        Config::$is3ds = (bool) config('midtrans.is_3ds', true);
    }

    public function isConfigured(): bool
    {
        return ! empty(Config::$serverKey) && ! empty(Config::$clientKey);
    }

    /**
     * Buat pembayaran (Midtrans Snap token jika terkonfigurasi).
     * Jika tidak terkonfigurasi, booking dibiarkan pending untuk konfirmasi admin.
     *
     * @return array{snap_token?: string, redirect_url?: string, payment: Payment}
     */
    public function createPayment(Booking $booking): array
    {
        $payment = $booking->payment;

        if (! $payment) {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'order_id' => 'MID-'.$booking->kode_booking,
                'gross_amount' => $booking->total_harga,
                'payment_status' => 'pending',
            ]);
        }

        $booking->status_pembayaran = 'pending';
        $booking->save();

        if (! $this->isConfigured()) {
            return ['payment' => $payment];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => $booking->total_harga,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
                'phone' => $booking->user->phone,
            ],
            'item_details' => $this->itemDetails($booking),
            'callbacks' => [
                'finish' => route('customer.booking.detail', $booking->id),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $payment->raw_response = ['snap_token' => $snapToken];
            $payment->save();

            return [
                'snap_token' => $snapToken,
                'payment' => $payment,
            ];
        } catch (\Throwable $e) {
            Log::error('Midtrans Snap gagal: '.$e->getMessage());

            throw new \Exception('Gagal menghubungi gateway pembayaran. Silakan coba lagi.');
        }
    }

    private function itemDetails(Booking $booking): array
    {
        $items = [];

        foreach ($booking->bookingSeats as $seat) {
            $items[] = [
                'id' => 'KURSI-'.$seat->id_kursi,
                'price' => $seat->harga,
                'quantity' => 1,
                'name' => 'Tiket Bus '.($seat->kursi->nomor_kursi ?? ''),
            ];
        }

        return $items;
    }

    /**
     * Proses notifikasi callback dari Midtrans.
     */
    public function handleNotification(): void
    {
        $notification = new Notification;

        $status = $notification->transaction_status;
        $fraud = $notification->fraud_status;
        $orderId = $notification->order_id;
        $grossAmount = $notification->gross_amount;

        $payment = Payment::where('order_id', $orderId)->first();

        if (! $payment) {
            Log::warning('Midtrans callback untuk order yang tidak dikenal: '.$orderId);

            return;
        }

        $booking = $payment->booking;

        $notifGross = (int) ($grossAmount ?? 0);
        if ($notifGross > 0 && $notifGross != (int) $booking->total_harga) {
            Log::error('Midtrans callback gross_amount tidak cocok. order='.$orderId
                .' notif='.$notifGross.' booking='.$booking->total_harga);

            return;
        }

        DB::transaction(function () use ($notification, $status, $fraud, $payment, $booking, $grossAmount) {
            $payment->transaction_id = $notification->transaction_id ?? $payment->transaction_id;
            $payment->payment_type = $notification->payment_type ?? $payment->payment_type;
            $payment->transaction_status = $status;
            $payment->gross_amount = (int) $grossAmount ?: $payment->gross_amount;
            $payment->raw_response = array_merge($payment->raw_response ?? [], (array) $notification->getResponse());

            $this->resolvePaymentStatus($payment, $status, $fraud, $booking);
        });
    }

    private function resolvePaymentStatus(Payment $payment, string $status, ?string $fraud, Booking $booking): void
    {
        switch ($status) {
            case 'capture':
                if ($fraud === 'accept') {
                    $this->markPaid($payment, $booking);
                } else {
                    $payment->payment_status = 'pending';
                    $payment->save();
                }
                break;

            case 'settlement':
                $this->markPaid($payment, $booking);
                break;

            case 'deny':
            case 'cancel':
            case 'expire':
                $payment->payment_status = 'failed';
                $payment->save();

                $booking->status_pembayaran = 'failed';
                $booking->save();

                app(BookingService::class)->updateBookingStatus($booking, 'cancelled');
                break;

            case 'pending':
                $payment->payment_status = 'pending';
                $payment->save();

                $booking->status_pembayaran = 'pending';
                $booking->save();
                break;

            default:
                $payment->payment_status = 'pending';
                $payment->save();
        }
    }

    private function markPaid(Payment $payment, Booking $booking): void
    {
        $payment->payment_status = 'paid';
        $payment->paid_at = now();
        $payment->save();

        $booking->status_pembayaran = 'paid';
        $booking->status_booking = 'confirmed';
        $booking->payment_method = $payment->payment_type ?: 'midtrans';
        $booking->paid_at = now();
        $booking->save();

        BookingSeat::where('booking_id', $booking->id)
            ->update(['status_booking' => 'confirmed']);
    }

    /**
     * Konfirmasi pembayaran secara manual oleh admin (untuk pembayaran di loket).
     */
    public function confirmManually(Booking $booking, string $method = 'cash'): void
    {
        DB::transaction(function () use ($booking, $method) {
            $payment = $booking->payment;

            if (! $payment) {
                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'order_id' => 'MID-'.$booking->kode_booking,
                    'gross_amount' => $booking->total_harga,
                    'payment_status' => 'pending',
                ]);
            }

            $payment->payment_type = $method;
            $payment->transaction_status = 'settlement';
            $payment->payment_status = 'paid';
            $payment->paid_at = now();
            $payment->save();

            $booking->status_pembayaran = 'paid';
            $booking->status_booking = 'confirmed';
            $booking->payment_method = $method;
            $booking->paid_at = now();
            $booking->save();

            BookingSeat::where('booking_id', $booking->id)
                ->update(['status_booking' => 'confirmed']);
        });
    }

    public function checkStatus(Booking $booking): void
    {
        $payment = $booking->payment;

        if (! $payment || empty($payment->order_id) || ! $this->isConfigured()) {
            return;
        }

        try {
            $result = Transaction::status($payment->order_id);

            $status = $result->transaction_status ?? '';
            $fraud = $result->fraud_status ?? null;

            $payment->transaction_status = $status;
            $payment->raw_response = array_merge($payment->raw_response ?? [], (array) $result);

            $this->resolvePaymentStatus($payment, $status, $fraud, $booking);
        } catch (\Throwable $e) {
            Log::warning('Cek status Midtrans gagal untuk '.$payment->order_id.': '.$e->getMessage());
        }
    }
}
