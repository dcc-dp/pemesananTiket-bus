<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users', 'id')
                ->cascadeOnDelete();
            $table->foreignId('id_jadwal')
                ->constrained('jadwals', 'id_jadwal')
                ->cascadeOnDelete();
            $table->string('kode_booking', 30)->unique();
            $table->dateTime('tanggal_booking');
            $table->integer('total_harga');
            $table->enum('status_booking', [
                'pending',
                'confirmed',
                'completed',
                'cancelled',
                'expired'
            ])->default('pending');
            $table->enum('status_pembayaran', [
                'unpaid',
                'pending',
                'paid',
                'failed',
                'expired'
            ])->default('unpaid');
            $table->string('payment_method', 50)->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
