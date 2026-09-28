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
        Schema::create('pengajuan_legalisir', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan', 50)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_pemohon', 150)->index();
            $table->string('nisn', 30)->index();
            $table->string('tahun_lulus', 10);
            $table->string('nomor_whatsapp', 25);
            $table->string('email', 191);
            $table->enum('jenis_dokumen', ['ijazah', 'transkrip_nilai', 'rapor', 'sertifikat_keahlian']);
            $table->integer('jumlah_lembar')->default(1);
            $table->string('keperluan', 255);
            $table->string('file_dokumen_path', 255);
            $table->enum('status', [
                'menunggu_verifikasi',
                'diverifikasi',
                'menunggu_approval_kepsek',
                'disetujui_kepsek',
                'sedang_diproses',
                'siap_diambil',
                'selesai',
                'ditolak'
            ])->default('menunggu_verifikasi')->index();
            $table->text('catatan_petugas')->nullable();
            $table->text('catatan_kepsek')->nullable();
            $table->date('tanggal_siap_ambil')->nullable();
            $table->date('tanggal_pengambilan')->nullable();
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_legalisir');
    }
};
