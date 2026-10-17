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
            ['nama_terminal' => 'Terminal Maccini Sombala', 'kode_terminal' => 'TML-MACCINI', 'alamat' => 'Jl. Hertasning', 'kota' => 'Makassar', 'provinsi' => 'Sulawesi Selatan', 'latitude' => -5.163000, 'longitude' => 119.412000],
            ['nama_terminal' => 'Terminal Parepare', 'kode_terminal' => 'TML-PAREPARE', 'alamat' => 'Jl. Jend. Sudirman', 'kota' => 'Parepare', 'provinsi' => 'Sulawesi Selatan', 'latitude' => -4.015000, 'longitude' => 119.635000],
            ['nama_terminal' => 'Terminal Palopo', 'kode_terminal' => 'TML-PALOPO', 'alamat' => 'Jl. Andi Djemma', 'kota' => 'Palopo', 'provinsi' => 'Sulawesi Selatan', 'latitude' => -2.994444, 'longitude' => 120.198611],
            ['nama_terminal' => 'Terminal Manado', 'kode_terminal' => 'TML-MANADO', 'alamat' => 'Jl. Martadinata', 'kota' => 'Manado', 'provinsi' => 'Sulawesi Utara', 'latitude' => 1.455000, 'longitude' => 124.825000],
            ['nama_terminal' => 'Terminal Palu', 'kode_terminal' => 'TML-PALU', 'alamat' => 'Jl. Moh. Yamin', 'kota' => 'Palu', 'provinsi' => 'Sulawesi Tengah', 'latitude' => -0.835000, 'longitude' => 119.885000],
            ['nama_terminal' => 'Terminal Kendari', 'kode_terminal' => 'TML-KENDARI', 'alamat' => 'Jl. Bunga Kamboja', 'kota' => 'Kendari', 'provinsi' => 'Sulawesi Tenggara', 'latitude' => -4.011667, 'longitude' => 122.502778],
            ['nama_terminal' => 'Terminal Ternate', 'kode_terminal' => 'TML-TERNATE', 'alamat' => 'Jl. Raya Bastiong', 'kota' => 'Ternate', 'provinsi' => 'Maluku Utara', 'latitude' => 0.783333, 'longitude' => 127.366667],
            ['nama_terminal' => 'Terminal Gorontalo', 'kode_terminal' => 'TML-GORONTALO', 'alamat' => 'Jl. Sultan Hasanuddin', 'kota' => 'Gorontalo', 'provinsi' => 'Gorontalo', 'latitude' => 0.540000, 'longitude' => 123.060000],
            ['nama_terminal' => 'Terminal Ambon', 'kode_terminal' => 'TML-AMBON', 'alamat' => 'Jl. Kapitan Pattimura', 'kota' => 'Ambon', 'provinsi' => 'Maluku', 'latitude' => -3.695833, 'longitude' => 128.183333],
            ['nama_terminal' => 'Terminal Samarinda', 'kode_terminal' => 'TML-SAMARINDA', 'alamat' => 'Jl. Pahlawan', 'kota' => 'Samarinda', 'provinsi' => 'Kalimantan Timur', 'latitude' => -0.502106, 'longitude' => 117.153709],
            ['nama_terminal' => 'Terminal Banjarmasin', 'kode_terminal' => 'TML-BANJARMASIN', 'alamat' => 'Jl. A. Yani KM 5', 'kota' => 'Banjarmasin', 'provinsi' => 'Kalimantan Selatan', 'latitude' => -3.319384, 'longitude' => 114.590755],
            ['nama_terminal' => 'Terminal Balikpapan', 'kode_terminal' => 'TML-BALIKPAPAN', 'alamat' => 'Jl. Jend. Sudirman', 'kota' => 'Balikpapan', 'provinsi' => 'Kalimantan Timur', 'latitude' => -1.265386, 'longitude' => 116.831200],
            ['nama_terminal' => 'Terminal Pontianak', 'kode_terminal' => 'TML-PONTIANAK', 'alamat' => 'Jl. Sutan Syahrir', 'kota' => 'Pontianak', 'provinsi' => 'Kalimantan Barat', 'latitude' => -0.026330, 'longitude' => 109.342504],
            ['nama_terminal' => 'Terminal Depok', 'kode_terminal' => 'TML-DEPOK', 'alamat' => 'Jl. Margonda Raya', 'kota' => 'Depok', 'provinsi' => 'Jawa Barat', 'latitude' => -6.402484, 'longitude' => 106.794241],
            ['nama_terminal' => 'Terminal Kampung Rambutan', 'kode_terminal' => 'TML-KPR', 'alamat' => 'Jl. Raya Bogor KM 12', 'kota' => 'Jakarta Timur', 'provinsi' => 'DKI Jakarta', 'latitude' => -6.310500, 'longitude' => 106.877000],
            ['nama_terminal' => 'Terminal Pulogebang', 'kode_terminal' => 'TML-PULOGEBANG', 'alamat' => 'Jl. Raya Pulogebang', 'kota' => 'Jakarta Timur', 'provinsi' => 'DKI Jakarta', 'latitude' => -6.212000, 'longitude' => 106.953000],
            ['nama_terminal' => 'Terminal Bungurasih', 'kode_terminal' => 'TML-BUNGURASIH', 'alamat' => 'Jl. Raya Bungurasih', 'kota' => 'Sidoarjo', 'provinsi' => 'Jawa Timur', 'latitude' => -7.354000, 'longitude' => 112.726000],
            ['nama_terminal' => 'Terminal Purabaya', 'kode_terminal' => 'TML-PURABAYA', 'alamat' => 'Jl. Raya Bungurasih No. 1', 'kota' => 'Surabaya', 'provinsi' => 'Jawa Timur', 'latitude' => -7.354000, 'longitude' => 112.726000],
        ];

        foreach ($terminals as $terminal) {
            Terminal::updateOrCreate(['kode_terminal' => $terminal['kode_terminal']], $terminal);
        }
    }
}
