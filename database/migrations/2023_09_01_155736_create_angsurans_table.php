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
        Schema::create('angsuran', function (Blueprint $table) {
            $table->increments('id_angsuran',11);
            $table->unsignedInteger('id_pinjaman');
            $table->unsignedInteger('id_petugas');
            $table->unsignedInteger('id_anggota');
            $table->double('bayar_pokok');
            $table->double('bayar_jasa');
            $table->date('tgl_bayar');
            $table->double('sebelum_pokok');
            $table->double('sebelum_jasa');
            $table->double('setelah_pokok');
            $table->double('setelah_jasa');
            $table->timestamps();
            $table->foreign('id_pinjaman')->references('id_pinjaman')->on('pinjaman')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsuran');
    }
};
