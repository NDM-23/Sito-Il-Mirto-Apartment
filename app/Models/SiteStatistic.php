<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteStatistic extends Model
{
    protected $fillable = ['day', 'page_views', 'quote_views'];

    protected function casts(): array
    {
        return [
            'day' => 'date',
        ];
    }
}
