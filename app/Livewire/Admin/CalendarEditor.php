<?php

namespace App\Livewire\Admin;

use App\Models\CalendarDay;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
class CalendarEditor extends Component
{
    #[Url]
    public int $year = 0;

    #[Url]
    public int $month = 0;

    /** Date keys use Y_m_d (underscores) for Livewire binding. @var array<string, array> */
    public array $draft = [];

    public function mount(): void
    {
        if ($this->year < 2000) {
            $this->year = (int) now()->year;
        }
        if ($this->month < 1 || $this->month > 12) {
            $this->month = (int) now()->month;
        }
        $this->loadMonth();
    }

    public function updatedYear(): void
    {
        $this->loadMonth();
    }

    public function updatedMonth(): void
    {
        $this->loadMonth();
    }

    public function prevMonth(): void
    {
        $d = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->year = (int) $d->year;
        $this->month = (int) $d->month;
        $this->loadMonth();
    }

    public function nextMonth(): void
    {
        $d = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->year = (int) $d->year;
        $this->month = (int) $d->month;
        $this->loadMonth();
    }

    public function loadMonth(): void
    {
        $start = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();
        $this->draft = [];

        for ($d = 1; $d <= $end->day; $d++) {
            $date = $start->copy()->day($d)->toDateString();
            $k = str_replace('-', '_', $date);
            $row = CalendarDay::query()->where('day', $date)->first();
            $this->draft[$k] = [
                'price_eur' => $row && $row->price_cents !== null ? (string) ($row->price_cents / 100) : '',
                'min_nights' => $row && $row->min_nights !== null ? (string) $row->min_nights : '',
                'is_booked' => $row?->is_booked ?? false,
                'is_blocked' => $row?->is_blocked ?? false,
                'promo_label' => (string) ($row?->promo_label ?? ''),
            ];
        }
    }

    public function syncIcal(): void
    {
        $sources = [
            'Booking.com' => SiteSetting::get('booking_ical_url', ''),
            'Airbnb'      => SiteSetting::get('airbnb_ical_url', ''),
        ];

        $imported = 0;
        foreach ($sources as $label => $url) {
            $url = trim((string) $url);
            if ($url === '') {
                continue;
            }
            try {
                $content = @file_get_contents($url, false, stream_context_create([
                    'http' => ['timeout' => 15, 'user_agent' => 'MirtoApartment/1.0'],
                ]));
                if ($content === false) {
                    continue;
                }
                $content = preg_replace('/\r\n[ \t]/', '', $content);
                $lines = explode("\n", str_replace("\r\n", "\n", $content));
                $inEvent = false;
                $current = [];
                foreach ($lines as $raw) {
                    $line = rtrim($raw);
                    if ($line === 'BEGIN:VEVENT') { $inEvent = true; $current = []; continue; }
                    if ($line === 'END:VEVENT') {
                        $inEvent = false;
                        $start = $this->parseIcalDate($current['DTSTART'] ?? null);
                        $end   = $this->parseIcalDate($current['DTEND']   ?? null);
                        if ($start) {
                            $cursor = $start->copy();
                            $until  = $end ?? $start->copy()->addDay();
                            while ($cursor->lt($until)) {
                                CalendarDay::query()->updateOrCreate(
                                    ['day' => $cursor->toDateString()],
                                    ['is_blocked' => true]
                                );
                                $imported++;
                                $cursor->addDay();
                            }
                        }
                        continue;
                    }
                    if ($inEvent && str_contains($line, ':')) {
                        [$rawKey, $val] = explode(':', $line, 2);
                        $current[strtoupper(explode(';', $rawKey)[0])] = trim($val);
                    }
                }
            } catch (\Throwable) {
                // skip failed source
            }
        }

        $this->loadMonth();
        session()->flash('flash_ok', "Sincronizzazione completata: {$imported} date importate.");
    }

    private function parseIcalDate(?string $raw): ?Carbon
    {
        if (! $raw) {
            return null;
        }
        $raw = trim($raw);
        if (preg_match('/^(\d{8})/', $raw, $m)) {
            return Carbon::createFromFormat('Ymd', $m[1])->startOfDay();
        }

        return null;
    }

    public function saveMonth(): void
    {
        foreach ($this->draft as $k => $data) {
            $date = str_replace('_', '-', $k);
            $priceCents = $data['price_eur'] === '' ? null : (int) round(((float) str_replace(',', '.', $data['price_eur'])) * 100);
            $minN = $data['min_nights'] === '' ? null : (int) $data['min_nights'];

            CalendarDay::query()->updateOrCreate(
                ['day' => $date],
                [
                    'price_cents' => $priceCents,
                    'min_nights' => $minN,
                    'is_booked' => (bool) ($data['is_booked'] ?? false),
                    'is_blocked' => (bool) ($data['is_blocked'] ?? false),
                    'promo_label' => $data['promo_label'] ?: null,
                ]
            );
        }

        session()->flash('flash_ok', 'Calendario salvato.');
    }

    public function render()
    {
        $start = Carbon::create($this->year, $this->month, 1)->startOfMonth();

        $bookingUrl = trim((string) SiteSetting::get('booking_ical_url', ''));
        $airbnbUrl  = trim((string) SiteSetting::get('airbnb_ical_url', ''));

        return view('livewire.admin.calendar-editor', [
            'title'       => $start->translatedFormat('F Y'),
            'hasIcalUrls' => $bookingUrl !== '' || $airbnbUrl !== '',
        ]);
    }
}
