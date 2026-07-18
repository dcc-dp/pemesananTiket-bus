<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('password'); 
            $table->string('jabatan')->nullable(); //Tata Usaha, TI & Inteldakim, Verdokjal
            $table->enum('role', ['admin', 'user','kepala_kantor','tata_usaha'])->default('user'); //user = verdokjal dan TI inteldaktim
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
