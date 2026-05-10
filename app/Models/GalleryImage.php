<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['path', 'section_key', 'alt', 'sort_order', 'is_active', 'is_hero'];

    protected function casts(): array
    {
        return [
            'alt' => 'array',
            'is_active' => 'boolean',
            'is_hero' => 'boolean',
        ];
    }

    /** URL pubblica (storage locale o URL esterno da seed) */
    public function url(): string
    {
        if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
            return $this->path;
        }

        return asset(ltrim($this->path, '/'));
    }

    public static function diskPathFromPublic(string $publicPath): ?string
    {
        if (! str_starts_with($publicPath, '/storage/')) {
            return null;
        }

        return substr($publicPath, strlen('/storage/'));
    }
}
