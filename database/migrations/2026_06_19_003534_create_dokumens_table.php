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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('jenis_usahas')->onDelete('cascade');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('nomor_dokumen')->unique();
            $table->string('judul');
            $table->longText('deskripsi')->nullable();

            $table->string('file_path');
            $table->date('tanggal_dokumen');
            $table->string('versi', 20)->default('1.0');

            $table->enum('status', [
                'draft',
                'review',
                'approved',
                'obsolete'
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
