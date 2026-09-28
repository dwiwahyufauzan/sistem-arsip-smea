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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda', 50)->unique();
            $table->string('nomor_surat', 100)->index();
            $table->date('tanggal_surat');
            $table->string('tujuan', 255)->index();
            $table->string('perihal', 255)->index();
            $table->text('isi_ringkas')->nullable();
            $table->foreignId('kategori_id')->constrained('kategori_surat')->cascadeOnDelete();
            $table->string('file_path', 255);
            $table->string('file_name', 255);
            $table->unsignedBigInteger('file_size');
            $table->enum('status_persetujuan', ['draft', 'menunggu_persetujuan', 'disetujui', 'ditolak'])->default('draft')->index();
            $table->text('catatan_kepsek')->nullable();
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
