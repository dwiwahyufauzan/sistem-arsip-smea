<?php

namespace Tests\Feature;

use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\PengajuanLegalisir;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LaporanAgendaTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    private User $kepsek;

    private User $pemohon;

    private KategoriSurat $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin@smkn1subang.sch.id'],
            [
                'name' => 'Petugas TU',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'nip_nisn' => '198501012010011001',
            ]
        );

        $this->kepsek = User::firstOrCreate(
            ['email' => 'kepsek@smkn1subang.sch.id'],
            [
                'name' => 'Deden Suryanto, M.Pd.',
                'password' => bcrypt('password'),
                'role' => 'kepala_sekolah',
                'nip_nisn' => '196805121993031008',
            ]
        );

        $this->pemohon = User::firstOrCreate(
            ['email' => 'alumni.laporan@test.com'],
            [
                'name' => 'Alumni Laporan',
                'password' => bcrypt('password'),
                'role' => 'pemohon',
                'nip_nisn' => '0091122334',
            ]
        );

        $this->kategori = KategoriSurat::firstOrCreate(
            ['kode_kategori' => '421.5'],
            [
                'nama_kategori' => 'Sekolah Menengah Kejuruan',
                'deskripsi' => 'Arsip Bidang Pendidikan Menengah Kejuruan',
            ]
        );
    }

    /**
     * Tamu tanpa autentikasi tidak dapat mengakses halaman laporan dan log audit.
     */
    public function test_guest_cannot_access_laporan_or_log_aktivitas(): void
    {
        $responseAdminLaporan = $this->get('/admin/laporan');
        $responseAdminLaporan->assertRedirect('/login');

        $responseAdminCetak = $this->get('/admin/laporan/cetak');
        $responseAdminCetak->assertRedirect('/login');

        $responseAdminLog = $this->get('/admin/log-aktivitas');
        $responseAdminLog->assertRedirect('/login');

        $responseKepsekLaporan = $this->get('/kepala-sekolah/laporan');
        $responseKepsekLaporan->assertRedirect('/login');

        $responseKepsekLog = $this->get('/kepala-sekolah/log-aktivitas');
        $responseKepsekLog->assertRedirect('/login');
    }

    /**
     * Pengguna dengan peran pemohon tidak dapat mengakses modul admin atau kepsek.
     */
    public function test_pemohon_cannot_access_admin_or_kepsek_laporan(): void
    {
        $response = $this->actingAs($this->pemohon)->get('/admin/laporan');
        $response->assertStatus(302);

        $responseKepsek = $this->actingAs($this->pemohon)->get('/kepala-sekolah/laporan');
        $responseKepsek->assertStatus(302);
    }

    /**
     * Admin dapat melihat rekapitulasi buku agenda surat masuk (SRS-P10).
     */
    public function test_admin_can_view_laporan_index_surat_masuk(): void
    {
        SuratMasuk::create([
            'nomor_agenda' => 'AGD-TEST-SM-01',
            'nomor_surat' => '001/TEST/SM/2026',
            'tanggal_terima' => now()->toDateString(),
            'tanggal_surat' => now()->subDay()->toDateString(),
            'pengirim' => 'Balai Dikmen Jabar',
            'perihal' => 'Undangan Koordinasi Kearsipan Digital',
            'ringkasan_isi' => 'Rapat koordinasi teknis kearsipan sekolah',
            'file_path' => 'surat-masuk/dummy.pdf',
            'file_name' => 'dummy.pdf',
            'file_size' => 1024,
            'status' => 'diterima',
            'kategori_id' => $this->kategori->id,
            'user_id' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/laporan?jenis=surat_masuk');

        $response->assertStatus(200);
        $response->assertViewIs('admin.laporan.index');
        $response->assertSee('Buku Agenda Surat Masuk');
        $response->assertSee('001/TEST/SM/2026');
        $response->assertSee('Balai Dikmen Jabar');
    }

    /**
     * Admin dapat memfilter dan melihat buku agenda surat keluar (SRS-P11).
     */
    public function test_admin_can_view_laporan_surat_keluar(): void
    {
        SuratKeluar::create([
            'nomor_agenda' => 'AGD-TEST-SK-01',
            'nomor_surat' => '002/TEST/SK/2026',
            'tanggal_surat' => now()->toDateString(),
            'tujuan' => 'Dinas Pendidikan Jawa Barat',
            'perihal' => 'Pengiriman Laporan Kearsipan Berkala',
            'isi_ringkas' => 'Dokumen rekapitulasi berkala arsip dinas',
            'file_path' => 'surat-keluar/dummy.pdf',
            'file_name' => 'dummy.pdf',
            'file_size' => 1024,
            'status_persetujuan' => 'disetujui',
            'kategori_id' => $this->kategori->id,
            'user_id' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/laporan?jenis=surat_keluar');

        $response->assertStatus(200);
        $response->assertViewIs('admin.laporan.index');
        $response->assertSee('Buku Agenda Surat Keluar');
        $response->assertSee('002/TEST/SK/2026');
        $response->assertSee('Dinas Pendidikan Jawa Barat');
    }

    /**
     * Admin dapat melihat rekapitulasi pelayanan legalisir online.
     */
    public function test_admin_can_view_laporan_legalisir(): void
    {
        PengajuanLegalisir::create([
            'nomor_pengajuan' => 'LGL-TEST-REKAP-01',
            'user_id' => $this->pemohon->id,
            'nama_pemohon' => 'Siswa Rekap Test',
            'nisn' => '0091122334',
            'tahun_lulus' => '2024',
            'nomor_whatsapp' => '081234567899',
            'email' => 'alumni.laporan@test.com',
            'jenis_dokumen' => 'ijazah',
            'jumlah_lembar' => 3,
            'keperluan' => 'Pendaftaran Seleksi Kerja Industri',
            'file_dokumen_path' => 'dokumen-legalisir/dummy.pdf',
            'status' => 'selesai',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/laporan?jenis=legalisir');

        $response->assertStatus(200);
        $response->assertViewIs('admin.laporan.index');
        $response->assertSee('Rekapitulasi Layanan Legalisir');
        $response->assertSee('LGL-TEST-REKAP-01');
        $response->assertSee('Siswa Rekap Test');
    }

    /**
     * Admin dapat mencetak buku agenda resmi surat masuk, surat keluar, dan legalisir.
     */
    public function test_admin_can_access_cetak_lembar_agenda_resmi(): void
    {
        // Cetak Agenda Surat Masuk
        $responseSM = $this->actingAs($this->admin)->get('/admin/laporan/cetak?jenis=surat_masuk');
        $responseSM->assertStatus(200);
        $responseSM->assertViewIs('admin.laporan.cetak');
        $responseSM->assertSee('BUKU AGENDA SURAT MASUK');
        $responseSM->assertSee('SEKOLAH MENENGAH KEJURUAN NEGERI 1 SUBANG');

        // Cetak Agenda Surat Keluar
        $responseSK = $this->actingAs($this->admin)->get('/admin/laporan/cetak?jenis=surat_keluar');
        $responseSK->assertStatus(200);
        $responseSK->assertSee('BUKU AGENDA SURAT KELUAR');

        // Cetak Rekapitulasi Legalisir
        $responseLegalisir = $this->actingAs($this->admin)->get('/admin/laporan/cetak?jenis=legalisir');
        $responseLegalisir->assertStatus(200);
        $responseLegalisir->assertSee('REKAPITULASI PELAYANAN LEGALISIR DOKUMEN ALUMNI');
    }

    /**
     * Admin dapat melihat dan mencari riwayat pada log aktivitas sistem.
     */
    public function test_admin_can_view_and_filter_log_aktivitas(): void
    {
        LogAktivitas::create([
            'user_id' => $this->admin->id,
            'modul' => 'SURAT_MASUK',
            'aksi' => 'SIMPAN_SURAT_TEST',
            'deskripsi' => 'Pengujian verifikasi log audit sistem kearsipan',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit/Testing',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/log-aktivitas?q=verifikasi+log+audit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.log-aktivitas.index');
        $response->assertSee('SIMPAN_SURAT_TEST');
        $response->assertSee('SURAT_MASUK');
    }

    /**
     * Kepala Sekolah dapat memantau rekapitulasi agenda eksekutif (SRS-KS09).
     */
    public function test_kepsek_can_view_executive_laporan_index(): void
    {
        $response = $this->actingAs($this->kepsek)->get('/kepala-sekolah/laporan');

        $response->assertStatus(200);
        $response->assertViewIs('kepsek.laporan.index');
        $response->assertSee('Rekapitulasi Agenda');
        $response->assertSee('SRS-KS09');
    }

    /**
     * Kepala Sekolah dapat mengakses lembar cetak rekapitulasi agenda eksekutif.
     */
    public function test_kepsek_can_access_cetak_laporan(): void
    {
        $response = $this->actingAs($this->kepsek)->get('/kepala-sekolah/laporan/cetak?jenis=surat_keluar');

        $response->assertStatus(200);
        $response->assertViewIs('admin.laporan.cetak');
        $response->assertSee('BUKU AGENDA SURAT KELUAR');
        $response->assertSee('Deden Suryanto, M.Pd.');
    }

    /**
     * Kepala Sekolah dapat melihat jejak audit aktivitas sistem.
     */
    public function test_kepsek_can_view_log_aktivitas_eksekutif(): void
    {
        LogAktivitas::create([
            'user_id' => $this->kepsek->id,
            'modul' => 'DISPOSISI',
            'aksi' => 'INSTRUKSI_KEPSEK_TEST',
            'deskripsi' => 'Kepala Sekolah memberikan instruksi disposisi surat dinas',
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/Test',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->kepsek)->get('/kepala-sekolah/log-aktivitas?modul=DISPOSISI');

        $response->assertStatus(200);
        $response->assertViewIs('kepsek.log-aktivitas.index');
        $response->assertSee('INSTRUKSI_KEPSEK_TEST');
        $response->assertSee('DISPOSISI');
    }
}
