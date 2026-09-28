<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
     * Menampilkan formulir registrasi khusus pemohon / alumni
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
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'nisn' => ['required', 'string', 'max:30'],
            'phone_number' => ['required', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'nisn.required' => 'NISN wajib diisi untuk verifikasi kelulusan.',
            'phone_number.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pemohon',
            'nip_nisn' => $validated['nisn'],
            'phone_number' => $validated['phone_number'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        LogAktivitas::catat(
            'REGISTER',
            'AUTH',
            "Pemohon baru {$user->name} berhasil mendaftar akun layanan legalisir."
        );

        return redirect()->route('pemohon.dashboard')
            ->with('success', 'Akun permohonan berhasil didaftarkan. Selamat datang di Portal Layanan SMKN 1 Subang!');
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
