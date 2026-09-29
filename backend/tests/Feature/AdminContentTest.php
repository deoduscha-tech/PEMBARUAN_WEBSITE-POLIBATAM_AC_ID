<?php

namespace Tests\Feature;

use App\Support\NewsRepository;
use Tests\TestCase;

class AdminContentTest extends TestCase
{
    protected function admin(): static
    {
        return $this->withSession([
            config('admin.session_key') => [
                'username' => 'admin',
                'name' => 'Administrator P3M',
            ],
        ]);
    }

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_login_page_loads(): void
    {
        $this->get(route('admin.login'))->assertStatus(200);
    }

    public function test_admin_dashboard_loads_when_authenticated(): void
    {
        $this->admin()->get('/admin')->assertStatus(200);
    }

    public function test_admin_news_index_loads_when_authenticated(): void
    {
        $this->admin()->get('/admin/berita')->assertStatus(200);
    }

    public function test_admin_create_form_loads_when_authenticated(): void
    {
        $this->admin()->get('/admin/berita/tambah')->assertStatus(200);
    }

    /**
     * The repository is the single writer for resources/data/berita.php. This
     * round-trips a real post through it and cleans up afterwards so the suite
     * does not leak test rows into the store.
     */
    public function test_repository_can_create_and_delete_a_post(): void
    {
        $news = app(NewsRepository::class);

        $created = $news->create([
            'title' => 'Uji Simpan Berita',
            'category' => 'Pengujian',
            'excerpt' => 'Ringkasan uji.',
            'body' => '<p>Isi uji.</p>',
        ]);

        try {
            $this->assertNotNull($news->find($created['slug']));
        } finally {
            $news->delete((int) $created['id']);
        }

        $this->assertNull($news->find($created['slug']));
    }
}
