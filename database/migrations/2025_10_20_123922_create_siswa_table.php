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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            // relasi ke tabel Users
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->string('nis', 50)->nullable();;
            $table->string('name');
            $table->string('asal_sekolah', 100)->nullable();
            $table->enum('jurusan', ['TKJ','RPL','DKV','ANIMASI']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
