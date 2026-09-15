<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_dashboard_page_loads(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(200)
            ->assertSee('P2M Polibatam');
    }
}
