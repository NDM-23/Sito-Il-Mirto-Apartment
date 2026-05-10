<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $v = Cache::rememberForever('site_setting_'.$key, function () use ($key) {
            return static::query()->where('key', $key)->value('value');
        });

        if ($v === null) {
            return $default;
        }

        $decoded = json_decode($v, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $v;
    }

    public static function set(string $key, mixed $value): void
    {
        $stored = is_string($value) ? $value : json_encode($value);

        $row = static::query()->firstOrNew(['key' => $key]);
        $row->value = $stored;
        if (! $row->exists) {
            $row->created_at = now();
        }
        $row->updated_at = now();
        $row->save();

        Cache::forget('site_setting_'.$key);
    }
}
