<?php

use App\Http\Controllers\ICalFeedController;
use App\Http\Controllers\MirtoPageController;
use App\Http\Controllers\NewsletterConfirmController;
use App\Http\Controllers\SitemapController;
use App\Livewire\Admin\CalendarEditor;
use App\Livewire\Admin\GalleryManager;
use App\Livewire\Admin\NewsletterTable;
use App\Livewire\Admin\PageVisibilityPanel;
use App\Livewire\Admin\PromotionsManager;
use App\Livewire\Admin\QuoteRequestsTable;
use App\Livewire\Admin\SiteSettingsPanel;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/ical/mirto.ics', ICalFeedController::class)->name('ical.feed');

Route::get('/robots.txt', function () {
    $sitemap = url('/sitemap.xml');

    return response(
        "User-agent: *\nAllow: /\nDisallow: /dashboard\nDisallow: /login\nSitemap: {$sitemap}\n",
        200,
        ['Content-Type' => 'text/plain; charset=UTF-8']
    );
})->name('robots');

Route::get('/confirm-newsletter/{token}', NewsletterConfirmController::class)
    ->middleware('throttle:newsletter')
    ->name('newsletter.confirm');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {
    Route::get('/', [MirtoPageController::class, 'home'])->name('home');
    Route::get('/appartamento', [MirtoPageController::class, 'apartment'])->name('apartment');
    Route::get('/galleria', [MirtoPageController::class, 'gallery'])->name('gallery');
    Route::get('/servizi', [MirtoPageController::class, 'services'])->name('services');
    Route::get('/promozioni', [MirtoPageController::class, 'promotions'])->name('promotions');
    Route::get('/esperienze', [MirtoPageController::class, 'experiences'])->name('experiences');
    Route::get('/dove-siamo', [MirtoPageController::class, 'location'])->name('location');
    Route::get('/recensioni', [MirtoPageController::class, 'reviews'])->name('reviews');
    Route::get('/contatti', [MirtoPageController::class, 'contacts'])->name('contacts');
    Route::get('/newsletter', [MirtoPageController::class, 'newsletter'])->name('newsletter.page');
    Route::get('/preventivo', [MirtoPageController::class, 'preventivo'])->name('preventivo');
    Route::get('/disponibilita', [MirtoPageController::class, 'availability'])->name('availability');
    Route::get('/privacy', [MirtoPageController::class, 'privacy'])->name('privacy');
    Route::get('/cookie-policy', [MirtoPageController::class, 'cookies'])->name('cookies');
    Route::get('/termini-prenotazione', [MirtoPageController::class, 'terms'])->name('terms');
    Route::get('/blog', [MirtoPageController::class, 'blog'])->name('blog');
    Route::get('/faq', [MirtoPageController::class, 'faq'])->name('faq');
    Route::get('/info/mirto-faq-7k2', fn () => redirect()->route('faq', [], 301));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin|editor',
])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/calendario', CalendarEditor::class)->name('calendar');
    Route::get('/preventivi', QuoteRequestsTable::class)->name('quotes');
    Route::get('/newsletter', NewsletterTable::class)->name('newsletter');
    Route::get('/impostazioni', SiteSettingsPanel::class)->name('settings');
    Route::get('/galleria', GalleryManager::class)->name('gallery');
    Route::get('/offerte', PromotionsManager::class)->name('promotions');
    Route::get('/pagine', PageVisibilityPanel::class)->name('pages');
});
