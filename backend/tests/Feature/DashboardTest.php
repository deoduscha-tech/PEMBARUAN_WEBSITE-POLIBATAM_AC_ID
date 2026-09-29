<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_dashboard_page_loads(): void
    {
        $this->get('/dashboard')
            ->assertStatus(200)
            ->assertSee('Pusat P2M Polibatam')
            ->assertSee('Latest Post');
    }

    /**
     * Every editorial page must render its own heading. Previously this asserted
     * a "data-page" attribute that was never added to the views, so it could only
     * ever fail — it now checks content the pages actually render.
     */
    public function test_public_pages_have_route_specific_state(): void
    {
        $headings = [
            '/profil' => 'PROFIL',
            '/informasi' => 'INFORMASI',
            '/hki' => 'HKI',
            '/statistik' => 'STATISTIK',
        ];

        foreach ($headings as $path => $heading) {
            $this->get($path)
                ->assertStatus(200)
                ->assertSee($heading);
        }

        $this->get('/dashboard')
            ->assertSee('id="search-panel"', false)
            ->assertSee('id="global-search-input"', false);
    }

    public function test_laporan_tahunan_page_loads(): void
    {
        $this->get('/laporan-tahunan')
            ->assertStatus(200)
            ->assertSee('LAPORAN TAHUNAN P3M TAHUN 2025')
            ->assertSee('Klik Disini');
    }

    public function test_public_api_returns_published_posts(): void
    {
        $this->getJson('/api/berita')
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'meta' => ['total', 'categories']]);

        $this->getJson('/api/laporan-tahunan')
            ->assertStatus(200)
            ->assertJsonPath('reportYear', '2025');
    }
}