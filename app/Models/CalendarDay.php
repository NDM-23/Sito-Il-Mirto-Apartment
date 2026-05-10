<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarDay extends Model
{
    protected $fillable = [
        'day', 'price_cents', 'min_nights', 'is_booked', 'is_blocked', 'promo_label', 'notes',
    ];

    protected function casts(): array
    {
        return [
            // 'day' is kept as a plain 'Y-m-d' string so that
            // WHERE day = '2026-04-01' works on both MySQL and SQLite.
            'is_booked' => 'boolean',
            'is_blocked' => 'boolean',
        ];
    }
}
