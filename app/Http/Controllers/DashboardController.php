<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Petugas Tata Usaha / Admin
     */
    public function admin(): View
    {
        return view('admin.dashboard');
    }

    /**
     * Tampilkan Dashboard Kepala Sekolah
     */
    public function kepsek(): View
    {
        return view('kepsek.dashboard');
    }

    /**
     * Tampilkan Dashboard Pemohon Mandiri (Siswa / Alumni)
     */
    public function pemohon(): View
    {
        return view('pemohon.dashboard');
    }

    /**
     * Alihkan pemohon yang membuka URL create di namespace pemohon
     */
    public function redirectCreate(): RedirectResponse
    {
        return redirect()->route('legalisir.create');
    }
}
