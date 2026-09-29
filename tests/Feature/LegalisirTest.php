<?php

namespace Tests\Feature;

use App\Models\PengajuanLegalisir;
use App\Models\RiwayatLegalisir;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LegalisirTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    private User $kepsek;

    private User $pemohon;

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
            ['email' => 'alumni@test.com'],
            [
                'name' => 'Alumni Subang',
                'password' => bcrypt('password'),
                'role' => 'pemohon',
                'nip_nisn' => '0049988771',
            ]
        );
    }

    private function createDummyPengajuan(string $status = 'menunggu_verifikasi'): PengajuanLegalisir
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('ijazah_test.pdf', 500, 'application/pdf');
        $path = $file->store('dokumen-legalisir', 'public');

        $pengajuan = PengajuanLegalisir::create([
            'nomor_pengajuan' => 'LEG-'.date('Ym').'-'.rand(1000, 9999),
            'user_id' => $this->pemohon->id,
            'nama_pemohon' => 'Siti Nurhaliza',
            'nisn' => '0049988771',
            'tahun_lulus' => '2023',
            'nomor_whatsapp' => '081234567890',
            'email' => 'alumni@test.com',
            'jenis_dokumen' => 'ijazah',
            'jumlah_lembar' => 3,
            'keperluan' => 'Pemberkasan CPNS Kemdikbud',
            'file_dokumen_path' => $path,
            'status' => $status,
        ]);

        RiwayatLegalisir::create([
            'pengajuan_legalisir_id' => $pengajuan->id,
            'status_sebelumnya' => null,
            'status_baru' => $status,
            'diubah_oleh' => $this->admin->id,
            'catatan' => 'Permohonan awal tercatat.',
            'created_at' => now(),
        ]);

        return $pengajuan;
    }

    public function test_public_user_can_view_legalisir_application_form(): void
    {
        $response = $this->get(route('legalisir.create'));

        $response->assertStatus(200);
        $response->assertSee('Permohonan Legalisir Dokumen Online');
        $response->assertSee('Ijazah Asli / Salinan');
    }

    public function test_public_user_can_submit_legalisir_application_successfully(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('scan_ijazah.pdf', 1024, 'application/pdf');

        $response = $this->post(route('legalisir.store'), [
            'nama_pemohon' => 'Ahmad Fajar',
            'nisn' => '0051234567',
            'tahun_lulus' => '2022',
            'nomor_whatsapp' => '082123456789',
            'email' => 'ahmad.fajar@example.com',
            'jenis_dokumen' => 'ijazah',
            'jumlah_lembar' => 5,
            'keperluan' => 'Syarat melanjutkan kuliah S1',
            'berkas' => $file,
        ]);

        $pengajuan = PengajuanLegalisir::where('nisn', '0051234567')->first();
        $this->assertNotNull($pengajuan);
        $this->assertStringStartsWith('LEG-'.date('Ym').'-', $pengajuan->nomor_pengajuan);
        $this->assertEquals('menunggu_verifikasi', $pengajuan->status);

        $response->assertRedirect(route('legalisir.sukses', $pengajuan->nomor_pengajuan));
        $this->assertDatabaseHas('riwayat_legalisir', [
            'pengajuan_legalisir_id' => $pengajuan->id,
            'status_baru' => 'menunggu_verifikasi',
        ]);
    }

    public function test_legalisir_validation_fails_for_invalid_data_and_large_files(): void
    {
        Storage::fake('public');
        $largeFile = UploadedFile::fake()->create('large.pdf', 6000, 'application/pdf'); // > 5MB

        $response = $this->post(route('legalisir.store'), [
            'nama_pemohon' => '',
            'nisn' => '',
            'tahun_lulus' => '',
            'nomor_whatsapp' => '',
            'email' => 'invalid-email',
            'jenis_dokumen' => 'dokumen_ilegal',
            'jumlah_lembar' => 20, // Max is 10
            'keperluan' => '',
            'berkas' => $largeFile,
        ]);

        $response->assertSessionHasErrors([
            'nama_pemohon',
            'nisn',
            'tahun_lulus',
            'nomor_whatsapp',
            'email',
            'jenis_dokumen',
            'jumlah_lembar',
            'keperluan',
            'berkas',
        ]);
    }

    public function test_public_user_can_view_success_page_and_tanda_terima(): void
    {
        $pengajuan = $this->createDummyPengajuan();

        $responseSukses = $this->get(route('legalisir.sukses', $pengajuan->nomor_pengajuan));
        $responseSukses->assertStatus(200);
        $responseSukses->assertSee($pengajuan->nomor_pengajuan);
        $responseSukses->assertSee($pengajuan->nama_pemohon);

        $responseTandaTerima = $this->get(route('legalisir.tanda-terima', $pengajuan->nomor_pengajuan));
        $responseTandaTerima->assertStatus(200);
        $responseTandaTerima->assertSee('BUKTI TANDA TERIMA PENDAFTARAN LEGALISIR');
        $responseTandaTerima->assertSee($pengajuan->nomor_pengajuan);
    }

    public function test_public_user_can_track_legalisir_using_receipt_code_or_nisn(): void
    {
        $pengajuan = $this->createDummyPengajuan();

        // Cari via nomor resi
        $responseResi = $this->get(route('legalisir.tracking', ['nomor_pengajuan' => $pengajuan->nomor_pengajuan]));
        $responseResi->assertStatus(200);
        $responseResi->assertSee($pengajuan->nomor_pengajuan);
        $responseResi->assertSee($pengajuan->nama_pemohon);

        // Cari via NISN
        $responseNisn = $this->get(route('legalisir.tracking', ['nomor_pengajuan' => $pengajuan->nisn]));
        $responseNisn->assertStatus(200);
        $responseNisn->assertSee($pengajuan->nomor_pengajuan);
    }

    public function test_admin_can_view_legalisir_queue_and_detail(): void
    {
        $pengajuan = $this->createDummyPengajuan();

        $responseIndex = $this->actingAs($this->admin)->get(route('admin.legalisir.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Pengelolaan Legalisir Online');
        $responseIndex->assertSee($pengajuan->nomor_pengajuan);

        $responseShow = $this->actingAs($this->admin)->get(route('admin.legalisir.show', $pengajuan->id));
        $responseShow->assertStatus(200);
        $responseShow->assertSee($pengajuan->nama_pemohon);
        $responseShow->assertSee('Lembar Verifikasi Berkas Legalisir');
    }

    public function test_admin_can_verify_legalisir_and_forward_to_kepsek(): void
    {
        $pengajuan = $this->createDummyPengajuan();

        $response = $this->actingAs($this->admin)->patch(route('admin.legalisir.verifikasi', $pengajuan->id), [
            'status' => 'menunggu_approval_kepsek',
            'catatan_petugas' => 'Data sesuai buku induk kelulusan SMKN 1 Subang tahun 2023.',
        ]);

        $response->assertRedirect();
        $pengajuan->refresh();

        $this->assertEquals('menunggu_approval_kepsek', $pengajuan->status);
        $this->assertEquals($this->admin->id, $pengajuan->petugas_id);
        $this->assertDatabaseHas('riwayat_legalisir', [
            'pengajuan_legalisir_id' => $pengajuan->id,
            'status_baru' => 'menunggu_approval_kepsek',
            'diubah_oleh' => $this->admin->id,
        ]);
    }

    public function test_kepsek_can_view_queue_and_approve_legalisir(): void
    {
        $pengajuan = $this->createDummyPengajuan('menunggu_approval_kepsek');

        $responseIndex = $this->actingAs($this->kepsek)->get(route('kepsek.legalisir.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee($pengajuan->nomor_pengajuan);

        $responseApprove = $this->actingAs($this->kepsek)->post(route('kepsek.legalisir.approve', $pengajuan->id), [
            'catatan_kepsek' => 'Disahkan untuk tanda tangan basah.',
        ]);

        $responseApprove->assertRedirect();
        $pengajuan->refresh();

        $this->assertEquals('disetujui_kepsek', $pengajuan->status);
        $this->assertEquals('Disahkan untuk tanda tangan basah.', $pengajuan->catatan_kepsek);
        $this->assertDatabaseHas('riwayat_legalisir', [
            'pengajuan_legalisir_id' => $pengajuan->id,
            'status_baru' => 'disetujui_kepsek',
            'diubah_oleh' => $this->kepsek->id,
        ]);
    }

    public function test_kepsek_can_reject_legalisir_with_reason(): void
    {
        $pengajuan = $this->createDummyPengajuan('menunggu_approval_kepsek');

        $responseReject = $this->actingAs($this->kepsek)->post(route('kepsek.legalisir.reject', $pengajuan->id), [
            'catatan_kepsek' => 'Berkas pindaian transkrip nilai bagian belakang tidak terbaca dengan jelas.',
        ]);

        $responseReject->assertRedirect();
        $pengajuan->refresh();

        $this->assertEquals('ditolak', $pengajuan->status);
        $this->assertDatabaseHas('riwayat_legalisir', [
            'pengajuan_legalisir_id' => $pengajuan->id,
            'status_baru' => 'ditolak',
            'diubah_oleh' => $this->kepsek->id,
        ]);
    }

    public function test_admin_can_process_printing_and_stamp(): void
    {
        $pengajuan = $this->createDummyPengajuan('disetujui_kepsek');

        $response = $this->actingAs($this->admin)->patch(route('admin.legalisir.proses-cetak', $pengajuan->id));

        $response->assertRedirect();
        $pengajuan->refresh();

        $this->assertEquals('sedang_diproses', $pengajuan->status);
        $this->assertDatabaseHas('riwayat_legalisir', [
            'pengajuan_legalisir_id' => $pengajuan->id,
            'status_baru' => 'sedang_diproses',
        ]);
    }

    public function test_admin_can_mark_legalisir_ready_for_pickup(): void
    {
        $pengajuan = $this->createDummyPengajuan('sedang_diproses');
        $pickupDate = now()->addDays(2)->toDateString();

        $response = $this->actingAs($this->admin)->patch(route('admin.legalisir.siap-diambil', $pengajuan->id), [
            'tanggal_siap_ambil' => $pickupDate,
            'catatan_petugas' => 'Harap bawa dokumen asli saat pengambilan di loket.',
        ]);

        $response->assertRedirect();
        $pengajuan->refresh();

        $this->assertEquals('siap_diambil', $pengajuan->status);
        $this->assertEquals($pickupDate, $pengajuan->tanggal_siap_ambil->toDateString());
    }

    public function test_admin_can_mark_legalisir_completed(): void
    {
        $pengajuan = $this->createDummyPengajuan('siap_diambil');
        $nowDate = now()->toDateString();

        $response = $this->actingAs($this->admin)->patch(route('admin.legalisir.selesai', $pengajuan->id), [
            'tanggal_pengambilan' => $nowDate,
        ]);

        $response->assertRedirect();
        $pengajuan->refresh();

        $this->assertEquals('selesai', $pengajuan->status);
        $this->assertEquals($nowDate, $pengajuan->tanggal_pengambilan->toDateString());
    }

    public function test_admin_can_reject_legalisir_with_reason(): void
    {
        $pengajuan = $this->createDummyPengajuan('menunggu_verifikasi');

        $response = $this->actingAs($this->admin)->patch(route('admin.legalisir.tolak', $pengajuan->id), [
            'catatan_petugas' => 'Nama dan NISN tidak terdaftar di buku induk angkatan 2023.',
        ]);

        $response->assertRedirect();
        $pengajuan->refresh();

        $this->assertEquals('ditolak', $pengajuan->status);
        $this->assertEquals('Nama dan NISN tidak terdaftar di buku induk angkatan 2023.', $pengajuan->catatan_petugas);
    }

    public function test_pemohon_can_view_own_dashboard_and_legalisir_history(): void
    {
        $pengajuan = $this->createDummyPengajuan();

        $responseDashboard = $this->actingAs($this->pemohon)->get(route('pemohon.dashboard'));
        $responseDashboard->assertStatus(200);
        $responseDashboard->assertSee($pengajuan->nomor_pengajuan);

        $responseIndex = $this->actingAs($this->pemohon)->get(route('pemohon.legalisir.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee($pengajuan->nomor_pengajuan);

        $responseShow = $this->actingAs($this->pemohon)->get(route('pemohon.legalisir.show', $pengajuan->id));
        $responseShow->assertStatus(200);
        $responseShow->assertSee($pengajuan->nomor_pengajuan);
        $responseShow->assertSee('Rincian Berkas Permohonan');
    }

    public function test_role_access_security_for_legalisir_endpoints(): void
    {
        // Tamu tidak bisa akses admin legalisir
        $responseGuest = $this->get(route('admin.legalisir.index'));
        $responseGuest->assertRedirect(route('login'));

        // Pemohon dialihkan saat akses rute admin
        $responsePemohonToAdmin = $this->actingAs($this->pemohon)->get(route('admin.legalisir.index'));
        $responsePemohonToAdmin->assertRedirect(route('pemohon.dashboard'));
        $responsePemohonToAdmin->assertSessionHas('error');

        // Pemohon dialihkan saat akses rute kepsek
        $responsePemohonToKepsek = $this->actingAs($this->pemohon)->get(route('kepsek.legalisir.index'));
        $responsePemohonToKepsek->assertRedirect(route('pemohon.dashboard'));
        $responsePemohonToKepsek->assertSessionHas('error');
    }
}
