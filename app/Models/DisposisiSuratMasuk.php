<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisposisiSuratMasuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'disposisi_surat_masuk';

    protected $fillable = [
        'surat_masuk_id',
        'diberikan_oleh',
        'tujuan_disposisi',
        'instruksi',
        'catatan',
        'batas_waktu',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'batas_waktu' => 'date',
        ];
    }

    public function suratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function pemberi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diberikan_oleh');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu Tindak Lanjut',
            'ditindaklanjuti' => 'Sedang Ditindaklanjuti',
            'selesai' => 'Selesai',
            default => ucfirst($this->status),
        };
    }
}
