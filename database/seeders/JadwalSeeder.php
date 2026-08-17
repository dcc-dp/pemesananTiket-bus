<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Jadwal;
use App\Models\Rute;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $buses = Bus::all();
        $routes = Rute::all();

        if ($buses->isEmpty() || $routes->isEmpty()) {
            return;
        }

        $hargaPerKelas = [
            'ekonomi' => 150000,
            'bisnis' => 250000,
            'executive' => 350000,
            'sleeper' => 450000,
        ];

        $jamBerangkat = ['07:00', '09:00', '11:00', '13:00', '16:00', '19:00', '21:00'];
        $index = 0;

        for ($day = 1; $day <= 3; $day++) {
            $tanggal = now()->addDays($day)->format('Y-m-d');

            foreach ($routes as $route) {
                $bus = $buses[$index % $buses->count()];
                $index++;

                $durasi = $route->estimasi_durasi ?? 300;
                $berangkat = $jamBerangkat[$index % count($jamBerangkat)];

                Jadwal::updateOrCreate(
                    [
                        'id_bus' => $bus->id_bus,
                        'id_rute' => $route->id_rute,
                        'tanggal' => $tanggal,
                        'jam_berangkat' => $berangkat,
                    ],
                    [
                        'jam_tiba' => now()->parse($berangkat)->addMinutes($durasi)->format('H:i'),
                        'harga' => $hargaPerKelas[$bus->kelas] ?? 150000,
                        'status' => 'tersedia',
                    ]
                );
            }
        }
    }
}