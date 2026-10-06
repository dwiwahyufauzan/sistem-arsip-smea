<?php

namespace App\Console\Commands;

use App\Models\DisposisiSuratMasuk;
use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\PengajuanLegalisir;
use App\Models\RiwayatLegalisir;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

#[Signature('arsip:backup {--clean : Hapus berkas pencadangan yang berusia lebih dari 30 hari} {--with-files : Sertakan pencadangan berkas fisik dokumen kearsipan dalam arsip ZIP}')]
#[Description('Lakukan pencadangan database kearsipan SMKN 1 Subang untuk disaster recovery')]
class BackupArsipCommand extends Command
{
    /**
     * Jalankan proses pencadangan database arsip
     */
    public function handle(): int
    {
        $this->info('====================================================');
        $this->info('  PENCADANGAN DATA ARSIP SMEA (SMKN 1 SUBANG)       ');
        $this->info('====================================================');

        $backupDir = storage_path('app/backups');
        if (! File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $timestamp = now()->format('Y_m_d_His');
        $filenameSql = "backup_arsip_smea_{$timestamp}.sql";
        $filenameJson = "backup_arsip_smea_{$timestamp}.json";
        $sqlPath = $backupDir.DIRECTORY_SEPARATOR.$filenameSql;
        $jsonPath = $backupDir.DIRECTORY_SEPARATOR.$filenameJson;

        $this->line('1. Mengumpulkan data entitas arsip utama...');

        $data = [
            'meta' => [
                'aplikasi' => 'Sistem Informasi Manajemen Arsip Kearsipan (SIMA-KMP)',
                'instansi' => 'SMK Negeri 1 Subang',
                'waktu_backup' => now()->toIso8601String(),
                'versi_laravel' => app()->version(),
                'versi_php' => PHP_VERSION,
            ],
            'users' => User::all()->toArray(),
            'kategori_surat' => KategoriSurat::all()->toArray(),
            'surat_masuk' => SuratMasuk::withTrashed()->get()->toArray(),
            'surat_keluar' => SuratKeluar::withTrashed()->get()->toArray(),
            'disposisi_surat_masuk' => DisposisiSuratMasuk::all()->toArray(),
            'pengajuan_legalisir' => PengajuanLegalisir::withTrashed()->get()->toArray(),
            'riwayat_legalisir' => RiwayatLegalisir::all()->toArray(),
            'log_aktivitas' => LogAktivitas::latest('id')->limit(500)->get()->toArray(),
        ];

        // 1. Simpan format JSON terstruktur
        File::put($jsonPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 2. Susun format dump SQL portable
        $sqlContent = "-- ====================================================\n";
        $sqlContent .= "-- PENCADANGAN DATABASE ARSIP SMKN 1 SUBANG (SMEA)\n";
        $sqlContent .= '-- Waktu Pembuatan : '.now()->format('d/m/Y H:i:s')."\n";
        $sqlContent .= "-- ====================================================\n\n";
        $sqlContent .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach (['users', 'kategori_surat', 'surat_masuk', 'surat_keluar', 'disposisi_surat_masuk', 'pengajuan_legalisir', 'riwayat_legalisir'] as $table) {
            $rows = DB::table($table)->get();
            $sqlContent .= "-- Data Tabel: {$table} (".$rows->count()." baris)\n";
            if ($rows->isNotEmpty()) {
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $columns = array_keys($rowArray);
                    $escapedValues = array_map(function ($val) {
                        if (is_null($val)) {
                            return 'NULL';
                        }

                        return "'".addslashes((string) $val)."'";
                    }, array_values($rowArray));

                    $sqlContent .= "INSERT INTO `{$table}` (`".implode('`, `', $columns).'`) VALUES ('.implode(', ', $escapedValues).");\n";
                }
            }
            $sqlContent .= "\n";
        }

        $sqlContent .= "SET FOREIGN_KEY_CHECKS=1;\n";
        File::put($sqlPath, $sqlContent);

        $summary = [
            ['Pengguna Terdaftar', count($data['users'])],
            ['Kategori Klasifikasi', count($data['kategori_surat'])],
            ['Surat Masuk (Termasuk Arsip Inaktif)', count($data['surat_masuk'])],
            ['Surat Keluar (Termasuk Arsip Inaktif)', count($data['surat_keluar'])],
            ['Disposisi Pimpinan', count($data['disposisi_surat_masuk'])],
            ['Pengajuan Legalisir Ijazah', count($data['pengajuan_legalisir'])],
            ['Log Aktivitas Audit Trail', count($data['log_aktivitas'])],
        ];

        $this->table(['Entitas Kearsipan', 'Jumlah Record Dicadangkan'], $summary);

        $this->info("✓ Berkas SQL  : {$sqlPath} (".round(filesize($sqlPath) / 1024, 2).' KB)');
        $this->info("✓ Berkas JSON : {$jsonPath} (".round(filesize($jsonPath) / 1024, 2).' KB)');

        // 3. Cadangkan berkas fisik dokumen jika opsi --with-files diaktifkan
        if ($this->option('with-files') && class_exists(\ZipArchive::class)) {
            $this->line('3. Mengompresi berkas fisik dokumen kearsipan (storage/app/public)...');
            $filenameZip = "backup_arsip_smea_{$timestamp}_files.zip";
            $zipPath = $backupDir.DIRECTORY_SEPARATOR.$filenameZip;
            $publicStorage = storage_path('app/public');

            if (File::exists($publicStorage)) {
                $files = File::allFiles($publicStorage);
                if (count($files) > 0) {
                    $zip = new \ZipArchive;
                    if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                        foreach ($files as $file) {
                            $relativePath = substr($file->getPathname(), strlen($publicStorage) + 1);
                            $zip->addFile($file->getPathname(), $relativePath);
                        }
                        $zip->close();
                        clearstatcache(true, $zipPath);
                        if (File::exists($zipPath)) {
                            $this->info("✓ Berkas Dokumen Fisik (ZIP) : {$zipPath} (".round(filesize($zipPath) / 1024, 2).' KB)');
                        }
                    }
                } else {
                    $this->comment('ℹ Direktori dokumen fisik kosong, tidak ada berkas scan yang perlu dikompresi.');
                }
            }
        }

        // 4. Rotasi Berkas (Hapus backup > 30 hari jika diminta atau otomatis)
        if ($this->option('clean')) {
            $this->cleanOldBackups($backupDir);
        }

        // 4. Catat aktivitas
        LogAktivitas::catat(
            'BACKUP_DATABASE',
            'SISTEM',
            "Pencadangan database kearsipan berhasil: {$filenameSql} (".count($data['surat_masuk']).' surat masuk, '.count($data['surat_keluar']).' surat keluar)'
        );

        $this->info('====================================================');
        $this->info('  PENCADANGAN DATA BERHASIL DISELESAIKAN SECARA AMAN! ');
        $this->info('====================================================');

        return Command::SUCCESS;
    }

    /**
     * Bersihkan berkas backup yang lebih tua dari 30 hari
     */
    protected function cleanOldBackups(string $dir): void
    {
        $files = File::files($dir);
        $threshold = now()->subDays(30)->timestamp;
        $deletedCount = 0;

        foreach ($files as $file) {
            if ($file->getMTime() < $threshold) {
                File::delete($file->getPathname());
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            $this->comment("✓ Membersihkan {$deletedCount} berkas cadangan lama (> 30 hari).");
        }
    }
}
