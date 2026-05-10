@extends('layouts.mirto')
@section('title', 'Offerte Speciali — Il Mirto Apartment Olbia')
@section('meta_description', 'Last minute, early booking, soggiorni settimana intera. Scopri le offerte speciali del Mirto Apartment e prenota direttamente per risparmiare.')

@section('content')

{{-- Mini-hero --}}
<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#1a6f78 0%,#2fb5c3 100%);min-height:280px;">
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Promozioni</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);">Offerte speciali</h1>
        <p class="mt-3 max-w-xl" style="color:rgba(255,255,255,.8);">Le migliori offerte si trovano prenotando direttamente. Zero commissioni, prezzo migliore garantito.</p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16">

    {{-- Promozioni attive --}}
    @if($promos->isNotEmpty())
    <section class="mb-16">
        <div class="text-center mb-10 fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Disponibili ora</span>
            <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.5rem);">Offerte attive</h2>
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($promos as $p)
            <div class="relative overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-amber-100 card-hover fade-in">
                <div class="absolute top-0 right-0 h-1 w-full" style="background:linear-gradient(to right,#2fb5c3,#1f5c4b);"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-800">
                            {{ $p->code }}
                        </span>
                        @if($p->discount_pct)
                        <span class="font-display text-3xl font-bold text-mirto">-{{ $p->discount_pct }}%</span>
                        @elseif($p->discount_flat_cents)
                        <span class="font-display text-2xl font-bold text-mirto">-{{ number_format($p->discount_flat_cents/100,0,',','.') }}€</span>
                        @endif
                    </div>
                    <h3 class="mt-4 font-display text-xl font-semibold text-slate-800">{{ $p->name }}</h3>
                    @if($p->description)
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $p->description }}</p>
                    @endif
                    <div class="mt-4 space-y-1 text-xs text-slate-500">
                        @if($p->valid_from)<p>Da: {{ $p->valid_from->format('d/m/Y') }}</p>@endif
                        @if($p->valid_to)<p>Fino al: <strong class="text-red-600">{{ $p->valid_to->format('d/m/Y') }}</strong></p>@endif
                        @if($p->min_nights)<p>Min. notti: {{ $p->min_nights }}</p>@endif
                    </div>
                    <a href="{{ route('preventivo') }}?promo={{ $p->code }}"
                       class="mt-5 block w-full rounded-full bg-mare py-2.5 text-center text-sm font-semibold text-white transition hover:bg-mare-deep">
                        Usa questa offerta →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Countdown promo + placeholder --}}
    <section class="mb-16 fade-in">
        <div class="text-center mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Le nostre politiche</span>
            <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.5rem);">Tipologie di offerta</h2>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @foreach([
                ['emoji'=>'⚡', 'color'=>'#e53e3e', 'bg'=>'#fff5f5', 'title'=>'Last Minute', 'text'=>'Prenotando con meno di 2 settimane di anticipo, spesso offriamo sconti speciali sulle date ancora libere. Iscriviti alla newsletter per riceverle in anteprima.'],
                ['emoji'=>'📅', 'color'=>'#1a6f78', 'bg'=>'#e6f7f9', 'title'=>'Early Booking', 'text'=>'Chi prenota con anticipo (più di 60 giorni) ottiene condizioni migliori. Blocca la tua settimana preferita prima che finisca disponibilità.'],
                ['emoji'=>'🗓️', 'color'=>'#1f5c4b', 'bg'=>'#ecf9f3', 'title'=>'Settimana intera', 'text'=>'Per soggiorni di 7+ notti il prezzo per notte scende. La vacanza lunga è la più bella — e la più conveniente.'],
                ['emoji'=>'💌', 'color'=>'#b45309', 'bg'=>'#fffbeb', 'title'=>'Offerte newsletter', 'text'=>'Gli iscritti alla newsletter ricevono codici sconto esclusivi, first access alle date migliori e offerte riservate. Iscriviti qui sotto.'],
            ] as $type)
            <div class="rounded-2xl p-6 shadow-sm border fade-in" style="background:{{ $type['bg'] }};border-color:{{ $type['color'] }}1a;">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-3xl">{{ $type['emoji'] }}</span>
                    <h3 class="font-display text-xl font-semibold" style="color:{{ $type['color'] }};">{{ $type['title'] }}</h3>
                </div>
                <p class="text-sm leading-relaxed text-slate-600">{{ $type['text'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Countdown Livewire --}}
    @livewire('public.promo-countdown')

    {{-- Newsletter CTA --}}
    <section class="mt-16 fade-in">
        <div class="rounded-3xl p-10 text-center" style="background:linear-gradient(135deg,#1f5c4b,#2fb5c3);">
            <span class="text-4xl">🎁</span>
            <h3 class="mt-4 font-display text-2xl font-semibold text-white">Vuoi essere il primo a sapere delle offerte?</h3>
            <p class="mt-3 max-w-md mx-auto text-sm" style="color:rgba(255,255,255,.85);">
                Iscriviti alla newsletter gratuita: riceverai last minute, early booking e codici sconto esclusivi prima di chiunque altro.
            </p>
            <a href="{{ route('newsletter.page') }}"
               class="mt-6 inline-flex items-center gap-2 rounded-full bg-white px-7 py-3.5 text-sm font-semibold text-mirto shadow-lg transition hover:-translate-y-1">
                Iscriviti gratis alla newsletter →
            </a>
        </div>
    </section>

    {{-- Come usare --}}
    <div class="mt-16 fade-in">
        <h3 class="font-display text-2xl text-mirto text-center mb-8">Come usare un codice promo</h3>
        <div class="grid gap-4 md:grid-cols-3">
            @foreach([
                ['n'=>'1', 'title'=>'Vai al preventivo', 'text'=>'Accedi alla pagina preventivo e inserisci le tue date.'],
                ['n'=>'2', 'title'=>'Inserisci il codice', 'text'=>'Nel campo "Codice promo" digita il codice esatto, maiuscolo.'],
                ['n'=>'3', 'title'=>'Calcola e prenota', 'text'=>'Il sistema applica automaticamente lo sconto. Inviaci il preventivo via WhatsApp per completare.'],
            ] as $step)
            <div class="flex items-start gap-4 rounded-xl bg-white p-5 shadow-sm">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-mirto text-white font-bold text-sm">{{ $step['n'] }}</span>
                <div>
                    <p class="font-semibold text-slate-800">{{ $step['title'] }}</p>
                    <p class="text-sm text-slate-600 mt-1">{{ $step['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('preventivo') }}" class="inline-flex items-center gap-2 rounded-full bg-mare px-7 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-mare-deep hover:-translate-y-0.5">
                Calcola il tuo preventivo →
            </a>
        </div>
    </div>
</div>
@endsection
