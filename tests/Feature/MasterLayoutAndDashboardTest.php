<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class MasterLayoutAndDashboardTest extends TestCase
{
    /**
     * Uji Master Layout Admin TU merender sidebar, topbar, dan modal PDF
     */
    public function test_admin_dashboard_renders_with_admin_master_layout(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('SMEA ARSIP');
        $response->assertSee('Dashboard Administrasi & Kearsipan');
        $response->assertSee('Pencarian Cerdas KMP');
        $response->assertSee('globalPdfModal');
        $response->assertSee($admin->name);
    }

    /**
     * Uji Master Layout Kepala Sekolah merender panel pimpinan dan counter approval
     */
    public function test_kepsek_dashboard_renders_with_kepsek_master_layout(): void
    {
        $kepsek = User::where('role', 'kepala_sekolah')->first();

        $response = $this->actingAs($kepsek)->get('/kepala-sekolah/dashboard');

        $response->assertStatus(200);
        $response->assertSee('EKSEKUTIF');
        $response->assertSee('Panel Eksekutif Kepala Sekolah');
        $response->assertSee('Persetujuan Surat Keluar');
        $response->assertSee('Pengesahan Legalisir');
        $response->assertSee('globalPdfModal');
        $response->assertSee($kepsek->name);
    }

    /**
     * Uji Master Layout Pemohon merender portal mandiri alumni dan tracking berkas
     */
    public function test_pemohon_dashboard_renders_with_pemohon_master_layout(): void
    {
        $pemohon = User::where('role', 'pemohon')->first();

        $response = $this->actingAs($pemohon)->get('/pemohon/dashboard');

        $response->assertStatus(200);
        $response->assertSee('LEGALISIR SMEA');
        $response->assertSee('Portal Layanan Legalisir Alumni');
        $response->assertSee('Ajukan Legalisir Baru');
        $response->assertSee('globalPdfModal');
        $response->assertSee($pemohon->name);
    }

    /**
     * Uji Blade Component Status Badge dan PDF Modal
     */
    public function test_status_badge_component_renders_labels_properly(): void
    {
        $badgeSm = Blade::render('<x-status-badge status="didisposisikan" type="surat_masuk" />');
        $this->assertStringContainsString('Didisposisikan', $badgeSm);

        $badgeLeg = Blade::render('<x-status-badge status="siap_diambil" type="legalisir" />');
        $this->assertStringContainsString('Siap Diambil di TU', $badgeLeg);

        $badgeSk = Blade::render('<x-status-badge status="menunggu_persetujuan" type="surat_keluar" />');
        $this->assertStringContainsString('Menunggu Persetujuan Kepsek', $badgeSk);
    }

    /**
     * Uji Blade Component KMP Highlight
     */
    public function test_kmp_highlight_component_renders_marks(): void
    {
        $rendered = Blade::render('<x-kmp-highlight text="Undangan Rapat Koordinasi UKK 2026" keyword="Koordinasi" />');
        $this->assertStringContainsString('<mark', $rendered);
        $this->assertStringContainsString('Koordinasi</mark>', $rendered);
    }
}
