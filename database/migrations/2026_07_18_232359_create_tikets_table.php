<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id('id_tiket');

            $table->string('kode_tiket', 50)->unique();

            $table->foreignId('id_penumpang')
                ->constrained('penumpangs', 'id_penumpang')
                ->cascadeOnDelete();

            $table->foreignId('id_kursi')
                ->constrained('kursis', 'id_kursi')
                ->cascadeOnDelete();

            $table->foreignId('id_bus')
                ->constrained('buses', 'id_bus')
                ->cascadeOnDelete();

            $table->foreignId('id_supir')
                ->constrained('supirs', 'id_supir')
                ->cascadeOnDelete();

            $table->foreignId('id_rute')
                ->constrained('rutes', 'id_rute')
                ->cascadeOnDelete();

            $table->dateTime('waktu_berangkat');

            $table->integer('harga_tiket');

            $table->enum('status_pembayaran', [
                'pending',
                'lunas',
                'batal'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
