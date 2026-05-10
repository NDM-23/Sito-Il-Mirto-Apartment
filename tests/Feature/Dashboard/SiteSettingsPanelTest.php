<?php

namespace Tests\Feature\Dashboard;

use App\Livewire\Admin\SiteSettingsPanel;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SiteSettingsPanelTest extends TestCase
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

    #[Test]
    public function it_renders_without_errors(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SiteSettingsPanel::class)
            ->assertStatus(200)
            ->assertSee('Impostazioni sito');
    }

    #[Test]
    public function it_mounts_defaults_when_no_settings_exist(): void
    {
        $this->actingAs($this->admin);

        $comp = Livewire::test(SiteSettingsPanel::class);

        // defaults come from SiteSetting::get($key, $default)
        $this->assertEquals('165', $comp->get('default_night_price_eur'));
        $this->assertEquals('85', $comp->get('cleaning_fee_eur'));
        $this->assertTrue($comp->get('tourist_tax_enabled'));
        $this->assertEquals(2, $comp->get('global_min_nights'));
        $this->assertEquals(4, $comp->get('max_guests_adults'));
    }

    #[Test]
    public function it_loads_existing_settings_from_database(): void
    {
        $this->actingAs($this->admin);

        SiteSetting::set('default_night_price_cents', 20000);
        SiteSetting::set('email_contact', 'test@example.com');
        SiteSetting::set('tourist_tax_enabled', false);

        $comp = Livewire::test(SiteSettingsPanel::class);

        $this->assertEquals('200', $comp->get('default_night_price_eur'));
        $this->assertEquals('test@example.com', $comp->get('email_contact'));
        $this->assertFalse($comp->get('tourist_tax_enabled'));
    }

    #[Test]
    public function save_persists_all_settings_to_database(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SiteSettingsPanel::class)
            ->set('default_night_price_eur', '180')
            ->set('cleaning_fee_eur', '90')
            ->set('tourist_tax_enabled', false)
            ->set('global_min_nights', 3)
            ->set('max_guests_adults', 6)
            ->set('email_contact', 'info@mirto.it')
            ->set('whatsapp_e164', '393334567890')
            ->call('save');

        $this->assertEquals(18000, (int) SiteSetting::get('default_night_price_cents'));
        $this->assertEquals(9000, (int) SiteSetting::get('cleaning_fee_cents'));
        $this->assertFalse((bool) SiteSetting::get('tourist_tax_enabled'));
        $this->assertEquals(3, (int) SiteSetting::get('global_min_nights'));
        $this->assertEquals(6, (int) SiteSetting::get('max_guests_adults'));
        $this->assertEquals('info@mirto.it', SiteSetting::get('email_contact'));
        $this->assertEquals('393334567890', SiteSetting::get('whatsapp_e164'));
    }

    #[Test]
    public function save_shows_success_message(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SiteSettingsPanel::class)
            ->call('save')
            ->assertSee('Impostazioni salvate.');
    }

    #[Test]
    public function save_handles_comma_decimal_separator(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SiteSettingsPanel::class)
            ->set('default_night_price_eur', '165,50')
            ->call('save');

        $this->assertEquals(16550, (int) SiteSetting::get('default_night_price_cents'));
    }

    #[Test]
    public function save_trims_whitespace_from_string_fields(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SiteSettingsPanel::class)
            ->set('email_contact', '  info@mirto.it  ')
            ->call('save');

        $this->assertEquals('info@mirto.it', SiteSetting::get('email_contact'));
    }

    #[Test]
    public function settings_cache_is_busted_after_save(): void
    {
        $this->actingAs($this->admin);

        // Warm the cache
        SiteSetting::get('email_contact', 'old@email.it');

        Livewire::test(SiteSettingsPanel::class)
            ->set('email_contact', 'new@email.it')
            ->call('save');

        // Cache should be cleared — fresh read returns the new value
        $this->assertEquals('new@email.it', SiteSetting::get('email_contact'));
    }
}
