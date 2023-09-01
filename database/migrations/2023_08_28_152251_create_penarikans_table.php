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
        Schema::create('penarikan', function (Blueprint $table) {
            $table->increments('id_penarikan',11);
            $table->unsignedInteger('id_anggota');
            $table->unsignedInteger('id_petugas');
            $table->unsignedInteger('id_kategori');
            $table->date('tgl_penarikan');
            $table->double('jumlah');
            $table->string('keterangan', 60);
            $table->double('saldo_sebelum');
            $table->double('saldo_sesudah');
            $table->timestamps();
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_simpanan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan');
    }
};
