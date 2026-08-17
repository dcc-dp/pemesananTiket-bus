<?php

namespace Database\Factories;

use App\Models\Rute;
use Illuminate\Database\Eloquent\Factories\Factory;

class RuteFactory extends Factory
{
    protected $model = Rute::class;

    public function definition(): array
    {
        return [
            'terminal_asal_id' => \App\Models\Terminal::factory(),
            'terminal_tujuan_id' => \App\Models\Terminal::factory(),
            'jarak' => fake()->numberBetween(50, 800),
            'estimasi_durasi' => fake()->numberBetween(1, 14) * 60,
            'status' => 'aktif',
        ];
    }
}
