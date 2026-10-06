<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatLegalisir extends Model
{
    use HasFactory;

    protected $table = 'riwayat_legalisir';

    public $timestamps = false;

    protected $fillable = [
        'pengajuan_legalisir_id',
        'status_sebelumnya',
        'status_baru',
        'diubah_oleh',
        'catatan',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanLegalisir::class, 'pengajuan_legalisir_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diubah_oleh')->withDefault([
            'name' => 'Sistem / Pemohon Mandiri',
        ]);
    }
}
