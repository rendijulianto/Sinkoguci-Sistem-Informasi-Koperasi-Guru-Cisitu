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
            $table->unsignedBigInteger('id_pinjaman');
            $table->unsignedBigInteger('id_petugas');
            $table->integer('angsuran_ke', 2);
            $table->date('tgl_bayar');
            $table->double('pokok');
            $table->double('jasa');
            $table->timestamps();
            $table->foreign('id_pinjaman')->references('id_pinjaman')->on('peminjaman')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade')->onUpdate('cascade');
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
