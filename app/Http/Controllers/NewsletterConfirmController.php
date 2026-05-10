<?php

namespace App\Http\Controllers;

use App\Models\ConsentLog;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewsletterConfirmController extends Controller
{
    public function __invoke(Request $request, string $token): RedirectResponse
    {
        $sub = NewsletterSubscriber::query()->where('confirmation_token', $token)->first();
        if (! $sub) {
            return redirect()->to('/')->with('flash_err', __('mirto.newsletter.bad_token'));
        }

        $sub->update([
            'confirmed_at' => now(),
            'confirmation_token' => null,
        ]);

        ConsentLog::query()->create([
            'email' => $sub->email,
            'action' => 'newsletter_confirmed',
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 2000),
            'payload' => ['locale' => $sub->locale],
        ]);

        return redirect()->to(LaravelLocalization::getLocalizedURL($sub->locale, '/newsletter'))
            ->with('flash_ok', __('mirto.newsletter.confirmed'));
    }
}
