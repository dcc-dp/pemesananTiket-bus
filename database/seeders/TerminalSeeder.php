<?php

namespace Database\Seeders;

use App\Models\Terminal;
use Illuminate\Database\Seeder;

class TerminalSeeder extends Seeder
{
    public function run(): void
    {
        $terminals = [
            ['nama_terminal' => 'Terminal Daya', 'kode_terminal' => 'TML-DAYA', 'alamat' => 'Jl. Perintis Kemerdekaan KM 11', 'kota' => 'Makassar', 'provinsi' => 'Sulawesi Selatan'],
            ['nama_terminal' => 'Terminal Malengkeri', 'kode_terminal' => 'TML-MALENGKERI', 'alamat' => 'Jl. Sultan Alauddin', 'kota' => 'Makassar', 'provinsi' => 'Sulawesi Selatan'],
            ['nama_terminal' => 'Terminal Parepare', 'kode_terminal' => 'TML-PAREPARE', 'alamat' => 'Jl. Jend. Sudirman', 'kota' => 'Parepare', 'provinsi' => 'Sulawesi Selatan'],
            ['nama_terminal' => 'Terminal Palopo', 'kode_terminal' => 'TML-PALOPO', 'alamat' => 'Jl. Andi Djemma', 'kota' => 'Palopo', 'provinsi' => 'Sulawesi Selatan'],
            ['nama_terminal' => 'Terminal Palu', 'kode_terminal' => 'TML-PALU', 'alamat' => 'Jl. Moh. Yamin', 'kota' => 'Palu', 'provinsi' => 'Sulawesi Tengah'],
            ['nama_terminal' => 'Terminal Kendari', 'kode_terminal' => 'TML-KENDARI', 'alamat' => 'Jl. Bunga Kamboja', 'kota' => 'Kendari', 'provinsi' => 'Sulawesi Tenggara'],
            ['nama_terminal' => 'Terminal Gorontalo', 'kode_terminal' => 'TML-GORONTALO', 'alamat' => 'Jl. Sultan Hasanuddin', 'kota' => 'Gorontalo', 'provinsi' => 'Gorontalo'],
        ];

        foreach ($terminals as $terminal) {
            Terminal::updateOrCreate(['kode_terminal' => $terminal['kode_terminal']], $terminal);
        }
    }
}
