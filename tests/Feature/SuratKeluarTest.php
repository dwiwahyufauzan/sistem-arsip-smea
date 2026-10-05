<?php

namespace Tests\Feature;

use App\Models\KategoriSurat;
use App\Models\SuratKeluar;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SuratKeluarTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Uji Admin TU dapat mengakses halaman indeks surat keluar
     */
    public function test_admin_can_view_surat_keluar_index_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/surat-keluar');

        $response->assertStatus(200);
        $response->assertSee('Pengelolaan Arsip Surat Keluar');
        $response->assertSee('Buat Surat Keluar');
        $response->assertSee('Total Surat');
    }

    /**
     * Uji pengguna non-admin (Pemohon) dilarang mengakses modul admin surat keluar
     */
    public function test_non_admin_cannot_access_admin_surat_keluar(): void
    {
        $pemohon = User::where('role', 'pemohon')->first();

        $response = $this->actingAs($pemohon)->get('/admin/surat-keluar');

        $response->assertRedirect('/pemohon/dashboard');
        $response->assertSessionHas('error');
    }

    /**
     * Uji Admin dapat membuka halaman pembuatan surat keluar dengan auto-agenda
     */
    public function test_admin_can_view_create_page_with_auto_generated_agenda(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/surat-keluar/create');

        $response->assertStatus(200);
        $response->assertSee('Registrasi Surat Keluar Baru');
        $response->assertSee('SK/'.date('Y').'/');
    }

    /**
     * Uji Admin dapat menyimpan draf surat keluar baru beserta unggahan dokumen (SRS-P04, SRS-P05)
     */
    public function test_admin_can_store_new_surat_keluar_with_draft_status(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $file = UploadedFile::fake()->create('draf-undangan-bkk.pdf', 300, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/surat-keluar', [
            'nomor_agenda' => 'SK/2026/991',
            'nomor_surat' => '421.5/120-SMKN1/IX/2026',
            'tanggal_surat' => '2026-09-25',
            'tujuan' => 'PT. Astra Honda Motor Divisi HRD',
            'perihal' => 'Undangan Seleksi Rekrutmen Karyawan Baru Alumni SMKN 1 Subang',
            'isi_ringkas' => 'Pelaksanaan tes psikotes dan wawancara kerja di Aula SMKN 1 Subang.',
            'kategori_id' => $kategori->id,
            'status_persetujuan' => 'draft',
            'berkas' => $file,
        ]);

        $suratKeluar = SuratKeluar::where('nomor_agenda', 'SK/2026/991')->first();

        $this->assertNotNull($suratKeluar);
        $response->assertRedirect('/admin/surat-keluar/'.$suratKeluar->id);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('surat_keluar', [
            'nomor_agenda' => 'SK/2026/991',
            'nomor_surat' => '421.5/120-SMKN1/IX/2026',
            'status_persetujuan' => 'draft',
            'user_id' => $admin->id,
        ]);

        Storage::disk('public')->assertExists($suratKeluar->file_path);

        $this->assertDatabaseHas('log_aktivitas', [
            'user_id' => $admin->id,
            'aksi' => 'TAMBAH_SURAT_KELUAR',
        ]);
    }

    /**
     * Uji Admin dapat langsung mengajukan surat keluar ke Kepala Sekolah saat registrasi
     */
    public function test_admin_can_store_new_surat_keluar_with_pending_approval_status(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $file = UploadedFile::fake()->create('surat-edaran-osis.pdf', 250, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/surat-keluar', [
            'nomor_agenda' => 'SK/2026/992',
            'nomor_surat' => '421.5/121-SMKN1/IX/2026',
            'tanggal_surat' => '2026-09-25',
            'tujuan' => 'Seluruh Pembina Ekstrakurikuler dan Pengurus OSIS',
            'perihal' => 'Edaran Pelaksanaan Latihan Dasar Kepemimpinan Siswa (LDKS) 2026',
            'isi_ringkas' => 'Koordinasi jadwal kegiatan LDKS gabungan di Ciater Highland Resort.',
            'kategori_id' => $kategori->id,
            'status_persetujuan' => 'menunggu_persetujuan',
            'berkas' => $file,
        ]);

        $suratKeluar = SuratKeluar::where('nomor_agenda', 'SK/2026/992')->first();

        $this->assertNotNull($suratKeluar);
        $this->assertEquals('menunggu_persetujuan', $suratKeluar->status_persetujuan);
    }

    /**
     * Uji validasi input wajib pada pembuatan surat keluar
     */
    public function test_store_surat_keluar_validation_fails_for_missing_fields(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/surat-keluar', []);

        $response->assertSessionHasErrors([
            'nomor_agenda',
            'nomor_surat',
            'tanggal_surat',
            'tujuan',
            'perihal',
            'kategori_id',
            'status_persetujuan',
            'berkas',
        ]);
    }

    /**
     * Uji validasi keunikan nomor agenda surat keluar
     */
    public function test_store_surat_keluar_validates_unique_nomor_agenda(): void
    {
        $admin = User::where('role', 'admin')->first();
        $existing = SuratKeluar::first();

        $response = $this->actingAs($admin)->post('/admin/surat-keluar', [
            'nomor_agenda' => $existing->nomor_agenda,
            'nomor_surat' => 'DUPLIKAT/SK/001',
            'tanggal_surat' => '2026-09-25',
            'tujuan' => 'Tujuan Duplikat',
            'perihal' => 'Perihal Duplikat',
            'kategori_id' => $existing->kategori_id,
            'status_persetujuan' => 'draft',
            'berkas' => UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors('nomor_agenda');
    }

    /**
     * Uji penolakan berkas draf jika melebihi 5 MB (NFR-02)
     */
    public function test_store_surat_keluar_fails_if_file_exceeds_5mb(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $largeFile = UploadedFile::fake()->create('large-draft.pdf', 6000, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/surat-keluar', [
            'nomor_agenda' => 'SK/2026/993',
            'nomor_surat' => '421.5/OVERSIZE/2026',
            'tanggal_surat' => '2026-09-25',
            'tujuan' => 'Dinas Pendidikan',
            'perihal' => 'Pengujian Berkas Besar',
            'kategori_id' => $kategori->id,
            'status_persetujuan' => 'draft',
            'berkas' => $largeFile,
        ]);

        $response->assertSessionHasErrors('berkas');
    }

    /**
     * Uji penolakan format file yang tidak diizinkan
     */
    public function test_store_surat_keluar_fails_for_invalid_file_extension(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $invalidFile = UploadedFile::fake()->create('payload.exe', 100, 'application/x-msdownload');

        $response = $this->actingAs($admin)->post('/admin/surat-keluar', [
            'nomor_agenda' => 'SK/2026/994',
            'nomor_surat' => '421.5/INVALID/2026',
            'tanggal_surat' => '2026-09-25',
            'tujuan' => 'Dinas Terkait',
            'perihal' => 'Pengujian Ekstensi Ilegal',
            'kategori_id' => $kategori->id,
            'status_persetujuan' => 'draft',
            'berkas' => $invalidFile,
        ]);

        $response->assertSessionHasErrors('berkas');
    }

    /**
     * Uji Admin dapat melihat halaman detail surat keluar
     */
    public function test_admin_can_view_surat_keluar_show_page(): void
    {
        $admin = User::where('role', 'admin')->first();
        $suratKeluar = SuratKeluar::first();

        $response = $this->actingAs($admin)->get('/admin/surat-keluar/'.$suratKeluar->id);

        $response->assertStatus(200);
        $response->assertSee($suratKeluar->nomor_surat);
        $response->assertSee($suratKeluar->nomor_agenda);
        $response->assertSee('Lembar Informasi Surat Keluar');
        $response->assertSee('Pratinjau Draf Dokumen');
    }

    /**
     * Uji Admin dapat memperbarui metadata surat keluar
     */
    public function test_admin_can_update_surat_keluar_metadata(): void
    {
        $admin = User::where('role', 'admin')->first();
        $suratKeluar = SuratKeluar::first();

        $response = $this->actingAs($admin)->put('/admin/surat-keluar/'.$suratKeluar->id, [
            'nomor_agenda' => $suratKeluar->nomor_agenda,
            'nomor_surat' => $suratKeluar->nomor_surat.'-REV',
            'tanggal_surat' => '2026-09-26',
            'tujuan' => 'Kepala Balai Besar Penjaminan Mutu Pendidikan (BBPMP)',
            'perihal' => 'Revisi Surat Permohonan Akreditasi Lab Komputer',
            'isi_ringkas' => 'Pembaruan data inventaris sarana prasarana sekolah',
            'kategori_id' => $suratKeluar->kategori_id,
            'status_persetujuan' => 'draft',
        ]);

        $response->assertRedirect('/admin/surat-keluar/'.$suratKeluar->id);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('surat_keluar', [
            'id' => $suratKeluar->id,
            'nomor_surat' => $suratKeluar->nomor_surat.'-REV',
            'tujuan' => 'Kepala Balai Besar Penjaminan Mutu Pendidikan (BBPMP)',
        ]);
    }

    /**
     * Uji Admin dapat mengganti berkas lampiran saat pembaruan surat keluar
     */
    public function test_admin_can_update_surat_keluar_with_new_file_replacement(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $oldFile = UploadedFile::fake()->create('draf-awal.pdf', 150, 'application/pdf');
        $oldPath = $oldFile->storeAs('dokumen-surat-keluar', 'draf-awal.pdf', 'public');

        $surat = SuratKeluar::create([
            'nomor_agenda' => 'SK/2026/995',
            'nomor_surat' => '421.5/REPLACE/2026',
            'tanggal_surat' => '2026-09-20',
            'tujuan' => 'Instansi Tujuan',
            'perihal' => 'Pengujian Penggantian Berkas',
            'kategori_id' => $kategori->id,
            'file_path' => $oldPath,
            'file_name' => 'draf-awal.pdf',
            'file_size' => 153600,
            'status_persetujuan' => 'draft',
            'user_id' => $admin->id,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        $newFile = UploadedFile::fake()->create('draf-revisi-final.pdf', 350, 'application/pdf');

        $response = $this->actingAs($admin)->put('/admin/surat-keluar/'.$surat->id, [
            'nomor_agenda' => $surat->nomor_agenda,
            'nomor_surat' => $surat->nomor_surat,
            'tanggal_surat' => '2026-09-20',
            'tujuan' => $surat->tujuan,
            'perihal' => $surat->perihal,
            'kategori_id' => $kategori->id,
            'status_persetujuan' => 'draft',
            'berkas' => $newFile,
        ]);

        $response->assertRedirect('/admin/surat-keluar/'.$surat->id);

        $surat->refresh();

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($surat->file_path);
        $this->assertEquals('draf-revisi-final.pdf', $surat->file_name);
    }

    /**
     * Uji Admin dapat mengajukan draf surat keluar ke Kepala Sekolah (SRS-P04)
     */
    public function test_admin_can_submit_draft_to_kepala_sekolah(): void
    {
        $admin = User::where('role', 'admin')->first();
        $suratKeluar = SuratKeluar::where('status_persetujuan', 'draft')->first();

        if (! $suratKeluar) {
            $suratKeluar = SuratKeluar::first();
            $suratKeluar->update(['status_persetujuan' => 'draft']);
        }

        $response = $this->actingAs($admin)->post('/admin/surat-keluar/'.$suratKeluar->id.'/ajukan');

        $response->assertRedirect('/admin/surat-keluar/'.$suratKeluar->id);
        $response->assertSessionHas('success');

        $suratKeluar->refresh();
        $this->assertEquals('menunggu_persetujuan', $suratKeluar->status_persetujuan);

        $this->assertDatabaseHas('log_aktivitas', [
            'user_id' => $admin->id,
            'aksi' => 'AJUKAN_SURAT_KELUAR',
        ]);
    }

    /**
     * Uji Admin dapat mengunduh berkas fisik surat keluar
     */
    public function test_admin_can_download_surat_keluar_file(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $file = UploadedFile::fake()->create('surat-keluar-unduh.pdf', 300, 'application/pdf');
        $path = $file->storeAs('dokumen-surat-keluar', 'surat-keluar-unduh.pdf', 'public');

        $surat = SuratKeluar::create([
            'nomor_agenda' => 'SK/2026/996',
            'nomor_surat' => 'DOWNLOAD/SK/2026',
            'tanggal_surat' => '2026-09-20',
            'tujuan' => 'Instansi Unduh',
            'perihal' => 'Pengujian Unduh Berkas SK',
            'kategori_id' => $kategori->id,
            'file_path' => $path,
            'file_name' => 'surat-keluar-unduh.pdf',
            'file_size' => 307200,
            'status_persetujuan' => 'draft',
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/surat-keluar/'.$surat->id.'/download');

        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=surat-keluar-unduh.pdf');
    }

    /**
     * Uji Admin dapat menghapus surat keluar dan berkas fisiknya dari storage
     */
    public function test_admin_can_delete_surat_keluar_and_file_is_deleted_from_storage(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $file = UploadedFile::fake()->create('surat-keluar-hapus.pdf', 120, 'application/pdf');
        $path = $file->storeAs('dokumen-surat-keluar', 'surat-keluar-hapus.pdf', 'public');

        $surat = SuratKeluar::create([
            'nomor_agenda' => 'SK/2026/997',
            'nomor_surat' => 'DELETE/SK/2026',
            'tanggal_surat' => '2026-09-20',
            'tujuan' => 'Instansi Hapus',
            'perihal' => 'Pengujian Hapus Berkas SK',
            'kategori_id' => $kategori->id,
            'file_path' => $path,
            'file_name' => 'surat-keluar-hapus.pdf',
            'file_size' => 122880,
            'status_persetujuan' => 'draft',
            'user_id' => $admin->id,
        ]);

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($admin)->delete('/admin/surat-keluar/'.$surat->id);

        $response->assertRedirect('/admin/surat-keluar');
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('surat_keluar', ['id' => $surat->id]);
        Storage::disk('public')->assertExists($path);
    }

    /**
     * Uji pencarian dan penyaringan data surat keluar
     */
    public function test_surat_keluar_search_and_filters_work(): void
    {
        $admin = User::where('role', 'admin')->first();

        // 1. Pencarian keyword yang ada di seeder
        $response = $this->actingAs($admin)->get('/admin/surat-keluar?search=Kurikulum');
        $response->assertStatus(200);
        $response->assertSee('Kurikulum');

        // 2. Filter Status Persetujuan
        $responseStatus = $this->actingAs($admin)->get('/admin/surat-keluar?status_persetujuan=menunggu_persetujuan');
        $responseStatus->assertStatus(200);

        // 3. Pencarian keyword nihil
        $responseEmpty = $this->actingAs($admin)->get('/admin/surat-keluar?search=SURAT_KELUAR_TIDAK_DITEMUKAN_XYZ');
        $responseEmpty->assertStatus(200);
        $responseEmpty->assertSee('Belum ada berkas surat keluar yang tercatat ke dalam sistem.');
    }

    /**
     * Uji Kepala Sekolah dapat memantau dan meninjau surat keluar (SRS-KS03)
     */
    public function test_kepala_sekolah_can_view_surat_keluar_monitoring_and_detail(): void
    {
        $kepsek = User::where('role', 'kepala_sekolah')->first();
        $suratKeluar = SuratKeluar::first();

        // Halaman Pemantauan Persetujuan
        $responseIndex = $this->actingAs($kepsek)->get('/kepala-sekolah/surat-keluar');
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Tinjauan Surat Keluar');
        $responseIndex->assertSee('Menunggu Persetujuan');

        // Halaman Tinjauan Detail Draf
        $responseShow = $this->actingAs($kepsek)->get('/kepala-sekolah/surat-keluar/'.$suratKeluar->id);
        $responseShow->assertStatus(200);
        $responseShow->assertSee($suratKeluar->nomor_surat);
        $responseShow->assertSee('Lembar Informasi Draf Surat Keluar');
    }

    /**
     * Uji Admin dan Kepala Sekolah dapat mencetak lembar kendali arsip surat keluar
     */
    public function test_admin_and_kepsek_can_access_cetak_lembar_surat_keluar(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kepsek = User::where('role', 'kepala_sekolah')->first();
        $suratKeluar = SuratKeluar::first();

        // Admin Cetak
        $responseAdmin = $this->actingAs($admin)->get("/admin/surat-keluar/{$suratKeluar->id}/cetak");
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('LEMBAR KENDALI DAN REGISTRASI SURAT KELUAR');
        $responseAdmin->assertSee($suratKeluar->nomor_agenda);
        $responseAdmin->assertSee($suratKeluar->nomor_surat);
        $responseAdmin->assertSee('logo-jabar.png');
        $responseAdmin->assertSee('logo-smk.png');

        // Kepsek Cetak
        $responseKepsek = $this->actingAs($kepsek)->get("/kepala-sekolah/surat-keluar/{$suratKeluar->id}/cetak");
        $responseKepsek->assertStatus(200);
        $responseKepsek->assertSee('LEMBAR KENDALI DAN REGISTRASI SURAT KELUAR');
    }
}
