<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')
                ->constrained('bookings', 'id')
                ->cascadeOnDelete();
            $table->string('order_id', 100)->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->integer('gross_amount')->nullable();
            $table->string('transaction_status', 50)->nullable();
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'expired'
            ])->default('pending');
            $table->dateTime('paid_at')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
