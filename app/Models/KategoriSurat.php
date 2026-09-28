<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSurat extends Model
{
    use HasFactory;

    protected $table = 'kategori_surat';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi',
    ];

    public function suratMasuk(): HasMany
    {
        return $this->hasMany(SuratMasuk::class, 'kategori_id');
    }

    public function suratKeluar(): HasMany
    {
        return $this->hasMany(SuratKeluar::class, 'kategori_id');
    }
}
