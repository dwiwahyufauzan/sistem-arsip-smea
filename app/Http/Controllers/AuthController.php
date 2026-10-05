<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Menampilkan formulir login
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    /**
     * Memproses autentikasi pengguna
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            LogAktivitas::catat(
                'LOGIN',
                'AUTH',
                "Pengguna {$user->name} ({$user->role_badge}) berhasil masuk ke sistem."
            );

            return $this->redirectBasedOnRole($user->role)
                ->with('success', "Selamat datang kembali, {$user->name}!");
        }

        return back()->withErrors([
            'email' => 'Kombinasi email dan kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan informasi kebijakan pendaftaran akun pemohon
     * (Pendaftaran mandiri dinonaktifkan: akun siswa dan alumni dikelola terpusat oleh Admin TU)
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        return view('auth.register');
    }

    /**
     * Memproses pendaftaran pemohon baru
     * (Registrasi mandiri dinonaktifkan: diarahkan kembali dengan notifikasi resmi)
     */
    public function register(Request $request): RedirectResponse
    {
        return redirect()->route('login')->with('warning', 'Pendaftaran akun mandiri dinonaktifkan. Akun siswa dan alumni didaftarkan secara resmi oleh Admin Tata Usaha SMKN 1 Subang. Untuk mengajukan legalisir tanpa akun, silakan gunakan formulir Pengajuan Legalisir Mandiri.');
    }

    /**
     * Memproses logout
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            LogAktivitas::catat(
                'LOGOUT',
                'AUTH',
                "Pengguna {$user->name} berhasil keluar dari sesi sistem."
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem kearsipan.');
    }

    /**
     * Pengalihan rute dinamis berdasarkan peran pengguna
     */
    protected function redirectBasedOnRole(string $role): RedirectResponse
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'kepala_sekolah' => redirect()->route('kepsek.dashboard'),
            'pemohon' => redirect()->route('pemohon.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
