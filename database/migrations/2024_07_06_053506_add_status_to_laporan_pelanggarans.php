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
        Schema::table('laporan_pelanggarans', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('user_id');
            $table->text('note')->nullable()->after('status');
            $table->unsignedBigInteger('verify_by')->nullable()->after('note');

            $table->foreign('verify_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_pelanggarans', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('note');
            $table->dropColumn('verify_by');
        });
    }
};
