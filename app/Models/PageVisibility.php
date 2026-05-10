<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageVisibility extends Model
{
    protected $fillable = ['slug', 'is_visible', 'sort_order'];

    protected static function booted(): void
    {
        static::saved(function (PageVisibility $m) {
            static::clearCache($m->slug);
        });
    }

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

    public static function isVisible(string $slug): bool
    {
        return Cache::rememberForever('page_visible_'.$slug, function () use ($slug) {
            $row = static::query()->where('slug', $slug)->first();

            return $row ? $row->is_visible : true;
        });
    }

    public static function clearCache(string $slug): void
    {
        Cache::forget('page_visible_'.$slug);
    }
}
