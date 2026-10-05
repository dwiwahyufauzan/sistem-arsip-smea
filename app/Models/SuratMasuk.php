<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_terima',
        'pengirim',
        'penerima',
        'perihal',
        'isi_ringkas',
        'kategori_id',
        'file_path',
        'file_name',
        'file_size',
        'status',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'tanggal_terima' => 'date',
            'file_size' => 'integer',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function disposisi(): HasMany
    {
        return $this->hasMany(DisposisiSuratMasuk::class, 'surat_masuk_id');
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }

        return number_format($bytes / 1024, 2).' KB';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'diterima' => 'Diterima',
            'didisposisikan' => 'Didisposisikan',
            'diarsipkan' => 'Diarsipkan',
            default => ucfirst($this->status),
        };
    }
}
