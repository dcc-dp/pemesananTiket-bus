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

    public function test_guest_redirected_to_login_when_booking(): void
    {
        $data = $this->seedJourney();
        $jadwal = $data['jadwal'];
        $kursi = $data['kursis']['1A'];

        $this->post('/booking/store', [
            'id_jadwal' => $jadwal->id_jadwal,
            'penumpang' => [0 => $this->passengerPayload($kursi)],
        ])->assertRedirect('/auth/login');
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
}
