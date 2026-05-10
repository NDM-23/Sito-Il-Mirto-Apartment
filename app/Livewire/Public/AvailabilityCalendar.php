<?php

namespace App\Livewire\Public;

use App\Models\CalendarDay;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class AvailabilityCalendar extends Component
{
    #[Url]
    public int $year = 0;

    #[Url]
    public int $month = 0;

    public function mount(): void
    {
        if ($this->year < 2000) {
            $this->year = (int) now()->year;
        }
        if ($this->month < 1 || $this->month > 12) {
            $this->month = (int) now()->month;
        }
    }

    public function prevMonth(): void
    {
        $d = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->year = (int) $d->year;
        $this->month = (int) $d->month;
    }

    public function nextMonth(): void
    {
        $d = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->year = (int) $d->year;
        $this->month = (int) $d->month;
    }

    public function render()
    {
        $start = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();
        $daysInMonth = $end->day;

        $rows = CalendarDay::query()
            ->whereBetween('day', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->keyBy(fn ($r) => $r->day->format('Y-m-d'));

        $cells = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = $start->copy()->day($d)->toDateString();
            $row = $rows->get($date);
            $cells[] = [
                'date' => $date,
                'day' => $d,
                'booked' => $row?->is_booked ?? false,
                'blocked' => $row?->is_blocked ?? false,
            ];
        }

        $pad = ($start->dayOfWeekIso + 6) % 7;

        return view('livewire.public.availability-calendar', [
            'cells' => $cells,
            'pad' => $pad,
            'title' => $start->translatedFormat('F Y'),
        ]);
    }
}
