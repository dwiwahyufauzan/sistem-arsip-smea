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
     * Test pemohon baru dapat mendaftar akun
     */
    public function test_new_pemohon_can_register(): void
    {
        $uniqueEmail = 'alumni.'.time().'@test.com';
        $response = $this->post('/register', [
            'name' => 'Siswa Baru',
            'email' => $uniqueEmail,
            'nisn' => '0098765432',
            'phone_number' => '081234567800',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/pemohon/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => $uniqueEmail,
            'role' => 'pemohon',
        ]);
    }
}
