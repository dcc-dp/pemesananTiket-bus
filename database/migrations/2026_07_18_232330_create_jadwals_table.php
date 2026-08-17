<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_bus')
                ->constrained('buses', 'id_bus')
                ->cascadeOnDelete();
            $table->foreignId('id_rute')
                ->constrained('rutes', 'id_rute')
                ->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_berangkat');
            $table->time('jam_tiba')->nullable();
            $table->integer('harga');
            $table->enum('status', [
                'tersedia',
                'penuh',
                'berangkat',
                'selesai',
                'dibatalkan'
            ])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
