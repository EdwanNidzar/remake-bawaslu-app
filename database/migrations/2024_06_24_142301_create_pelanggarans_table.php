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
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parpols_id');
            $table->unsignedBigInteger('jenis_pelanggaran_id');
            $table->string('status_peserta_pemilu');
            $table->string('nama_bacaleg');
            $table->string('dapil');
            $table->date('tanggal_input');
            $table->timestamps();

            // Foreign key
            $table->foreign('parpols_id')->references('id')->on('parpols')->onDelete('cascade');
            $table->foreign('jenis_pelanggaran_id')->references('id')->on('jenis_pelanggarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};
