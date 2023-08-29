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
        Schema::create('penarikan_dana_sosial', function (Blueprint $table) {
            $table->increments('id_penarikan',11);
            $table->unsignedInteger('id_petugas', 2);
            $table->double('jumlah');
            $table->string('keterangan', 60);
            $table->date('tgl_penarikan');
            $table->timestamps();
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan_dana_sosial');
    }
};
