<?php

namespace Tests\Feature;

use App\Models\KategoriSurat;
use App\Models\PengajuanLegalisir;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class SecurityAndIntegrityEnhancementTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected User $kepsek;

    protected User $pemohonA;

    protected User $pemohonB;

    protected KategoriSurat $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        RateLimiter::clear('login:test@smkn1subang.sch.id|127.0.0.1');

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->kepsek = User::factory()->create([
            'role' => 'kepala_sekolah',
            'is_active' => true,
        ]);

        $this->pemohonA = User::factory()->create([
            'role' => 'pemohon',
            'is_active' => true,
        ]);

        $this->pemohonB = User::factory()->create([
            'role' => 'pemohon',
            'is_active' => true,
        ]);

        $this->kategori = KategoriSurat::create([
            'kode_kategori' => '421.5',
            'nama_kategori' => 'Kurikulum & Pembelajaran',
            'deskripsi' => 'Arsip bidang kurikulum SMK',
        ]);
    }

    /**
     * 1. Uji Rate Limiter pada Login (Anti Brute-Force)
     */
    public function test_login_rate_limiting_locks_out_after_five_failed_attempts(): void
    {
        $email = 'bruteforce@smkn1subang.sch.id';
        User::factory()->create([
            'email' => $email,
            'password' => Hash::make('password_benar'),
            'is_active' => true,
        ]);

        // 5x percobaan salah
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', [
                'email' => $email,
                'password' => 'password_salah',
            ]);
            $response->assertSessionHasErrors('email');
        }

        // Percobaan ke-6 harus terkunci rate limiter
        $lockedResponse = $this->post('/login', [
            'email' => $email,
            'password' => 'password_salah',
        ]);

        $lockedResponse->assertSessionHasErrors('email');
        $errorMessage = session('errors')->first('email');
        $this->assertStringContainsString('Terlalu banyak percobaan masuk', $errorMessage);
    }

    /**
     * 2. Uji Akun Nonaktif (is_active = false) Tidak Dapat Login
     */
    public function test_inactive_user_is_prevented_from_logging_in(): void
    {
        $inactiveUser = User::factory()->create([
            'email' => 'nonaktif@smkn1subang.sch.id',
            'password' => Hash::make('password123'),
            'is_active' => false,
        ]);

        $response = $this->post('/login', [
            'email' => $inactiveUser->email,
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('dinonaktifkan', session('errors')->first('email'));
    }

    /**
     * 3. Uji Proteksi IDOR pada Lembar Rincian Pemohon Legalisir
     */
    public function test_applicant_cannot_view_other_applicant_legalisir_idor_protection(): void
    {
        $legalisirA = PengajuanLegalisir::create([
            'user_id' => $this->pemohonA->id,
            'nomor_pengajuan' => 'LEG-202610-0001',
            'kode_akses' => 'AKSES00001',
            'nama_pemohon' => 'Siswa A',
            'nisn' => '0012345678',
            'nomor_whatsapp' => '081234567890',
            'email' => 'siswaA@test.com',
            'tahun_lulus' => '2025',
            'jenis_dokumen' => 'ijazah',
            'jumlah_lembar' => 3,
            'keperluan' => 'Melamar pekerjaan',
            'file_dokumen_path' => 'dokumen-legalisir/dummyA.pdf',
            'status' => 'menunggu_verifikasi',
        ]);

        // Pemohon B mencoba mengakses permohonan Pemohon A -> Harus 403 Forbidden
        $response = $this->actingAs($this->pemohonB)->get(route('pemohon.legalisir.show', $legalisirA));
        $response->assertStatus(403);

        // Pemohon A dapat mengakses permohonannya sendiri -> 200 OK
        $responseOwner = $this->actingAs($this->pemohonA)->get(route('pemohon.legalisir.show', $legalisirA));
        $responseOwner->assertStatus(200);
    }

    /**
     * 4. Uji Download Dokumen Legalisir Memerlukan Otorisasi / Signed URL
     */
    public function test_unauthorized_guest_cannot_download_legalisir_document_without_signed_url(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('ijazah.pdf', 200, 'application/pdf');
        $path = $file->storeAs('dokumen-legalisir', 'ijazah.pdf', 'public');

        $legalisir = PengajuanLegalisir::create([
            'user_id' => $this->pemohonA->id,
            'nomor_pengajuan' => 'LEG-202610-0002',
            'kode_akses' => 'AKSES00002',
            'nama_pemohon' => 'Siswa A',
            'nisn' => '0012345678',
            'nomor_whatsapp' => '081234567890',
            'email' => 'siswa@test.com',
            'tahun_lulus' => '2025',
            'jenis_dokumen' => 'ijazah',
            'jumlah_lembar' => 2,
            'keperluan' => 'Pemberkasan',
            'file_dokumen_path' => $path,
            'status' => 'menunggu_verifikasi',
        ]);

        // Tamu / Pemohon lain tanpa signature -> 403 Forbidden
        $responseGuest = $this->get(route('legalisir.download', $legalisir));
        $responseGuest->assertStatus(403);

        // Akses menggunakan signed URL sementara yang valid -> 200 Download
        $signedUrl = URL::temporarySignedRoute(
            'legalisir.download',
            now()->addMinutes(60),
            ['legalisir' => $legalisir->id]
        );

        $responseSigned = $this->get($signedUrl);
        $responseSigned->assertStatus(200);

        // Admin selalu diizinkan mengunduh tanpa signed URL
        $responseAdmin = $this->actingAs($this->admin)->get(route('legalisir.download', $legalisir));
        $responseAdmin->assertStatus(200);
    }

    /**
     * 5. Uji Surat Keluar yang Disetujui Dikunci dari Pengeditan Staf TU
     */
    public function test_admin_cannot_edit_approved_surat_keluar(): void
    {
        $suratApproved = SuratKeluar::create([
            'nomor_agenda' => 'SK/2026/099',
            'nomor_surat' => '421.5/099/SMK-CADISDIK/2026',
            'tanggal_surat' => '2026-10-01',
            'tujuan' => 'Dinas Pendidikan Jawa Barat',
            'perihal' => 'Laporan Akreditasi Sekolah',
            'kategori_id' => $this->kategori->id,
            'file_path' => 'dokumen-surat-keluar/sk-099.pdf',
            'file_name' => 'sk-099.pdf',
            'file_size' => 1024,
            'status_persetujuan' => 'disetujui',
            'user_id' => $this->admin->id,
        ]);

        // Buka form edit -> dialihkan kembali dengan error
        $responseEdit = $this->actingAs($this->admin)->get(route('admin.surat-keluar.edit', $suratApproved));
        $responseEdit->assertRedirect(route('admin.surat-keluar.show', $suratApproved));
        $responseEdit->assertSessionHas('error');

        // Submit pembaruan -> ditolak dengan pesan error
        $responseUpdate = $this->actingAs($this->admin)->put(route('admin.surat-keluar.update', $suratApproved), [
            'nomor_agenda' => 'SK/2026/099',
            'nomor_surat' => '421.5/099/MODIFIED',
            'tanggal_surat' => '2026-10-01',
            'tujuan' => 'Pihak Lain',
            'perihal' => 'Perubahan Ilegal',
            'kategori_id' => $this->kategori->id,
            'status_persetujuan' => 'draft',
        ]);

        $responseUpdate->assertRedirect(route('admin.surat-keluar.show', $suratApproved));
        $responseUpdate->assertSessionHas('error');

        // Pastikan isi di database tidak berubah
        $suratApproved->refresh();
        $this->assertEquals('421.5/099/SMK-CADISDIK/2026', $suratApproved->nomor_surat);
    }

    /**
     * 6. Uji Kepala Sekolah Hanya Dapat Menyetujui Surat Berstatus Menunggu Persetujuan
     */
    public function test_kepala_sekolah_cannot_approve_draft_surat_keluar(): void
    {
        $suratDraft = SuratKeluar::create([
            'nomor_agenda' => 'SK/2026/088',
            'nomor_surat' => '421.5/088/SMK/2026',
            'tanggal_surat' => '2026-10-01',
            'tujuan' => 'Dinas Pendidikan',
            'perihal' => 'Draf Konsep',
            'kategori_id' => $this->kategori->id,
            'file_path' => 'dokumen-surat-keluar/sk-088.pdf',
            'file_name' => 'sk-088.pdf',
            'file_size' => 1024,
            'status_persetujuan' => 'draft', // Masih draf, belum diajukan
            'user_id' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->kepsek)->post(route('kepsek.persetujuan.approve', $suratDraft), [
            'catatan_kepsek' => 'Setuju',
        ]);

        $response->assertRedirect(route('kepsek.persetujuan.show', $suratDraft));
        $response->assertSessionHas('error');

        $suratDraft->refresh();
        $this->assertEquals('draft', $suratDraft->status_persetujuan);
    }

    /**
     * 7. Uji Integritas Status Mesin Legalisir (Mencegah Melompati Tahapan)
     */
    public function test_legalisir_state_machine_prevents_illegal_transitions(): void
    {
        $legalisir = PengajuanLegalisir::create([
            'user_id' => $this->pemohonA->id,
            'nomor_pengajuan' => 'LEG-202610-0003',
            'kode_akses' => 'AKSES00003',
            'nama_pemohon' => 'Siswa A',
            'nisn' => '0012345678',
            'nomor_whatsapp' => '081234567890',
            'email' => 'siswa@test.com',
            'tahun_lulus' => '2025',
            'jenis_dokumen' => 'ijazah',
            'jumlah_lembar' => 1,
            'keperluan' => 'Pendaftaran Universitas',
            'file_dokumen_path' => 'dokumen-legalisir/dummy.pdf',
            'status' => 'menunggu_verifikasi',
        ]);

        // Coba langsung menandai selesai sebelum diverifikasi & siap diambil
        $response = $this->actingAs($this->admin)->patch(route('admin.legalisir.selesai', $legalisir));
        $response->assertSessionHas('error');

        $legalisir->refresh();
        $this->assertEquals('menunggu_verifikasi', $legalisir->status);
    }

    /**
     * 8. Uji Kategori Klasifikasi Tidak Dapat Dihapus Jika Masih Ada Surat (Termasuk Arsip Inaktif)
     */
    public function test_kategori_cannot_be_deleted_if_has_soft_deleted_surat(): void
    {
        $surat = SuratMasuk::create([
            'nomor_agenda' => 'SM/2026/SEC-999',
            'nomor_surat' => '999/DINAS/2026',
            'tanggal_surat' => '2026-10-01',
            'tanggal_terima' => '2026-10-02',
            'pengirim' => 'Dinas Pendidikan',
            'penerima' => 'Kepala Sekolah',
            'perihal' => 'Surat Pembinaan',
            'kategori_id' => $this->kategori->id,
            'file_path' => 'dokumen-surat-masuk/sm-001.pdf',
            'file_name' => 'sm-001.pdf',
            'file_size' => 1024,
            'status' => 'diterima',
            'user_id' => $this->admin->id,
        ]);

        // Surat dimasukkan ke arsip inaktif (Soft Delete)
        $surat->delete();

        // Mencoba menghapus kategori -> harus dicegah karena masih ada arsip inaktif yang terikat
        $response = $this->actingAs($this->admin)->delete(route('admin.kategori.destroy', $this->kategori));
        $response->assertRedirect(route('admin.kategori.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('kategori_surat', ['id' => $this->kategori->id]);
    }
}
