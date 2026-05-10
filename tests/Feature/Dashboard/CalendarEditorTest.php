<?php

namespace Tests\Feature\Dashboard;

use App\Livewire\Admin\CalendarEditor;
use App\Models\CalendarDay;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CalendarEditorTest extends TestCase
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
    public function it_mounts_with_current_year_and_month(): void
    {
        $this->actingAs($this->admin);
        $now = Carbon::now();

        Livewire::test(CalendarEditor::class)
            ->assertSet('year', (int) $now->year)
            ->assertSet('month', (int) $now->month);
    }

    #[Test]
    public function it_loads_draft_array_for_every_day_of_month(): void
    {
        $this->actingAs($this->admin);
        $now = Carbon::now();
        $days = $now->daysInMonth;

        $draft = Livewire::test(CalendarEditor::class)->get('draft');
        $this->assertCount($days, $draft, "Expected $days draft entries for current month.");
    }

    #[Test]
    public function prev_month_navigates_backwards(): void
    {
        $this->actingAs($this->admin);
        $now = Carbon::now();
        $prev = $now->copy()->subMonth();

        Livewire::test(CalendarEditor::class)
            ->call('prevMonth')
            ->assertSet('year', (int) $prev->year)
            ->assertSet('month', (int) $prev->month);
    }

    #[Test]
    public function next_month_navigates_forward(): void
    {
        $this->actingAs($this->admin);
        $now = Carbon::now();
        $next = $now->copy()->addMonth();

        Livewire::test(CalendarEditor::class)
            ->call('nextMonth')
            ->assertSet('year', (int) $next->year)
            ->assertSet('month', (int) $next->month);
    }

    #[Test]
    public function save_month_persists_calendar_days_to_database(): void
    {
        $this->actingAs($this->admin);
        $now = Carbon::now();
        $firstKey = $now->copy()->startOfMonth()->format('Y_m_d');
        $dateStr = str_replace('_', '-', $firstKey);

        Livewire::test(CalendarEditor::class)
            ->set("draft.$firstKey.price_eur", '200')
            ->set("draft.$firstKey.min_nights", '3')
            ->set("draft.$firstKey.is_blocked", true)
            ->set("draft.$firstKey.is_booked", false)
            ->set("draft.$firstKey.promo_label", '')
            ->call('saveMonth');

        $day = CalendarDay::where('day', $dateStr)->first();

        $this->assertNotNull($day, "CalendarDay for $dateStr should exist after save.");
        $this->assertEquals(20000, $day->price_cents);
        $this->assertEquals(3, $day->min_nights);
        $this->assertTrue($day->is_blocked);
    }

    #[Test]
    public function save_month_stores_null_when_price_is_empty(): void
    {
        $this->actingAs($this->admin);
        $now = Carbon::now();
        $firstKey = $now->copy()->startOfMonth()->format('Y_m_d');
        $dateStr = str_replace('_', '-', $firstKey);

        // Mount and immediately save (all fields empty)
        Livewire::test(CalendarEditor::class)
            ->set("draft.$firstKey.price_eur", '')
            ->call('saveMonth');

        $day = CalendarDay::where('day', $dateStr)->first();
        $this->assertNotNull($day, "Record should be created for $dateStr.");
        $this->assertNull($day->price_cents);
    }

    #[Test]
    public function save_month_shows_success_message(): void
    {
        $this->actingAs($this->admin);

        // session()->flash() inside the component sets the value for the current
        // request; the Blade @if(session('flash_ok')) block re-renders in the
        // same Livewire cycle, so assertSee finds the message in the rendered HTML.
        Livewire::test(CalendarEditor::class)
            ->call('saveMonth')
            ->assertSee('Calendario salvato.');
    }

    #[Test]
    public function it_loads_existing_calendar_day_into_draft(): void
    {
        $this->actingAs($this->admin);
        $now = Carbon::now();
        $firstDay = $now->copy()->startOfMonth()->toDateString();

        CalendarDay::create([
            'day' => $firstDay,
            'price_cents' => 17500,
            'min_nights' => 4,
            'is_booked' => true,
            'is_blocked' => false,
            'promo_label' => 'ESTATE',
        ]);

        $draft = Livewire::test(CalendarEditor::class)->get('draft');
        $key = str_replace('-', '_', $firstDay);

        $this->assertArrayHasKey($key, $draft, "Draft should have key $key.");
        $this->assertEquals('175', $draft[$key]['price_eur']);
        $this->assertEquals('4', $draft[$key]['min_nights']);
        $this->assertTrue($draft[$key]['is_booked']);
        $this->assertEquals('ESTATE', $draft[$key]['promo_label']);
    }
}
