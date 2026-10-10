<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Operator;
use App\Models\Payment;
use App\Models\Rute;
use App\Models\Terminal;
use App\Models\User;
use App\Services\BookingService;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MidtransPaymentTest extends TestCase
{
    use DatabaseTransactions;

    private function setupBookingEnvironment(): array
    {
        $operator = Operator::factory()->create();
        $asal = Terminal::factory()->create();
        $tujuan = Terminal::factory()->create();
        $rute = Rute::factory()->create([
            'terminal_asal_id' => $asal->id_terminal,
            'terminal_tujuan_id' => $tujuan->id_terminal,
        ]);

        $bus = Bus::factory()->create([
            'operator_id' => $operator->id,
            'kapasitas' => 10,
            'status' => 'aktif',
        ]);

        $kursi1 = Kursi::create([
            'id_bus' => $bus->id_bus,
            'nomor_kursi' => '1A',
            'status' => 'tersedia',
        ]);

        $kursi2 = Kursi::create([
            'id_bus' => $bus->id_bus,
            'nomor_kursi' => '1B',
            'status' => 'tersedia',
        ]);

        $jadwal = Jadwal::factory()->create([
            'id_bus' => $bus->id_bus,
            'id_rute' => $rute->id_rute,
            'harga' => 150000,
            'status' => 'tersedia',
            'tanggal' => today()->addDays(3)->format('Y-m-d'),
        ]);

        $customer1 = User::factory()->customer()->create();
        $customer2 = User::factory()->customer()->create();

        return compact('operator', 'asal', 'tujuan', 'rute', 'bus', 'kursi1', 'kursi2', 'jadwal', 'customer1', 'customer2');
    }

    private function loginUser(User $user): void
    {
        $this->session([
            'cek' => true,
            'user_id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'role' => $user->role,
        ]);
    }

    /**
     * Test 1: Alur Pemesanan Normal hingga halaman Pembayaran
     */
    public function test_normal_booking_flow_creates_pending_order_and_payment(): void
    {
        $data = $this->setupBookingEnvironment();
        $this->loginUser($data['customer1']);

        // 1. Kunjungi form penumpang
        $responseForm = $this->get('/booking/'.$data['jadwal']->id_jadwal.'/form?seats[]='.$data['kursi1']->id_kursi);
        $responseForm->assertOk();

        // 2. Submit data pemesan
        $responseStore = $this->post('/booking/store', [
            'id_jadwal' => $data['jadwal']->id_jadwal,
            'penumpang' => [
                0 => [
                    'id_kursi' => $data['kursi1']->id_kursi,
                    'nama' => 'Budi Santoso',
                    'nik' => '7371012345670001',
                    'no_hp' => '081234567890',
                    'jenis_kelamin' => 'L',
                    'tanggal_lahir' => '1995-05-20',
                ],
            ],
        ]);

        $responseStore->assertRedirect();
        $booking = Booking::where('user_id', $data['customer1']->id)->latest('id')->firstOrFail();

        $this->assertEquals('pending', $booking->status_booking);
        $this->assertEquals('unpaid', $booking->status_pembayaran);
        $this->assertEquals(150000, $booking->total_harga);

        // 3. Akses halaman bayar (Langkah 4: Midtrans Payment)
        $responsePay = $this->get('/booking/'.$booking->id.'/bayar');
        $responsePay->assertOk();

        $booking->refresh();
        $this->assertEquals('pending', $booking->status_pembayaran);
        $this->assertNotNull($booking->payment);
        $this->assertEquals('MID-'.$booking->kode_booking, $booking->payment->order_id);
    }

    /**
     * Test 2: Pembayaran Berhasil via Webhook Midtrans (settlement) -> Pesanan Lunas & Tiket Aktif
     */
    public function test_midtrans_webhook_settlement_marks_booking_paid_and_ticket_available(): void
    {
        $data = $this->setupBookingEnvironment();
        $bookingService = app(BookingService::class);
        $paymentService = app(PaymentService::class);

        $booking = $bookingService->createBooking($data['customer1'], $data['jadwal'], [
            [
                'id_kursi' => $data['kursi1']->id_kursi,
                'nama_penumpang' => 'Budi Santoso',
                'nik' => '7371012345670001',
                'no_hp' => '081234567890',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1995-05-20',
            ],
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'order_id' => 'MID-'.$booking->kode_booking,
            'gross_amount' => $booking->total_harga,
            'payment_status' => 'pending',
        ]);

        $serverKey = config('midtrans.server_key');
        $orderId = $payment->order_id;
        $statusCode = '200';
        $grossAmount = (string) $booking->total_harga;
        $signatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        $webhookPayload = [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'settlement',
            'transaction_id' => 'midtrans-trx-12345',
            'payment_type' => 'qris',
        ];

        // Callback ke /midtrans/callback
        $response = $this->postJson('/midtrans/callback', $webhookPayload);
        $response->assertOk();

        $booking->refresh();
        $payment->refresh();

        $this->assertEquals('paid', $payment->payment_status);
        $this->assertEquals('paid', $booking->status_pembayaran);
        $this->assertEquals('confirmed', $booking->status_booking);
        $this->assertEquals('confirmed', $booking->bookingSeats->first()->status_booking);

        // Tiket kini dapat diakses oleh customer
        $this->loginUser($data['customer1']);
        $ticketResponse = $this->get('/booking/'.$booking->id.'/tiket');
        $ticketResponse->assertOk();
    }

    /**
     * Test 3: Pembayaran Gagal via Webhook Midtrans (cancel/deny) -> Status failed & Kursi lepas
     */
    public function test_midtrans_webhook_failed_updates_status_and_releases_seat(): void
    {
        $data = $this->setupBookingEnvironment();
        $bookingService = app(BookingService::class);

        $booking = $bookingService->createBooking($data['customer1'], $data['jadwal'], [
            [
                'id_kursi' => $data['kursi1']->id_kursi,
                'nama_penumpang' => 'Budi Santoso',
                'nik' => '7371012345670001',
                'no_hp' => '081234567890',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1995-05-20',
            ],
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'order_id' => 'MID-'.$booking->kode_booking,
            'gross_amount' => $booking->total_harga,
            'payment_status' => 'pending',
        ]);

        $serverKey = config('midtrans.server_key');
        $orderId = $payment->order_id;
        $statusCode = '202';
        $grossAmount = (string) $booking->total_harga;
        $signatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        $webhookPayload = [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'cancel',
            'transaction_id' => 'midtrans-trx-failed',
            'payment_type' => 'bank_transfer',
        ];

        $response = $this->postJson('/payment/callback', $webhookPayload);
        $response->assertOk();

        $booking->refresh();
        $payment->refresh();

        $this->assertEquals('failed', $payment->payment_status);
        $this->assertEquals('failed', $booking->status_pembayaran);
        $this->assertEquals('cancelled', $booking->status_booking);

        // Kursi 1A kembali tersedia dan tidak terdaftar di kursiTerpesan
        $this->assertFalse(in_array($data['kursi1']->id_kursi, $data['jadwal']->fresh()->kursiTerpesan()));

        // Tiket tidak dapat diakses
        $this->loginUser($data['customer1']);
        $this->get('/booking/'.$booking->id.'/tiket')->assertRedirect();
    }

    /**
     * Test 4: Pembayaran Expired via Webhook Midtrans -> Status expired & Kursi kembali tersedia
     */
    public function test_midtrans_webhook_expired_updates_status_and_seat_becomes_available(): void
    {
        $data = $this->setupBookingEnvironment();
        $bookingService = app(BookingService::class);

        $booking = $bookingService->createBooking($data['customer1'], $data['jadwal'], [
            [
                'id_kursi' => $data['kursi1']->id_kursi,
                'nama_penumpang' => 'Budi Santoso',
                'nik' => '7371012345670001',
                'no_hp' => '081234567890',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1995-05-20',
            ],
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'order_id' => 'MID-'.$booking->kode_booking,
            'gross_amount' => $booking->total_harga,
            'payment_status' => 'pending',
        ]);

        $serverKey = config('midtrans.server_key');
        $orderId = $payment->order_id;
        $statusCode = '202';
        $grossAmount = (string) $booking->total_harga;
        $signatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        $webhookPayload = [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'expire',
            'transaction_id' => 'midtrans-trx-expired',
            'payment_type' => 'echannel',
        ];

        $response = $this->postJson('/midtrans/callback', $webhookPayload);
        $response->assertOk();

        $booking->refresh();
        $payment->refresh();

        $this->assertEquals('expired', $booking->status_pembayaran);
        $this->assertEquals('expired', $booking->status_booking);

        // Kursi 1A kembali tersedia untuk dipesan customer 2
        $this->assertTrue($bookingService->isSeatAvailable($data['jadwal']->fresh(), $data['kursi1']));

        // Customer 2 kini berhasil memesan kursi 1A tersebut
        $newBooking = $bookingService->createBooking($data['customer2'], $data['jadwal']->fresh(), [
            [
                'id_kursi' => $data['kursi1']->id_kursi,
                'nama_penumpang' => 'Siti Aminah',
                'nik' => '7371012345670002',
                'no_hp' => '081298765432',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1998-08-12',
            ],
        ]);

        $this->assertNotNull($newBooking);
        $this->assertEquals('pending', $newBooking->status_booking);
    }

    /**
     * Test 5: Pencegahan Double Booking Kursi
     */
    public function test_double_booking_prevention_while_pending(): void
    {
        $data = $this->setupBookingEnvironment();
        $bookingService = app(BookingService::class);

        // Customer 1 memesan Kursi 1A
        $booking1 = $bookingService->createBooking($data['customer1'], $data['jadwal'], [
            [
                'id_kursi' => $data['kursi1']->id_kursi,
                'nama_penumpang' => 'Customer A',
                'nik' => '7371012345670001',
                'no_hp' => '081234567890',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1995-05-20',
            ],
        ]);

        $this->assertNotNull($booking1);

        // Customer 2 mencoba memesan Kursi 1A yang sama
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('sudah dipesan orang lain');

        $bookingService->createBooking($data['customer2'], $data['jadwal']->fresh(), [
            [
                'id_kursi' => $data['kursi1']->id_kursi,
                'nama_penumpang' => 'Customer B',
                'nik' => '7371012345670002',
                'no_hp' => '081298765432',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1996-06-25',
            ],
        ]);
    }

    /**
     * Test 6: Verifikasi Keamanan Webhook (Signature & Gross Amount)
     */
    public function test_midtrans_webhook_rejects_tampered_amount(): void
    {
        $data = $this->setupBookingEnvironment();
        $bookingService = app(BookingService::class);

        $booking = $bookingService->createBooking($data['customer1'], $data['jadwal'], [
            [
                'id_kursi' => $data['kursi1']->id_kursi,
                'nama_penumpang' => 'Budi Santoso',
                'nik' => '7371012345670001',
                'no_hp' => '081234567890',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1995-05-20',
            ],
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'order_id' => 'MID-'.$booking->kode_booking,
            'gross_amount' => $booking->total_harga,
            'payment_status' => 'pending',
        ]);

        $serverKey = config('midtrans.server_key');
        $orderId = $payment->order_id;
        $statusCode = '200';
        $tamperedAmount = '50000'; // Seharusnya 150000
        $signatureKey = hash('sha512', $orderId.$statusCode.$tamperedAmount.$serverKey);

        $webhookPayload = [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $tamperedAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'settlement',
            'transaction_id' => 'midtrans-tampered-123',
            'payment_type' => 'qris',
        ];

        $response = $this->postJson('/midtrans/callback', $webhookPayload);
        $response->assertOk();

        $booking->refresh();
        $payment->refresh();

        // Status TIDAK boleh berubah menjadi paid karena nominal di-tamper
        $this->assertEquals('pending', $payment->payment_status);
        $this->assertEquals('unpaid', $booking->status_pembayaran);
    }
}
