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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->increments('id_pinjaman',11);
            $table->unsignedInteger('id_anggota');
            $table->unsignedInteger('id_petugas');
            $table->double('nominal');
            $table->integer('lama_angsuran');
            $table->double('sisa_pokok');
            $table->double('sisa_jasa');
            $table->date('tgl_pinjam');
            $table->date('tgl_terakhir_bayar')->nullable();
            $table->timestamps();
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
