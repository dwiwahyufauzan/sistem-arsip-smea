<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. users: tambahkan status aktif akun
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('role');
            });
        }

        // 2. disposisi_surat_masuk: tambahkan soft deletes
        if (Schema::hasTable('disposisi_surat_masuk') && ! Schema::hasColumn('disposisi_surat_masuk', 'deleted_at')) {
            Schema::table('disposisi_surat_masuk', function (Blueprint $table) {
                $table->softDeletes()->after('status');
            });
        }

        // 3. pengajuan_legalisir: tambahkan kode_akses untuk proteksi data pelacakan publik
        if (Schema::hasTable('pengajuan_legalisir') && ! Schema::hasColumn('pengajuan_legalisir', 'kode_akses')) {
            Schema::table('pengajuan_legalisir', function (Blueprint $table) {
                $table->string('kode_akses', 10)->nullable()->after('nomor_pengajuan')->index();
            });
        }

        // 4. riwayat_legalisir: buat diubah_oleh menjadi nullable
        if (Schema::hasTable('riwayat_legalisir')) {
            Schema::table('riwayat_legalisir', function (Blueprint $table) {
                $table->unsignedBigInteger('diubah_oleh')->nullable()->change();
            });
        }

        // Isi kode_akses acak unik untuk data yang sudah ada sebelumnya
        if (Schema::hasTable('pengajuan_legalisir')) {
            $existing = DB::table('pengajuan_legalisir')
                ->whereNull('kode_akses')
                ->get();

            foreach ($existing as $item) {
                DB::table('pengajuan_legalisir')
                    ->where('id', $item->id)
                    ->update([
                        'kode_akses' => strtoupper(Str::random(6)),
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        if (Schema::hasTable('disposisi_surat_masuk') && Schema::hasColumn('disposisi_surat_masuk', 'deleted_at')) {
            Schema::table('disposisi_surat_masuk', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasTable('pengajuan_legalisir') && Schema::hasColumn('pengajuan_legalisir', 'kode_akses')) {
            Schema::table('pengajuan_legalisir', function (Blueprint $table) {
                $table->dropColumn('kode_akses');
            });
        }
    }
};
