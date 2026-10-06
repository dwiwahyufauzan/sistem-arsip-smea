<?php

namespace Tests\Feature;

use App\Models\DisposisiSuratMasuk;
use App\Models\KategoriSurat;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PersetujuanDisposisiTest extends TestCase
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
            ['email' => 'pemohon@gmail.com'],
            [
                'name' => 'Alumni SMK',
                'password' => bcrypt('password'),
                'role' => 'pemohon',
                'nip_nisn' => '181910001',
            ]
        );

        $this->kategori = KategoriSurat::firstOrCreate(
            ['kode_kategori' => '421.5'],
            [
                'nama_kategori' => 'Sekolah Menengah Kejuruan',
                'deskripsi' => 'Klasifikasi urusan SMK',
            ]
        );
    }

    private function buatSuratMasuk(array $attributes = []): SuratMasuk
    {
        static $counter = 800;
        $counter++;

        return SuratMasuk::create(array_merge([
            'nomor_agenda' => 'SM/2026/'.$counter,
            'nomor_surat' => '005/'.$counter.'/DISDIK/2026',
            'tanggal_surat' => '2026-09-25',
            'tanggal_terima' => '2026-09-26',
            'pengirim' => 'Instansi Pengirim '.$counter,
            'penerima' => 'SMKN 1 Subang',
            'perihal' => 'Perihal Surat Masuk '.$counter,
            'kategori_id' => $this->kategori->id,
            'file_path' => 'dokumen-surat-masuk/sample-'.$counter.'.pdf',
            'file_name' => 'sample-'.$counter.'.pdf',
            'file_size' => 102400,
            'status' => 'diterima',
            'user_id' => $this->admin->id,
        ], $attributes));
    }

    private function buatSuratKeluar(array $attributes = []): SuratKeluar
    {
        static $counter = 700;
        $counter++;

        return SuratKeluar::create(array_merge([
            'nomor_agenda' => 'SK/2026/'.$counter,
            'nomor_surat' => '421.5/'.$counter.'/SMK/2026',
            'tanggal_surat' => '2026-09-29',
            'tujuan' => 'Instansi Tujuan '.$counter,
            'perihal' => 'Perihal Surat Keluar '.$counter,
            'kategori_id' => $this->kategori->id,
            'file_path' => 'dokumen-surat-keluar/sample-'.$counter.'.pdf',
            'file_name' => 'sample-'.$counter.'.pdf',
            'file_size' => 102400,
            'status_persetujuan' => 'menunggu_persetujuan',
            'user_id' => $this->admin->id,
        ], $attributes));
    }

    // ==========================================
    // 1. PENGUJIAN OTORISASI & AKSES PERSURATAN
    // ==========================================

    public function test_tamu_tidak_dapat_mengakses_persetujuan_atau_disposisi(): void
    {
        $response1 = $this->get('/kepala-sekolah/persetujuan');
        $response1->assertRedirect('/login');

        $response2 = $this->get('/kepala-sekolah/disposisi');
        $response2->assertRedirect('/login');
    }

    public function test_admin_dan_pemohon_tidak_dapat_mengakses_halaman_persetujuan_kepsek(): void
    {
        $responseAdmin = $this->actingAs($this->admin)->get('/kepala-sekolah/persetujuan');
        $responseAdmin->assertRedirect(route('admin.dashboard'));
        $responseAdmin->assertSessionHas('error');

        $responsePemohon = $this->actingAs($this->pemohon)->get('/kepala-sekolah/persetujuan');
        $responsePemohon->assertRedirect(route('pemohon.dashboard'));
        $responsePemohon->assertSessionHas('error');
    }

    // ==========================================
    // 2. PENGUJIAN PERSURATAN SURAT KELUAR (SRS-KS05, SRS-KS07)
    // ==========================================

    public function test_kepala_sekolah_dapat_melihat_daftar_antrean_persetujuan_surat_keluar(): void
    {
        $suratKeluar = $this->buatSuratKeluar([
            'tujuan' => 'Dinas Pendidikan Jawa Barat',
            'perihal' => 'Pengajuan Persetujuan Uji Kompetensi Keahlian',
        ]);

        $response = $this->actingAs($this->kepsek)->get(route('kepsek.persetujuan.index'));

        $response->assertStatus(200);
        $response->assertSee('Persetujuan Surat Keluar');
        $response->assertSee($suratKeluar->nomor_agenda);
        $response->assertSee('Dinas Pendidikan Jawa Barat');
    }

    public function test_kepala_sekolah_dapat_memfilter_persetujuan_berdasarkan_status_dan_kata_kunci(): void
    {
        $sk1 = $this->buatSuratKeluar([
            'tujuan' => 'PT Astra Honda Motor',
            'status_persetujuan' => 'menunggu_persetujuan',
        ]);

        $sk2 = $this->buatSuratKeluar([
            'tujuan' => 'Kementerian Perindustrian',
            'status_persetujuan' => 'disetujui',
        ]);

        // Filter status menunggu_persetujuan
        $responseWaiting = $this->actingAs($this->kepsek)
            ->get(route('kepsek.persetujuan.index', ['status' => 'menunggu_persetujuan']));
        $responseWaiting->assertSee($sk1->nomor_agenda);
        $responseWaiting->assertDontSee($sk2->nomor_agenda);

        // Filter status disetujui
        $responseApproved = $this->actingAs($this->kepsek)
            ->get(route('kepsek.persetujuan.index', ['status' => 'disetujui']));
        $responseApproved->assertSee($sk2->nomor_agenda);
        $responseApproved->assertDontSee($sk1->nomor_agenda);

        // Search query q
        $responseSearch = $this->actingAs($this->kepsek)
            ->get(route('kepsek.persetujuan.index', ['status' => 'semua', 'q' => 'Astra']));
        $responseSearch->assertSee($sk1->nomor_agenda);
        $responseSearch->assertDontSee($sk2->nomor_agenda);
    }

    public function test_kepala_sekolah_dapat_melihat_detail_lembar_persetujuan_surat_keluar(): void
    {
        $suratKeluar = $this->buatSuratKeluar([
            'tujuan' => 'Pemerintah Kabupaten Subang',
            'perihal' => 'Permohonan Narasumber Sosialisasi Ketertiban Siswa',
        ]);

        $response = $this->actingAs($this->kepsek)
            ->get(route('kepsek.persetujuan.show', $suratKeluar));

        $response->assertStatus(200);
        $response->assertSee($suratKeluar->nomor_agenda);
        $response->assertSee('Permohonan Narasumber Sosialisasi Ketertiban Siswa');
        $response->assertSee('Setujui Surat Keluar');
        $response->assertSee('Tolak / Minta Revisi');
    }

    public function test_kepala_sekolah_dapat_menyetujui_surat_keluar(): void
    {
        $suratKeluar = $this->buatSuratKeluar([
            'tujuan' => 'Balai Besar Pengembangan Penjaminan Mutu',
            'perihal' => 'Undangan Rapat Sinkronisasi Kurikulum Berbasis Industri',
        ]);

        $response = $this->actingAs($this->kepsek)->post(route('kepsek.persetujuan.approve', $suratKeluar), [
            'catatan_kepsek' => 'Disetujui untuk segera dikirimkan ke Balai Besar.',
        ]);

        $response->assertRedirect(route('kepsek.persetujuan.show', $suratKeluar));
        $response->assertSessionHas('success');

        $suratKeluar->refresh();
        $this->assertEquals('disetujui', $suratKeluar->status_persetujuan);
        $this->assertEquals('Disetujui untuk segera dikirimkan ke Balai Besar.', $suratKeluar->catatan_kepsek);
        $this->assertEquals($this->kepsek->id, $suratKeluar->disetujui_oleh);
        $this->assertNotNull($suratKeluar->tanggal_disetujui);

        // Verifikasi audit trail log aktivitas
        $this->assertDatabaseHas('log_aktivitas', [
            'aksi' => 'SETUJUI_SURAT_KELUAR',
            'modul' => 'SURAT_KELUAR',
            'user_id' => $this->kepsek->id,
        ]);
    }

    public function test_kepala_sekolah_dapat_menolak_draf_surat_keluar_dengan_catatan_wajib(): void
    {
        $suratKeluar = $this->buatSuratKeluar([
            'tujuan' => 'Pimpinan Cabang Bank BJB Subang',
            'perihal' => 'Pengajuan Program Beasiswa Siswa Berprestasi',
        ]);

        // Coba tolak tanpa catatan -> harus gagal validasi
        $invalidResponse = $this->actingAs($this->kepsek)->post(route('kepsek.persetujuan.reject', $suratKeluar), [
            'catatan_kepsek' => '',
        ]);
        $invalidResponse->assertSessionHasErrors('catatan_kepsek');

        // Tolak dengan catatan revisi yang valid
        $response = $this->actingAs($this->kepsek)->post(route('kepsek.persetujuan.reject', $suratKeluar), [
            'catatan_kepsek' => 'Format nomor rekening komite sekolah mohon diperbarui ke cabang resmi.',
        ]);

        $response->assertRedirect(route('kepsek.persetujuan.show', $suratKeluar));
        $response->assertSessionHas('warning');

        $suratKeluar->refresh();
        $this->assertEquals('ditolak', $suratKeluar->status_persetujuan);
        $this->assertEquals('Format nomor rekening komite sekolah mohon diperbarui ke cabang resmi.', $suratKeluar->catatan_kepsek);
        $this->assertEquals($this->kepsek->id, $suratKeluar->disetujui_oleh);

        // Verifikasi log penolakan
        $this->assertDatabaseHas('log_aktivitas', [
            'aksi' => 'TOLAK_SURAT_KELUAR',
            'modul' => 'SURAT_KELUAR',
            'user_id' => $this->kepsek->id,
        ]);
    }

    // ==========================================
    // 3. PENGUJIAN DISPOSISI SURAT MASUK (SRS-KS06)
    // ==========================================

    public function test_kepala_sekolah_dapat_melihat_daftar_disposisi_surat_masuk(): void
    {
        $suratMasuk = $this->buatSuratMasuk([
            'pengirim' => 'Cabang Dinas Pendidikan Wilayah IV',
            'perihal' => 'Undangan Rapat Koordinasi Kepala Sekolah',
            'status' => 'didisposisikan',
        ]);

        DisposisiSuratMasuk::create([
            'surat_masuk_id' => $suratMasuk->id,
            'diberikan_oleh' => $this->kepsek->id,
            'tujuan_disposisi' => 'Waka Bidang Kurikulum',
            'instruksi' => 'Hadir mewakili Kepala Sekolah dan siapkan resume materi rapat.',
            'catatan' => 'Bawa surat tugas resmi.',
            'batas_waktu' => '2026-09-30',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->kepsek)->get(route('kepsek.disposisi.index'));

        $response->assertStatus(200);
        $response->assertSee('Disposisi Surat Masuk');
        $response->assertSee('Waka Bidang Kurikulum');
        $response->assertSee('Hadir mewakili Kepala Sekolah');
    }

    public function test_kepala_sekolah_dapat_mengakses_formulir_buat_disposisi(): void
    {
        $suratMasuk = $this->buatSuratMasuk([
            'pengirim' => 'Dinas Pendidikan Jawa Barat',
            'perihal' => 'Pemberitahuan Pelaksanaan Akreditasi Satuan Pendidikan',
            'status' => 'diterima',
        ]);

        $response = $this->actingAs($this->kepsek)
            ->get(route('kepsek.disposisi.create', ['surat_masuk_id' => $suratMasuk->id]));

        $response->assertStatus(200);
        $response->assertSee('Buat Lembar Disposisi Baru');
        $response->assertSee($suratMasuk->nomor_agenda);
        $response->assertSee($suratMasuk->pengirim);
    }

    public function test_kepala_sekolah_dapat_menerbitkan_lembar_disposisi_dan_mengubah_status_surat_masuk(): void
    {
        $suratMasuk = $this->buatSuratMasuk([
            'pengirim' => 'Kementerian Agama Kab. Subang',
            'perihal' => 'Penyelenggaraan Peringatan Maulid Nabi Tingkat Kabupaten',
            'status' => 'diterima',
        ]);

        $data = [
            'surat_masuk_id' => $suratMasuk->id,
            'tujuan_disposisi' => 'Pembina OSIS & Rohis',
            'instruksi' => 'Koordinasikan partisipasi delegasi siswa sekolah untuk menghadiri acara.',
            'catatan' => 'Dampingi oleh pembina pembimbing.',
            'batas_waktu' => '2026-10-05',
        ];

        $response = $this->actingAs($this->kepsek)->post(route('kepsek.disposisi.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verifikasi tabel disposisi_surat_masuk
        $this->assertDatabaseHas('disposisi_surat_masuk', [
            'surat_masuk_id' => $suratMasuk->id,
            'diberikan_oleh' => $this->kepsek->id,
            'tujuan_disposisi' => 'Pembina OSIS & Rohis',
            'status' => 'menunggu',
        ]);

        // Verifikasi status surat masuk berubah menjadi 'didisposisikan'
        $suratMasuk->refresh();
        $this->assertEquals('didisposisikan', $suratMasuk->status);

        // Verifikasi audit trail log
        $this->assertDatabaseHas('log_aktivitas', [
            'aksi' => 'BUAT_DISPOSISI',
            'modul' => 'DISPOSISI',
            'user_id' => $this->kepsek->id,
        ]);
    }

    public function test_kepala_sekolah_dapat_mengubah_data_lembar_disposisi(): void
    {
        $suratMasuk = $this->buatSuratMasuk([
            'pengirim' => 'Disdikpora Subang',
            'perihal' => 'Sosialisasi Bantuan Operasional Sekolah (BOS)',
            'status' => 'didisposisikan',
        ]);

        $disposisi = DisposisiSuratMasuk::create([
            'surat_masuk_id' => $suratMasuk->id,
            'diberikan_oleh' => $this->kepsek->id,
            'tujuan_disposisi' => 'Bendahara Sekolah',
            'instruksi' => 'Pelajari petunjuk teknis pelaporan BOS.',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->kepsek)->put(route('kepsek.disposisi.update', $disposisi), [
            'tujuan_disposisi' => 'Bendahara Sekolah & KTU',
            'instruksi' => 'Pelajari petunjuk teknis dan siapkan laporan SPJ triwulan.',
            'catatan' => 'Selesaikan sebelum audit internal.',
            'status' => 'ditindaklanjuti',
        ]);

        $response->assertRedirect(route('kepsek.disposisi.show', $disposisi));
        $response->assertSessionHas('success');

        $disposisi->refresh();
        $this->assertEquals('Bendahara Sekolah & KTU', $disposisi->tujuan_disposisi);
        $this->assertEquals('ditindaklanjuti', $disposisi->status);
    }

    public function test_kepala_sekolah_dan_admin_dapat_memperbarui_status_tindak_lanjut_disposisi(): void
    {
        $suratMasuk = $this->buatSuratMasuk([
            'pengirim' => 'Polres Subang',
            'perihal' => 'Penyuluhan Tertib Berlalu Lintas Pelajar',
            'status' => 'didisposisikan',
        ]);

        $disposisi = DisposisiSuratMasuk::create([
            'surat_masuk_id' => $suratMasuk->id,
            'diberikan_oleh' => $this->kepsek->id,
            'tujuan_disposisi' => 'Waka Bidang Kesiswaan',
            'instruksi' => 'Siapkan tempat di aula dan hadirkan pengurus OSIS.',
            'status' => 'menunggu',
        ]);

        // Admin update status to ditindaklanjuti
        $responseAdmin = $this->actingAs($this->admin)->patch(route('admin.disposisi.status', $disposisi), [
            'status' => 'ditindaklanjuti',
        ]);
        $responseAdmin->assertSessionHas('success');

        $disposisi->refresh();
        $this->assertEquals('ditindaklanjuti', $disposisi->status);

        // Kepsek update status to selesai
        $responseKepsek = $this->actingAs($this->kepsek)->patch(route('kepsek.disposisi.status', $disposisi), [
            'status' => 'selesai',
        ]);
        $responseKepsek->assertSessionHas('success');

        $disposisi->refresh();
        $this->assertEquals('selesai', $disposisi->status);
    }

    public function test_halaman_cetak_lembar_disposisi_dapat_diakses_dan_memiliki_kop_resmi_sekolah(): void
    {
        $suratMasuk = $this->buatSuratMasuk([
            'pengirim' => 'Kwartir Cabang Gerakan Pramuka Subang',
            'perihal' => 'Undangan Raimuna Cabang Tingkat Penegak',
            'status' => 'didisposisikan',
        ]);

        $disposisi = DisposisiSuratMasuk::create([
            'surat_masuk_id' => $suratMasuk->id,
            'diberikan_oleh' => $this->kepsek->id,
            'tujuan_disposisi' => 'Pembina Pramuka',
            'instruksi' => 'Kirim 1 sangga putra dan 1 sangga putri untuk berpartisipasi aktif.',
            'status' => 'menunggu',
        ]);

        // Kepala sekolah cetak disposisi
        $responseKepsek = $this->actingAs($this->kepsek)->get(route('kepsek.disposisi.cetak', $disposisi));
        $responseKepsek->assertStatus(200);
        $responseKepsek->assertSee('SMK Negeri 1 Subang');
        $responseKepsek->assertSee('Lembar Disposisi Kepala Sekolah');
        $responseKepsek->assertSee($suratMasuk->nomor_agenda);
        $responseKepsek->assertSee('Pembina Pramuka');

        // Admin juga dapat mencetak lembar disposisi
        $responseAdmin = $this->actingAs($this->admin)->get(route('admin.disposisi.cetak', $disposisi));
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('Lembar Disposisi Kepala Sekolah');
    }

    public function test_penghapusan_disposisi_mengembalikan_status_surat_masuk_jika_tidak_ada_disposisi_lain(): void
    {
        $suratMasuk = $this->buatSuratMasuk([
            'pengirim' => 'DPRD Kabupaten Subang',
            'perihal' => 'Undangan Dengar Pendapat Pendidikan Vokasi',
            'status' => 'didisposisikan',
        ]);

        $disposisi = DisposisiSuratMasuk::create([
            'surat_masuk_id' => $suratMasuk->id,
            'diberikan_oleh' => $this->kepsek->id,
            'tujuan_disposisi' => 'Waka Bidang Hubinmas',
            'instruksi' => 'Siapkan data penyerapan lulusan SMK di industri daerah.',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->kepsek)->delete(route('kepsek.disposisi.destroy', $disposisi));

        $response->assertRedirect(route('kepsek.disposisi.index'));
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('disposisi_surat_masuk', [
            'id' => $disposisi->id,
        ]);

        // Status surat masuk harus kembali menjadi 'diterima'
        $suratMasuk->refresh();
        $this->assertEquals('diterima', $suratMasuk->status);
    }
}
