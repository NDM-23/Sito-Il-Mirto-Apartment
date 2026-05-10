<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email', 'locale', 'confirmation_token', 'confirmed_at', 'marketing_consent',
        'privacy_accepted_at', 'ip', 'user_agent', 'brevo_contact_id',
    ];

    protected function casts(): array
    {
        return [
            'confirmed_at' => 'datetime',
            'privacy_accepted_at' => 'datetime',
            'marketing_consent' => 'boolean',
        ];
    }
}
