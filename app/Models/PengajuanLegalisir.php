<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengajuanLegalisir extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_legalisir';

    protected $fillable = [
        'nomor_pengajuan',
        'user_id',
        'nama_pemohon',
        'nisn',
        'tahun_lulus',
        'nomor_whatsapp',
        'email',
        'jenis_dokumen',
        'jumlah_lembar',
        'keperluan',
        'file_dokumen_path',
        'status',
        'catatan_petugas',
        'catatan_kepsek',
        'tanggal_siap_ambil',
        'tanggal_pengambilan',
        'petugas_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_siap_ambil' => 'date',
            'tanggal_pengambilan' => 'date',
            'jumlah_lembar' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function riwayat(): HasMany
    {
        return $this->hasMany(RiwayatLegalisir::class, 'pengajuan_legalisir_id')->orderBy('created_at', 'desc');
    }

    public function getJenisDokumenLabelAttribute(): string
    {
        return match ($this->jenis_dokumen) {
            'ijazah' => 'Ijazah Asli / Salinan',
            'transkrip_nilai' => 'Transkrip Nilai',
            'rapor' => 'Buku Rapor Lengkap',
            'sertifikat_keahlian' => 'Sertifikat Uji Kompetensi Keahlian',
            default => ucfirst(str_replace('_', ' ', $this->jenis_dokumen)),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi TU',
            'diverifikasi' => 'Berkas Terverifikasi',
            'menunggu_approval_kepsek' => 'Menunggu Persetujuan Kepsek',
            'disetujui_kepsek' => 'Disetujui Kepala Sekolah',
            'sedang_diproses' => 'Sedang Diproses & Distempel',
            'siap_diambil' => 'Siap Diambil di SMKN 1 Subang',
            'selesai' => 'Selesai / Sudah Diambil',
            'ditolak' => 'Permohonan Ditolak',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}
