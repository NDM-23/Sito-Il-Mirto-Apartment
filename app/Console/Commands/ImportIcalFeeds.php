<?php

namespace App\Console\Commands;

use App\Models\CalendarDay;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportIcalFeeds extends Command
{
    protected $signature = 'ical:import {--dry-run : Mostra le date importate senza salvare}';

    protected $description = 'Importa le prenotazioni dai feed iCal di Booking.com e Airbnb';

    public function handle(): int
    {
        $sources = [
            'Booking.com' => SiteSetting::get('booking_ical_url', ''),
            'Airbnb'      => SiteSetting::get('airbnb_ical_url', ''),
        ];

        $totalImported = 0;
        $dry = $this->option('dry-run');

        foreach ($sources as $label => $url) {
            $url = trim((string) $url);
            if ($url === '') {
                $this->line("  <comment>{$label}</comment>: URL non configurato — saltato.");
                continue;
            }

            $this->line("  Scarico <info>{$label}</info>: {$url}");

            try {
                $content = $this->fetchUrl($url);
            } catch (\Throwable $e) {
                $this->error("  Errore scaricando {$label}: ".$e->getMessage());
                continue;
            }

            $events = $this->parseIcal($content);
            $this->line("  → trovati ".count($events)." eventi.");

            foreach ($events as $event) {
                $start = $event['start'] ?? null;
                $end   = $event['end']   ?? null;
                if (! $start) {
                    continue;
                }

                $cursor = $start->copy();
                $endDate = $end ?? $start->copy()->addDay();

                while ($cursor->lt($endDate)) {
                    $dateStr = $cursor->toDateString();
                    if (! $dry) {
                        CalendarDay::query()->updateOrCreate(
                            ['day' => $dateStr],
                            ['is_blocked' => true]
                        );
                    } else {
                        $this->line("    [dry] {$dateStr} bloccato da {$label}");
                    }
                    $totalImported++;
                    $cursor->addDay();
                }
            }
        }

        if (! $dry) {
            $this->info("✓ Importate/aggiornate {$totalImported} date.");
        } else {
            $this->info("Dry-run: trovate {$totalImported} date da bloccare.");
        }

        return self::SUCCESS;
    }

    /** Fetches the URL contents using file_get_contents with a timeout. */
    private function fetchUrl(string $url): string
    {
        $context = stream_context_create([
            'http' => [
                'timeout'        => 15,
                'follow_location' => true,
                'user_agent'     => 'Mozilla/5.0 (compatible; MirtoApartment/1.0)',
            ],
            'ssl' => [
                'verify_peer'      => true,
                'verify_peer_name' => true,
            ],
        ]);

        $result = @file_get_contents($url, false, $context);
        if ($result === false) {
            throw new \RuntimeException("Impossibile scaricare: {$url}");
        }

        return $result;
    }

    /**
     * Minimal iCal parser — returns array of ['start' => Carbon, 'end' => Carbon|null].
     *
     * @return array<int, array{start: Carbon, end: Carbon|null}>
     */
    private function parseIcal(string $content): array
    {
        // Unfold lines (RFC 5545 line folding: CRLF + whitespace)
        $content = preg_replace('/\r\n[ \t]/', '', $content);
        $lines = explode("\n", str_replace("\r\n", "\n", $content));

        $events   = [];
        $inEvent  = false;
        $current  = [];

        foreach ($lines as $rawLine) {
            $line = rtrim($rawLine);

            if ($line === 'BEGIN:VEVENT') {
                $inEvent = true;
                $current = [];
                continue;
            }

            if ($line === 'END:VEVENT') {
                $inEvent = false;
                if (! empty($current)) {
                    $events[] = $current;
                }
                continue;
            }

            if (! $inEvent || ! str_contains($line, ':')) {
                continue;
            }

            [$rawKey, $value] = explode(':', $line, 2);
            // Remove parameters (e.g. DTSTART;VALUE=DATE → DTSTART)
            $key = strtoupper(explode(';', $rawKey)[0]);
            $current[$key] = trim($value);
        }

        $parsed = [];
        foreach ($events as $ev) {
            $start = $this->parseIcalDate($ev['DTSTART'] ?? null);
            $end   = $this->parseIcalDate($ev['DTEND']   ?? null);
            if ($start) {
                $parsed[] = ['start' => $start, 'end' => $end];
            }
        }

        return $parsed;
    }

    private function parseIcalDate(?string $raw): ?Carbon
    {
        if (! $raw) {
            return null;
        }
        $raw = trim($raw);

        // DATE-only: 20260401
        if (preg_match('/^(\d{8})$/', $raw, $m)) {
            return Carbon::createFromFormat('Ymd', $m[1])->startOfDay();
        }

        // DATE-TIME UTC: 20260401T120000Z
        if (preg_match('/^(\d{8})T\d{6}Z?$/', $raw, $m)) {
            return Carbon::createFromFormat('Ymd', $m[1])->startOfDay();
        }

        return null;
    }
}
