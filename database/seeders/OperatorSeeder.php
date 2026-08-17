<?php

namespace Database\Seeders;

use App\Models\Operator;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    public function run(): void
    {
        $operators = [
            [
                'nama_operator' => 'PO Damri',
                'kode_operator' => 'OP-DAMRI',
                'alamat' => 'Jl. Sultan Hasanuddin No. 1, Makassar',
                'telepon' => '0411-123456',
                'email' => 'cs@damri.co.id',
            ],
            [
                'nama_operator' => 'PO Sinar Jaya',
                'kode_operator' => 'OP-SINARJAYA',
                'alamat' => 'Jl. Veteran No. 45, Surabaya',
                'telepon' => '031-234567',
                'email' => 'info@sinarjaya.co.id',
            ],
            [
                'nama_operator' => 'PO Gunung Harta',
                'kode_operator' => 'OP-GUNUNGHARTA',
                'alamat' => 'Jl. Panglima Sudirman No. 78, Surabaya',
                'telepon' => '031-876543',
                'email' => 'cs@gunungharta.co.id',
            ],
            [
                'nama_operator' => 'PO Rosalia Indah',
                'kode_operator' => 'OP-ROSALIA',
                'alamat' => 'Jl. Bhayangkara No. 12, Boyolali',
                'telepon' => '0276-345678',
                'email' => 'info@rosaliaindah.co.id',
            ],
            [
                'nama_operator' => 'PO Harapan Jaya',
                'kode_operator' => 'OP-HARAPANJAYA',
                'alamat' => 'Jl. Pahlawan No. 90, Jakarta',
                'telepon' => '021-345678',
                'email' => 'cs@harapanjaya.co.id',
            ],
        ];

        foreach ($operators as $operator) {
            Operator::updateOrCreate(['kode_operator' => $operator['kode_operator']], $operator);
        }
    }
}
