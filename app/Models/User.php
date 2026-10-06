<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'tipe_pemohon',
        'nip_nisn',
        'phone_number',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Helper Role Checking
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKepalaSekolah(): bool
    {
        return $this->role === 'kepala_sekolah';
    }

    public function isPemohon(): bool
    {
        return $this->role === 'pemohon';
    }

    public function isSiswaAktif(): bool
    {
        return $this->role === 'pemohon' && $this->tipe_pemohon === 'siswa_aktif';
    }

    public function isAlumni(): bool
    {
        return $this->role === 'pemohon' && ($this->tipe_pemohon === 'alumni' || empty($this->tipe_pemohon));
    }

    public function getRoleBadgeAttribute(): string
    {
        if ($this->role === 'pemohon') {
            return $this->tipe_pemohon === 'siswa_aktif' ? 'Siswa Aktif' : 'Alumni';
        }

        return match ($this->role) {
            'admin' => 'Petugas TU',
            'kepala_sekolah' => 'Kepala Sekolah',
            default => 'Pengguna',
        };
    }

    /**
     * Relasi ke entitas lain
     */
    public function suratMasuk(): HasMany
    {
        return $this->hasMany(SuratMasuk::class, 'user_id');
    }

    public function suratKeluar(): HasMany
    {
        return $this->hasMany(SuratKeluar::class, 'user_id');
    }

    public function suratKeluarDisetujui(): HasMany
    {
        return $this->hasMany(SuratKeluar::class, 'disetujui_oleh');
    }

    public function disposisiDiberikan(): HasMany
    {
        return $this->hasMany(DisposisiSuratMasuk::class, 'diberikan_oleh');
    }

    public function pengajuanLegalisir(): HasMany
    {
        return $this->hasMany(PengajuanLegalisir::class, 'user_id');
    }

    public function legalisirDiverifikasi(): HasMany
    {
        return $this->hasMany(PengajuanLegalisir::class, 'petugas_id');
    }

    public function logAktivitas(): HasMany
    {
        return $this->hasMany(LogAktivitas::class, 'user_id');
    }
}
