<?php

namespace Tests\Feature\Dashboard;

use App\Livewire\Admin\PromotionsManager;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PromotionsManagerTest extends TestCase
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

    private function makePromotion(array $overrides = []): Promotion
    {
        return Promotion::create(array_merge([
            'code'           => 'TEST'.rand(1000, 9999),
            'name'           => 'Test promo',
            'discount_type'  => 'percent',
            'discount_value' => 10,
            'min_nights'     => 2,
            'active'         => true,
            'stackable'      => false,
        ], $overrides));
    }

    #[Test]
    public function it_renders_without_errors(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PromotionsManager::class)
            ->assertSee('Offerte e codici promozionali')
            ->assertStatus(200);
    }

    #[Test]
    public function it_shows_empty_promotions_message(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PromotionsManager::class)
            ->assertSee('Nessuna offerta.');
    }

    #[Test]
    public function save_creates_new_percent_promotion(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PromotionsManager::class)
            ->set('code', 'NEWPROMO')
            ->set('name', 'New Promo')
            ->set('discount_type', 'percent')
            ->set('discount_input', '15')
            ->set('min_nights', 3)
            ->set('active', true)
            ->call('save')
            ->assertSee('Offerta creata.');

        $promo = Promotion::where('code', 'NEWPROMO')->first();
        $this->assertNotNull($promo);
        $this->assertEquals('percent', $promo->discount_type);
        $this->assertEquals(15, $promo->discount_value);
        $this->assertEquals(3, $promo->min_nights);
    }

    #[Test]
    public function save_creates_fixed_discount_promotion(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PromotionsManager::class)
            ->set('code', 'FIXED50')
            ->set('name', 'Fixed 50 euro')
            ->set('discount_type', 'fixed')
            ->set('discount_input', '50')
            ->set('min_nights', 1)
            ->call('save');

        $promo = Promotion::where('code', 'FIXED50')->first();
        $this->assertNotNull($promo);
        $this->assertEquals('fixed', $promo->discount_type);
        $this->assertEquals(5000, $promo->discount_value); // stored as cents
    }

    #[Test]
    public function save_validates_required_fields(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PromotionsManager::class)
            ->set('code', '')
            ->set('name', '')
            ->call('save')
            ->assertHasErrors(['code', 'name']);
    }

    #[Test]
    public function save_validates_code_is_alphanumeric_with_dashes(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PromotionsManager::class)
            ->set('code', 'INVALID CODE!')
            ->set('name', 'Test')
            ->call('save')
            ->assertHasErrors(['code']);
    }

    #[Test]
    public function save_rejects_percent_over_100(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PromotionsManager::class)
            ->set('code', 'OVER100')
            ->set('name', 'Bad promo')
            ->set('discount_type', 'percent')
            ->set('discount_input', '110')
            ->set('min_nights', 1)
            ->call('save')
            ->assertHasErrors(['discount_input']);
    }

    #[Test]
    public function edit_loads_promotion_into_form(): void
    {
        $this->actingAs($this->admin);
        $promo = $this->makePromotion(['code' => 'LOAD123', 'discount_value' => 20]);

        Livewire::test(PromotionsManager::class)
            ->call('edit', $promo->id)
            ->assertSet('editingId', $promo->id)
            ->assertSet('code', 'LOAD123')
            ->assertSet('discount_input', '20'); // percent stored as integer
    }

    #[Test]
    public function edit_then_save_updates_promotion(): void
    {
        $this->actingAs($this->admin);
        $promo = $this->makePromotion(['code' => 'EDITME', 'discount_value' => 10]);

        Livewire::test(PromotionsManager::class)
            ->call('edit', $promo->id)
            ->set('name', 'Updated name')
            ->set('discount_input', '25')
            ->call('save')
            ->assertSee('Offerta aggiornata.');

        $promo->refresh();
        $this->assertEquals('Updated name', $promo->name);
        $this->assertEquals(25, $promo->discount_value);
    }

    #[Test]
    public function delete_removes_promotion(): void
    {
        $this->actingAs($this->admin);
        $promo = $this->makePromotion(['code' => 'DELETE1']);
        $id = $promo->id;

        Livewire::test(PromotionsManager::class)
            ->call('delete', $id)
            ->assertSee('Offerta eliminata.');

        $this->assertNull(Promotion::find($id));
    }

    #[Test]
    public function delete_while_editing_same_promotion_resets_form(): void
    {
        $this->actingAs($this->admin);
        $promo = $this->makePromotion(['code' => 'DELEDIT']);

        Livewire::test(PromotionsManager::class)
            ->call('edit', $promo->id)
            ->call('delete', $promo->id)
            ->assertSet('editingId', null)
            ->assertSet('code', '');
    }

    #[Test]
    public function reset_form_clears_editing_state(): void
    {
        $this->actingAs($this->admin);
        $promo = $this->makePromotion();

        Livewire::test(PromotionsManager::class)
            ->call('edit', $promo->id)
            ->call('resetForm')
            ->assertSet('editingId', null)
            ->assertSet('code', '')
            ->assertSet('discount_type', 'percent');
    }

    #[Test]
    public function save_uppercases_promotion_code(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PromotionsManager::class)
            ->set('code', 'lower2026')
            ->set('name', 'Lowercase test')
            ->set('discount_type', 'percent')
            ->set('discount_input', '5')
            ->set('min_nights', 1)
            ->call('save');

        $this->assertNotNull(Promotion::where('code', 'LOWER2026')->first());
    }

    #[Test]
    public function duplicate_code_fails_validation(): void
    {
        $this->actingAs($this->admin);
        $this->makePromotion(['code' => 'DUPETEST']);

        Livewire::test(PromotionsManager::class)
            ->set('code', 'DUPETEST')
            ->set('name', 'Dup name')
            ->set('discount_input', '10')
            ->call('save')
            ->assertHasErrors(['code']);
    }
}
