<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@busticket.test',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Admin Operasional',
                'username' => 'admin2',
                'email' => 'admin2@busticket.test',
                'phone' => '081234567891',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Admin Keuangan',
                'username' => 'admin3',
                'email' => 'admin3@busticket.test',
                'phone' => '081234567892',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }

        User::factory()->customer()->count(10)->create();

        User::updateOrCreate(
            ['email' => 'customer@busticket.test'],
            [
                'name' => 'Customer Demo',
                'username' => 'customer',
                'phone' => '082198765432',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );
    }
}
