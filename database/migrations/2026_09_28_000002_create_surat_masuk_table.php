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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda', 50)->unique();
            $table->string('nomor_surat', 100)->index();
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->string('pengirim', 255)->index();
            $table->string('penerima', 255)->default('Kepala SMKN 1 Subang');
            $table->string('perihal', 255)->index();
            $table->text('isi_ringkas')->nullable();
            $table->foreignId('kategori_id')->constrained('kategori_surat')->cascadeOnDelete();
            $table->string('file_path', 255);
            $table->string('file_name', 255);
            $table->unsignedBigInteger('file_size');
            $table->enum('status', ['diterima', 'didisposisikan', 'diarsipkan'])->default('diterima');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
