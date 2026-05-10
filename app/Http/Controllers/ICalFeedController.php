<?php

namespace App\Http\Controllers;

use App\Models\CalendarDay;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ICalFeedController extends Controller
{
    public function __invoke(): Response
    {
        $now = Carbon::now()->format('Ymd\THis\Z');
        $uid_base = 'mirto-apartment-olbia';

        // Recupera tutti i giorni occupati o bloccati nei prossimi 2 anni
        $days = CalendarDay::query()
            ->where('day', '>=', now()->toDateString())
            ->where('day', '<=', now()->addYears(2)->toDateString())
            ->where(function ($q) {
                $q->where('is_booked', true)->orWhere('is_blocked', true);
            })
            ->orderBy('day')
            ->get();

        // Raggruppa giorni consecutivi in eventi
        $events = [];
        $groupStart = null;
        $groupEnd = null;
        $groupType = null;

        foreach ($days as $day) {
            $current = Carbon::parse($day->day);
            $type = $day->is_booked ? 'CONFIRMED' : 'TENTATIVE';

            if ($groupStart === null) {
                $groupStart = $current->copy();
                $groupEnd = $current->copy()->addDay();
                $groupType = $type;
            } elseif ($current->equalTo($groupEnd) && $type === $groupType) {
                $groupEnd->addDay();
            } else {
                $events[] = ['start' => $groupStart, 'end' => $groupEnd, 'status' => $groupType];
                $groupStart = $current->copy();
                $groupEnd = $current->copy()->addDay();
                $groupType = $type;
            }
        }
        if ($groupStart !== null) {
            $events[] = ['start' => $groupStart, 'end' => $groupEnd, 'status' => $groupType];
        }

        // Genera iCal
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Il Mirto Apartment//Disponibilità//IT',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'X-WR-CALNAME:Il Mirto Apartment - Disponibilità',
            'X-WR-CALDESC:Calendario disponibilità Il Mirto Apartment - Olbia Sardegna',
            'X-WR-TIMEZONE:Europe/Rome',
        ];

        foreach ($events as $i => $ev) {
            $dtstart = $ev['start']->format('Ymd');
            $dtend = $ev['end']->format('Ymd');
            $summary = $ev['status'] === 'CONFIRMED' ? 'Occupato' : 'Bloccato';
            $uid = $uid_base.'-'.$dtstart.'-'.$i.'@ilmirtoapartment.it';

            $lines[] = 'BEGIN:VEVENT';
            $lines[] = 'DTSTART;VALUE=DATE:'.$dtstart;
            $lines[] = 'DTEND;VALUE=DATE:'.$dtend;
            $lines[] = 'SUMMARY:'.$summary;
            $lines[] = 'STATUS:'.$ev['status'];
            $lines[] = 'TRANSP:OPAQUE';
            $lines[] = 'UID:'.$uid;
            $lines[] = 'DTSTAMP:'.$now;
            $lines[] = 'END:VEVENT';
        }

        $lines[] = 'END:VCALENDAR';

        $content = implode("\r\n", $lines)."\r\n";

        return response($content, 200, [
            'Content-Type' => 'text/calendar; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="mirto-apartment.ics"',
            'Cache-Control' => 'no-cache, must-revalidate',
            'Pragma' => 'no-cache',
        ]);
    }
}
