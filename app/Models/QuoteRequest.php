<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'check_in', 'check_out', 'adults', 'children', 'extras', 'promo_code',
        'calculation', 'guest_email', 'guest_phone', 'locale', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'extras' => 'array',
            'calculation' => 'array',
        ];
    }
}
