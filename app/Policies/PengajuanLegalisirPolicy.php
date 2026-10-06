<?php

namespace App\Policies;

use App\Models\PengajuanLegalisir;
use App\Models\User;

class PengajuanLegalisirPolicy
{
    /**
     * Tentukan apakah pengguna dapat melihat detail permohonan.
     */
    public function view(User $user, PengajuanLegalisir $legalisir): bool
    {
        if ($user->isAdmin() || $user->isKepalaSekolah()) {
            return true;
        }

        if ($user->isPemohon()) {
            return $user->id === $legalisir->user_id
                || $user->email === $legalisir->email
                || (! empty($user->nip_nisn) && $user->nip_nisn === $legalisir->nisn);
        }

        return false;
    }

    /**
     * Tentukan apakah pengguna dapat mengunduh berkas fisik permohonan.
     */
    public function download(User $user, PengajuanLegalisir $legalisir): bool
    {
        return $this->view($user, $legalisir);
    }
}
