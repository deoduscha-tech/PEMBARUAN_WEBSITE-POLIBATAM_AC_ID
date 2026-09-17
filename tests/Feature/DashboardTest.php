<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_dashboard_page_loads(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(200)
            ->assertSee('P2M Polibatam')
            ->assertSee('data-page="home"', false);
    }

    public function test_public_pages_have_route_specific_state(): void
    {
        $this->get('/profil')
            ->assertStatus(200)
            ->assertSee('data-page="profil"', false);

        $this->get('/informasi')
            ->assertStatus(200)
            ->assertSee('data-page="informasi"', false);

        $this->get('/publikasi')
            ->assertStatus(200)
            ->assertSee('data-page="publikasi"', false);

        $this->get('/hki')
            ->assertStatus(200)
            ->assertSee('data-page="hki"', false);

        $this->get('/statistik')
            ->assertStatus(200)
            ->assertSee('data-page="statistik"', false);

        $this->get('/berdampak')
            ->assertStatus(200)
            ->assertSee('data-page="berdampak"', false);

        $response = $this->get('/dashboard');
        $response->assertSee('id="search-panel"', false)
            ->assertSee('id="global-search-input"', false);
    }
}
