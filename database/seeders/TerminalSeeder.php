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
            ['nama_terminal' => 'Terminal Maccini Sombala', 'kode_terminal' => 'TML-MACCINI', 'alamat' => 'Jl. Hertasning', 'kota' => 'Makassar', 'provinsi' => 'Sulawesi Selatan'],
            ['nama_terminal' => 'Terminal Parepare', 'kode_terminal' => 'TML-PAREPARE', 'alamat' => 'Jl. Jend. Sudirman', 'kota' => 'Parepare', 'provinsi' => 'Sulawesi Selatan'],
            ['nama_terminal' => 'Terminal Palopo', 'kode_terminal' => 'TML-PALOPO', 'alamat' => 'Jl. Andi Djemma', 'kota' => 'Palopo', 'provinsi' => 'Sulawesi Selatan'],
            ['nama_terminal' => 'Terminal Manado', 'kode_terminal' => 'TML-MANADO', 'alamat' => 'Jl. Martadinata', 'kota' => 'Manado', 'provinsi' => 'Sulawesi Utara'],
            ['nama_terminal' => 'Terminal Palu', 'kode_terminal' => 'TML-PALU', 'alamat' => 'Jl. Moh. Yamin', 'kota' => 'Palu', 'provinsi' => 'Sulawesi Tengah'],
            ['nama_terminal' => 'Terminal Kendari', 'kode_terminal' => 'TML-KENDARI', 'alamat' => 'Jl. Bunga Kamboja', 'kota' => 'Kendari', 'provinsi' => 'Sulawesi Tenggara'],
            ['nama_terminal' => 'Terminal Ternate', 'kode_terminal' => 'TML-TERNATE', 'alamat' => 'Jl. Raya Bastiong', 'kota' => 'Ternate', 'provinsi' => 'Maluku Utara'],
            ['nama_terminal' => 'Terminal Gorontalo', 'kode_terminal' => 'TML-GORONTALO', 'alamat' => 'Jl. Sultan Hasanuddin', 'kota' => 'Gorontalo', 'provinsi' => 'Gorontalo'],
            ['nama_terminal' => 'Terminal Ambon', 'kode_terminal' => 'TML-AMBON', 'alamat' => 'Jl. Kapitan Pattimura', 'kota' => 'Ambon', 'provinsi' => 'Maluku'],
            ['nama_terminal' => 'Terminal Samarinda', 'kode_terminal' => 'TML-SAMARINDA', 'alamat' => 'Jl. Pahlawan', 'kota' => 'Samarinda', 'provinsi' => 'Kalimantan Timur'],
            ['nama_terminal' => 'Terminal Banjarmasin', 'kode_terminal' => 'TML-BANJARMASIN', 'alamat' => 'Jl. A. Yani KM 5', 'kota' => 'Banjarmasin', 'provinsi' => 'Kalimantan Selatan'],
            ['nama_terminal' => 'Terminal Balikpapan', 'kode_terminal' => 'TML-BALIKPAPAN', 'alamat' => 'Jl. Jend. Sudirman', 'kota' => 'Balikpapan', 'provinsi' => 'Kalimantan Timur'],
            ['nama_terminal' => 'Terminal Pontianak', 'kode_terminal' => 'TML-PONTIANAK', 'alamat' => 'Jl. Sutan Syahrir', 'kota' => 'Pontianak', 'provinsi' => 'Kalimantan Barat'],
            ['nama_terminal' => 'Terminal Depok', 'kode_terminal' => 'TML-DEPOK', 'alamat' => 'Jl. Margonda Raya', 'kota' => 'Depok', 'provinsi' => 'Jawa Barat'],
            ['nama_terminal' => 'Terminal Kampung Rambutan', 'kode_terminal' => 'TML-KPR', 'alamat' => 'Jl. Raya Bogor KM 12', 'kota' => 'Jakarta Timur', 'provinsi' => 'DKI Jakarta'],
            ['nama_terminal' => 'Terminal Pulogebang', 'kode_terminal' => 'TML-PULOGEBANG', 'alamat' => 'Jl. Raya Pulogebang', 'kota' => 'Jakarta Timur', 'provinsi' => 'DKI Jakarta'],
            ['nama_terminal' => 'Terminal Bungurasih', 'kode_terminal' => 'TML-BUNGURASIH', 'alamat' => 'Jl. Raya Bungurasih', 'kota' => 'Sidoarjo', 'provinsi' => 'Jawa Timur'],
            ['nama_terminal' => 'Terminal Purabaya', 'kode_terminal' => 'TML-PURABAYA', 'alamat' => 'Jl. Raya Bungurasih No. 1', 'kota' => 'Surabaya', 'provinsi' => 'Jawa Timur'],
        ];

        foreach ($terminals as $terminal) {
            Terminal::updateOrCreate(['kode_terminal' => $terminal['kode_terminal']], $terminal);
        }
    }
}