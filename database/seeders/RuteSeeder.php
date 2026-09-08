<?php

namespace Database\Seeders;

use App\Models\Rute;
use App\Models\Terminal;
use Illuminate\Database\Seeder;

class RuteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            ['asal' => 'TML-DAYA', 'tujuan' => 'TML-PAREPARE', 'jarak' => 154, 'durasi' => 165],
            ['asal' => 'TML-DAYA', 'tujuan' => 'TML-KENDARI', 'jarak' => 688, 'durasi' => 780],
            ['asal' => 'TML-PAREPARE', 'tujuan' => 'TML-PALOPO', 'jarak' => 226, 'durasi' => 240],
            ['asal' => 'TML-PALU', 'tujuan' => 'TML-MANADO', 'jarak' => 520, 'durasi' => 540],
            ['asal' => 'TML-DAYA', 'tujuan' => 'TML-GORONTALO', 'jarak' => 500, 'durasi' => 510],
        ];

        foreach ($routes as $route) {
            $asal = Terminal::where('kode_terminal', $route['asal'])->first();
            $tujuan = Terminal::where('kode_terminal', $route['tujuan'])->first();

            if (!$asal || !$tujuan) {
                continue;
            }

            Rute::updateOrCreate(
                ['terminal_asal_id' => $asal->id_terminal, 'terminal_tujuan_id' => $tujuan->id_terminal],
                [
                    'jarak' => $route['jarak'],
                    'estimasi_durasi' => $route['durasi'],
                    'status' => 'aktif',
                ]
            );
        }
    }
}