<?php

namespace App\Livewire\Public;

use App\Mail\NewsletterConfirmationMail;
use App\Models\ConsentLog;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class NewsletterBox extends Component
{
    public string $email = '';

    public bool $privacy = false;

    public bool $marketing = false;

    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc'],
            'privacy' => ['accepted'],
        ];
    }

    public function subscribe(): void
    {
        $this->validate();

        $token = Str::random(64);

        NewsletterSubscriber::query()->updateOrCreate(
            ['email' => mb_strtolower($this->email)],
            [
                'locale' => app()->getLocale(),
                'confirmation_token' => $token,
                'confirmed_at' => null,
                'marketing_consent' => $this->marketing,
                'privacy_accepted_at' => now(),
                'ip' => request()->ip(),
                'user_agent' => substr((string) request()->userAgent(), 0, 2000),
            ]
        );

        ConsentLog::query()->create([
            'email' => mb_strtolower($this->email),
            'action' => 'newsletter_signup_request',
            'ip' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 2000),
            'payload' => [
                'locale' => app()->getLocale(),
                'marketing' => $this->marketing,
            ],
        ]);

        $url = route('newsletter.confirm', ['token' => $token]);

        Mail::to($this->email)
            ->locale(app()->getLocale())
            ->send(new NewsletterConfirmationMail($url, app()->getLocale()));

        $this->sent = true;
        $this->reset('email', 'privacy', 'marketing');
    }

    public function render()
    {
        return view('livewire.public.newsletter-box');
    }
}
