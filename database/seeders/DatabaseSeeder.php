<?php

namespace Database\Seeders;

use App\Models\DisposisiSuratMasuk;
use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\PengajuanLegalisir;
use App\Models\RiwayatLegalisir;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengguna 3 Role
        $admin = User::firstOrCreate(
            ['email' => 'petugas@smkn1subang.sch.id'],
            [
                'name' => 'Petugas Arsip SMKN 1 Subang',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nip_nisn' => '19850412 201001 1 008',
                'phone_number' => '081234567890',
            ]
        );

        $kepsek = User::firstOrCreate(
            ['email' => 'kepsek@smkn1subang.sch.id'],
            [
                'name' => 'Deden Suryanto, M.Pd.',
                'password' => Hash::make('password'),
                'role' => 'kepala_sekolah',
                'nip_nisn' => '19720815 199802 1 003',
                'phone_number' => '081298765432',
            ]
        );

        $pemohon = User::firstOrCreate(
            ['email' => 'alumni@smkn1subang.sch.id'],
            [
                'name' => 'Ridwan Kurniawan',
                'password' => Hash::make('password'),
                'role' => 'pemohon',
                'tipe_pemohon' => 'alumni',
                'nip_nisn' => '0045892134',
                'phone_number' => '085712345678',
            ]
        );
        $pemohon->update(['tipe_pemohon' => 'alumni']);

        // 2. Kategori Surat Klasifikasi Dinas SMKN 1 Subang
        $kategoriList = [
            [
                'kode_kategori' => '421.5/KUR',
                'nama_kategori' => 'Kurikulum & Pembelajaran',
                'deskripsi' => 'Pengelolaan silabus, kurikulum merdeka, uji kompetensi keahlian, dan asesmen',
            ],
            [
                'kode_kategori' => '421.5/KSW',
                'nama_kategori' => 'Kesiswaan & Ekstrakurikuler',
                'deskripsi' => 'Data kesiswaan, beasiswa, kedisiplinan, OSIS, dan kegiatan ekstrakurikuler',
            ],
            [
                'kode_kategori' => '421.5/HUMAS',
                'nama_kategori' => 'Hubungan Industri & Kerjasama',
                'deskripsi' => 'Kemitraan dunia usaha/industri (DUDI), PKL/Prakerin, dan Bursa Kerja Khusus',
            ],
            [
                'kode_kategori' => '421.5/SARPRAS',
                'nama_kategori' => 'Sarana & Prasarana',
                'deskripsi' => 'Inventaris gedung, bengkel kejuruan, laboratorium komputer, dan pemeliharaan alat',
            ],
            [
                'kode_kategori' => '421.5/TU',
                'nama_kategori' => 'Tata Usaha & Kepegawaian',
                'deskripsi' => 'Surat tugas, kepegawaian guru/staf, kenaikan pangkat, dan administrasi umum',
            ],
            [
                'kode_kategori' => '421.5/DISDIK',
                'nama_kategori' => 'Dinas Pendidikan & Pemprov',
                'deskripsi' => 'Surat edaran, petunjuk teknis, dan koordinasi dengan Cabang Dinas Wilayah IV',
            ],
        ];

        $kategoriModels = [];
        foreach ($kategoriList as $kat) {
            $kategoriModels[$kat['kode_kategori']] = KategoriSurat::firstOrCreate(
                ['kode_kategori' => $kat['kode_kategori']],
                $kat
            );
        }

        // 3. Sampel Surat Masuk
        $sm1 = SuratMasuk::firstOrCreate(
            ['nomor_agenda' => 'SM/2026/001'],
            [
                'nomor_surat' => '005/1420/Cadisdik.Wil.IV/2026',
                'tanggal_surat' => '2026-09-10',
                'tanggal_terima' => '2026-09-12',
                'pengirim' => 'Cabang Dinas Pendidikan Wilayah IV',
                'penerima' => 'Kepala SMKN 1 Subang',
                'perihal' => 'Undangan Rapat Koordinasi Pelaksanaan Uji Kompetensi Keahlian (UKK) Tahun 2026',
                'isi_ringkas' => 'Rapat persiapan pelaksanaan UKK bersama seluruh SMK Negeri dan Swasta se-Kabupaten Subang.',
                'kategori_id' => $kategoriModels['421.5/KUR']->id,
                'file_path' => 'dokumen-surat-masuk/sample-undangan-ukk.pdf',
                'file_name' => 'sample-undangan-ukk.pdf',
                'file_size' => 245760, // 240 KB
                'status' => 'didisposisikan',
                'user_id' => $admin->id,
            ]
        );

        SuratMasuk::firstOrCreate(
            ['nomor_agenda' => 'SM/2026/002'],
            [
                'nomor_surat' => 'B/412/PINDAD/IX/2026',
                'tanggal_surat' => '2026-09-15',
                'tanggal_terima' => '2026-09-16',
                'pengirim' => 'PT. Pindad (Persero)',
                'penerima' => 'Kepala SMKN 1 Subang',
                'perihal' => 'Konfirmasi Penerimaan Siswa Praktik Kerja Lapangan (PKL) Periode Oktober - Desember 2026',
                'isi_ringkas' => 'Penerimaan 15 siswa konsentrasi keahlian Teknik Pemesinan dan Sistem Informasi Jaringan.',
                'kategori_id' => $kategoriModels['421.5/HUMAS']->id,
                'file_path' => 'dokumen-surat-masuk/sample-konfirmasi-pkl.pdf',
                'file_name' => 'sample-konfirmasi-pkl.pdf',
                'file_size' => 312000,
                'status' => 'diterima',
                'user_id' => $admin->id,
            ]
        );

        SuratMasuk::firstOrCreate(
            ['nomor_agenda' => 'SM/2026/003'],
            [
                'nomor_surat' => '1829/A.A1/PR/2026',
                'tanggal_surat' => '2026-09-18',
                'tanggal_terima' => '2026-09-20',
                'pengirim' => 'Kementerian Pendidikan Dasar dan Menengah',
                'penerima' => 'Kepala SMKN 1 Subang',
                'perihal' => 'Bantuan Hibah Revitalisasi Laboratorium Komputer dan Jaringan SMK Pusat Keunggulan',
                'isi_ringkas' => 'Pemberitahuan verifikasi proposal bantuan hibah peralatan laboratorium jaringan komputer.',
                'kategori_id' => $kategoriModels['421.5/SARPRAS']->id,
                'file_path' => 'dokumen-surat-masuk/sample-bantuan-sarpras.pdf',
                'file_name' => 'sample-bantuan-sarpras.pdf',
                'file_size' => 524288,
                'status' => 'diarsipkan',
                'user_id' => $admin->id,
            ]
        );

        // 4. Sampel Disposisi Surat Masuk
        DisposisiSuratMasuk::firstOrCreate(
            ['surat_masuk_id' => $sm1->id, 'tujuan_disposisi' => 'Wakasek Bidang Kurikulum'],
            [
                'diberikan_oleh' => $kepsek->id,
                'instruksi' => 'Tindak lanjuti dan hadirkan perwakilan tim penguji kejuruan pada rapat koordinasi.',
                'catatan' => 'Siapkan rekapitulasi data calon peserta UKK dari seluruh program keahlian.',
                'batas_waktu' => '2026-09-25',
                'status' => 'ditindaklanjuti',
            ]
        );

        // 5. Sampel Surat Keluar
        SuratKeluar::firstOrCreate(
            ['nomor_agenda' => 'SK/2026/001'],
            [
                'nomor_surat' => '421.5/089-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-21',
                'tujuan' => 'Kepala Dinas Pendidikan Provinsi Jawa Barat',
                'perihal' => 'Permohonan Pengesahan Kurikulum Merdeka Konsentrasi Keahlian SIJA dan Rekayasa Perangkat Lunak',
                'isi_ringkas' => 'Pengajuan buku kurikulum operasional satuan pendidikan (KOSP) tahun ajaran berjalan.',
                'kategori_id' => $kategoriModels['421.5/KUR']->id,
                'file_path' => 'dokumen-surat-keluar/sample-pengesahan-kurikulum.pdf',
                'file_name' => 'sample-pengesahan-kurikulum.pdf',
                'file_size' => 450000,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Berkas lengkap dan sesuai standar kurikulum vokasi.',
                'disetujui_oleh' => $kepsek->id,
                'tanggal_disetujui' => '2026-09-22 09:30:00',
                'user_id' => $admin->id,
            ]
        );

        SuratKeluar::firstOrCreate(
            ['nomor_agenda' => 'SK/2026/002'],
            [
                'nomor_surat' => '421.5/095-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-25',
                'tujuan' => 'Orang Tua / Wali Siswa Kelas XII Semua Jurusan',
                'perihal' => 'Pemberitahuan Sosialisasi Bimbingan Karir dan Penjajakan Rekrutmen Bursa Kerja Khusus (BKK)',
                'isi_ringkas' => 'Undangan pertemuan daring orang tua siswa mengenai prospek kerja industri mitra sekolah.',
                'kategori_id' => $kategoriModels['421.5/HUMAS']->id,
                'file_path' => 'dokumen-surat-keluar/sample-sosialisasi-bkk.pdf',
                'file_name' => 'sample-sosialisasi-bkk.pdf',
                'file_size' => 198000,
                'status_persetujuan' => 'menunggu_persetujuan',
                'catatan_kepsek' => null,
                'disetujui_oleh' => null,
                'tanggal_disetujui' => null,
                'user_id' => $admin->id,
            ]
        );

        // 6. Sampel Pengajuan Legalisir Online
        $leg1 = PengajuanLegalisir::firstOrCreate(
            ['nomor_pengajuan' => 'LEG-202609-0001'],
            [
                'user_id' => $pemohon->id,
                'nama_pemohon' => 'Ridwan Kurniawan',
                'nisn' => '0045892134',
                'tahun_lulus' => '2023',
                'nomor_whatsapp' => '085712345678',
                'email' => 'alumni@smkn1subang.sch.id',
                'jenis_dokumen' => 'ijazah',
                'jumlah_lembar' => 5,
                'keperluan' => 'Kelengkapan Dokumen Rekrutmen Calon Tenaga Ahli IT PT. Dahana',
                'file_dokumen_path' => 'dokumen-legalisir/sample-scan-ijazah.pdf',
                'status' => 'sedang_diproses',
                'catatan_petugas' => 'Berkas scan ijazah asli jelas dan data sesuai dengan buku induk kelulusan 2023.',
                'catatan_kepsek' => 'Disetujui untuk pengesahan legalisir.',
                'tanggal_siap_ambil' => '2026-09-30',
                'petugas_id' => $admin->id,
            ]
        );

        PengajuanLegalisir::firstOrCreate(
            ['nomor_pengajuan' => 'LEG-202609-0002'],
            [
                'user_id' => null,
                'nama_pemohon' => 'Siti Nurhaliza',
                'nisn' => '0051287634',
                'tahun_lulus' => '2024',
                'nomor_whatsapp' => '087812984567',
                'email' => 'siti.nurhaliza@gmail.com',
                'jenis_dokumen' => 'transkrip_nilai',
                'jumlah_lembar' => 3,
                'keperluan' => 'Persyaratan Pendaftaran Seleksi Calon Pegawai Negeri Sipil (CPNS)',
                'file_dokumen_path' => 'dokumen-legalisir/sample-scan-transkrip.pdf',
                'status' => 'menunggu_verifikasi',
                'catatan_petugas' => null,
                'catatan_kepsek' => null,
                'tanggal_siap_ambil' => null,
                'petugas_id' => null,
            ]
        );

        // 7. Sampel Riwayat Audit Legalisir
        RiwayatLegalisir::firstOrCreate(
            ['pengajuan_legalisir_id' => $leg1->id, 'status_baru' => 'diverifikasi'],
            [
                'status_sebelumnya' => 'menunggu_verifikasi',
                'diubah_oleh' => $admin->id,
                'catatan' => 'Verifikasi nomor seri ijazah dan nilai rapor pada buku induk sekolah telah valid.',
                'created_at' => now()->subDays(2),
            ]
        );

        RiwayatLegalisir::firstOrCreate(
            ['pengajuan_legalisir_id' => $leg1->id, 'status_baru' => 'disetujui_kepsek'],
            [
                'status_sebelumnya' => 'diverifikasi',
                'diubah_oleh' => $kepsek->id,
                'catatan' => 'Persetujuan pengesahan legalisir disahkan oleh Kepala Sekolah.',
                'created_at' => now()->subDay(),
            ]
        );

        RiwayatLegalisir::firstOrCreate(
            ['pengajuan_legalisir_id' => $leg1->id, 'status_baru' => 'sedang_diproses'],
            [
                'status_sebelumnya' => 'disetujui_kepsek',
                'diubah_oleh' => $admin->id,
                'catatan' => 'Sedang dilakukan pencetakan stempel basah dan pengarsipan salinan berkas.',
                'created_at' => now(),
            ]
        );

        // 8. Log Aktivitas Awal
        LogAktivitas::create([
            'user_id' => $admin->id,
            'aksi' => 'SEEDING',
            'modul' => 'SISTEM',
            'deskripsi' => 'Inisialisasi sistem informasi pengelolaan arsip SMKN 1 Subang berhasil dieksekusi.',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Console Seeder',
            'created_at' => now(),
        ]);

        // 9. Data Dummy Kearsipan Tambahan (~100+ Surat Masuk & Keluar, Siswa & Alumni)
        $this->call(DummyArsipSeeder::class);
    }
}
