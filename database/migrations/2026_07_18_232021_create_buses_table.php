<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id('id_bus');
            $table->foreignId('operator_id')
                ->constrained('operators', 'id')
                ->cascadeOnDelete();
            $table->string('nomor_polisi', 20)->unique();
            $table->string('kode_bus', 30)->unique();
            $table->string('nama_bus', 100);
            $table->enum('kelas', ['ekonomi', 'bisnis', 'executive', 'sleeper'])->default('ekonomi');
            $table->integer('kapasitas');
            $table->text('fasilitas')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'perbaikan'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
