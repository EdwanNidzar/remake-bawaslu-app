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
        Schema::create('verifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporan_pelanggaran_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->text('note')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('laporan_pelanggaran_id')->references('id')->on('laporan_pelanggarans')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifs');
    }
};
