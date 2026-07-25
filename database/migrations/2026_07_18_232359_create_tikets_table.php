<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id('id_tiket');

            $table->string('kode_tiket', 50)->unique();

            $table->foreignId('id_jadwal')
                ->constrained('jadwals', 'id_jadwal')
                ->cascadeOnDelete();

            $table->foreignId('id_penumpang')
                ->nullable()
                ->constrained('penumpangs', 'id_penumpang')
                ->nullOnDelete();

            $table->foreignId('id_kursi')
                ->constrained('kursis', 'id_kursi')
                ->cascadeOnDelete();

            $table->string('nama_pemesan', 250);
            $table->string('no_hp_pemesan', 20);

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
