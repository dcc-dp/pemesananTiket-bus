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

            $table->foreignId('id_supir')
                ->constrained('supirs', 'id_supir')
                ->cascadeOnDelete();

            $table->date('tanggal');

            $table->time('jam_berangkat');

            $table->integer('harga');

            $table->enum('status', [
                'tersedia',
                'berangkat',
                'selesai',
                'dibatalkan'
            ])->default('tersedia');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
