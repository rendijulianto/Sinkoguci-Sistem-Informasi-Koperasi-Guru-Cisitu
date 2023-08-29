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
        Schema::create('simpanan_detail', function (Blueprint $table) {
            $table->unsignedInteger('id_simpanan', 11);
            $table->unsignedInteger('id_kategori', 3);
            $table->double('jumlah');
            $table->foreign('id_simpanan')->references('id_simpanan')->on('simpanan')->onDelete('cascade')->onUpdate('cascade');    
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_simpanan')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanan_detail');
    }
};
