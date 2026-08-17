<?php

namespace Database\Factories;

use App\Models\Terminal;
use Illuminate\Database\Eloquent\Factories\Factory;

class TerminalFactory extends Factory
{
    protected $model = Terminal::class;

    public function definition(): array
    {
        return [
            'nama_terminal' => 'Terminal ' . fake()->city(),
            'kode_terminal' => strtoupper(fake()->unique()->bothify('TML-###')),
            'alamat' => fake()->streetAddress(),
            'kota' => fake()->city(),
            'provinsi' => 'Sulawesi Selatan',
            'status' => 'aktif',
        ];
    }
}
