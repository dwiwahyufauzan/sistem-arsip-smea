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
        Schema::create('riwayat_legalisir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_legalisir_id')->constrained('pengajuan_legalisir')->cascadeOnDelete();
            $table->string('status_sebelumnya', 50)->nullable();
            $table->string('status_baru', 50);
            $table->foreignId('diubah_oleh')->constrained('users')->cascadeOnDelete();
            $table->text('catatan')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_legalisir');
    }
};
