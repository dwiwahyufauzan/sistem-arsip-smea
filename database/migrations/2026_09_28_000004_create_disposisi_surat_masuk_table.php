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
        Schema::create('disposisi_surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk')->cascadeOnDelete();
            $table->foreignId('diberikan_oleh')->constrained('users')->cascadeOnDelete();
            $table->string('tujuan_disposisi', 150);
            $table->text('instruksi');
            $table->text('catatan')->nullable();
            $table->date('batas_waktu')->nullable();
            $table->enum('status', ['menunggu', 'ditindaklanjuti', 'selesai'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi_surat_masuk');
    }
};
