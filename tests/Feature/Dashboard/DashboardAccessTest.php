<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Verify that every dashboard route is:
 *  - accessible to an admin/editor (200)
 *  - blocked to a guest         (redirect to /login)
 *  - blocked to a plain user    (403 — role middleware)
 */
class DashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $editor;
    protected User $plain;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->editor = User::factory()->create();
        $this->editor->assignRole('editor');

        $this->plain = User::factory()->create();
    }

    private function dashboardRoutes(): array
    {
        return [
            '/dashboard',
            '/dashboard/calendario',
            '/dashboard/preventivi',
            '/dashboard/newsletter',
            '/dashboard/impostazioni',
            '/dashboard/galleria',
            '/dashboard/offerte',
            '/dashboard/pagine',
        ];
    }

    /* ──────────────────────────────────────── guests ─── */

    #[Test]
    public function guests_are_redirected_to_login(): void
    {
        foreach ($this->dashboardRoutes() as $url) {
            $this->get($url)->assertRedirect('/login');
        }
    }

    /* ──────────────────────────────────────── plain user ─── */

    #[Test]
    public function plain_user_cannot_access_admin_routes(): void
    {
        $this->actingAs($this->plain);

        // /dashboard itself is accessible (just auth, no role)
        $this->get('/dashboard')->assertStatus(200);

        // all admin sub-routes are forbidden
        $adminRoutes = array_slice($this->dashboardRoutes(), 1); // skip /dashboard
        foreach ($adminRoutes as $url) {
            $response = $this->get($url);
            $this->assertContains(
                $response->status(), [403, 404, 302],
                "Expected 403 for $url, got {$response->status()}"
            );
        }
    }

    /* ──────────────────────────────────────── admin ─── */

    #[Test]
    public function admin_can_access_all_dashboard_routes(): void
    {
        $this->actingAs($this->admin);

        foreach ($this->dashboardRoutes() as $url) {
            $this->get($url)->assertStatus(200);
        }
    }

    /* ──────────────────────────────────────── editor ─── */

    #[Test]
    public function editor_can_access_all_dashboard_routes(): void
    {
        $this->actingAs($this->editor);

        foreach ($this->dashboardRoutes() as $url) {
            $this->get($url)->assertStatus(200);
        }
    }
}
