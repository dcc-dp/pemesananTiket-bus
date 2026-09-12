<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Kursi;
use App\Models\Operator;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            ['operator' => 'OP-DAMRI', 'buses' => [
                ['nomor_polisi' => 'DD 1012 AB', 'nama_bus' => 'Damri Ekspres 1', 'kapasitas' => 40, 'fasilitas' => 'AC, Wifi, Reclining Seat'],
                ]],
            ['operator' => 'OP-SINARJAYA', 'buses' => [
                ['nomor_polisi' => 'AG 2345 BD', 'nama_bus' => 'Sinar Jaya Raya', 'kapasitas' => 30, 'fasilitas' => 'AC, Wifi, Toilet, Reclining Seat, TV'],
            ]],
            ['operator' => 'OP-GUNUNGHARTA', 'buses' => [
                ['nomor_polisi' => 'AG 3456 CF', 'nama_bus' => 'Gunung Harta Nusantara', 'kapasitas' => 30, 'fasilitas' => 'AC, Wifi, Toilet, Reclining Seat'],
            ]],
            ['operator' => 'OP-ROSALIA', 'buses' => [
                ['nomor_polisi' => 'AD 4567 DH', 'nama_bus' => 'Rosalia Indah 88', 'kapasitas' => 24, 'fasilitas' => 'AC, Wifi, Toilet, Sleeper Bed'],
            ]],
            ['operator' => 'OP-HARAPANJAYA', 'buses' => [
                ['nomor_polisi' => 'B 5678 EK', 'nama_bus' => 'Harapan Jaya Ekonomi', 'kapasitas' => 40, 'fasilitas' => 'AC'],
            ]],
        ];

        foreach ($configs as $config) {
            $operator = Operator::where('kode_operator', $config['operator'])->first();
            if (!$operator) {
                continue;
            }

            foreach ($config['buses'] as $index => $bus) {
                $bus['operator_id'] = $operator->id;
                $bus['kode_bus'] = $operator->kode_operator . '-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);

                $existing = Bus::where('nomor_polisi', $bus['nomor_polisi'])->first();
                if ($existing) {
                    $existing->update($bus);
                    $created = $existing;
                } else {
                    $created = Bus::create($bus);
                }

                $this->generateSeats($created);
            }
        }
    }

    private function generateSeats(Bus $bus): void
    {
        $kapasitas = $bus->kapasitas;
        $rows = intdiv($kapasitas, 4);
        $seats = [];

        foreach (range(1, $rows) as $row) {
            foreach (['A', 'B', 'C', 'D'] as $col) {
                $seats[] = $row . $col;
            }
        }

        foreach ($seats as $nomor) {
            Kursi::updateOrCreate(
                ['id_bus' => $bus->id_bus, 'nomor_kursi' => $nomor],
                ['posisi' => 'jendela', 'status' => 'tersedia']
            );
        }
    }
}