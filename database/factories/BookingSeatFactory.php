<?php

namespace Database\Factories;

use App\Models\BookingSeat;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingSeatFactory extends Factory
{
    protected $model = BookingSeat::class;

    public function definition(): array
    {
        return [
            'booking_id' => \App\Models\Booking::factory(),
            'id_jadwal' => \App\Models\Jadwal::factory(),
            'id_kursi' => \App\Models\Kursi::factory(),
            'harga' => fake()->numberBetween(100000, 500000),
            'nama_penumpang' => fake()->name(),
            'nik' => fake()->numerify('################'),
            'no_hp' => fake()->phoneNumber(),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'tanggal_lahir' => fake()->dateTimeBetween('-50 years', '-17 years')->format('Y-m-d'),
            'status_booking' => 'pending',
        ];
    }
}
