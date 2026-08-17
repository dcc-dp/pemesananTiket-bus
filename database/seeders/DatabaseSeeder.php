<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(OperatorSeeder::class);
        $this->call(TerminalSeeder::class);
        $this->call(BusSeeder::class);
        $this->call(RuteSeeder::class);
        $this->call(JadwalSeeder::class);
        $this->call(BookingSeeder::class);
    }
}