<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\Operator;
use App\Models\Rute;
use App\Models\Terminal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private function seedJourney(): array
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
            'kapasitas' => 8,
            'status' => 'aktif',
        ]);

        $kursis = [];
        foreach (['1A', '1B', '1C', '1D', '2A', '2B'] as $nomor) {
            $kursis[$nomor] = Kursi::create([
                'id_bus' => $bus->id_bus,
                'nomor_kursi' => $nomor,
                'status' => 'tersedia',
            ]);
        }

        $jadwal = Jadwal::factory()->create([
            'id_bus' => $bus->id_bus,
            'id_rute' => $rute->id_rute,
            'harga' => 100000,
            'status' => 'tersedia',
            'tanggal' => today()->addDays(2)->format('Y-m-d'),
        ]);

        $customer = User::factory()->customer()->create();
        $other = User::factory()->customer()->create();

        return compact('operator', 'asal', 'tujuan', 'rute', 'bus', 'kursis', 'jadwal', 'customer', 'other');
    }

    private function loginAs(User $user): void
    {
        $this->session([
            'cek' => true,
            'user_id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'role' => $user->role,
        ]);
    }

    private function passengerPayload(Kursi $kursi, string $name = 'Andi Test'): array
    {
        return [
            'id_kursi' => $kursi->id_kursi,
            'nama' => $name,
            'nik' => '1201234567890001',
            'no_hp' => '081234567890',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1992-03-15',
        ];
    }

    public function test_guest_can_create_booking_without_login(): void
    {
        $data = $this->seedJourney();
        $jadwal = $data['jadwal'];
        $kursi = $data['kursis']['1A'];

        $response = $this->post('/booking/store', [
            'id_jadwal' => $jadwal->id_jadwal,
            'penumpang' => [0 => $this->passengerPayload($kursi)],
        ]);

        $response->assertRedirect();

        $booking = Booking::whereNull('user_id')->latest()->first();
        $this->assertNotNull($booking);
        $this->assertEquals('pending', $booking->status_booking);
        $response->assertRedirect(route('customer.booking.detail', $booking->id));

        // Tamu dapat melihat detail pesanan yang baru dibuat dalam sesi yang sama
        $this->get('/booking/'.$booking->id)->assertOk();
    }

    public function test_customer_can_create_booking(): void
    {
        $data = $this->seedJourney();
        $this->loginAs($data['customer']);

        $response = $this->post('/booking/store', [
            'id_jadwal' => $data['jadwal']->id_jadwal,
            'penumpang' => [0 => $this->passengerPayload($data['kursis']['1A'])],
        ]);

        $response->assertRedirect();

        $booking = Booking::where('user_id', $data['customer']->id)->first();

        $this->assertNotNull($booking);
        $this->assertEquals('pending', $booking->status_booking);
        $this->assertEquals(100000, $booking->total_harga);
        $this->assertSame(1, $booking->bookingSeats()->count());

        // Verifikasi Bug 1: Pelanggan yang login dapat mengakses detail pemesanan mereka tanpa 403
        $this->get('/booking/'.$booking->id)->assertOk();
        $this->get('/booking/'.$booking->id.'/bayar')->assertOk();
    }

    public function test_double_booking_same_seat_is_rejected(): void
    {
        $data = $this->seedJourney();
        $this->loginAs($data['customer']);

        $payload = [
            'id_jadwal' => $data['jadwal']->id_jadwal,
            'penumpang' => [0 => $this->passengerPayload($data['kursis']['1A'])],
        ];

        $this->post('/booking/store', $payload)->assertRedirect();

        $second = $this->post('/booking/store', $payload);

        $second->assertRedirect();

        $this->assertSame(
            1,
            Booking::where('user_id', $data['customer']->id)->count(),
            'Kursi yang sama tidak boleh dipesan dua kali.'
        );
    }

    public function test_customer_cannot_view_other_users_booking(): void
    {
        $data = $this->seedJourney();
        $this->loginAs($data['customer']);

        $this->post('/booking/store', [
            'id_jadwal' => $data['jadwal']->id_jadwal,
            'penumpang' => [0 => $this->passengerPayload($data['kursis']['1A'])],
        ])->assertRedirect();

        $booking = Booking::where('user_id', $data['customer']->id)->firstOrFail();

        $this->loginAs($data['other']);

        $this->get('/booking/'.$booking->id)->assertForbidden();
        $this->get('/booking/'.$booking->id.'/bayar')->assertForbidden();
        $this->get('/booking/'.$booking->id.'/tiket')->assertForbidden();
    }

    public function test_ticket_not_available_before_payment(): void
    {
        $data = $this->seedJourney();
        $this->loginAs($data['customer']);

        $this->post('/booking/store', [
            'id_jadwal' => $data['jadwal']->id_jadwal,
            'penumpang' => [0 => $this->passengerPayload($data['kursis']['1A'])],
        ])->assertRedirect();

        $booking = Booking::where('user_id', $data['customer']->id)->firstOrFail();

        $this->get('/booking/'.$booking->id.'/tiket')->assertRedirect();
    }

    public function test_admin_can_confirm_payment_and_ticket_becomes_available(): void
    {
        $data = $this->seedJourney();
        $this->loginAs($data['customer']);

        $this->post('/booking/store', [
            'id_jadwal' => $data['jadwal']->id_jadwal,
            'penumpang' => [0 => $this->passengerPayload($data['kursis']['1A'])],
        ])->assertRedirect();

        $booking = Booking::where('user_id', $data['customer']->id)->firstOrFail();

        $admin = User::factory()->admin()->create();
        $this->loginAs($admin);

        $this->post('/admin/bookings/'.$booking->id.'/confirm-payment', [
            'payment_method' => 'cash',
        ])->assertRedirect();

        $booking->refresh();

        $this->assertEquals('paid', $booking->status_pembayaran);
        $this->assertEquals('confirmed', $booking->status_booking);

        $this->loginAs($data['customer']);
        $this->get('/booking/'.$booking->id.'/tiket')->assertOk();
    }

    public function test_guest_accessing_customer_bookings_is_redirected_to_login(): void
    {
        $response = $this->get('/customer/bookings');

        $response->assertRedirect(route('login'));
    }

    public function test_guest_booking_is_associated_with_customer_after_login(): void
    {
        $data = $this->seedJourney();
        $jadwal = $data['jadwal'];
        $kursi = $data['kursis']['1A'];

        // Tamu pesan tiket tanpa login
        $this->post('/booking/store', [
            'id_jadwal' => $jadwal->id_jadwal,
            'penumpang' => [0 => $this->passengerPayload($kursi)],
        ])->assertRedirect();

        $booking = Booking::whereNull('user_id')->latest()->first();
        $this->assertNotNull($booking);

        // Tamu melakukan login
        $customer = $data['customer'];
        $this->post('/auth/login', [
            'identity' => $customer->username,
            'password' => 'password',
        ])->assertRedirect(route('customer.dashboard'));

        // Booking sekarang otomatis terhubung ke akun customer
        $booking->refresh();
        $this->assertEquals($customer->id, $booking->user_id);

        // Customer dapat mengakses riwayat pesanannya
        $this->get('/customer/bookings')->assertOk();
    }

    public function test_search_filters_out_departed_schedules_for_today(): void
    {
        Carbon::setTestNow('2026-11-06 14:00:00');

        $data = $this->seedJourney();
        $rute = $data['rute'];
        $bus = $data['bus'];

        // Jadwal yang sudah lewat tadi pagi (10:00)
        $pastJadwal = Jadwal::factory()->create([
            'id_bus' => $bus->id_bus,
            'id_rute' => $rute->id_rute,
            'tanggal' => '2026-11-06',
            'jam_berangkat' => '10:00',
            'jam_tiba' => '16:00',
            'status' => 'tersedia',
        ]);

        // Jadwal yang akan berangkat sore nanti (16:00)
        $futureJadwal = Jadwal::factory()->create([
            'id_bus' => $bus->id_bus,
            'id_rute' => $rute->id_rute,
            'tanggal' => '2026-11-06',
            'jam_berangkat' => '16:00',
            'jam_tiba' => '22:00',
            'status' => 'tersedia',
        ]);

        $response = $this->get(route('tiket.search', [
            'terminal_asal' => $rute->terminal_asal_id,
            'terminal_tujuan' => $rute->terminal_tujuan_id,
            'tanggal' => '2026-11-06',
            'penumpang' => 1,
        ]));

        $response->assertOk();

        $jadwals = $response->viewData('jadwals');
        $this->assertFalse($jadwals->contains('id_jadwal', $pastJadwal->id_jadwal));
        $this->assertTrue($jadwals->contains('id_jadwal', $futureJadwal->id_jadwal));

        Carbon::setTestNow();
    }

    public function test_cannot_access_or_book_departed_schedule(): void
    {
        Carbon::setTestNow('2026-11-06 14:00:00');

        $data = $this->seedJourney();
        $rute = $data['rute'];
        $bus = $data['bus'];
        $kursi = $data['kursis']['1A'];

        $pastJadwal = Jadwal::factory()->create([
            'id_bus' => $bus->id_bus,
            'id_rute' => $rute->id_rute,
            'tanggal' => '2026-11-06',
            'jam_berangkat' => '10:00',
            'jam_tiba' => '16:00',
            'status' => 'tersedia',
        ]);

        // Coba akses halaman pemilihan kursi untuk jadwal yang sudah lewat
        $seatsResponse = $this->get(route('tiket.seats', $pastJadwal->id_jadwal));
        $seatsResponse->assertRedirect(route('tiket.search.form'));
        $seatsResponse->assertSessionHas('error');

        // Coba kirim request booking langsung
        $bookResponse = $this->post('/booking/store', [
            'id_jadwal' => $pastJadwal->id_jadwal,
            'penumpang' => [0 => $this->passengerPayload($kursi)],
        ]);
        $bookResponse->assertRedirect(route('tiket.seats', $pastJadwal->id_jadwal));
        $bookResponse->assertSessionHas('error');

        Carbon::setTestNow();
    }
}
