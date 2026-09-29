<?php

namespace Tests\Feature;

use App\Models\KategoriSurat;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    /**
     * Uji Admin TU dapat mengakses halaman master kategori surat
     */
    public function test_admin_can_view_kategori_index_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/kategori');

        $response->assertStatus(200);
        $response->assertSee('Master Klasifikasi Kategori Surat');
        $response->assertSee('Tambah Kategori');
    }

    /**
     * Uji pengguna non-admin (misal: Pemohon) ditolak mengakses master kategori
     */
    public function test_non_admin_cannot_access_kategori_page(): void
    {
        $pemohon = User::where('role', 'pemohon')->first();

        $response = $this->actingAs($pemohon)->get('/admin/kategori');

        $response->assertRedirect('/pemohon/dashboard');
        $response->assertSessionHas('error');
    }

    /**
     * Uji Admin TU dapat menambahkan kategori klasifikasi surat baru
     */
    public function test_admin_can_create_new_kategori(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/kategori', [
            'kode_kategori' => '421.5/KEU',
            'nama_kategori' => 'Keuangan & Anggaran Sekolah',
            'deskripsi' => 'Pengelolaan SPP, BOS, dan administrasi keuangan',
        ]);

        $response->assertRedirect('/admin/kategori');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kategori_surat', [
            'kode_kategori' => '421.5/KEU',
            'nama_kategori' => 'Keuangan & Anggaran Sekolah',
        ]);
    }

    /**
     * Uji validasi kode kategori harus unik
     */
    public function test_create_kategori_validates_unique_kode(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/kategori', [
            'kode_kategori' => '421.5/KUR', // Kode sudah ada dari seeder
            'nama_kategori' => 'Kurikulum Duplikat',
        ]);

        $response->assertSessionHasErrors('kode_kategori');
    }

    /**
     * Uji Admin dapat memperbarui kategori surat
     */
    public function test_admin_can_update_kategori(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::where('kode_kategori', '421.5/KEU')->first();

        $response = $this->actingAs($admin)->put('/admin/kategori/'.$kategori->id, [
            'kode_kategori' => '421.5/KEU-REV',
            'nama_kategori' => 'Keuangan & Anggaran Sekolah Terpadu',
            'deskripsi' => 'Revisi deskripsi kategori',
        ]);

        $response->assertRedirect('/admin/kategori');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kategori_surat', [
            'id' => $kategori->id,
            'kode_kategori' => '421.5/KEU-REV',
        ]);
    }

    /**
     * Uji proteksi: Kategori yang sedang digunakan oleh surat tidak boleh dihapus
     */
    public function test_admin_cannot_delete_kategori_that_is_in_use(): void
    {
        $admin = User::where('role', 'admin')->first();
        // Kategori 421.5/KUR digunakan oleh surat masuk di seeder
        $kategoriUsed = KategoriSurat::where('kode_kategori', '421.5/KUR')->first();

        $response = $this->actingAs($admin)->delete('/admin/kategori/'.$kategoriUsed->id);

        $response->assertRedirect('/admin/kategori');
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('kategori_surat', ['id' => $kategoriUsed->id]);
    }

    /**
     * Uji Admin dapat menghapus kategori yang tidak digunakan
     */
    public function test_admin_can_delete_unused_kategori(): void
    {
        $admin = User::where('role', 'admin')->first();
        $kategori = KategoriSurat::where('kode_kategori', '421.5/KEU-REV')->first();

        $response = $this->actingAs($admin)->delete('/admin/kategori/'.$kategori->id);

        $response->assertRedirect('/admin/kategori');
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('kategori_surat', ['id' => $kategori->id]);
    }

    /**
     * Uji Admin dapat mengakses halaman manajemen pengguna
     */
    public function test_admin_can_view_user_management_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/pengguna');

        $response->assertStatus(200);
        $response->assertSee('Manajemen Pengguna Sistem');
        $response->assertSee('Tambah Pengguna');
    }

    /**
     * Uji Admin dapat mendaftarkan akun pengguna baru
     */
    public function test_admin_can_create_new_user(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/pengguna', [
            'name' => 'Staf Tata Usaha Baru',
            'email' => 'staf.baru@smkn1subang.sch.id',
            'role' => 'admin',
            'nip_nisn' => '199001012020011005',
            'phone_number' => '081299887766',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/admin/pengguna');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'staf.baru@smkn1subang.sch.id',
            'role' => 'admin',
        ]);
    }

    /**
     * Uji Admin dapat mengubah data profil pengguna
     */
    public function test_admin_can_update_user(): void
    {
        $admin = User::where('role', 'admin')->first();
        $targetUser = User::where('email', 'staf.baru@smkn1subang.sch.id')->first();

        $response = $this->actingAs($admin)->put('/admin/pengguna/'.$targetUser->id, [
            'name' => 'Staf Tata Usaha Senior',
            'email' => 'staf.baru@smkn1subang.sch.id',
            'role' => 'admin',
            'nip_nisn' => '199001012020011005',
            'phone_number' => '081299881111',
        ]);

        $response->assertRedirect('/admin/pengguna');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'name' => 'Staf Tata Usaha Senior',
            'phone_number' => '081299881111',
        ]);
    }

    /**
     * Uji Admin tidak boleh menghapus akunnya sendiri yang sedang aktif
     */
    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->delete('/admin/pengguna/'.$admin->id);

        $response->assertRedirect('/admin/pengguna');
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    /**
     * Uji Admin dapat menghapus pengguna tanpa keterkaitan arsip
     */
    public function test_admin_can_delete_user_without_archives(): void
    {
        $admin = User::where('role', 'admin')->first();
        $targetUser = User::where('email', 'staf.baru@smkn1subang.sch.id')->first();

        $response = $this->actingAs($admin)->delete('/admin/pengguna/'.$targetUser->id);

        $response->assertRedirect('/admin/pengguna');
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    /**
     * Uji seluruh pengguna dapat mengakses halaman pengaturan profil mandiri
     */
    public function test_authenticated_user_can_view_profile_page(): void
    {
        $pemohon = User::where('role', 'pemohon')->first();

        $response = $this->actingAs($pemohon)->get('/profil');

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Akun & Profil');
        $response->assertSee('Informasi Pribadi');
        $response->assertSee('Perbarui Kata Sandi');
    }

    /**
     * Uji pengguna dapat memperbarui data profil mandiri
     */
    public function test_authenticated_user_can_update_profile_info(): void
    {
        $pemohon = User::where('role', 'pemohon')->first();

        $response = $this->actingAs($pemohon)->put('/profil', [
            'name' => 'Ridwan Kurniawan Alumni Update',
            'email' => $pemohon->email,
            'phone_number' => '085799998888',
            'nip_nisn' => $pemohon->nip_nisn,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $pemohon->id,
            'name' => 'Ridwan Kurniawan Alumni Update',
            'phone_number' => '085799998888',
        ]);
    }

    /**
     * Uji pengguna dapat memperbarui kata sandi dengan kata sandi lama yang benar
     */
    public function test_authenticated_user_can_update_password(): void
    {
        $pemohon = User::where('role', 'pemohon')->first();

        $response = $this->actingAs($pemohon)->put('/profil/password', [
            'current_password' => 'password',
            'password' => 'newsecretpass123',
            'password_confirmation' => 'newsecretpass123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $pemohon->refresh();
        $this->assertTrue(Hash::check('newsecretpass123', $pemohon->password));

        // Kembalikan ke password default agar tidak mengganggu test lainnya
        $pemohon->update(['password' => Hash::make('password')]);
    }
}
