<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')
                ->constrained('bookings', 'id')
                ->cascadeOnDelete();
            $table->foreignId('id_jadwal')
                ->constrained('jadwals', 'id_jadwal')
                ->cascadeOnDelete();
            $table->foreignId('id_kursi')
                ->constrained('kursis', 'id_kursi')
                ->cascadeOnDelete();
            $table->integer('harga');
            $table->string('nama_penumpang', 150)->nullable();
            $table->string('nik', 30)->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('status_booking', [
                'pending',
                'confirmed',
                'completed',
                'cancelled',
                'expired'
            ])->default('pending');
            $table->unsignedBigInteger('seat_lock')
                ->virtualAs("CASE WHEN status_booking IN ('cancelled', 'expired') THEN NULL ELSE id_kursi END");
            $table->timestamps();

            $table->unique(['id_jadwal', 'seat_lock'], 'unq_seat_per_schedule');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};
