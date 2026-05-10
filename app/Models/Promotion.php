<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Promotion extends Model
{
    protected $fillable = [
        'code', 'name', 'discount_type', 'discount_value', 'valid_from', 'valid_to',
        'min_nights', 'active', 'stackable', 'description',
    ];

    protected function casts(): array
    {
        return [
            'valid_from' => 'date',
            'valid_to' => 'date',
            'active' => 'boolean',
            'stackable' => 'boolean',
        ];
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('active', true)
            ->where(function (Builder $b) {
                $b->whereNull('valid_from')->orWhere('valid_from', '<=', now()->toDateString());
            })
            ->where(function (Builder $b) {
                $b->whereNull('valid_to')->orWhere('valid_to', '>=', now()->toDateString());
            });
    }
}
