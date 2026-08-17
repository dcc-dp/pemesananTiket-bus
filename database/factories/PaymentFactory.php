<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'booking_id' => \App\Models\Booking::factory(),
            'order_id' => 'ORDER-' . fake()->unique()->numerify('##########'),
            'transaction_id' => fake()->unique()->numerify('############'),
            'payment_type' => fake()->randomElement(['bank_transfer', 'credit_card', 'qris', 'gopay']),
            'gross_amount' => fake()->numberBetween(100000, 2000000),
            'transaction_status' => 'pending',
            'payment_status' => 'pending',
        ];
    }
}
