<?php

namespace Tests\Feature;

use App\Models\KategoriSurat;
use App\Models\PengajuanLegalisir;
use App\Models\SuratKeluar;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class VerifikasiDanBackupTest extends TestCase
{
    /**
     * Uji halaman verifikasi publik surat keluar via QR Code
     */
    public function test_halaman_verifikasi_surat_keluar_dapat_diakses_publik(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kepsek = User::where('role', 'kepala_sekolah')->first();
        $kategori = KategoriSurat::first();

        $uniq = uniqid();
        $surat = SuratKeluar::create([
            'nomor_agenda' => 'SK/VERIF/'.$uniq,
            'nomor_surat' => '421.5/VERIF-'.$uniq.'/SMK/2026',
            'tanggal_surat' => '2026-09-15',
            'tujuan' => 'Dinas Pendidikan Provinsi Jawa Barat',
            'perihal' => 'Pengujian Validasi Keabsahan Dokumen',
            'kategori_id' => $kategori->id,
            'file_path' => 'dokumen-surat-keluar/test.pdf',
            'file_name' => 'test.pdf',
            'file_size' => 1024,
            'status_persetujuan' => 'disetujui',
            'disetujui_oleh' => $kepsek->id,
            'tanggal_disetujui' => now(),
            'user_id' => $admin->id,
        ]);

        $response = $this->get(route('verifikasi.surat-keluar', $surat->id));

        $response->assertStatus(200);
        $response->assertSee('TERVERIFIKASI DI SISTEM ARSIP');
        $response->assertSee('Dokumen Resmi & Sah', false);
        $response->assertSee($surat->nomor_surat);
        $response->assertSee($surat->perihal);

        $surat->forceDelete();
    }

    /**
     * Uji halaman verifikasi publik bukti legalisir via QR Code
     */
    public function test_halaman_verifikasi_legalisir_dapat_diakses_publik(): void
    {
        $uniq = uniqid();
        $pengajuan = PengajuanLegalisir::create([
            'nomor_pengajuan' => 'LEG-VERIF-'.$uniq,
            'nama_pemohon' => 'Siti Alumni Subang',
            'nisn' => '0054321987',
            'tahun_lulus' => '2023',
            'nomor_whatsapp' => '081298765432',
            'email' => 'siti.alumni@example.com',
            'jenis_dokumen' => 'ijazah',
            'jumlah_lembar' => 3,
            'keperluan' => 'Pendaftaran Kuliah PTN',
            'file_dokumen_path' => 'dokumen-legalisir/ijazah_siti.pdf',
            'status' => 'siap_diambil',
        ]);

        $response = $this->get(route('verifikasi.legalisir', $pengajuan->nomor_pengajuan));

        $response->assertStatus(200);
        $response->assertSee('LEGALISIR RESMI SMKN 1 SUBANG');
        $response->assertSee($pengajuan->nomor_pengajuan);
        $response->assertSee($pengajuan->nama_pemohon_masked);
        $response->assertSee($pengajuan->nisn_masked);

        $pengajuan->forceDelete();
    }

    /**
     * Uji perintah pencadangan database arsip berjalan sukses
     */
    public function test_artisan_backup_command_berhasil_dijalankan(): void
    {
        $exitCode = Artisan::call('arsip:backup', ['--clean' => true]);

        $this->assertEquals(0, $exitCode);
        $output = Artisan::output();
        $this->assertStringContainsString('PENCADANGAN DATA BERHASIL DISELESAIKAN SECARA AMAN', $output);
        $this->assertStringContainsString('backup_arsip_smea_', $output);
    }

    /**
     * Uji notification service menghasilkan format nomor HP dan pesan WA yang benar
     */
    public function test_notification_service_format_phone_dan_pesan_wa(): void
    {
        $service = new NotificationService;

        // 1. Format nomor
        $formatted1 = $service->formatPhoneNumber('081234567890');
        $this->assertEquals('6281234567890', $formatted1);

        $formatted2 = $service->formatPhoneNumber('+62 812-3456-7890');
        $this->assertEquals('6281234567890', $formatted2);

        // 2. Buat URL WA
        $url = $service->generateWhatsAppUrl('081234567890', 'Pesan Uji Coba');
        $this->assertStringContainsString('phone=6281234567890', $url);
        $this->assertStringContainsString('text=Pesan+Uji+Coba', $url);
    }
}
