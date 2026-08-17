<?php

namespace Database\Factories;

use App\Models\Bus;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusFactory extends Factory
{
    protected $model = Bus::class;

    public function definition(): array
    {
        $kelas = ['ekonomi', 'bisnis', 'executive', 'sleeper'];
        $kapasitas = ['ekonomi' => 40, 'bisnis' => 36, 'executive' => 30, 'sleeper' => 24];

        return [
            'operator_id' => \App\Models\Operator::factory(),
            'nomor_polisi' => fake()->unique()->regexify('[A-Z]{1,2} [0-9]{1,4} [A-Z]{1,3}'),
            'kode_bus' => strtoupper(fake()->unique()->bothify('BUS-###??')),
            'nama_bus' => fake()->words(2, true),
            'kelas' => $kelas = fake()->randomElement($kelas),
            'kapasitas' => $kapasitas[$kelas],
            'fasilitas' => implode(', ', fake()->randomElements(['AC', 'Wifi', 'Toilet', 'USB Charger', 'TV', 'Reclining Seat'], 3)),
            'status' => 'aktif',
        ];
    }
}
