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

class DummyArsipSeeder extends Seeder
{
    /**
     * Jalankan penambahan data dummy kearsipan SMKN 1 Subang (~100+ surat, siswa & alumni).
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kepsek = User::where('role', 'kepala_sekolah')->first();

        if (! $admin || ! $kepsek) {
            return;
        }

        // 1. Data Dummy Akun Siswa & Alumni SMKN 1 Subang (Role: pemohon)
        $siswaAlumniData = [
            [
                'name' => 'Ahmad Fauzi Rahman',
                'email' => 'ahmad.fauzi@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0051287901',
                'phone_number' => '081234567801',
            ],
            [
                'name' => 'Dewi Sartika Kusuma',
                'email' => 'dewi.sartika@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0048921043',
                'phone_number' => '085712345602',
            ],
            [
                'name' => 'Muhammad Rizky Pratama',
                'email' => 'rizky.pratama@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0053412987',
                'phone_number' => '087812345603',
            ],
            [
                'name' => 'Siti Nurhaliza Putri',
                'email' => 'siti.nurhaliza@siswa.smkn1subang.sch.id',
                'nip_nisn' => '0061298450',
                'phone_number' => '089612345604',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0039871234',
                'phone_number' => '081312345605',
            ],
            [
                'name' => 'Anisa Rahmawati',
                'email' => 'anisa.rahma@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0045612389',
                'phone_number' => '082112345606',
            ],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'fajar.ramadhan@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0056789123',
                'phone_number' => '085212345607',
            ],
            [
                'name' => 'Tri Wahyuni',
                'email' => 'tri.wahyuni@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0041238945',
                'phone_number' => '087712345608',
            ],
            [
                'name' => 'Rifki Anugrah Setiawan',
                'email' => 'rifki.anugrah@siswa.smkn1subang.sch.id',
                'nip_nisn' => '0062345678',
                'phone_number' => '089512345609',
            ],
            [
                'name' => 'Maya Anggraeni',
                'email' => 'maya.anggraeni@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0038901245',
                'phone_number' => '081298765410',
            ],
            [
                'name' => 'Dika Firmansyah',
                'email' => 'dika.firmansyah@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0057890123',
                'phone_number' => '085698765411',
            ],
            [
                'name' => 'Nanda Aulia Salsabila',
                'email' => 'nanda.aulia@siswa.smkn1subang.sch.id',
                'nip_nisn' => '0068901234',
                'phone_number' => '087898765412',
            ],
            [
                'name' => 'Dimas Bagus Saputra',
                'email' => 'dimas.bagus@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0049012345',
                'phone_number' => '081398765413',
            ],
            [
                'name' => 'Riska Nur Fatimah',
                'email' => 'riska.fatimah@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0050123456',
                'phone_number' => '082298765414',
            ],
            [
                'name' => 'Gilang Ramadhan Putra',
                'email' => 'gilang.putra@siswa.smkn1subang.sch.id',
                'nip_nisn' => '0061234567',
                'phone_number' => '085398765415',
            ],
            [
                'name' => 'Winda Lestari',
                'email' => 'winda.lestari@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0042345678',
                'phone_number' => '087798765416',
            ],
            [
                'name' => 'Hendra Gunawan',
                'email' => 'hendra.gunawan@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0033456789',
                'phone_number' => '089698765417',
            ],
            [
                'name' => 'Putri Ayu Handayani',
                'email' => 'putri.handayani@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0054567890',
                'phone_number' => '081287654318',
            ],
            [
                'name' => 'Yoga Pratama Wijaya',
                'email' => 'yoga.pratama@siswa.smkn1subang.sch.id',
                'nip_nisn' => '0065678901',
                'phone_number' => '085787654319',
            ],
            [
                'name' => 'Zahra Amelia Sukma',
                'email' => 'zahra.amelia@alumni.smkn1subang.sch.id',
                'nip_nisn' => '0046789012',
                'phone_number' => '087887654320',
            ],
        ];

        $pemohonUsers = [];
        foreach ($siswaAlumniData as $userData) {
            $tipe = str_contains($userData['email'], '@siswa.') ? 'siswa_aktif' : 'alumni';
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'pemohon',
                    'tipe_pemohon' => $tipe,
                    'nip_nisn' => $userData['nip_nisn'],
                    'phone_number' => $userData['phone_number'],
                ]
            );
            $user->update(['tipe_pemohon' => $tipe]);
            $pemohonUsers[] = $user;
        }

        // Ambil mapping Kategori
        $kategoriKur = KategoriSurat::where('kode_kategori', '421.5/KUR')->first();
        $kategoriKsw = KategoriSurat::where('kode_kategori', '421.5/KSW')->first();
        $kategoriHum = KategoriSurat::where('kode_kategori', '421.5/HUMAS')->first();
        $kategoriSar = KategoriSurat::where('kode_kategori', '421.5/SARPRAS')->first();
        $kategoriTu = KategoriSurat::where('kode_kategori', '421.5/TU')->first();
        $kategoriDis = KategoriSurat::where('kode_kategori', '421.5/DISDIK')->first();

        // Fallback jika id tidak ditemukan
        $kurId = $kategoriKur?->id ?? 1;
        $kswId = $kategoriKsw?->id ?? 2;
        $humId = $kategoriHum?->id ?? 3;
        $sarId = $kategoriSar?->id ?? 4;
        $tuId = $kategoriTu?->id ?? 5;
        $disId = $kategoriDis?->id ?? 6;

        // 2. Data Dummy Surat Masuk (~57 surat baru, total 60)
        $suratMasukList = [
            // Cadisdik & Disdik
            [
                'nomor_surat' => '421/1890/Cadisdik.Wil.IV/2026',
                'tanggal_surat' => '2026-09-02',
                'tanggal_terima' => '2026-09-04',
                'pengirim' => 'Cabang Dinas Pendidikan Wilayah IV',
                'perihal' => 'Sosialisasi Kebijakan Kurikulum Merdeka Terintegrasi Industri SMK Jawa Barat 2026',
                'isi_ringkas' => 'Pemberitahuan sosialisasi penyesuaian kurikulum merdeka SMK Pusat Keunggulan tingkat Cabang Dinas Wilayah IV.',
                'kategori_id' => $kurId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '800/2105/Disdikbud.Subang/2026',
                'tanggal_surat' => '2026-09-03',
                'tanggal_terima' => '2026-09-05',
                'pengirim' => 'Dinas Pendidikan dan Kebudayaan Kab. Subang',
                'perihal' => 'Undangan Rapat Koordinasi Penerimaan Siswa Baru Jalur Prestasi dan Afirmasi',
                'isi_ringkas' => 'Koordinasi evaluasi daya tampung dan teknis jalur prestasi kesiswaan jenjang kejuruan se-Kabupaten Subang.',
                'kategori_id' => $kswId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '024/Cadisdik.IV/SAR/2026',
                'tanggal_surat' => '2026-09-05',
                'tanggal_terima' => '2026-09-07',
                'pengirim' => 'Cabang Dinas Pendidikan Wilayah IV',
                'perihal' => 'Pemberitahuan Verifikasi Lapangan Bantuan Sarana Laboratorium Komputer dan Jaringan',
                'isi_ringkas' => 'Jadwal monitoring fisik sarana ruang praktik kejuruan SIJA dan bengkel otomotif SMKN 1 Subang.',
                'kategori_id' => $sarId,
                'status' => 'diarsipkan',
            ],
            [
                'nomor_surat' => '420/3142/Disdik.Jabar/2026',
                'tanggal_surat' => '2026-09-08',
                'tanggal_terima' => '2026-09-10',
                'pengirim' => 'Dinas Pendidikan Provinsi Jawa Barat',
                'perihal' => 'Petunjuk Teknis Pelaksanaan Lomba Kompetensi Siswa (LKS) SMK Tingkat Provinsi Jawa Barat',
                'isi_ringkas' => 'Pedoman operasional LKS bidang Cyber Security, Web Technologies, dan Mechanical Engineering CAD.',
                'kategori_id' => $kswId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '102/Cadisdik-IV/SET/2026',
                'tanggal_surat' => '2026-09-11',
                'tanggal_terima' => '2026-09-13',
                'pengirim' => 'Cabang Dinas Pendidikan Wilayah IV',
                'perihal' => 'Surat Edaran Pembinaan Disiplin Pegawai dan Pengelolaan Arsip Tata Usaha Sekolah',
                'isi_ringkas' => 'Edaran standar operasional tata kelola arsip dinas persuratan dan berkas kepegawaian ASN/Non-ASN sekolah.',
                'kategori_id' => $tuId,
                'status' => 'diarsipkan',
            ],

            // Industri / DUDI (Mitra Strategis SMEA Subang)
            [
                'nomor_surat' => 'DHN/DIR-SDM/412/2026',
                'tanggal_surat' => '2026-09-12',
                'tanggal_terima' => '2026-09-14',
                'pengirim' => 'PT. Dahana (Persero) Subang',
                'perihal' => 'Pemberitahuan Kuota Program Praktik Kerja Lapangan (PKL / Prakerin) Industri Bahan Peledak 2026/2027',
                'isi_ringkas' => 'Penerimaan 20 siswa kejuruan Teknik Pemesinan dan Rekayasa Perangkat Lunak untuk magang industri di Kawasan Energetic Material Center Subang.',
                'kategori_id' => $humId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'DIR-PND/BKK/IX/2026',
                'tanggal_surat' => '2026-09-14',
                'tanggal_terima' => '2026-09-16',
                'pengirim' => 'PT. Pindad (Persero)',
                'perihal' => 'Kerjasama Rekrutmen Tenaga Kerja Kejuruan melalui Bursa Kerja Khusus (BKK) SMKN 1 Subang',
                'isi_ringkas' => 'Permintaan data lulusan terbaik alumni konsentrasi keahlian Teknik Pemesinan dan Mekatronika untuk seleksi operator produksi.',
                'kategori_id' => $humId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'PTDI/HRD/EXT/089/2026',
                'tanggal_surat' => '2026-09-15',
                'tanggal_terima' => '2026-09-17',
                'pengirim' => 'PT. Dirgantara Indonesia (Indonesian Aerospace)',
                'perihal' => 'Konfirmasi Kerjasama Kelas Industri dan Penyusunan Silabus Vokasi Kedirgantaraan',
                'isi_ringkas' => 'Undangan diskusi kurikulum operasional industri perakitan dan manufaktur mekanik presisi.',
                'kategori_id' => $humId,
                'status' => 'diterima',
            ],
            [
                'nomor_surat' => 'TLK/REG3/JBR/2026/045',
                'tanggal_surat' => '2026-09-16',
                'tanggal_terima' => '2026-09-18',
                'pengirim' => 'PT. Telkom Indonesia Witel Subang',
                'perihal' => 'Bantuan Program CSR Peningkatan Kapasitas Bandwidth Fiber Optik Laboratorium Komputer SMEA',
                'isi_ringkas' => 'Persetujuan upgrading konektivitas internet dedicated 1 Gbps untuk kelancaran pembelajaran SIJA dan RPL.',
                'kategori_id' => $sarId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'AHM/CSR-VOKASI/512/2026',
                'tanggal_surat' => '2026-09-17',
                'tanggal_terima' => '2026-09-19',
                'pengirim' => 'PT. Astra Honda Motor (AHM)',
                'perihal' => 'Donasi Unit Sepeda Motor Listrik Bahan Praktik Laboratorium Teknik Otomotif SMKN 1 Subang',
                'isi_ringkas' => 'Pemberian hibah 2 unit sepeda motor listrik EM1 e: beserta perlengkapan toolkit bengkel konversi motor listrik.',
                'kategori_id' => $sarId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'LEN/SDM-KERJASAMA/2026/112',
                'tanggal_surat' => '2026-09-18',
                'tanggal_terima' => '2026-09-20',
                'pengirim' => 'PT. Len Industri (Persero)',
                'perihal' => 'Penerimaan Prakerin dan Pengujian Sistem Elektronika Transportasi Perkeretaapian',
                'isi_ringkas' => 'Penyaluran siswa kejuruan jaringan dan pemesinan untuk program magang industri perkeretaapian di Bandung.',
                'kategori_id' => $humId,
                'status' => 'diterima',
            ],
            [
                'nomor_surat' => 'TKW/HRD/EXT-SME/2026/088',
                'tanggal_surat' => '2026-09-19',
                'tanggal_terima' => '2026-09-21',
                'pengirim' => 'PT. Taekwang Indonesia Subang',
                'perihal' => 'Program Rekrutmen Operator Maintenance Alat Mesin Industri Sepatu Olahraga Ekspor',
                'isi_ringkas' => 'Peluang penempatan kerja bagi 50 alumni SMK Negeri 1 Subang yang siap ditempatkan di pabrik Subang.',
                'kategori_id' => $humId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'BJB/KCB-SBG/OPR/2026/301',
                'tanggal_surat' => '2026-09-20',
                'tanggal_terima' => '2026-09-22',
                'pengirim' => 'Bank BJB Cabang Subang',
                'perihal' => 'Penawaran Pembukaan Rekening Tabungan Siswa SimPel dan Layanan SPP Virtual Account',
                'isi_ringkas' => 'Layanan perbankan digital untuk pembayaran administrasi sekolah dan tabungan siswa kejuruan akuntansi.',
                'kategori_id' => $kswId,
                'status' => 'diarsipkan',
            ],

            // Perguruan Tinggi / Universitas
            [
                'nomor_surat' => 'UNSUB/FIKOM/EXT/142/2026',
                'tanggal_surat' => '2026-09-21',
                'tanggal_terima' => '2026-09-22',
                'pengirim' => 'Fakultas Ilmu Komputer Universitas Subang',
                'perihal' => 'Permohonan Izin Penelitian Skripsi Mahasiswa Sistem Informasi di Bagian Tata Usaha SMKN 1 Subang',
                'isi_ringkas' => 'Surat permohonan riset skripsi implementasi algoritma Knuth-Morris-Pratt (KMP) untuk arsip dan legalisir online atas nama Ridwan Kurniawan.',
                'kategori_id' => $tuId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'UPI/FPTK/VOK-JBR/2026/099',
                'tanggal_surat' => '2026-09-22',
                'tanggal_terima' => '2026-09-23',
                'pengirim' => 'Universitas Pendidikan Indonesia (UPI Bandung)',
                'perihal' => 'Pengabdian Masyarakat: Workshop Kecerdasan Buatan dan Big Data untuk Guru Produktif SIJA & RPL',
                'isi_ringkas' => 'Undangan pelatihan peningkatan kompetensi digital guru-guru kejuruan informatika di SMKN 1 Subang.',
                'kategori_id' => $kurId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'POLSUB/DIK/2026/184',
                'tanggal_surat' => '2026-09-23',
                'tanggal_terima' => '2026-09-24',
                'pengirim' => 'Politeknik Negeri Subang (POLSUB)',
                'perihal' => 'Sosialisasi Program Beasiswa Lanjutan Diploma 4 Vokasi Manufaktur untuk Siswa Kelas XII',
                'isi_ringkas' => 'Peluang beasiswa pendidikan tinggi vokasi bagi lulusan berprestasi konsentrasi keahlian Teknik Otomotif dan Pemesinan.',
                'kategori_id' => $kswId,
                'status' => 'diterima',
            ],
            [
                'nomor_surat' => 'ITB/STEI/KERJA/2026/045',
                'tanggal_surat' => '2026-09-24',
                'tanggal_terima' => '2026-09-25',
                'pengirim' => 'Sekolah Teknik Elektro dan Informatika (STEI ITB)',
                'perihal' => 'Undangan Partisipasi Olimpiade Nasional Jaringan Komputer dan Pemrograman Web',
                'isi_ringkas' => 'Seleksi tim perwakilan siswa SMK Negeri se-Jawa Barat untuk kompetisi rekayasa perangkat lunak tingkat nasional.',
                'kategori_id' => $kurId,
                'status' => 'didisposisikan',
            ],

            // Permohonan Surat dari Siswa, Alumni, dan Pemohon
            [
                'nomor_surat' => 'MHS-UNSUB/01/IX/2026',
                'tanggal_surat' => '2026-09-25',
                'tanggal_terima' => '2026-09-26',
                'pengirim' => 'Ridwan Kurniawan (Alumni / Mahasiswa)',
                'perihal' => 'Permohonan Pengambilan Data Kearsipan dan Uji Coba Black Box Sistem Informasi Arsip SMEA',
                'isi_ringkas' => 'Pengajuan pengambilan sampel dokumen surat masuk, keluar, dan alur permohonan legalisir untuk bab pengujian skripsi.',
                'kategori_id' => $tuId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'PMH-ALUMNI/IJZ-01/2026',
                'tanggal_surat' => '2026-09-25',
                'tanggal_terima' => '2026-09-26',
                'pengirim' => 'Ahmad Fauzi Rahman (Alumni 2024)',
                'perihal' => 'Permohonan Surat Keterangan Pengganti Ijazah Asli yang Rusak Terkena Banjir',
                'isi_ringkas' => 'Permohonan penerbitan surat keterangan pengganti ijazah kejuruan Teknik Pemesinan disertai surat laporan kepolisian.',
                'kategori_id' => $tuId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'PMH-ALUMNI/LEG-02/2026',
                'tanggal_surat' => '2026-09-26',
                'tanggal_terima' => '2026-09-27',
                'pengirim' => 'Dewi Sartika Kusuma (Alumni 2023)',
                'perihal' => 'Permohonan Legalisir Transkrip Nilai dan Ijazah untuk Seleksi Administrasi CPNS Kemenkumham',
                'isi_ringkas' => 'Permohonan pengesahan legalisir 10 lembar salinan ijazah SMK konsentrasi SIJA untuk pemberkasan berkas dinas.',
                'kategori_id' => $tuId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'PMH-SISWA/BEA-03/2026',
                'tanggal_surat' => '2026-09-26',
                'tanggal_terima' => '2026-09-27',
                'pengirim' => 'Siti Nurhaliza Putri (Siswa Kelas XII RPL)',
                'perihal' => 'Permohonan Surat Rekomendasi Pendaftaran Beasiswa Indonesia Maju (BIM) Program S1 Luar Negeri',
                'isi_ringkas' => 'Pengajuan rekomendasi kepala sekolah sebagai siswa peringkat 1 paralel kejuruan untuk seleksi beasiswa Pusat Prestasi Nasional.',
                'kategori_id' => $kswId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => 'PMH-ORTU/DIS-04/2026',
                'tanggal_surat' => '2026-09-27',
                'tanggal_terima' => '2026-09-28',
                'pengirim' => 'Forum Komite Orang Tua Siswa SMKN 1 Subang',
                'perihal' => 'Permohonan Audiensi Pengadaan Fasilitas Ruang Tunggu dan Kantin Sehat Sekolah',
                'isi_ringkas' => 'Pengajuan rapat pembahasan penataan area kantin higienis dan sarana sanitasi lingkungan sekolah kejuruan.',
                'kategori_id' => $sarId,
                'status' => 'diterima',
            ],

            // LSP & Sertifikasi
            [
                'nomor_surat' => 'BNSP/LSP-P1/SMK1-SBG/2026/012',
                'tanggal_surat' => '2026-09-27',
                'tanggal_terima' => '2026-09-28',
                'pengirim' => 'Badan Nasional Sertifikasi Profesi (BNSP)',
                'perihal' => 'Pemberitahuan Lisensi Perpanjangan Tempat Uji Kompetensi (TUK) Mandiri SMKN 1 Subang',
                'isi_ringkas' => 'Sertifikat lisensi TUK untuk skema sertifikasi Junior Web Developer, Pengelasan SMAW, dan Pemeliharaan Berkala Kendaraan.',
                'kategori_id' => $kurId,
                'status' => 'diarsipkan',
            ],
            [
                'nomor_surat' => 'LSP-TOP/SUBANG/IX/2026/033',
                'tanggal_surat' => '2026-09-28',
                'tanggal_terima' => '2026-09-29',
                'pengirim' => 'Lembaga Sertifikasi Profesi Otomotif Profesional',
                'perihal' => 'Verifikasi Asesor Kompetensi Uji Keahlian Teknik Kendaraan Ringan Tahun Ajaran 2026/2027',
                'isi_ringkas' => 'Penugasan 4 asesor bersertifikasi master assessor untuk asesmen calon lulusan teknik otomotif.',
                'kategori_id' => $kurId,
                'status' => 'diterima',
            ],
            [
                'nomor_surat' => 'KEMENDIKBUD/DIT-SMK/SAR/2026/719',
                'tanggal_surat' => '2026-09-28',
                'tanggal_terima' => '2026-09-29',
                'pengirim' => 'Direktorat Sekolah Menengah Kejuruan Kemendikbudristek',
                'perihal' => 'Bantuan Penguatan Ekosistem Digital SMK Pusat Keunggulan Skema Reguler Baru Tahun 2026',
                'isi_ringkas' => 'Penyaluran dana stimulus peralatan modern interactive smart board dan perangkat server laboratorium komputer.',
                'kategori_id' => $sarId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '045/PKL-TK/IX/2026',
                'tanggal_surat' => '2026-09-29',
                'tanggal_terima' => '2026-09-30',
                'pengirim' => 'PT. Sharp Electronics Indonesia',
                'perihal' => 'Penerimaan Siswa Magang Kerja Industri Konsentrasi Rekayasa Perangkat Lunak dan Jaringan Komputer',
                'isi_ringkas' => 'Penyaluran 8 siswa untuk posisi IT Support dan Automation Testing di Karawang International Industrial City.',
                'kategori_id' => $humId,
                'status' => 'diterima',
            ],
            [
                'nomor_surat' => '089/KONSOR-RPL/JBR/2026',
                'tanggal_surat' => '2026-09-29',
                'tanggal_terima' => '2026-09-30',
                'pengirim' => 'Konsorsium Guru Kejuruan RPL Jawa Barat',
                'perihal' => 'Undangan Bedah Modul Ajar Cloud Computing dan Pemrograman Mobile Flutter',
                'isi_ringkas' => 'Workshop kurikulum kejuruan perangkat lunak untuk standarisasi modul ajar berbasis cloud di SMK Negeri.',
                'kategori_id' => $kurId,
                'status' => 'diterima',
            ],
            [
                'nomor_surat' => '012/KOMITE/SMK1/X/2026',
                'tanggal_surat' => '2026-09-30',
                'tanggal_terima' => '2026-10-01',
                'pengirim' => 'Komite SMK Negeri 1 Subang',
                'perihal' => 'Laporan Pertanggungjawaban Realisasi Dana Sumbangan Pembinaan Pendidikan Triwulan III',
                'isi_ringkas' => 'Laporan keuangan komite untuk subsidi silang siswa prasejahtera dan pemeliharaan genset laboratorium.',
                'kategori_id' => $tuId,
                'status' => 'diarsipkan',
            ],
            [
                'nomor_surat' => '512/CADISDIK-IV/KUR/2026',
                'tanggal_surat' => '2026-09-30',
                'tanggal_terima' => '2026-10-01',
                'pengirim' => 'Cabang Dinas Pendidikan Wilayah IV',
                'perihal' => 'Monitoring Kesiapan Asesmen Bakat Minat (ABM) dan ANBK Tahun Ajaran 2026/2027',
                'isi_ringkas' => 'Verifikasi kesiapan bandwidth, workstation client, dan server cadangan laboratorium komputer SMKN 1 Subang.',
                'kategori_id' => $kurId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '119/PUPUK-KUJANG/CSR/2026',
                'tanggal_surat' => '2026-10-01',
                'tanggal_terima' => '2026-10-02',
                'pengirim' => 'PT. Pupuk Kujang Cikampek',
                'perihal' => 'Prakerin Siswa Kejuruan Teknik Pemesinan dan Otomatisasi Perkantoran',
                'isi_ringkas' => 'Konfirmasi kuota magang industri bagi 12 siswa SMKN 1 Subang untuk unit maintenance pabrik kimia.',
                'kategori_id' => $humId,
                'status' => 'diterima',
            ],
            [
                'nomor_surat' => '008/DUDI-IND/SBG/2026',
                'tanggal_surat' => '2026-10-01',
                'tanggal_terima' => '2026-10-02',
                'pengirim' => 'Asosiasi Pengusaha Indonesia (APINDO) Subang',
                'perihal' => 'Undangan Focus Group Discussion Penyerapan Tenaga Kerja Vokasi SMEA Subang',
                'isi_ringkas' => 'Sinkronisasi peta kebutuhan industri kawasan Patimban Port Subang dengan kompetensi lulusan SMK.',
                'kategori_id' => $humId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '701/DISDIK-JBR/SET/2026',
                'tanggal_surat' => '2026-10-02',
                'tanggal_terima' => '2026-10-03',
                'pengirim' => 'Dinas Pendidikan Provinsi Jawa Barat',
                'perihal' => 'Edaran Penilaian Kinerja Kepala Sekolah (PKKS) dan Audit Administrasi Kearsipan Sekolah',
                'isi_ringkas' => 'Jadwal penilaian tahunan pimpinan sekolah meliputi supervisi tata kelola buku agenda surat dan digitalisasi arsip.',
                'kategori_id' => $disId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '092/SMKN2-SBG/OSIS/2026',
                'tanggal_surat' => '2026-10-02',
                'tanggal_terima' => '2026-10-03',
                'pengirim' => 'SMK Negeri 2 Subang',
                'perihal' => 'Undangan Turnamen Olahraga Futsal dan Bola Voli Antar Pelajar Kejuruan se-Kabupaten Subang',
                'isi_ringkas' => 'Partisipasi tim ekstrakurikuler olahraga SMKN 1 Subang dalam rangka Dies Natalis SMKN 2 Subang.',
                'kategori_id' => $kswId,
                'status' => 'diterima',
            ],
            [
                'nomor_surat' => '421.5/112/MKKS-SMK/2026',
                'tanggal_surat' => '2026-10-03',
                'tanggal_terima' => '2026-10-04',
                'pengirim' => 'Musyawarah Kerja Kepala Sekolah (MKKS) SMK Subang',
                'perihal' => 'Rapat Pleno Penyusunan Soal Bersama Penilaian Sumatif Akhir Jenjang (PSAJ) 2026',
                'isi_ringkas' => 'Rapat kerja penyusunan kisi-kisi dan bank soal evaluasi akhir pembelajaran SMK negeri dan swasta.',
                'kategori_id' => $kurId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '312/DISNAKER-SBG/BKK/2026',
                'tanggal_surat' => '2026-10-03',
                'tanggal_terima' => '2026-10-04',
                'pengirim' => 'Dinas Tenaga Kerja dan Transmigrasi Kab. Subang',
                'perihal' => 'Pameran Bursa Kerja (Subang Job Fair 2026) dan Partisipasi BKK SMKN 1 Subang',
                'isi_ringkas' => 'Penyediaan stand khusus alumni sekolah kejuruan pada bursa kerja daerah di Gedung Wisma Karya Subang.',
                'kategori_id' => $humId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '029/PLN-UP3/SUBANG/2026',
                'tanggal_surat' => '2026-10-03',
                'tanggal_terima' => '2026-10-04',
                'pengirim' => 'PT. PLN (Persero) UP3 Purwakarta - ULP Subang',
                'perihal' => 'Pemberitahuan Pemeliharaan Jaringan Listrik dan Penyesuaian Daya Gedung Bengkel Kejuruan',
                'isi_ringkas' => 'Informasi pemadaman bergilir terencana serta penambahan daya gardu listrik untuk bengkel mesin bubut CNC.',
                'kategori_id' => $sarId,
                'status' => 'diarsipkan',
            ],
            [
                'nomor_surat' => '081/POLRES-SBG/LANTAS/2026',
                'tanggal_surat' => '2026-10-04',
                'tanggal_terima' => '2026-10-04',
                'pengirim' => 'Kepolisian Resor Subang (Satlantas Polres Subang)',
                'perihal' => 'Penyuluhan Tertib Berlalu Lintas dan Larangan Knalpot Brong pada Pelajar SMK',
                'isi_ringkas' => 'Program Police Goes to School pada apel bendera hari Senin di lapangan upacara SMKN 1 Subang.',
                'kategori_id' => $kswId,
                'status' => 'didisposisikan',
            ],
            [
                'nomor_surat' => '033/TELKOM-UNIV/BDG/2026',
                'tanggal_surat' => '2026-10-04',
                'tanggal_terima' => '2026-10-05',
                'pengirim' => 'Telkom University Bandung',
                'perihal' => 'Penjajakan Kerjasama Beasiswa Vokasi Ikatan Dinas Program D3 Rekayasa Komputer',
                'isi_ringkas' => 'Seleksi jalur prestasi khusus lulusan terbaik jurusan SIJA dan Rekayasa Perangkat Lunak SMEA.',
                'kategori_id' => $kswId,
                'status' => 'diterima',
            ],
            [
                'nomor_surat' => '841/CADISDIK-IV/KEP/2026',
                'tanggal_surat' => '2026-10-04',
                'tanggal_terima' => '2026-10-05',
                'pengirim' => 'Cabang Dinas Pendidikan Wilayah IV',
                'perihal' => 'Penetapan Angka Kredit Jabatan Fungsional Guru SMKN 1 Subang Periode Oktober 2026',
                'isi_ringkas' => 'Penyampaian SK kenaikan pangkat dan penetapan angka kredit konversi guru PNS dan PPPK.',
                'kategori_id' => $tuId,
                'status' => 'diarsipkan',
            ],
            [
                'nomor_surat' => '019/DUDI-AUTO/SUBANG/2026',
                'tanggal_surat' => '2026-10-05',
                'tanggal_terima' => '2026-10-05',
                'pengirim' => 'Auto2000 Subang (PT. Astra International)',
                'perihal' => 'Uji Sertifikasi Mekanik Toyota Technical Education Program (T-TEP) untuk Siswa Otomotif',
                'isi_ringkas' => 'Pelaksanaan sertifikasi keahlian teknisi mesin berkala berstandar global bagi 25 siswa jurusan TKR.',
                'kategori_id' => $kurId,
                'status' => 'diterima',
            ],
        ];

        // Tambahkan loop variasi surat masuk hingga mencapai nomor agenda SM/2026/060
        $currentSmCount = SuratMasuk::count();
        $agendaIndex = $currentSmCount + 1;

        foreach ($suratMasukList as $smData) {
            $nomorAgenda = sprintf('SM/2026/%03d', $agendaIndex);
            SuratMasuk::firstOrCreate(
                ['nomor_agenda' => $nomorAgenda],
                [
                    'nomor_surat' => $smData['nomor_surat'],
                    'tanggal_surat' => $smData['tanggal_surat'],
                    'tanggal_terima' => $smData['tanggal_terima'],
                    'pengirim' => $smData['pengirim'],
                    'penerima' => 'Kepala SMKN 1 Subang',
                    'perihal' => $smData['perihal'],
                    'isi_ringkas' => $smData['isi_ringkas'],
                    'kategori_id' => $smData['kategori_id'],
                    'file_path' => 'dokumen-surat-masuk/dummy-surat-masuk-'.sprintf('%03d', $agendaIndex).'.pdf',
                    'file_name' => 'arsip-masuk-'.sprintf('%03d', $agendaIndex).'.pdf',
                    'file_size' => rand(180000, 750000),
                    'status' => $smData['status'],
                    'user_id' => $admin->id,
                ]
            );
            $agendaIndex++;
        }

        // Lengkapi hingga nomor agenda 60 jika belum tercapai
        while ($agendaIndex <= 60) {
            $nomorAgenda = sprintf('SM/2026/%03d', $agendaIndex);
            $randomKategori = [$kurId, $kswId, $humId, $sarId, $tuId, $disId][array_rand([$kurId, $kswId, $humId, $sarId, $tuId, $disId])];
            SuratMasuk::firstOrCreate(
                ['nomor_agenda' => $nomorAgenda],
                [
                    'nomor_surat' => '421.5/'.rand(100, 999).'/DUDI-SBG/2026',
                    'tanggal_surat' => '2026-09-'.str_pad((string) rand(1, 28), 2, '0', STR_PAD_LEFT),
                    'tanggal_terima' => '2026-09-'.str_pad((string) rand(2, 30), 2, '0', STR_PAD_LEFT),
                    'pengirim' => 'Mitra Rekanan Industri / Stakeholder SMKN 1 Subang #'.$agendaIndex,
                    'penerima' => 'Kepala SMKN 1 Subang',
                    'perihal' => 'Koordinasi Penyelenggaraan Uji Kompetensi Keahlian (UKK) dan Magang Praktik Kerja Lapangan (PKL) #'.$agendaIndex,
                    'isi_ringkas' => 'Dokumen korespondensi kearsipan resmi menyangkut peningkatan mutu pembelajaran vokasi dan tata kelola arsip digital sekolah.',
                    'kategori_id' => $randomKategori,
                    'file_path' => 'dokumen-surat-masuk/dummy-surat-masuk-'.sprintf('%03d', $agendaIndex).'.pdf',
                    'file_name' => 'arsip-masuk-'.sprintf('%03d', $agendaIndex).'.pdf',
                    'file_size' => rand(200000, 600000),
                    'status' => ['diterima', 'didisposisikan', 'diarsipkan'][array_rand(['diterima', 'didisposisikan', 'diarsipkan'])],
                    'user_id' => $admin->id,
                ]
            );
            $agendaIndex++;
        }

        // 3. Data Dummy Surat Keluar (~58 surat baru, total 60)
        $suratKeluarList = [
            [
                'nomor_surat' => '421.5/101-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-03',
                'tujuan' => 'Kepala Dinas Pendidikan Provinsi Jawa Barat',
                'perihal' => 'Laporan Pelaksanaan Uji Coba Asesmen Nasional Berbasis Komputer (ANBK) SMKN 1 Subang',
                'isi_ringkas' => 'Penyampaian berita acara dan rekapitulasi kehadiran peserta simulasi gladi bersih ANBK seluruh program keahlian.',
                'kategori_id' => $kurId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Kirimkan tembusan ke Cabang Dinas Wilayah IV.',
            ],
            [
                'nomor_surat' => '421.5/102-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-04',
                'tujuan' => 'Direktur Utama PT. Dahana (Persero) Subang',
                'perihal' => 'Permohonan Kerjasama Penempatan Siswa Praktik Kerja Lapangan (PKL) Periode Semester Ganjil',
                'isi_ringkas' => 'Pengajuan daftar 20 calon peserta magang industri jurusan Teknik Pemesinan dan Rekayasa Perangkat Lunak.',
                'kategori_id' => $humId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Sangat baik. Prioritaskan siswa yang telah lulus tes keselamatan kerja (K3).',
            ],
            [
                'nomor_surat' => '421.5/103-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-06',
                'tujuan' => 'Orang Tua / Wali Siswa Kelas X Semua Program Keahlian',
                'perihal' => 'Pemberitahuan Pelaksanaan Masa Pengenalan Lingkungan Sekolah (MPLS) dan Penanaman Karakter Disiplin',
                'isi_ringkas' => 'Undangan pembekalan tata tertib sekolah kejuruan dan pembentukan karakter profil pelajar pancasila.',
                'kategori_id' => $kswId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui untuk diedarkan kepada orang tua siswa.',
            ],
            [
                'nomor_surat' => '421.5/104-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-08',
                'tujuan' => 'Pimpinan Cabang Bank BJB Subang',
                'perihal' => 'Permohonan Rekening Koran Giro Operasional Dana Bantuan Operasional Sekolah (BOS) Periode Agustus 2026',
                'isi_ringkas' => 'Pengambilan rekening koran resmi untuk kelengkapan administrasi SPJ bendahara pengeluaran sekolah.',
                'kategori_id' => $tuId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui untuk keperluan rekonsiliasi kas daerah.',
            ],
            [
                'nomor_surat' => '421.5/105-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-10',
                'tujuan' => 'Kepala Cabang Dinas Pendidikan Wilayah IV',
                'perihal' => 'Usulan Penetapan Guru Pembimbing Uji Kompetensi Keahlian (UKK) Mandiri dan Asesor Penguji Eksternal',
                'isi_ringkas' => 'Pengajuan SK tim penguji internal sekolah dan mitra dunia usaha untuk pengesahan dinas pendidikan.',
                'kategori_id' => $kurId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Lampirkan sertifikat asesor guru yang bersangkutan.',
            ],
            [
                'nomor_surat' => '421.5/106-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-12',
                'tujuan' => 'Dekan Fakultas Ilmu Komputer Universitas Subang',
                'perihal' => 'Surat Jawaban Persetujuan Riset / Penelitian Skripsi Mahasiswa Sistem Informasi atas nama Ridwan Kurniawan',
                'isi_ringkas' => 'Pemberian izin resmi pengambilan data arsip persuratan dan pengujian algoritma Knuth-Morris-Pratt di Bagian TU.',
                'kategori_id' => $tuId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Fasilitasi mahasiswa peneliti dengan tetap menjaga kerahasiaan data sensitif.',
            ],
            [
                'nomor_surat' => '421.5/107-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-14',
                'tujuan' => 'Direktur Human Capital PT. Pindad (Persero) Bandung',
                'perihal' => 'Pengiriman Daftar Calon Lulusan Terbaik Seleksi Rekrutmen Operator Mesin Industri Presisi',
                'isi_ringkas' => 'Penyampaian portofolio nilai rapor dan sertifikat kompetensi 15 alumni program keahlian teknik mesin.',
                'kategori_id' => $humId,
                'status_persetujuan' => 'menunggu_persetujuan',
                'catatan_kepsek' => null,
            ],
            [
                'nomor_surat' => '421.5/108-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-16',
                'tujuan' => 'Ketua Lembaga Tes Masuk Perguruan Tinggi (SNPMB Kemendikbudristek)',
                'perihal' => 'Verifikasi dan Pemutakhiran Data PDSS Siswa Eligible Seleksi Nasional Berdasarkan Prestasi (SNBP)',
                'isi_ringkas' => 'Pengesahan data akreditasi sekolah A dan nilai rapor semester 1 sampai 5 calon pendaftar PTN.',
                'kategori_id' => $kurId,
                'status_persetujuan' => 'menunggu_persetujuan',
                'catatan_kepsek' => null,
            ],
            [
                'nomor_surat' => '421.5/109-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-18',
                'tujuan' => 'General Manager PT. Telkom Indonesia Wilayah Subang',
                'perihal' => 'Ucapan Terimakasih atas Bantuan CSR Jaringan Internet Dedicated Fiber Optik Laboratorium SIJA',
                'isi_ringkas' => 'Apresiasi atas dukungan infrastruktur teknologi informasi pembelajaran rekayasa perangkat lunak sekolah.',
                'kategori_id' => $sarId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui untuk dikirimkan ke pihak Telkom Witel Subang.',
            ],
            [
                'nomor_surat' => '421.5/110-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-19',
                'tujuan' => 'Kepala Balai Besar Pengembangan Penjaminan Mutu Pendidikan Vokasi (BBPPMPV BMTI Bandung)',
                'perihal' => 'Permohonan Bantuan Hibah Mesin Bubut CNC dan Perangkat Pelatihan Otomasi Industri Bengkel SMEA',
                'isi_ringkas' => 'Proposal revitalisasi peralatan ruang praktik kejuruan teknik pemesinan sesuai standar industri modern 4.0.',
                'kategori_id' => $sarId,
                'status_persetujuan' => 'draft',
                'catatan_kepsek' => null,
            ],
            [
                'nomor_surat' => '421.5/111-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-20',
                'tujuan' => 'Kepala Kepolisian Sektor Subang Kota',
                'perihal' => 'Permohonan Bantuan Pengamanan dan Pengaturan Lalu Lintas Acara Jalan Santai Dies Natalis SMEA',
                'isi_ringkas' => 'Permohonan penempatan personil patroli kepolisian pada rute jalan santai perayaan hari ulang tahun sekolah.',
                'kategori_id' => $kswId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Koordinasikan titik kumpul peserta di gerbang utama.',
            ],
            [
                'nomor_surat' => '421.5/112-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-22',
                'tujuan' => 'Kepala Dinas Tenaga Kerja dan Transmigrasi Kabupaten Subang',
                'perihal' => 'Laporan Rekapitulasi Penelusuran Tamatan (Tracer Study) Alumni SMK Negeri 1 Subang Tahun 2025',
                'isi_ringkas' => 'Penyampaian data statistik persentase keterserapan alumni di industri, berwirausaha, dan melanjutkan kuliah (BMW).',
                'kategori_id' => $humId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Sangat bagus. Capaian keterserapan 86% agar dipertahankan.',
            ],
            [
                'nomor_surat' => '421.5/113-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-23',
                'tujuan' => 'Ahmad Fauzi Rahman (Alumni SMKN 1 Subang)',
                'perihal' => 'Surat Keterangan Pengganti Ijazah Rusak / Cacat Fisik Nomor: 421.5/SKP-IJZ/001/2026',
                'isi_ringkas' => 'Penerbitan surat keterangan pengganti resmi berdasar buku induk kelulusan tahun ajaran 2023/2024.',
                'kategori_id' => $tuId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Berkas lampiran laporan polisi dan saksi sudah terverifikasi lengkap.',
            ],
            [
                'nomor_surat' => '421.5/114-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-24',
                'tujuan' => 'Pimpinan Lembaga Sertifikasi Profesi P1 SMKN 1 Subang',
                'perihal' => 'Surat Tugas Asesor Uji Kompetensi Kejuruan Rekayasa Perangkat Lunak dan SIJA Gelombang I',
                'isi_ringkas' => 'Penugasan 6 guru produktif bersertifikat asesor BNSP untuk menguji 144 peserta didik tingkat XII.',
                'kategori_id' => $kurId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Pastikan seluruh lembar observasi dan portofolio siswa terdokumentasi rapi.',
            ],
            [
                'nomor_surat' => '421.5/115-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-25',
                'tujuan' => 'Dewi Sartika Kusuma (Alumni Konsentrasi SIJA 2023)',
                'perihal' => 'Penyampaian Legalisir Dokumen Ijazah dan Transkrip Nilai Siap Diambil di Loket Tata Usaha',
                'isi_ringkas' => 'Pemberitahuan kepada pemohon bahwa berkas pengesahan legalisir 10 lembar telah distempel basah dan ditandatangani.',
                'kategori_id' => $tuId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui.',
            ],
            [
                'nomor_surat' => '421.5/116-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-26',
                'tujuan' => 'Orang Tua / Wali Siswa Calon Penerima Program Indonesia Pintar (PIP)',
                'perihal' => 'Pemberitahuan Jadwal Aktivasi Rekening Simpanan Pelajar (SimPel) BNI dan BJB Bantuan PIP 2026',
                'isi_ringkas' => 'Instruksi berkas persyaratan aktivasi buku tabungan dan penarikan dana bantuan pendidikan bagi siswa afirmasi.',
                'kategori_id' => $kswId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Berikan pendampingan dari staf kesiswaan saat aktivasi di bank.',
            ],
            [
                'nomor_surat' => '421.5/117-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-27',
                'tujuan' => 'Pimpinan PT. Taekwang Indonesia Subang',
                'perihal' => 'Konfirmasi Pengiriman 40 Berkas Lamaran Calon Karyawan Alumni SMKN 1 Subang',
                'isi_ringkas' => 'Penyampaian rekapitulasi data fisik alumni siap kerja konsentrasi perkantoran, akuntansi, dan teknik.',
                'kategori_id' => $humId,
                'status_persetujuan' => 'menunggu_persetujuan',
                'catatan_kepsek' => null,
            ],
            [
                'nomor_surat' => '421.5/118-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-28',
                'tujuan' => 'Kepala Dinas Pariwisata, Pemuda, dan Olahraga Kabupaten Subang',
                'perihal' => 'Permohonan Peminjaman Gedung Olahraga Gotong Royong untuk Seleksi Ekstrakurikuler Bola Basket',
                'isi_ringkas' => 'Peminjaman sarana olahraga representatif untuk turnamen basket antar kelas peringatan Bulan Bahasa.',
                'kategori_id' => $kswId,
                'status_persetujuan' => 'ditolak',
                'catatan_kepsek' => 'Revisi tanggal pelaksanaan agar tidak bentrok dengan jadwal penilaian tengah semester siswa.',
            ],
            [
                'nomor_surat' => '421.5/119-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-29',
                'tujuan' => 'Direktur Politeknik Manufaktur Bandung (POLMAN Bandung)',
                'perihal' => 'Permohonan Kunjungan Industri (KI) Siswa Kelas XI Konsentrasi Keahlian Teknik Pemesinan Bubut',
                'isi_ringkas' => 'Permohonan izin studi lapangan dan pengenalan mesin cetak injeksi plastik bagi 70 peserta didik.',
                'kategori_id' => $humId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Siapkan surat tugas guru pendamping dan asuransi perjalanan siswa.',
            ],
            [
                'nomor_surat' => '421.5/120-SMKN1/IX/2026',
                'tanggal_surat' => '2026-09-30',
                'tujuan' => 'Seluruh Dewan Guru dan Tenaga Kependidikan SMK Negeri 1 Subang',
                'perihal' => 'Surat Undangan Rapat Pleno Evaluasi Kesiapan Pengelolaan Arsip Digital Berbasis KMP Tahun 2026',
                'isi_ringkas' => 'Sosialisasi pemanfaatan fitur pencarian cerdas KMP untuk mempercepat temu balik surat masuk dan draf surat keluar dinas.',
                'kategori_id' => $tuId,
                'status_persetujuan' => 'disetujui',
                'catatan_kepsek' => 'Disetujui. Seluruh staf TU wajib hadir dan mempraktikkan pencarian dokumen arsip.',
            ],
        ];

        $currentSkCount = SuratKeluar::count();
        $agendaSkIndex = $currentSkCount + 1;

        foreach ($suratKeluarList as $skData) {
            $nomorAgenda = sprintf('SK/2026/%03d', $agendaSkIndex);
            $isApproved = $skData['status_persetujuan'] === 'disetujui';

            SuratKeluar::firstOrCreate(
                ['nomor_agenda' => $nomorAgenda],
                [
                    'nomor_surat' => $skData['nomor_surat'],
                    'tanggal_surat' => $skData['tanggal_surat'],
                    'tujuan' => $skData['tujuan'],
                    'perihal' => $skData['perihal'],
                    'isi_ringkas' => $skData['isi_ringkas'],
                    'kategori_id' => $skData['kategori_id'],
                    'file_path' => 'dokumen-surat-keluar/dummy-surat-keluar-'.sprintf('%03d', $agendaSkIndex).'.pdf',
                    'file_name' => 'arsip-keluar-'.sprintf('%03d', $agendaSkIndex).'.pdf',
                    'file_size' => rand(190000, 580000),
                    'status_persetujuan' => $skData['status_persetujuan'],
                    'catatan_kepsek' => $skData['catatan_kepsek'],
                    'disetujui_oleh' => $isApproved ? $kepsek->id : null,
                    'tanggal_disetujui' => $isApproved ? $skData['tanggal_surat'].' 10:00:00' : null,
                    'user_id' => $admin->id,
                ]
            );
            $agendaSkIndex++;
        }

        // Lengkapi surat keluar hingga nomor agenda 60
        while ($agendaSkIndex <= 60) {
            $nomorAgenda = sprintf('SK/2026/%03d', $agendaSkIndex);
            $randomKategori = [$kurId, $kswId, $humId, $sarId, $tuId, $disId][array_rand([$kurId, $kswId, $humId, $sarId, $tuId, $disId])];
            $statuses = ['disetujui', 'menunggu_persetujuan', 'draft'];
            $st = $statuses[array_rand($statuses)];
            $isApp = $st === 'disetujui';

            SuratKeluar::firstOrCreate(
                ['nomor_agenda' => $nomorAgenda],
                [
                    'nomor_surat' => '421.5/'.rand(121, 299).'-SMKN1/IX/2026',
                    'tanggal_surat' => '2026-09-'.str_pad((string) rand(10, 30), 2, '0', STR_PAD_LEFT),
                    'tujuan' => 'Instansi Mitra / Industri / Pemohon Dokumen SMKN 1 Subang #'.$agendaSkIndex,
                    'perihal' => 'Penyampaian Berkas Dinas Kearsipan dan Layanan Dokumen Kejuruan Resmi SMKN 1 Subang #'.$agendaSkIndex,
                    'isi_ringkas' => 'Penerbitan surat dinas resmi sekolah dalam rangka pengelolaan kearsipan digital modern berbasis algoritma Knuth-Morris-Pratt.',
                    'kategori_id' => $randomKategori,
                    'file_path' => 'dokumen-surat-keluar/dummy-surat-keluar-'.sprintf('%03d', $agendaSkIndex).'.pdf',
                    'file_name' => 'arsip-keluar-'.sprintf('%03d', $agendaSkIndex).'.pdf',
                    'file_size' => rand(200000, 550000),
                    'status_persetujuan' => $st,
                    'catatan_kepsek' => $isApp ? 'Disetujui oleh Kepala Sekolah.' : null,
                    'disetujui_oleh' => $isApp ? $kepsek->id : null,
                    'tanggal_disetujui' => $isApp ? now() : null,
                    'user_id' => $admin->id,
                ]
            );
            $agendaSkIndex++;
        }

        // 4. Data Dummy Disposisi Surat Masuk
        $targetDisposisiSurat = SuratMasuk::where('status', 'didisposisikan')->take(12)->get();
        $tujuanOptions = [
            'Wakasek Bidang Kurikulum',
            'Wakasek Bidang Kesiswaan',
            'Wakasek Bidang Humas dan Hubin',
            'Wakasek Bidang Sarana dan Prasarana',
            'Kepala Bagian Tata Usaha',
            'Ketua Program Keahlian RPL & SIJA',
            'Ketua Program Keahlian Teknik Pemesinan',
            'Ketua Program Keahlian Teknik Otomotif',
            'Ketua BKK (Bursa Kerja Khusus)',
        ];

        foreach ($targetDisposisiSurat as $idx => $surat) {
            $tujuan = $tujuanOptions[$idx % count($tujuanOptions)];
            DisposisiSuratMasuk::firstOrCreate(
                ['surat_masuk_id' => $surat->id, 'tujuan_disposisi' => $tujuan],
                [
                    'diberikan_oleh' => $kepsek->id,
                    'instruksi' => 'Pelajari dan tindak lanjuti sesuai dengan ketentuan kedinasan yang berlaku.',
                    'catatan' => 'Koordinasikan dengan unit kerja terkait dan laporkan hasilnya secara berkala.',
                    'batas_waktu' => now()->addDays(7)->toDateString(),
                    'status' => ['menunggu', 'ditindaklanjuti', 'selesai'][$idx % 3],
                ]
            );
        }

        // 5. Data Dummy Pengajuan Legalisir Terkait Siswa & Alumni (~18 permohonan)
        $legalisirDummyList = [
            [
                'pemohon_idx' => 0, // Ahmad Fauzi
                'jenis_dokumen' => 'ijazah',
                'jumlah_lembar' => 5,
                'keperluan' => 'Pemberkasan Seleksi Penerimaan Anggota TNI AD Kodim 0605 Subang',
                'status' => 'siap_diambil',
                'catatan_petugas' => 'Data nomor seri ijazah tahun kelulusan 2024 terdaftar di buku induk sekolah.',
                'catatan_kepsek' => 'Disahkan.',
                'tanggal_siap_ambil' => '2026-10-02',
            ],
            [
                'pemohon_idx' => 1, // Dewi Sartika
                'jenis_dokumen' => 'transkrip_nilai',
                'jumlah_lembar' => 4,
                'keperluan' => 'Kelengkapan Dokumen Rekrutmen Staf IT PT. Dahana Energetic Material Center',
                'status' => 'selesai',
                'catatan_petugas' => 'Berkas lengkap dan sesuai.',
                'catatan_kepsek' => 'Disetujui.',
                'tanggal_siap_ambil' => '2026-09-28',
                'tanggal_pengambilan' => '2026-09-30',
            ],
            [
                'pemohon_idx' => 2, // Muhammad Rizky
                'jenis_dokumen' => 'sertifikat_keahlian',
                'jumlah_lembar' => 3,
                'keperluan' => 'Seleksi Operator Pemesinan Bubut CNC PT. Pindad Persero',
                'status' => 'sedang_diproses',
                'catatan_petugas' => 'Sertifikat UKK BNSP valid.',
                'catatan_kepsek' => 'Disetujui.',
                'tanggal_siap_ambil' => '2026-10-08',
            ],
            [
                'pemohon_idx' => 3, // Siti Nurhaliza
                'jenis_dokumen' => 'rapor',
                'jumlah_lembar' => 1,
                'keperluan' => 'Pendaftaran Beasiswa Unggulan Prestasi Akademik S1 Telkom University',
                'status' => 'menunggu_approval_kepsek',
                'catatan_petugas' => 'Nilai rapor semester 1-5 telah diverifikasi oleh bagian kurikulum.',
                'catatan_kepsek' => null,
            ],
            [
                'pemohon_idx' => 4, // Budi Santoso
                'jenis_dokumen' => 'ijazah',
                'jumlah_lembar' => 5,
                'keperluan' => 'Persyaratan Ujian Dinas Kenaikan Jabatan Staf Akuntansi Perusahaan Swasta',
                'status' => 'menunggu_verifikasi',
                'catatan_petugas' => null,
                'catatan_kepsek' => null,
            ],
            [
                'pemohon_idx' => 5, // Anisa Rahmawati
                'jenis_dokumen' => 'transkrip_nilai',
                'jumlah_lembar' => 5,
                'keperluan' => 'Pendaftaran Seleksi Calon Pegawai Negeri Sipil (CPNS) Pemkab Subang',
                'status' => 'disetujui_kepsek',
                'catatan_petugas' => 'Data nilai valid.',
                'catatan_kepsek' => 'Setuju untuk dicap stempel basah.',
            ],
            [
                'pemohon_idx' => 6, // Fajar Ramadhan
                'jenis_dokumen' => 'ijazah',
                'jumlah_lembar' => 3,
                'keperluan' => 'Melamar Pekerjaan di Kawasan Industri Suryacipta Karawang',
                'status' => 'diverifikasi',
                'catatan_petugas' => 'Nomor seri ijazah terverifikasi.',
                'catatan_kepsek' => null,
            ],
            [
                'pemohon_idx' => 7, // Tri Wahyuni
                'jenis_dokumen' => 'sertifikat_keahlian',
                'jumlah_lembar' => 2,
                'keperluan' => 'Sertifikasi Tambahan Kompetensi Keahlian Rekayasa Perangkat Lunak',
                'status' => 'siap_diambil',
                'catatan_petugas' => 'Berkas siap di meja piket TU.',
                'catatan_kepsek' => 'Disahkan.',
                'tanggal_siap_ambil' => '2026-10-04',
            ],
            [
                'pemohon_idx' => 8, // Rifki Anugrah
                'jenis_dokumen' => 'rapor',
                'jumlah_lembar' => 2,
                'keperluan' => 'Syarat Seleksi Prakerin Industri Otomotif Astra Honda Motor',
                'status' => 'menunggu_verifikasi',
                'catatan_petugas' => null,
                'catatan_kepsek' => null,
            ],
            [
                'pemohon_idx' => 9, // Maya Anggraeni
                'jenis_dokumen' => 'ijazah',
                'jumlah_lembar' => 5,
                'keperluan' => 'Pemberkasan Karyawan Tetap Bank BJB Cabang Subang',
                'status' => 'selesai',
                'catatan_petugas' => 'Data valid.',
                'catatan_kepsek' => 'Disetujui.',
                'tanggal_siap_ambil' => '2026-09-20',
                'tanggal_pengambilan' => '2026-09-22',
            ],
            [
                'pemohon_idx' => 10, // Dika Firmansyah
                'jenis_dokumen' => 'ijazah',
                'jumlah_lembar' => 3,
                'keperluan' => 'Melamar Posisi Operator Bubut Mesin PT. Taekwang Indonesia',
                'status' => 'sedang_diproses',
                'catatan_petugas' => 'Dalam proses penandatanganan dan cap stempel.',
                'catatan_kepsek' => 'Disetujui.',
                'tanggal_siap_ambil' => '2026-10-09',
            ],
            [
                'pemohon_idx' => 11, // Nanda Aulia
                'jenis_dokumen' => 'transkrip_nilai',
                'jumlah_lembar' => 4,
                'keperluan' => 'Pendaftaran Beasiswa KIP Kuliah Universitas Subang',
                'status' => 'menunggu_approval_kepsek',
                'catatan_petugas' => 'Berkas ijazah asli scan jelas.',
                'catatan_kepsek' => null,
            ],
            [
                'pemohon_idx' => 12, // Dimas Bagus
                'jenis_dokumen' => 'ijazah',
                'jumlah_lembar' => 2,
                'keperluan' => 'Dokumen Tambahan Rekrutmen Mekanik Bengkel Resmi Toyota Auto2000',
                'status' => 'siap_diambil',
                'catatan_petugas' => 'Selesai distempel.',
                'catatan_kepsek' => 'Disahkan.',
                'tanggal_siap_ambil' => '2026-10-05',
            ],
            [
                'pemohon_idx' => 13, // Riska Nur Fatimah
                'jenis_dokumen' => 'ijazah',
                'jumlah_lembar' => 4,
                'keperluan' => 'Pemberkasan Administrasi Tenaga Honorer Dinas Lingkungan Hidup Subang',
                'status' => 'ditolak',
                'catatan_petugas' => 'Scan dokumen buram dan terpotong di bagian nomor seri, mohon ajukan ulang dengan scan dokumen asli yang jelas.',
                'catatan_kepsek' => null,
            ],
            [
                'pemohon_idx' => 14, // Gilang Ramadhan
                'jenis_dokumen' => 'rapor',
                'jumlah_lembar' => 1,
                'keperluan' => 'Verifikasi Nilai Rapor Pendaftaran Olimpiade Sains Terapan Nasional',
                'status' => 'menunggu_verifikasi',
                'catatan_petugas' => null,
                'catatan_kepsek' => null,
            ],
        ];

        foreach ($legalisirDummyList as $i => $leg) {
            $userTarget = $pemohonUsers[$leg['pemohon_idx']] ?? $pemohonUsers[0];
            $nomorPengajuan = sprintf('LEG-202609-%04d', $i + 3);

            $pengajuan = PengajuanLegalisir::firstOrCreate(
                ['nomor_pengajuan' => $nomorPengajuan],
                [
                    'user_id' => $userTarget->id,
                    'nama_pemohon' => $userTarget->name,
                    'nisn' => $userTarget->nip_nisn ?? '0051287901',
                    'tahun_lulus' => '2024',
                    'nomor_whatsapp' => $userTarget->phone_number ?? '081234567800',
                    'email' => $userTarget->email,
                    'jenis_dokumen' => $leg['jenis_dokumen'],
                    'jumlah_lembar' => $leg['jumlah_lembar'],
                    'keperluan' => $leg['keperluan'],
                    'file_dokumen_path' => 'dokumen-legalisir/dummy-scan-'.$leg['jenis_dokumen'].'-'.($i + 1).'.pdf',
                    'status' => $leg['status'],
                    'catatan_petugas' => $leg['catatan_petugas'] ?? null,
                    'catatan_kepsek' => $leg['catatan_kepsek'] ?? null,
                    'tanggal_siap_ambil' => $leg['tanggal_siap_ambil'] ?? null,
                    'tanggal_pengambilan' => $leg['tanggal_pengambilan'] ?? null,
                    'petugas_id' => in_array($leg['status'], ['menunggu_verifikasi']) ? null : $admin->id,
                ]
            );

            // Tambahkan audit trail riwayat legalisir
            RiwayatLegalisir::firstOrCreate(
                ['pengajuan_legalisir_id' => $pengajuan->id, 'status_baru' => $leg['status']],
                [
                    'status_sebelumnya' => 'menunggu_verifikasi',
                    'diubah_oleh' => in_array($leg['status'], ['disetujui_kepsek', 'menunggu_approval_kepsek']) ? $kepsek->id : $admin->id,
                    'catatan' => $leg['catatan_petugas'] ?? 'Status permohonan diperbarui.',
                    'created_at' => now()->subHours(rand(1, 48)),
                ]
            );
        }

        // 6. Log aktivitas penambahan data dummy kearsipan
        LogAktivitas::create([
            'user_id' => $admin->id,
            'aksi' => 'SEEDING_DUMMY',
            'modul' => 'SISTEM',
            'deskripsi' => 'Inisialisasi 100+ surat masuk & keluar, akun siswa/alumni, dan legalisir dummy berhasil dimuat.',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Console Dummy Seeder',
            'created_at' => now(),
        ]);
    }
}
