<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('mirto.brand').' — '.__('mirto.tagline'))</title>
    <meta name="description" content="@yield('meta_description', 'Appartamento vacanze con piscina a Olbia, Sardegna. A 5 minuti dall\'aeroporto, vicino alla Costa Smeralda. Prenota diretto e risparmia.')">
    <link rel="canonical" href="{{ url()->current() }}">
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
    @endforeach
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600,700|dm-sans:300,400,500,600,700&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/mirto.css') }}?v={{ file_exists(public_path('css/mirto.css')) ? filemtime(public_path('css/mirto.css')) : '1' }}">
    @endif
    @stack('head')

    {{-- Alpine.js DEVE essere caricato prima di @livewireScripts per evitare conflitti --}}
    {{-- In Livewire v3, Alpine viene incluso in livewire.js ma serve defer esplicito qui --}}
    <style>
        [x-cloak]{display:none !important;}
        html{scroll-behavior:smooth;}

        /* Colori costieri dal vivo dell'appartamento */
        :root {
            --cielo: #e8f3f8;
            --azzurro: #6BAED6;
            --costa: #2b6a9e;
            --costa-dark: #1a4971;
        }

        .hero-gradient{background:linear-gradient(to bottom,rgba(0,0,0,.15) 0%,rgba(0,0,0,.60) 65%,rgba(0,0,0,.75) 100%);}
        .costa-gradient{background:linear-gradient(135deg,#1a4971 0%,#2b6a9e 100%);}
        .mare-gradient{background:linear-gradient(135deg,#1a6f78 0%,#2fb5c3 100%);}

        /* Wave animation */
        @keyframes waveMove{0%{background-position-x:0}100%{background-position-x:1440px}}
        .wave-anim{animation:waveMove 14s linear infinite;}

        /* Galleggiante mare - piccole onde CSS */
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        .float-anim{animation:float 5s ease-in-out infinite;}

        /* Bolle acqua decorative */
        .bubble{position:absolute;border-radius:50%;background:rgba(107,174,214,.15);animation:bubbleRise 8s ease-in infinite;}
        @keyframes bubbleRise{0%{transform:translateY(100%) scale(0);opacity:0}50%{opacity:.6}100%{transform:translateY(-200%) scale(1.5);opacity:0}}

        /* Nav link underline effect */
        .nav-link{position:relative;}
        .nav-link::after{content:'';position:absolute;bottom:-2px;left:0;width:0;height:2px;background:#2fb5c3;transition:width .3s;}
        .nav-link:hover::after{width:100%;}

        /* Card hover */
        .card-hover{transition:transform .35s ease,box-shadow .35s ease;}
        .card-hover:hover{transform:translateY(-5px);box-shadow:0 20px 40px -12px rgba(43,106,158,.2);}

        /* Fade in on scroll */
        .fade-in{opacity:0;transform:translateY(20px);transition:opacity .65s ease,transform .65s ease;}
        .fade-in.visible{opacity:1;transform:translateY(0);}

        /* Nav scrolled state */
        .nav-scrolled{background:rgba(255,255,255,.96)!important;backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);box-shadow:0 1px 20px rgba(43,106,158,.12);}
        .nav-transparent{background:transparent!important;}
    </style>

    @livewireStyles

    @php
        $ld = [
            '@context' => 'https://schema.org',
            '@type' => 'LodgingBusiness',
            'name' => 'Il Mirto Apartment',
            'url' => config('app.url'),
            'description' => 'Appartamento vacanze con piscina a Olbia, Sardegna. Vicino all\'aeroporto e alla Costa Smeralda.',
            'image' => [asset('img/salotto.png')],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Via Giovanni Gentile 1',
                'addressLocality' => 'Olbia',
                'addressRegion' => 'SS',
                'postalCode' => '07026',
                'addressCountry' => 'IT',
            ],
            'geo' => ['@type' => 'GeoCoordinates', 'latitude' => 40.9236, 'longitude' => 9.4991],
            'amenityFeature' => [
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Piscina', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'WiFi', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Aria condizionata', 'value' => true],
            ],
            'telephone' => \App\Models\SiteSetting::get('phone_display', '+39 333 123 4567'),
            'email' => \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it'),
            'priceRange' => '€€',
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</head>
<body class="font-sans antialiased" style="background-color:var(--cielo);color:#1e293b;">

{{-- ===== NAVIGAZIONE ===== --}}
{{-- Usa JS vanilla per scroll (più affidabile di Alpine per nav fissa) --}}
<nav id="main-nav"
     class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
     style="{{ Request::routeIs('home') ? 'background:transparent;' : 'background:rgba(255,255,255,.96);backdrop-filter:blur(12px);box-shadow:0 1px 20px rgba(43,106,158,.12);' }}"
     x-data="{ open: false }">

    <div class="relative z-50 mx-auto flex max-w-7xl items-center justify-between px-4 py-4 md:py-5">

        {{-- Logo --}}
        <a href="{{ route('home') }}"
           id="nav-logo"
           class="font-display text-xl font-semibold tracking-tight transition-colors duration-300"
           style="{{ Request::routeIs('home') ? 'color:white;' : 'color:#1f5c4b;' }}">
            Il Mirto Apartment
        </a>

        {{-- Desktop Nav (da lg: 1024px — tablet landscape vede menu completo; sotto, hamburger) --}}
        <div class="hidden items-center gap-4 lg:flex">
            @foreach([
                ['route' => 'apartment',    'key' => 'apartment'],
                ['route' => 'gallery',      'key' => 'gallery'],
                ['route' => 'services',     'key' => 'services'],
                ['route' => 'experiences',  'key' => 'experiences'],
                ['route' => 'location',     'key' => 'location'],
            ] as $item)
            <a href="{{ route($item['route']) }}"
               class="nav-link text-sm font-medium transition-colors duration-300 nav-desktop-link"
               style="{{ Request::routeIs('home') ? 'color:rgba(255,255,255,.9);' : 'color:#374151;' }}">
                {{ __('mirto.nav.'.$item['key']) }}
            </a>
            @endforeach

            @if(\App\Models\PageVisibility::isVisible('reviews'))
            <a href="{{ route('reviews') }}"
               class="nav-link text-sm font-medium transition-colors duration-300 nav-desktop-link"
               style="{{ Request::routeIs('home') ? 'color:rgba(255,255,255,.9);' : 'color:#374151;' }}">
                {{ __('mirto.nav.reviews') }}
            </a>
            @endif

            <a href="{{ route('faq') }}"
               class="nav-link text-sm font-medium transition-colors duration-300 nav-desktop-link"
               style="{{ Request::routeIs('home') ? 'color:rgba(255,255,255,.9);' : 'color:#374151;' }}">
                {{ __('mirto.nav.faq') }}
            </a>

            {{-- Language selector --}}
            {{-- @click.outside DEVE stare sul container (che include bottone + dropdown),
                 NON sul dropdown: altrimenti click sul bottone = outside del dropdown → chiude subito --}}
            <div class="relative" x-data="{ langOpen: false }" @click.outside="langOpen = false">
                <button
                    @click="langOpen = !langOpen"
                    class="flex items-center gap-1 rounded-full border px-2.5 py-1 text-xs font-bold uppercase transition-colors duration-300 nav-lang-btn"
                    style="{{ Request::routeIs('home') ? 'border-color:rgba(255,255,255,.4);color:rgba(255,255,255,.9);' : 'border-color:#d1d5db;color:#6b7280;' }}"
                    type="button">
                    {{ app()->getLocale() }}
                    <svg class="h-3 w-3 transition-transform duration-200" :class="langOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="langOpen"
                     x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute right-0 mt-2 rounded-xl bg-white py-1 shadow-xl ring-1 ring-slate-100"
                     style="min-width:130px;z-index:9999;">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                       class="flex items-center gap-2 px-4 py-2.5 text-xs font-semibold uppercase tracking-wide hover:bg-blue-50 transition-colors {{ app()->getLocale() === $localeCode ? 'text-blue-700 bg-blue-50' : 'text-slate-700' }}">
                        @if(app()->getLocale() === $localeCode)
                        <span class="text-blue-500">✓</span>
                        @else
                        <span class="w-4"></span>
                        @endif
                        {{ $properties['native'] }}
                    </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('availability') }}"
               class="text-sm font-medium transition-colors nav-desktop-link"
               style="{{ Request::routeIs('home') ? 'color:rgba(255,255,255,.8);' : 'color:#6b7280;' }}">
                {{ __('mirto.nav.availability') }}
            </a>

            <a href="{{ route('preventivo') }}"
               class="rounded-full bg-mare px-5 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:bg-mare-deep hover:-translate-y-0.5 hover:shadow-xl">
                {{ __('mirto.nav.preventivo') }} →
            </a>
        </div>

        {{-- Mobile / tablet hamburger (sempre contrastato: chip chiaro + icona scura) --}}
        <button @click="open = !open"
                id="nav-hamburger"
                class="relative z-[60] flex lg:hidden rounded-lg border border-slate-200 bg-white/95 p-2 shadow-md transition-colors duration-200"
                style="color:#1e293b;"
                type="button"
                aria-label="Menu">
            <span x-show="!open">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </span>
            <span x-show="open" x-cloak>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </span>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="lg:hidden relative z-[55] max-h-[min(80vh,calc(100dvh-5rem))] overflow-y-auto border-t border-slate-100 px-4 py-4 shadow-xl"
         style="background:rgba(255,255,255,.98);backdrop-filter:blur(12px);">
        <div class="space-y-1">
            @foreach([
                ['route' => 'apartment',   'key' => 'apartment'],
                ['route' => 'gallery',     'key' => 'gallery'],
                ['route' => 'services',    'key' => 'services'],
                ['route' => 'experiences', 'key' => 'experiences'],
                ['route' => 'location',    'key' => 'location'],
                ['route' => 'contacts',    'key' => 'contacts'],
                ['route' => 'availability','key' => 'availability'],
                ['route' => 'promotions',  'key' => 'promotions'],
                ['route' => 'faq',         'key' => 'faq'],
            ] as $item)
            <a href="{{ route($item['route']) }}"
               @click="open = false"
               class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                {{ __('mirto.nav.'.$item['key']) }}
            </a>
            @endforeach
            @if(\App\Models\PageVisibility::isVisible('reviews'))
            <a href="{{ route('reviews') }}" @click="open = false" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">{{ __('mirto.nav.reviews') }}</a>
            @endif

            <div class="pt-3 border-t border-slate-100">
                <a href="{{ route('preventivo') }}"
                   class="block w-full rounded-full bg-mare px-4 py-3 text-center text-sm font-semibold text-white hover:bg-mare-deep transition-colors">
                    {{ __('mirto.cta.quote') }} →
                </a>
            </div>

            <div class="flex flex-wrap gap-2 pt-3 border-t border-slate-100">
                <p class="w-full text-xs text-slate-500 mb-1">Lingua:</p>
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                   class="rounded-full border px-3 py-1 text-xs font-bold uppercase {{ app()->getLocale() === $localeCode ? 'bg-blue-700 text-white border-blue-700' : 'border-slate-300 text-slate-600' }}">
                    {{ $localeCode }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
</nav>

{{-- Scroll detection via vanilla JS (più affidabile di Alpine per questo caso) --}}
<script>
(function(){
    var nav = document.getElementById('main-nav');
    var logo = document.getElementById('nav-logo');
    var isHome = {{ Request::routeIs('home') ? 'true' : 'false' }};

    function applyScrolled(scrolled) {
        var links = document.querySelectorAll('.nav-desktop-link');
        var langBtn = document.querySelector('.nav-lang-btn');
        if (scrolled || !isHome) {
            nav.style.background = 'rgba(255,255,255,.96)';
            nav.style.backdropFilter = 'blur(12px)';
            nav.style.webkitBackdropFilter = 'blur(12px)';
            nav.style.boxShadow = '0 1px 20px rgba(43,106,158,.12)';
            if (logo) { logo.style.color = '#1f5c4b'; }
            links.forEach(function(l){ l.style.color = '#374151'; });
            if (langBtn) { langBtn.style.color = '#6b7280'; langBtn.style.borderColor = '#d1d5db'; }
        } else {
            nav.style.background = 'transparent';
            nav.style.backdropFilter = '';
            nav.style.webkitBackdropFilter = '';
            nav.style.boxShadow = 'none';
            if (logo) { logo.style.color = 'white'; }
            links.forEach(function(l){ l.style.color = 'rgba(255,255,255,.9)'; });
            if (langBtn) { langBtn.style.color = 'rgba(255,255,255,.9)'; langBtn.style.borderColor = 'rgba(255,255,255,.4)'; }
        }
    }

    window.addEventListener('scroll', function(){ applyScrolled(window.scrollY > 80); }, {passive:true});
    applyScrolled(window.scrollY > 80);
})();
</script>

{{-- Flash messages --}}
@if(session('flash_ok') || session('flash_err'))
<div class="fixed top-20 inset-x-4 z-30 pointer-events-none" style="max-width:40rem;left:50%;transform:translateX(-50%);">
    @if(session('flash_ok'))
    <div class="pointer-events-auto mb-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-lg">
        <strong>✓</strong> {{ session('flash_ok') }}
    </div>
    @endif
    @if(session('flash_err'))
    <div class="pointer-events-auto mb-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900 shadow-lg">
        <strong>✕</strong> {{ session('flash_err') }}
    </div>
    @endif
</div>
@endif

{{-- ===== MAIN ===== --}}
<main>
    @yield('content')
</main>

{{-- ===== FOOTER ===== --}}
<footer style="background:linear-gradient(135deg,#1a4971 0%,#2b6a9e 100%);color:rgba(240,247,251,.9);">
    {{-- Wave top --}}
    <div class="h-14 bg-wave bg-bottom bg-repeat-x opacity-30 wave-anim" style="background-color:transparent;"></div>

    <div class="mx-auto max-w-7xl px-4 py-14 grid gap-10 md:grid-cols-2 lg:grid-cols-4">
        {{-- Brand --}}
        <div>
            <p class="font-display text-2xl font-semibold text-white">{{ __('mirto.brand') }}</p>
            <p class="mt-2 text-sm" style="color:rgba(240,247,251,.7);">{{ __('mirto.footer.tagline') }}</p>
            {{-- Real apartment photo --}}
            <img src="{{ asset('img/salotto.png') }}" alt="Soggiorno Il Mirto Apartment" class="mt-4 rounded-xl w-full object-cover" style="height:100px;opacity:.85;" loading="lazy">
            <div class="mt-4 flex gap-3">
                <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_e164', '393331234567') }}"
                   class="flex h-9 w-9 items-center justify-center rounded-full text-white transition hover:opacity-80" style="background:rgba(255,255,255,.15);" target="_blank" aria-label="WhatsApp">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
                <a href="mailto:{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}"
                   class="flex h-9 w-9 items-center justify-center rounded-full text-white transition hover:opacity-80" style="background:rgba(255,255,255,.15);" aria-label="Email">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </a>
            </div>
        </div>

        {{-- Links --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-white mb-4">{{ __('mirto.footer.explore') }}</p>
            <ul class="space-y-2.5 text-sm" style="color:rgba(240,247,251,.75);">
                @foreach([
                    ['route' => 'apartment', 'label' => 'L\'appartamento'],
                    ['route' => 'gallery', 'label' => 'Galleria foto'],
                    ['route' => 'services', 'label' => 'Servizi inclusi'],
                    ['route' => 'experiences', 'label' => 'Esperienze'],
                    ['route' => 'location', 'label' => 'Dove siamo'],
                    ['route' => 'faq', 'label' => 'FAQ'],
                ] as $item)
                <li><a href="{{ route($item['route']) }}" class="hover:text-white transition-colors">{{ $item['label'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- Prenotazione --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-white mb-4">{{ __('mirto.footer.booking') }}</p>
            <ul class="space-y-2.5 text-sm" style="color:rgba(240,247,251,.75);">
                <li><a href="{{ route('preventivo') }}" class="hover:text-white transition-colors">Preventivo immediato</a></li>
                <li><a href="{{ route('availability') }}" class="hover:text-white transition-colors">Disponibilità</a></li>
                <li><a href="{{ route('promotions') }}" class="hover:text-white transition-colors">Offerte speciali</a></li>
                <li><a href="{{ route('newsletter.page') }}" class="hover:text-white transition-colors">Newsletter</a></li>
                <li><a href="{{ route('contacts') }}" class="hover:text-white transition-colors">Contatti</a></li>
            </ul>
        </div>

        {{-- Contatti --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-white mb-4">{{ __('mirto.footer.info') }}</p>
            <ul class="space-y-2.5 text-sm" style="color:rgba(240,247,251,.75);">
                <li class="flex items-start gap-2">
                    <svg class="h-4 w-4 mt-0.5 shrink-0 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Via Giovanni Gentile 1<br>07026 Olbia (SS)</span>
                </li>
                <li><a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_e164', '393331234567') }}" class="hover:text-white transition-colors">{{ \App\Models\SiteSetting::get('phone_display', '+39 333 123 4567') }}</a></li>
                <li><a href="mailto:{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}" class="hover:text-white transition-colors">{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}</a></li>
            </ul>
            <div class="mt-5 space-y-1.5 text-xs" style="color:rgba(240,247,251,.5);">
                <a href="{{ route('privacy') }}" class="block hover:text-white transition-colors">Privacy Policy</a>
                <a href="{{ route('cookies') }}" class="block hover:text-white transition-colors">Cookie Policy</a>
                <a href="{{ route('terms') }}" class="block hover:text-white transition-colors">Termini di prenotazione</a>
            </div>
        </div>
    </div>

    <div class="border-t py-5 text-center text-xs" style="border-color:rgba(255,255,255,.12);color:rgba(240,247,251,.4);">
        © {{ date('Y') }} Il Mirto Apartment — Olbia, Sardegna, Italia &nbsp;·&nbsp;
        <strong style="color:rgba(240,247,251,.7);">{{ __('mirto.footer.copyright') }}</strong>
    </div>
</footer>

{{-- WhatsApp FAB --}}
<a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_e164', '393331234567') }}?text=Ciao!%20Sono%20interessato%20a%20Il%20Mirto%20Apartment.%20Potete%20aiutarmi%3F"
   target="_blank" rel="noopener noreferrer"
   class="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full text-white shadow-2xl transition-all duration-300 hover:-translate-y-1"
   style="background:#25D366;box-shadow:0 8px 25px rgba(37,211,102,.4);"
   title="Scrivici su WhatsApp">
    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

{{-- Exit intent popup --}}
@livewire('public.exit-intent-offer')

{{-- Scroll fade-in observer --}}
<script>
(function(){
    if('IntersectionObserver' in window){
        var obs=new IntersectionObserver(function(entries){
            entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target);}});
        },{threshold:.1});
        document.querySelectorAll('.fade-in').forEach(function(el){obs.observe(el);});
    }else{
        document.querySelectorAll('.fade-in').forEach(function(el){el.classList.add('visible');});
    }
})();
</script>

@stack('scripts')
@livewireStyles
@php
    $lvManifest = json_decode(@file_get_contents(base_path('vendor/livewire/livewire/dist/manifest.json')), true) ?? [];
    $lvId = $lvManifest['/livewire.js'] ?? 'dev';
@endphp
<script
    src="{{ url('/livewire/livewire.js') }}?id={{ $lvId }}"
    data-csrf="{{ csrf_token() }}"
    data-update-uri="{{ url('/livewire/update') }}"
    data-navigate-once="true"
></script>
</body>
</html>
