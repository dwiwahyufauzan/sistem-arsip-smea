<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir pengaturan profil dan kata sandi
     */
    public function edit(): View
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Memperbarui informasi profil pengguna yang sedang login
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email,'.$user->id],
            'phone_number' => ['nullable', 'string', 'max:25'],
            'nip_nisn' => ['nullable', 'string', 'max:50'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Alamat email ini sudah terdaftar oleh pengguna lain.',
        ]);

        $user->update($validated);

        LogAktivitas::catat(
            'UBAH_PROFIL',
            'PROFIL',
            "Pengguna {$user->name} memperbarui informasi biodata profil mandiri."
        );

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Memperbarui kata sandi akun
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini tidak sesuai.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        LogAktivitas::catat(
            'UBAH_PASSWORD',
            'PROFIL',
            "Pengguna {$user->name} berhasil mengubah kata sandi akun."
        );

        return back()->with('success', 'Kata sandi Anda berhasil diperbarui.');
    }
}
