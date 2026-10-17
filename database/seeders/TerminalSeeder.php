<?php

namespace Database\Seeders;

use App\Models\Terminal;
use Illuminate\Database\Seeder;

class TerminalSeeder extends Seeder
{
    public function run(): void
    {
        $terminals = [
            ['nama_terminal' => 'Terminal Daya', 'kode_terminal' => 'TML-DAYA', 'alamat' => 'Jl. Perintis Kemerdekaan KM 11', 'kota' => 'Makassar', 'provinsi' => 'Sulawesi Selatan', 'latitude' => -5.109722, 'longitude' => 119.509722],
            ['nama_terminal' => 'Terminal Malengkeri', 'kode_terminal' => 'TML-MALENGKERI', 'alamat' => 'Jl. Sultan Alauddin', 'kota' => 'Makassar', 'provinsi' => 'Sulawesi Selatan', 'latitude' => -5.176389, 'longitude' => 119.436389],
            ['nama_terminal' => 'Terminal Parepare', 'kode_terminal' => 'TML-PAREPARE', 'alamat' => 'Jl. Jend. Sudirman', 'kota' => 'Parepare', 'provinsi' => 'Sulawesi Selatan', 'latitude' => -4.015000, 'longitude' => 119.635000],
            ['nama_terminal' => 'Terminal Palopo', 'kode_terminal' => 'TML-PALOPO', 'alamat' => 'Jl. Andi Djemma', 'kota' => 'Palopo', 'provinsi' => 'Sulawesi Selatan', 'latitude' => -2.994444, 'longitude' => 120.198611],
            ['nama_terminal' => 'Terminal Manado', 'kode_terminal' => 'TML-MANADO', 'alamat' => 'Jl. Martadinata', 'kota' => 'Manado', 'provinsi' => 'Sulawesi Utara', 'latitude' => 1.455000, 'longitude' => 124.825000],
            ['nama_terminal' => 'Terminal Palu', 'kode_terminal' => 'TML-PALU', 'alamat' => 'Jl. Moh. Yamin', 'kota' => 'Palu', 'provinsi' => 'Sulawesi Tengah', 'latitude' => -0.835000, 'longitude' => 119.885000],
            ['nama_terminal' => 'Terminal Kendari', 'kode_terminal' => 'TML-KENDARI', 'alamat' => 'Jl. Bunga Kamboja', 'kota' => 'Kendari', 'provinsi' => 'Sulawesi Tenggara', 'latitude' => -4.011667, 'longitude' => 122.502778],
            ['nama_terminal' => 'Terminal Gorontalo', 'kode_terminal' => 'TML-GORONTALO', 'alamat' => 'Jl. Sultan Hasanuddin', 'kota' => 'Gorontalo', 'provinsi' => 'Gorontalo', 'latitude' => 0.540000, 'longitude' => 123.060000],
        
        ];

        foreach ($terminals as $terminal) {
            Terminal::updateOrCreate(['kode_terminal' => $terminal['kode_terminal']], $terminal);
        }
    }
}
