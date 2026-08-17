<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'id_jadwal' => \App\Models\Jadwal::factory(),
            'kode_booking' => 'BUS-' . fake()->unique()->bothify('####??##'),
            'tanggal_booking' => now(),
            'total_harga' => fake()->numberBetween(100000, 2000000),
            'status_booking' => 'pending',
            'status_pembayaran' => 'unpaid',
            'expired_at' => now()->addHours(2),
        ];
    }
}
