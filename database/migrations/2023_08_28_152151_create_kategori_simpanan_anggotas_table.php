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
        Schema::create('kategori_simpanan_anggota', function (Blueprint $table) {
            $table->unsignedInteger('id_anggota');
            $table->unsignedInteger('id_kategori');
            $table->double('nominal', 15, 2);
            $table->double('saldo', 15, 2);
            $table->timestamps();
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_simpanan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_simpanan_anggota');
    }
};
