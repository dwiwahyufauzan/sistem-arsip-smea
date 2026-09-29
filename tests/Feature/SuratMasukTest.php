<?php

namespace Tests\Feature;

use App\Models\KategoriSurat;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SuratMasukTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Uji Admin TU dapat mengakses halaman daftar surat masuk
     */
    public function test_admin_can_view_surat_masuk_index_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/surat-masuk');

        $response->assertStatus(200);
        $response->assertSee('Pengelolaan Arsip Surat Masuk');
        $response->assertSee('Catat Surat Masuk');
        $response->assertSee('Total Surat Masuk');
    }

    /**
     * Uji pengguna non-admin (Pemohon) dilarang mengakses modul admin surat masuk
     */
    public function test_non_admin_cannot_access_admin_surat_masuk(): void
    {
        $pemohon = User::where('role', 'pemohon')->first();

        $response = $this->actingAs($pemohon)->get('/admin/surat-masuk');

        $response->assertRedirect('/pemohon/dashboard');
        $response->assertSessionHas('error');
    }

    /**
     * Uji Admin dapat membuka halaman form pencatatan dengan nomor agenda otomatis
     */
    public function test_admin_can_view_create_page_with_auto_generated_agenda(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/surat-masuk/create');

        $response->assertStatus(200);
        $response->assertSee('Registrasi Surat Masuk Baru');
        $response->assertSee('SM/'.date('Y').'/');
    }

    /**
     * Uji Admin dapat mencatat surat masuk baru beserta unggahan berkas scan PDF (SRS-P02)
     */
    public function test_admin_can_store_new_surat_masuk_with_file_upload(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $file = UploadedFile::fake()->create('surat-kerjasama-dudi.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/surat-masuk', [
            'nomor_agenda' => 'SM/2026/999',
            'nomor_surat' => '421/098/SMK-DUDI/2026',
            'tanggal_surat' => '2026-09-20',
            'tanggal_terima' => '2026-09-21',
            'pengirim' => 'PT. Dirgantara Indonesia',
            'penerima' => 'Kepala SMKN 1 Subang',
            'perihal' => 'MoU Kerjasama Kelas Industri dan Magang Siswa 2026',
            'isi_ringkas' => 'Kesepakatan pembinaan kejuruan dan penyaluran lulusan teknik pemesinan.',
            'kategori_id' => $kategori->id,
            'berkas' => $file,
        ]);

        $suratMasuk = SuratMasuk::where('nomor_agenda', 'SM/2026/999')->first();

        $this->assertNotNull($suratMasuk);
        $response->assertRedirect('/admin/surat-masuk/'.$suratMasuk->id);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('surat_masuk', [
            'nomor_agenda' => 'SM/2026/999',
            'nomor_surat' => '421/098/SMK-DUDI/2026',
            'pengirim' => 'PT. Dirgantara Indonesia',
            'status' => 'diterima',
            'user_id' => $admin->id,
        ]);

        Storage::disk('public')->assertExists($suratMasuk->file_path);

        $this->assertDatabaseHas('log_aktivitas', [
            'user_id' => $admin->id,
        ]);
    }

    /**
     * Uji validasi input wajib pada pencatatan surat masuk
     */
    public function test_store_surat_masuk_validation_fails_for_missing_fields(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/surat-masuk', []);

        $response->assertSessionHasErrors([
            'nomor_agenda',
            'nomor_surat',
            'tanggal_surat',
            'tanggal_terima',
            'pengirim',
            'perihal',
            'kategori_id',
            'berkas',
        ]);
    }

    /**
     * Uji validasi keunikan nomor agenda surat
     */
    public function test_store_surat_masuk_validates_unique_nomor_agenda(): void
    {
        $admin = User::where('role', 'admin')->first();
        $existingSurat = SuratMasuk::first();

        $response = $this->actingAs($admin)->post('/admin/surat-masuk', [
            'nomor_agenda' => $existingSurat->nomor_agenda,
            'nomor_surat' => 'DUPLIKAT/123',
            'tanggal_surat' => '2026-09-20',
            'tanggal_terima' => '2026-09-21',
            'pengirim' => 'Pengirim Duplikat',
            'perihal' => 'Perihal Duplikat',
            'kategori_id' => $existingSurat->kategori_id,
            'berkas' => UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors('nomor_agenda');
    }

    /**
     * Uji penolakan berkas jika ukuran melebihi 5 MB (NFR & SRS-P02)
     */
    public function test_store_surat_masuk_fails_if_file_exceeds_5mb(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        // 6000 KB = 6 MB (melebihi batas 5120 KB)
        $largeFile = UploadedFile::fake()->create('large-scan.pdf', 6000, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/surat-masuk', [
            'nomor_agenda' => 'SM/2026/998',
            'nomor_surat' => 'OVERSIZE/001',
            'tanggal_surat' => '2026-09-20',
            'tanggal_terima' => '2026-09-21',
            'pengirim' => 'Instansi Besar',
            'perihal' => 'Pengujian File Besar',
            'kategori_id' => $kategori->id,
            'berkas' => $largeFile,
        ]);

        $response->assertSessionHasErrors('berkas');
    }

    /**
     * Uji penolakan format file selain PDF/JPG/PNG
     */
    public function test_store_surat_masuk_fails_for_invalid_file_extension(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $invalidFile = UploadedFile::fake()->create('script.exe', 100, 'application/x-msdownload');

        $response = $this->actingAs($admin)->post('/admin/surat-masuk', [
            'nomor_agenda' => 'SM/2026/997',
            'nomor_surat' => 'INVALID/001',
            'tanggal_surat' => '2026-09-20',
            'tanggal_terima' => '2026-09-21',
            'pengirim' => 'Pengirim Uji',
            'perihal' => 'Pengujian Ekstensi Ilegal',
            'kategori_id' => $kategori->id,
            'berkas' => $invalidFile,
        ]);

        $response->assertSessionHasErrors('berkas');
    }

    /**
     * Uji Admin dapat melihat lembar detail surat masuk
     */
    public function test_admin_can_view_surat_masuk_show_page(): void
    {
        $admin = User::where('role', 'admin')->first();
        $suratMasuk = SuratMasuk::first();

        $response = $this->actingAs($admin)->get('/admin/surat-masuk/'.$suratMasuk->id);

        $response->assertStatus(200);
        $response->assertSee($suratMasuk->nomor_surat);
        $response->assertSee($suratMasuk->nomor_agenda);
        $response->assertSee('Lembar Informasi Surat Masuk');
        $response->assertSee('Pratinjau Dokumen Fisik');
    }

    /**
     * Uji Admin dapat memperbarui metadata surat masuk (SRS-P03)
     */
    public function test_admin_can_update_surat_masuk_metadata(): void
    {
        $admin = User::where('role', 'admin')->first();
        $suratMasuk = SuratMasuk::where('nomor_agenda', 'SM/2026/999')->first() ?? SuratMasuk::first();

        $response = $this->actingAs($admin)->put('/admin/surat-masuk/'.$suratMasuk->id, [
            'nomor_agenda' => $suratMasuk->nomor_agenda,
            'nomor_surat' => $suratMasuk->nomor_surat.'-REV',
            'tanggal_surat' => '2026-09-22',
            'tanggal_terima' => '2026-09-23',
            'pengirim' => 'PT. Dirgantara Indonesia (Persero)',
            'perihal' => 'Revisi Kerjasama MoU Kelas Industri 2026',
            'isi_ringkas' => 'Pembaruan kuota magang siswa',
            'kategori_id' => $suratMasuk->kategori_id,
            'status' => 'didisposisikan',
        ]);

        $response->assertRedirect('/admin/surat-masuk/'.$suratMasuk->id);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('surat_masuk', [
            'id' => $suratMasuk->id,
            'nomor_surat' => $suratMasuk->nomor_surat.'-REV',
            'status' => 'didisposisikan',
        ]);
    }

    /**
     * Uji Admin dapat mengganti berkas scan fisik saat edit (SRS-P03)
     */
    public function test_admin_can_update_surat_masuk_with_new_file_replacement(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        // 1. Buat surat awal
        $oldFile = UploadedFile::fake()->create('surat-lama.pdf', 200, 'application/pdf');
        $oldPath = $oldFile->storeAs('dokumen-surat-masuk', 'surat-lama.pdf', 'public');

        $surat = SuratMasuk::create([
            'nomor_agenda' => 'SM/2026/888',
            'nomor_surat' => 'OLD/FILE/2026',
            'tanggal_surat' => '2026-09-10',
            'tanggal_terima' => '2026-09-11',
            'pengirim' => 'Instansi Asal',
            'perihal' => 'Surat Pergantian Berkas',
            'kategori_id' => $kategori->id,
            'file_path' => $oldPath,
            'file_name' => 'surat-lama.pdf',
            'file_size' => 204800,
            'status' => 'diterima',
            'user_id' => $admin->id,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        // 2. Unggah berkas baru
        $newFile = UploadedFile::fake()->create('surat-revisi-baru.pdf', 400, 'application/pdf');

        $response = $this->actingAs($admin)->put('/admin/surat-masuk/'.$surat->id, [
            'nomor_agenda' => $surat->nomor_agenda,
            'nomor_surat' => $surat->nomor_surat,
            'tanggal_surat' => '2026-09-10',
            'tanggal_terima' => '2026-09-11',
            'pengirim' => $surat->pengirim,
            'perihal' => $surat->perihal,
            'kategori_id' => $kategori->id,
            'status' => 'diterima',
            'berkas' => $newFile,
        ]);

        $response->assertRedirect('/admin/surat-masuk/'.$surat->id);

        $surat->refresh();

        // Berkas lama harus terhapus dan berkas baru tersimpan
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($surat->file_path);
        $this->assertEquals('surat-revisi-baru.pdf', $surat->file_name);
    }

    /**
     * Uji Admin dapat mengunduh berkas fisik surat masuk
     */
    public function test_admin_can_download_surat_masuk_file(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $file = UploadedFile::fake()->create('arsip-unduh.pdf', 300, 'application/pdf');
        $path = $file->storeAs('dokumen-surat-masuk', 'arsip-unduh.pdf', 'public');

        $surat = SuratMasuk::create([
            'nomor_agenda' => 'SM/2026/777',
            'nomor_surat' => 'DOWNLOAD/TEST/2026',
            'tanggal_surat' => '2026-09-10',
            'tanggal_terima' => '2026-09-11',
            'pengirim' => 'Dinas Terkait',
            'perihal' => 'Uji Unduh Berkas',
            'kategori_id' => $kategori->id,
            'file_path' => $path,
            'file_name' => 'arsip-unduh.pdf',
            'file_size' => 307200,
            'status' => 'diterima',
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/surat-masuk/'.$surat->id.'/download');

        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=arsip-unduh.pdf');
    }

    /**
     * Uji Admin dapat menghapus surat masuk dan berkas fisik terhapus dari storage (SRS-P03)
     */
    public function test_admin_can_delete_surat_masuk_and_file_is_deleted_from_storage(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::first();

        $file = UploadedFile::fake()->create('surat-akan-dihapus.pdf', 150, 'application/pdf');
        $path = $file->storeAs('dokumen-surat-masuk', 'surat-akan-dihapus.pdf', 'public');

        $surat = SuratMasuk::create([
            'nomor_agenda' => 'SM/2026/666',
            'nomor_surat' => 'DELETE/TEST/2026',
            'tanggal_surat' => '2026-09-10',
            'tanggal_terima' => '2026-09-11',
            'pengirim' => 'Instansi Hapus',
            'perihal' => 'Surat Siap Dihapus',
            'kategori_id' => $kategori->id,
            'file_path' => $path,
            'file_name' => 'surat-akan-dihapus.pdf',
            'file_size' => 153600,
            'status' => 'diterima',
            'user_id' => $admin->id,
        ]);

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($admin)->delete('/admin/surat-masuk/'.$surat->id);

        $response->assertRedirect('/admin/surat-masuk');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('surat_masuk', ['id' => $surat->id]);
        Storage::disk('public')->assertMissing($path);
    }

    /**
     * Uji fitur pencarian dan filter arsip surat masuk
     */
    public function test_surat_masuk_search_and_filters_work(): void
    {
        $admin = User::where('role', 'admin')->first();

        // 1. Pencarian keyword yang ada
        $response = $this->actingAs($admin)->get('/admin/surat-masuk?search=Pindad');
        $response->assertStatus(200);
        $response->assertSee('Pindad');

        // 2. Filter Status
        $responseStatus = $this->actingAs($admin)->get('/admin/surat-masuk?status=diterima');
        $responseStatus->assertStatus(200);

        // 3. Pencarian keyword yang tidak ada
        $responseEmpty = $this->actingAs($admin)->get('/admin/surat-masuk?search=XYZ_TIDAK_ADA_DI_ARSIP');
        $responseEmpty->assertStatus(200);
        $responseEmpty->assertSee('Tidak Ada Arsip Surat Masuk');
    }

    /**
     * Uji Kepala Sekolah dapat memantau dan meninjau surat masuk (SRS-KS02)
     */
    public function test_kepala_sekolah_can_view_surat_masuk_monitoring_and_detail(): void
    {
        $kepsek = User::where('role', 'kepala_sekolah')->first();
        $suratMasuk = SuratMasuk::first();

        // Halaman Pemantauan
        $responseIndex = $this->actingAs($kepsek)->get('/kepala-sekolah/surat-masuk');
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Pemantauan Surat Masuk');
        $responseIndex->assertSee('Perlu Disposisi');

        // Halaman Tinjauan Detail
        $responseShow = $this->actingAs($kepsek)->get('/kepala-sekolah/surat-masuk/'.$suratMasuk->id);
        $responseShow->assertStatus(200);
        $responseShow->assertSee($suratMasuk->nomor_surat);
        $responseShow->assertSee('Lembar Informasi Surat Dinas Masuk');
    }
}
