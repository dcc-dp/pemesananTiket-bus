<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Kursi;
use Illuminate\Database\Eloquent\Factories\Factory;

class KursiFactory extends Factory
{
    protected $model = Kursi::class;

    public function definition(): array
    {
        return [
            'id_bus' => Bus::factory(),
            'nomor_kursi' => fake()->randomElement(['1A', '1B', '1C', '1D', '2A', '2B']),
            'posisi' => fake()->randomElement(['jendela', 'tengah', 'lorong']),
            'status' => 'tersedia',
        ];
    }
}
