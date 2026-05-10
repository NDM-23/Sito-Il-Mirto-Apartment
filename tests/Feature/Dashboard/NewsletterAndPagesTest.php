<?php

namespace Tests\Feature\Dashboard;

use App\Livewire\Admin\NewsletterTable;
use App\Livewire\Admin\PageVisibilityPanel;
use App\Models\NewsletterSubscriber;
use App\Models\PageVisibility;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class NewsletterAndPagesTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    /* ═══════════════════════════ NewsletterTable ═══════════════════════════ */

    #[Test]
    public function newsletter_renders_empty_state(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(NewsletterTable::class)
            ->assertSee('Nessun iscritto.');
    }

    #[Test]
    public function newsletter_shows_subscriber_rows(): void
    {
        $this->actingAs($this->admin);

        NewsletterSubscriber::create([
            'email' => 'mario@example.it',
            'locale' => 'it',
            'marketing_consent' => true,
        ]);

        Livewire::test(NewsletterTable::class)
            ->assertSee('mario@example.it')
            ->assertSee('it')
            ->assertSee('sì');
    }

    #[Test]
    public function newsletter_shows_unconfirmed_subscribers(): void
    {
        $this->actingAs($this->admin);

        NewsletterSubscriber::create([
            'email' => 'notconfirmed@example.it',
            'locale' => 'it',
            'confirmed_at' => null,
            'marketing_consent' => false,
        ]);

        Livewire::test(NewsletterTable::class)
            ->assertSee('notconfirmed@example.it')
            ->assertSee('—'); // confirmed_at = null shows em-dash
    }

    #[Test]
    public function newsletter_shows_confirmed_date(): void
    {
        $this->actingAs($this->admin);

        NewsletterSubscriber::create([
            'email' => 'confirmed@example.it',
            'locale' => 'en',
            'confirmed_at' => '2026-03-15 10:30:00',
            'marketing_consent' => false,
        ]);

        Livewire::test(NewsletterTable::class)
            ->assertSee('2026-03-15');
    }

    #[Test]
    public function newsletter_paginates_with_more_than_thirty_records(): void
    {
        $this->actingAs($this->admin);

        for ($i = 1; $i <= 35; $i++) {
            NewsletterSubscriber::create([
                'email' => "sub{$i}@example.com",
                'locale' => 'it',
            ]);
        }

        // Only first 30 per page — row 35 shows latest (ordered by id desc)
        Livewire::test(NewsletterTable::class)
            ->assertSee('sub35@example.com')
            ->assertDontSee('sub1@example.com');
    }

    /* ══════════════════════════ PageVisibilityPanel ════════════════════════ */

    #[Test]
    public function pages_panel_renders(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PageVisibilityPanel::class)
            ->assertSee('Visibilità pagine')
            ->assertSee('Recensioni pubbliche')
            ->assertSee('Blog');
    }

    #[Test]
    public function pages_panel_mounts_defaults(): void
    {
        $this->actingAs($this->admin);

        $comp = Livewire::test(PageVisibilityPanel::class);
        $pages = $comp->get('pages');

        $this->assertTrue($pages['reviews']); // default = visible
        $this->assertFalse($pages['blog']);   // default = hidden
    }

    #[Test]
    public function pages_panel_loads_from_database(): void
    {
        $this->actingAs($this->admin);

        PageVisibility::create(['slug' => 'reviews', 'is_visible' => false, 'sort_order' => 0]);
        PageVisibility::create(['slug' => 'blog', 'is_visible' => true, 'sort_order' => 1]);

        $comp = Livewire::test(PageVisibilityPanel::class);
        $pages = $comp->get('pages');

        $this->assertFalse($pages['reviews']);
        $this->assertTrue($pages['blog']);
    }

    #[Test]
    public function pages_panel_save_persists_visibility(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PageVisibilityPanel::class)
            ->set('pages.reviews', false)
            ->set('pages.blog', true)
            ->call('save')
            ->assertSee('Visibilità pagine aggiornata.');

        $reviews = PageVisibility::where('slug', 'reviews')->first();
        $blog    = PageVisibility::where('slug', 'blog')->first();

        $this->assertNotNull($reviews);
        $this->assertFalse((bool) $reviews->is_visible);

        $this->assertNotNull($blog);
        $this->assertTrue((bool) $blog->is_visible);
    }

    #[Test]
    public function pages_panel_save_clears_cache(): void
    {
        $this->actingAs($this->admin);

        // Warm cache with default values
        PageVisibility::isVisible('reviews');
        PageVisibility::isVisible('blog');

        // Change via panel
        Livewire::test(PageVisibilityPanel::class)
            ->set('pages.reviews', false)
            ->call('save');

        // Cache should be invalidated — fresh read from DB
        $this->assertFalse(PageVisibility::isVisible('reviews'));
    }

    #[Test]
    public function pages_panel_upserts_on_repeated_saves(): void
    {
        $this->actingAs($this->admin);

        // First save
        Livewire::test(PageVisibilityPanel::class)
            ->set('pages.reviews', true)
            ->call('save');

        // Second save with different value
        Livewire::test(PageVisibilityPanel::class)
            ->set('pages.reviews', false)
            ->call('save');

        // Should be exactly one record, not two
        $this->assertEquals(1, PageVisibility::where('slug', 'reviews')->count());
        $this->assertFalse((bool) PageVisibility::where('slug', 'reviews')->value('is_visible'));
    }
}
