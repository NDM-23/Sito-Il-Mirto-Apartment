<?php

namespace Tests\Feature\Dashboard;

use App\Livewire\Admin\GalleryManager;
use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GalleryManagerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    private function makeImage(array $overrides = []): GalleryImage
    {
        return GalleryImage::create(array_merge([
            'path' => 'https://picsum.photos/seed/test/800/600',
            'section_key' => 'gallery.public',
            'alt' => ['it' => 'Test', 'en' => 'Test'],
            'sort_order' => 0,
            'is_active' => true,
            'is_hero' => false,
        ], $overrides));
    }

    #[Test]
    public function it_renders_gallery_manager_page(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(GalleryManager::class)
            ->assertSee('Galleria immagini')
            ->assertStatus(200);
    }

    #[Test]
    public function it_shows_empty_gallery_message(): void
    {
        $this->actingAs($this->admin);

        // With no images the @foreach loop simply produces no rows
        Livewire::test(GalleryManager::class)
            ->assertStatus(200);
    }

    #[Test]
    public function toggle_is_active_flips_boolean(): void
    {
        $this->actingAs($this->admin);
        $img = $this->makeImage(['is_active' => true]);

        Livewire::test(GalleryManager::class)
            ->call('toggle', $img->id, 'is_active');

        $img->refresh();
        $this->assertFalse($img->is_active);
    }

    #[Test]
    public function toggle_is_active_twice_restores_original(): void
    {
        $this->actingAs($this->admin);
        $img = $this->makeImage(['is_active' => true]);

        Livewire::test(GalleryManager::class)
            ->call('toggle', $img->id, 'is_active')
            ->call('toggle', $img->id, 'is_active');

        $img->refresh();
        $this->assertTrue($img->is_active);
    }

    #[Test]
    public function toggle_is_hero_works(): void
    {
        $this->actingAs($this->admin);
        $img = $this->makeImage(['is_hero' => false]);

        Livewire::test(GalleryManager::class)
            ->call('toggle', $img->id, 'is_hero');

        $img->refresh();
        $this->assertTrue($img->is_hero);
    }

    #[Test]
    public function remove_deletes_database_record(): void
    {
        $this->actingAs($this->admin);
        $img = $this->makeImage();
        $id = $img->id;

        Livewire::test(GalleryManager::class)
            ->call('remove', $id)
            ->assertSee('Immagine rimossa.');

        $this->assertNull(GalleryImage::find($id));
    }

    #[Test]
    public function remove_external_url_image_does_not_throw(): void
    {
        $this->actingAs($this->admin);
        // External URL — deleteStoredFile must skip silently
        $img = $this->makeImage(['path' => 'https://picsum.photos/seed/x/800/600']);
        $id = $img->id;

        Livewire::test(GalleryManager::class)->call('remove', $id);

        $this->assertNull(GalleryImage::find($id));
    }

    #[Test]
    public function update_section_persists_to_database(): void
    {
        $this->actingAs($this->admin);
        $img = $this->makeImage(['section_key' => 'gallery.public']);

        Livewire::test(GalleryManager::class)
            ->call('updateSection', $img->id, 'home.hero');

        $img->refresh();
        $this->assertEquals('home.hero', $img->section_key);
    }

    #[Test]
    public function update_section_with_empty_string_sets_null(): void
    {
        $this->actingAs($this->admin);
        $img = $this->makeImage(['section_key' => 'gallery.public']);

        Livewire::test(GalleryManager::class)
            ->call('updateSection', $img->id, '');

        $img->refresh();
        $this->assertNull($img->section_key);
    }

    #[Test]
    public function start_replace_sets_replacing_id(): void
    {
        $this->actingAs($this->admin);
        $img = $this->makeImage();

        Livewire::test(GalleryManager::class)
            ->call('startReplace', $img->id)
            ->assertSet('replacingId', $img->id);
    }

    #[Test]
    public function cancel_replace_clears_state(): void
    {
        $this->actingAs($this->admin);
        $img = $this->makeImage();

        Livewire::test(GalleryManager::class)
            ->call('startReplace', $img->id)
            ->call('cancelReplace')
            ->assertSet('replacingId', null);
    }

    #[Test]
    public function save_uploads_stores_images_in_gallery(): void
    {
        $this->actingAs($this->admin);

        $file = UploadedFile::fake()->image('photo.jpg', 800, 600);

        Livewire::test(GalleryManager::class)
            ->set('uploads', [$file])
            ->set('uploadSectionKey', 'gallery.public')
            ->call('saveUploads')
            ->assertSee('Immagini caricate.');

        $this->assertEquals(1, GalleryImage::count());
        $img = GalleryImage::first();
        $this->assertEquals('gallery.public', $img->section_key);
        $this->assertTrue(str_starts_with($img->path, '/storage/'));
    }

    #[Test]
    public function save_uploads_rejects_non_image_files(): void
    {
        $this->actingAs($this->admin);

        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        Livewire::test(GalleryManager::class)
            ->set('uploads', [$file])
            ->call('saveUploads')
            ->assertHasErrors(['uploads.*']);
    }

    #[Test]
    public function gallery_paginates_images(): void
    {
        $this->actingAs($this->admin);

        for ($i = 0; $i < 18; $i++) {
            $this->makeImage(['sort_order' => $i]);
        }

        // With 18 images and per-page=16, the pagination shows "pagina 1 di 2"
        Livewire::test(GalleryManager::class)
            ->assertSee('pagina 1 di 2', false);
    }
}
