<?php

namespace Database\Factories;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalFactory extends Factory
{
    protected $model = Jadwal::class;

    public function definition(): array
    {
        return [
            'id_bus' => \App\Models\Bus::factory(),
            'id_rute' => \App\Models\Rute::factory(),
            'tanggal' => fake()->dateTimeBetween('today', '+30 days')->format('Y-m-d'),
            'jam_berangkat' => fake()->time('H:i'),
            'jam_tiba' => fake()->time('H:i'),
            'harga' => fake()->numberBetween(100000, 500000),
            'status' => 'tersedia',
        ];
    }
}
