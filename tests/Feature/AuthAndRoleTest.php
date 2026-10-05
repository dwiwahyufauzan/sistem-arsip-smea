<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthAndRoleTest extends TestCase
{
    /**
     * Test halaman login dapat dimuat
     */
    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('SISTEM ARSIP SMEA');
    }

    /**
     * Test admin login diarahkan ke /admin/dashboard
     */
    public function test_admin_can_login_and_redirect_to_admin_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'petugas@smkn1subang.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Test kepala sekolah login diarahkan ke /kepala-sekolah/dashboard
     */
    public function test_kepsek_can_login_and_redirect_to_kepsek_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'kepsek@smkn1subang.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/kepala-sekolah/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Test pemohon login diarahkan ke /pemohon/dashboard
     */
    public function test_pemohon_can_login_and_redirect_to_pemohon_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'alumni@smkn1subang.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/pemohon/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Test pemohon dilarang mengakses rute admin (RBAC protection)
     */
    public function test_pemohon_cannot_access_admin_dashboard(): void
    {
        $pemohon = User::where('email', 'alumni@smkn1subang.sch.id')->first();

        $response = $this->actingAs($pemohon)->get('/admin/dashboard');
        // RoleMiddleware redirects unauthorized role back to their dashboard with error flash
        $response->assertRedirect('/pemohon/dashboard');
    }

    /**
     * Test tamu yang belum login dicegah mengakses dashboard
     */
    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test pendaftaran akun mandiri dinonaktifkan dan diarahkan ke login dengan notifikasi
     */
    public function test_public_registration_is_disabled_and_redirects_with_notice(): void
    {
        $response = $this->post('/register', [
            'name' => 'Siswa Baru',
            'email' => 'siswa.baru@test.com',
            'nisn' => '0098765432',
            'phone_number' => '081234567800',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('warning');
        $this->assertGuest();
    }

    /**
     * Test Admin Tata Usaha dapat mendaftarkan akun pemohon (siswa/alumni)
     */
    public function test_admin_can_register_pemohon_account(): void
    {
        $admin = User::where('role', 'admin')->first();
        $email = 'alumni.terdaftar.'.time().'@smkn1subang.sch.id';

        $response = $this->actingAs($admin)->post('/admin/pengguna', [
            'name' => 'Alumni Baru Terdaftar',
            'email' => $email,
            'role' => 'pemohon',
            'nip_nisn' => '0054321678',
            'phone_number' => '085711223344',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/admin/pengguna');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => 'pemohon',
            'nip_nisn' => '0054321678',
        ]);
    }
}
