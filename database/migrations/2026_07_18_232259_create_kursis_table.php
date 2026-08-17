<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kursis', function (Blueprint $table) {
            $table->id('id_kursi');
            $table->foreignId('id_bus')
                ->constrained('buses', 'id_bus')
                ->cascadeOnDelete();
            $table->string('nomor_kursi', 10);
            $table->string('posisi', 20)->nullable();
            $table->enum('status', ['tersedia', 'rusak'])->default('tersedia');
            $table->unique(['id_bus', 'nomor_kursi']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kursis');
    }
};
