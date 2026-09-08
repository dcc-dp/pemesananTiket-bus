<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terminals', function (Blueprint $table) {
            $table->id('id_terminal');
            $table->string('nama_terminal', 150);
            $table->string('kode_terminal', 30)->unique();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('kota', 100);
            $table->string('provinsi', 100)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terminals');
    }
};
