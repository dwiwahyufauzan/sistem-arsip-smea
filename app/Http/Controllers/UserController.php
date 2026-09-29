<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan daftar seluruh akun pengguna sistem kearsipan
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('q', ''));
        $selectedRole = trim((string) $request->input('role', ''));

        $query = User::query()->orderBy('name', 'asc');

        if ($selectedRole !== '' && in_array($selectedRole, ['admin', 'kepala_sekolah', 'pemohon'])) {
            $query->where('role', $selectedRole);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nip_nisn', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();

        $roleCounts = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'kepala_sekolah' => User::where('role', 'kepala_sekolah')->count(),
            'pemohon' => User::where('role', 'pemohon')->count(),
        ];

        return view('admin.pengguna.index', compact('users', 'selectedRole', 'search', 'roleCounts'));
    }

    /**
     * Menyimpan akun pengguna baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'role' => ['required', 'in:admin,kepala_sekolah,pemohon'],
            'nip_nisn' => ['nullable', 'string', 'max:50'],
            'phone_number' => ['nullable', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'role.required' => 'Peran hak akses wajib dipilih.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'nip_nisn' => $validated['nip_nisn'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        LogAktivitas::catat(
            'TAMBAH_PENGGUNA',
            'PENGGUNA',
            "Menambahkan akun pengguna baru: {$user->name} ({$user->role_badge} - {$user->email})"
        );

        return redirect()->route('admin.pengguna.index')
            ->with('success', "Pengguna {$user->name} ({$user->role_badge}) berhasil didaftarkan ke sistem.");
    }

    /**
     * Memperbarui informasi akun pengguna
     */
    public function update(Request $request, User $pengguna): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email,'.$pengguna->id],
            'role' => ['required', 'in:admin,kepala_sekolah,pemohon'],
            'nip_nisn' => ['nullable', 'string', 'max:50'],
            'phone_number' => ['nullable', 'string', 'max:25'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'role.required' => 'Peran hak akses wajib dipilih.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Cegah admin aktif menurunkan perannya sendiri
        if ($pengguna->id === Auth::id() && $validated['role'] !== 'admin') {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Anda tidak dapat mengubah peran akun Anda sendiri saat sedang masuk sebagai Administrator.');
        }

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'nip_nisn' => $validated['nip_nisn'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $pengguna->update($updateData);

        LogAktivitas::catat(
            'UBAH_PENGGUNA',
            'PENGGUNA',
            "Memperbarui data akun pengguna: {$pengguna->name} ({$pengguna->role_badge})"
        );

        return redirect()->route('admin.pengguna.index')
            ->with('success', "Data pengguna {$pengguna->name} berhasil diperbarui.");
    }

    /**
     * Menghapus akun pengguna dari sistem
     */
    public function destroy(User $pengguna): RedirectResponse
    {
        // Proteksi 1: Tidak boleh menghapus akun yang sedang aktif digunakan login
        if ($pengguna->id === Auth::id()) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        // Proteksi 2: Integritas kearsipan
        $suratCount = $pengguna->suratMasuk()->count() + $pengguna->suratKeluar()->count();
        if ($suratCount > 0) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', "Pengguna {$pengguna->name} tidak dapat dihapus karena tercatat sebagai pembuat/pencatat pada {$suratCount} dokumen arsip.");
        }

        $nama = $pengguna->name;
        $pengguna->delete();

        LogAktivitas::catat(
            'HAPUS_PENGGUNA',
            'PENGGUNA',
            "Menghapus akun pengguna: {$nama}"
        );

        return redirect()->route('admin.pengguna.index')
            ->with('success', "Akun pengguna {$nama} berhasil dihapus dari sistem.");
    }
}
