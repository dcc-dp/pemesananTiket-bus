<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rutes', function (Blueprint $table) {
            $table->id('id_rute');
            $table->foreignId('terminal_asal_id')
                ->constrained('terminals', 'id_terminal')
                ->cascadeOnDelete();
            $table->foreignId('terminal_tujuan_id')
                ->constrained('terminals', 'id_terminal')
                ->cascadeOnDelete();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('jarak', 10, 2)->nullable();
            $table->integer('estimasi_durasi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rutes');
    }
};
