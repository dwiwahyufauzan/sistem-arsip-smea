<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingAndTrackingTest extends TestCase
{
    /**
     * Uji halaman beranda publik dapat diakses dengan respons 200
     */
    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SMEA ARCHIVE');
        $response->assertSee('Lacak Status Permohonan Legalisir');
        $response->assertSee('SMK Negeri 1 Subang');
    }

    /**
     * Uji pelacakan berkas legalisir menggunakan nomor resi pengajuan
     */
    public function test_public_tracking_finds_valid_pengajuan_by_nomor_pengajuan(): void
    {
        $response = $this->get('/?nomor_pengajuan=LEG-202609-0001');

        $response->assertStatus(200);
        $response->assertSee('LEG-202609-0001');
        $response->assertSee('Ridwan Kurniawan');
        $response->assertSee('Histori Pelacakan Berkas');
    }

    /**
     * Uji pelacakan berkas legalisir menggunakan NISN
     */
    public function test_public_tracking_finds_valid_pengajuan_by_nisn(): void
    {
        $response = $this->get('/?nomor_pengajuan=0045892134');

        $response->assertStatus(200);
        $response->assertSee('LEG-202609-0001');
        $response->assertSee('Ridwan Kurniawan');
    }

    /**
     * Uji penanganan ketika nomor resi tidak ditemukan
     */
    public function test_public_tracking_shows_not_found_message_for_invalid_query(): void
    {
        $response = $this->get('/?nomor_pengajuan=INVALID-RESI-9999');

        $response->assertStatus(200);
        $response->assertSee('Data Permohonan Tidak Ditemukan');
    }
}
