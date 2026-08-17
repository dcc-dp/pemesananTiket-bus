<?php

namespace Database\Factories;

use App\Models\Operator;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperatorFactory extends Factory
{
    protected $model = Operator::class;

    public function definition(): array
    {
        return [
            'nama_operator' => fake()->company(),
            'kode_operator' => strtoupper(fake()->unique()->bothify('OP-###??')),
            'alamat' => fake()->address(),
            'telepon' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'status' => 'aktif',
        ];
    }
}
