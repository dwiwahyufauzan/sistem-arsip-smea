<?php

namespace Tests\Feature;

use App\Models\KategoriSurat;
use App\Models\PengajuanLegalisir;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PencarianKmpTest extends TestCase
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
            ['email' => 'alumni.kmp@test.com'],
            [
                'name' => 'Alumni KMP',
                'password' => bcrypt('password'),
                'role' => 'pemohon',
                'nip_nisn' => '0098765432',
            ]
        );

        $this->kategori = KategoriSurat::firstOrCreate(
            ['kode_kategori' => '421.5'],
            [
                'nama_kategori' => 'Sekolah Menengah Kejuruan',
                'uraian' => 'Klasifikasi persuratan SMK',
            ]
        );
    }

    private function createSampleRecordsForKeyword(string $keyword): void
    {
        // 1. Surat Masuk
        SuratMasuk::create([
            'nomor_agenda' => 'AGD-'.rand(1000, 9999),
            'nomor_surat' => '005/SMK/'.$keyword.'/2026',
            'pengirim' => 'Dinas Pendidikan Jabar',
            'perihal' => "Pelaksanaan Program {$keyword} SMK PK",
            'tanggal_surat' => now()->subDays(2)->toDateString(),
            'tanggal_terima' => now()->toDateString(),
            'kategori_id' => $this->kategori->id,
            'ringkasan_isi' => "Dokumen panduan teknis program {$keyword} nasional.",
            'file_path' => 'surat-masuk/dummy.pdf',
            'file_name' => 'dummy.pdf',
            'file_size' => 1024,
            'status' => 'diterima',
            'user_id' => $this->admin->id,
        ]);

        // 2. Surat Keluar
        SuratKeluar::create([
            'nomor_agenda' => 'AGD-OUT-'.rand(1000, 9999),
            'nomor_surat' => '421.5/120/'.$keyword.'/2026',
            'tujuan' => "Balai Besar Penjaminan Mutu {$keyword}",
            'perihal' => "Laporan Pertanggungjawaban Hibah {$keyword}",
            'tanggal_surat' => now()->toDateString(),
            'kategori_id' => $this->kategori->id,
            'isi_ringkas' => "Laporan realisasi sarana prasarana {$keyword} SMKN 1 Subang.",
            'file_path' => 'surat-keluar/dummy.pdf',
            'file_name' => 'dummy.pdf',
            'file_size' => 1024,
            'status_persetujuan' => 'disetujui',
            'user_id' => $this->admin->id,
        ]);

        // 3. Legalisir
        PengajuanLegalisir::create([
            'nomor_pengajuan' => 'LEG-'.date('Ym').'-'.rand(1000, 9999),
            'user_id' => $this->pemohon->id,
            'nama_pemohon' => "Budi {$keyword}",
            'nisn' => '0098765432',
            'tahun_lulus' => '2023',
            'nomor_whatsapp' => '081234567899',
            'email' => 'alumni.kmp@test.com',
            'jenis_dokumen' => 'ijazah',
            'jumlah_lembar' => 4,
            'keperluan' => "Persyaratan beasiswa percepatan karir {$keyword}",
            'file_dokumen_path' => 'dokumen-legalisir/dummy.pdf',
            'status' => 'menunggu_verifikasi',
        ]);
    }

    public function test_admin_can_access_pencarian_kmp_page_without_query(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pencarian-kmp'));

        $response->assertStatus(200);
        $response->assertSee('Pencarian Cerdas Terpadu Seluruh Arsip SMEA');
        $response->assertSee('Tanpa Backtracking');
        $response->assertSee('Simultan Lintas Modul');
    }

    public function test_kepsek_can_access_pencarian_kmp_page(): void
    {
        $response = $this->actingAs($this->kepsek)->get(route('kepsek.pencarian-kmp'));

        $response->assertStatus(200);
        $response->assertSee('Penelusuran Presisi Seluruh Dokumen Sekolah');
        $response->assertSee('Pencarian Cepat Kearsipan Pimpinan');
    }

    public function test_admin_can_search_with_kmp_and_get_results_across_all_modules(): void
    {
        $keyword = 'REVITALISASI';
        $this->createSampleRecordsForKeyword($keyword);

        $response = $this->actingAs($this->admin)->get(route('admin.pencarian-kmp', ['q' => $keyword]));

        $response->assertStatus(200);
        $response->assertSee('Metrik Pencarian Algoritma KMP');
        $response->assertSee('Lihat Tabel Pergeseran LPS');
        $response->assertSee('Arsip Surat Masuk');
        $response->assertSee('Arsip Surat Keluar');
        $response->assertSee('Permohonan Legalisir Online');
        $response->assertSee('<mark', false); // Verify highlighting tag presence
    }

    public function test_admin_can_filter_search_by_specific_module(): void
    {
        $keyword = 'TRANSFORMASI';
        $this->createSampleRecordsForKeyword($keyword);

        // Filter hanya Surat Masuk
        $responseMasuk = $this->actingAs($this->admin)->get(route('admin.pencarian-kmp', [
            'q' => $keyword,
            'modul' => 'surat_masuk',
        ]));

        $responseMasuk->assertStatus(200);
        $responseMasuk->assertSee('Arsip Surat Masuk');
        $responseMasuk->assertDontSee('Arsip Surat Keluar');
        $responseMasuk->assertDontSee('Permohonan Legalisir Online');

        // Filter hanya Surat Keluar
        $responseKeluar = $this->actingAs($this->admin)->get(route('admin.pencarian-kmp', [
            'q' => $keyword,
            'modul' => 'surat_keluar',
        ]));

        $responseKeluar->assertStatus(200);
        $responseKeluar->assertDontSee('Arsip Surat Masuk');
        $responseKeluar->assertSee('Arsip Surat Keluar');

        // Filter hanya Legalisir
        $responseLegalisir = $this->actingAs($this->admin)->get(route('admin.pencarian-kmp', [
            'q' => $keyword,
            'modul' => 'legalisir',
        ]));

        $responseLegalisir->assertStatus(200);
        $responseLegalisir->assertDontSee('Arsip Surat Masuk');
        $responseLegalisir->assertDontSee('Arsip Surat Keluar');
        $responseLegalisir->assertSee('Permohonan Legalisir Online');
    }

    public function test_scientific_benchmark_mode_generates_comparison_metrics(): void
    {
        $keyword = 'KOMPETENSI';
        $this->createSampleRecordsForKeyword($keyword);

        $response = $this->actingAs($this->admin)->get(route('admin.pencarian-kmp', [
            'q' => $keyword,
            'compare' => 1,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Hasil Pengujian Benchmark Komparasi Kuantitatif');
        $response->assertSee('Algoritma KMP (Usulan)');
        $response->assertSee('Algoritma Naïve / Brute Force');
        $response->assertSee('Efisiensi Kecepatan:');
    }

    public function test_live_search_api_returns_json_results(): void
    {
        $keyword = 'AKREDITASI';
        $this->createSampleRecordsForKeyword($keyword);

        $response = $this->actingAs($this->admin)->getJson(route('api.pencarian-kmp.live', ['q' => $keyword]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'results',
            'total',
            'time_ms',
        ]);
        $this->assertGreaterThan(0, $response->json('total'));
    }

    public function test_role_access_security_for_pencarian_kmp(): void
    {
        // Tamu tidak diizinkan
        $responseGuest = $this->get(route('admin.pencarian-kmp'));
        $responseGuest->assertRedirect(route('login'));

        // Pemohon dialihkan saat akses panel admin
        $responsePemohonToAdmin = $this->actingAs($this->pemohon)->get(route('admin.pencarian-kmp'));
        $responsePemohonToAdmin->assertRedirect(route('pemohon.dashboard'));
        $responsePemohonToAdmin->assertSessionHas('error');

        // Pemohon dialihkan saat akses panel kepsek
        $responsePemohonToKepsek = $this->actingAs($this->pemohon)->get(route('kepsek.pencarian-kmp'));
        $responsePemohonToKepsek->assertRedirect(route('pemohon.dashboard'));
        $responsePemohonToKepsek->assertSessionHas('error');
    }
}
