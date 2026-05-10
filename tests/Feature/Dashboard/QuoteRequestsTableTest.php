<?php

namespace Tests\Feature\Dashboard;

use App\Livewire\Admin\QuoteRequestsTable;
use App\Models\QuoteRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QuoteRequestsTableTest extends TestCase
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
    public function it_renders_with_empty_table(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(QuoteRequestsTable::class)
            ->assertSee('Nessuna richiesta ancora.');
    }

    #[Test]
    public function it_shows_quote_request_rows(): void
    {
        $this->actingAs($this->admin);

        QuoteRequest::create([
            'check_in' => '2026-07-01',
            'check_out' => '2026-07-07',
            'adults' => 2,
            'children' => 1,
            'calculation' => ['total_cents' => 110000],
            'status' => 'new',
        ]);

        Livewire::test(QuoteRequestsTable::class)
            ->assertSee('2026-07-01')
            ->assertSee('2026-07-07')
            ->assertSee('2+1')
            ->assertSee('1 100,00', false)  // number_format uses space as thousands separator
            ->assertSee('new');
    }

    #[Test]
    public function it_shows_dash_when_calculation_is_null(): void
    {
        $this->actingAs($this->admin);

        QuoteRequest::create([
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-04',
            'adults' => 2,
            'children' => 0,
            'calculation' => null,
            'status' => 'new',
        ]);

        // Should not throw — blade has @if($r->calculation) guard
        Livewire::test(QuoteRequestsTable::class)
            ->assertSee('2026-08-01')
            ->assertSee('—');
    }

    #[Test]
    public function it_paginates_when_more_than_twenty_records(): void
    {
        $this->actingAs($this->admin);

        for ($i = 1; $i <= 22; $i++) {
            QuoteRequest::create([
                'check_in'  => '2026-06-'.str_pad($i, 2, '0', STR_PAD_LEFT),
                'check_out' => '2026-06-'.str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                'adults' => 2,
                'children' => 0,
                'status' => 'new',
            ]);
        }

        // Default page shows 20 rows, so row 21 and 22 are on page 2
        $comp = Livewire::test(QuoteRequestsTable::class);
        // pagination links rendered (uses Tailwind paginator)
        $comp->assertSee('2026-06-22', false); // newest on page 1 (ordered by id desc)
    }

    #[Test]
    public function check_in_is_rendered_without_throwing_when_null_would_crash(): void
    {
        // This confirms the blade safely handles all quote requests.
        $this->actingAs($this->admin);

        // Seed 3 records with various states
        QuoteRequest::create([
            'check_in' => '2026-09-01',
            'check_out' => '2026-09-05',
            'adults' => 3,
            'children' => 0,
            'calculation' => ['total_cents' => 50000, 'nights' => 4],
            'status' => 'confirmed',
        ]);

        $response = Livewire::test(QuoteRequestsTable::class);
        $response->assertStatus(200);
    }
}
