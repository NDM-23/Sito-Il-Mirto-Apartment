@extends('layouts.mirto')
@section('title', 'Dove siamo — Il Mirto Apartment Via Giovanni Gentile 1 Olbia')
@section('meta_description', 'Appartamento a Via Giovanni Gentile 1, Olbia. A 5 min dall\'aeroporto, 15 min dalle spiagge, 30 min dalla Costa Smeralda. La posizione perfetta per la Sardegna.')

@section('content')

{{-- Mini-hero --}}
<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#1a4971 0%,#2b6a9e 100%);min-height:280px;">
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Dove siamo</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);">Dove siamo</h1>
        <p class="mt-3 max-w-xl" style="color:rgba(255,255,255,.8);">Via Giovanni Gentile 1, 07026 Olbia (SS) — Sardegna, Italia.</p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16">

    {{-- Map + info --}}
    <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
        <div class="fade-in">
            <div class="overflow-hidden rounded-2xl shadow-2xl">
                <iframe
                    src="{{ $mapUrl }}"
                    class="w-full"
                    style="height:460px;border:0;"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="mt-4 flex gap-3">
                <a href="https://maps.google.com/?q=Via+Giovanni+Gentile+1,+Olbia"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-full bg-mirto px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-mirto-light">
                    📍 Apri in Google Maps
                </a>
                <a href="https://maps.apple.com/?q=Via+Giovanni+Gentile+1,+Olbia"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-mirto ring-1 ring-mirto/20 transition hover:bg-sabbia">
                    🍎 Apple Maps
                </a>
            </div>
        </div>

        <div class="fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Posizione imbattibile</span>
            <h2 class="mt-3 font-display font-semibold text-mirto" style="font-size:clamp(1.6rem,4vw,2.2rem);">
                La base perfetta<br>per la Sardegna del nord-est
            </h2>
            <p class="mt-4 text-slate-600 leading-relaxed">
                In un quartiere tranquillo ma centralissimo di Olbia: a pochi minuti dall'aeroporto, dal porto,
                dai supermercati e dalla vita del centro. E con le spiagge più belle raggiungibili in meno di 20 minuti.
            </p>

            <div class="mt-8 space-y-4">
                @foreach([
                    ['emoji'=>'✈️', 'place'=>'Aeroporto Olbia Costa Smeralda (OLB)', 'dist'=>'~5 km — 5–8 min in auto', 'note'=>'Il trasferimento più veloce che troverai mai.'],
                    ['emoji'=>'🚢', 'place'=>'Porto Isola Bianca (traghetti)', 'dist'=>'~8 km — 10–15 min', 'note'=>'Traghetti per Genova, Civitavecchia, Livorno, Barcellona.'],
                    ['emoji'=>'🚉', 'place'=>'Stazione Ferroviaria Olbia', 'dist'=>'~3 km — 5–8 min', 'note'=>'Collegata con Sassari e il resto della Sardegna.'],
                    ['emoji'=>'🏖️', 'place'=>'Spiaggia Pittulongu (La Playa)', 'dist'=>'~10 km — 12–15 min', 'note'=>'La spiaggia più popolare di Olbia, sabbia fine e acque turchesi.'],
                    ['emoji'=>'🌊', 'place'=>'Porto Istana (4 spiagge)', 'dist'=>'~15 km — 18 min', 'note'=>'Le spiagge più belle e riservate del territorio.'],
                    ['emoji'=>'🛒', 'place'=>'Supermercati (Eurospin, Lidl, Esselunga)', 'dist'=>'~1–2 km — 2–3 min', 'note'=>'Tutto il necessario per la spesa quotidiana.'],
                    ['emoji'=>'💎', 'place'=>'Porto Cervo — Costa Smeralda', 'dist'=>'~35 km — 30–35 min', 'note'=>'Il cuore esclusivo della Costa Smeralda.'],
                    ['emoji'=>'🚤', 'place'=>'Palau (imbarco per La Maddalena)', 'dist'=>'~60 km — 45–50 min', 'note'=>'L\'Arcipelago de La Maddalena, uno dei posti più belli del mondo.'],
                ] as $dist)
                <div class="flex items-start gap-4 rounded-xl bg-sabbia p-4">
                    <span class="text-2xl shrink-0 mt-0.5">{{ $dist['emoji'] }}</span>
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-800 text-sm">{{ $dist['place'] }}</p>
                        <p class="text-xs font-bold text-mare-deep mt-0.5">{{ $dist['dist'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $dist['note'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Come arrivare --}}
    <div class="mt-20 fade-in">
        <div class="text-center mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Praticamente</span>
            <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.5rem);">Come arrivare</h2>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            @foreach([
                ['icon'=>'✈️', 'method'=>'In aereo', 'steps'=>['Atterrate a Olbia Costa Smeralda (OLB)','Taxi: ~5–8 min, circa €15–20','Auto a noleggio: consigliata per le spiagge','Bus navetta linea 2 o 10 per il centro']],
                ['icon'=>'🚢', 'method'=>'In traghetto', 'steps'=>['Traghetto da Genova, Civitavecchia, Livorno','Arrivo al Porto Isola Bianca','Auto propria: seguire indicazioni centro','Appartamento a ~10 min dal porto']],
                ['icon'=>'🚗', 'method'=>'In auto', 'steps'=>['SS131 (Sassari) o SS125 (Nuoro)','Parcheggio in zona disponibile','Navigatore: "Via Giovanni Gentile 1, Olbia"','Citofono interno 25 (chiedere al host)']],
            ] as $how)
            <div class="rounded-2xl bg-white p-6 shadow-md ring-1 ring-slate-100 fade-in">
                <span class="text-4xl">{{ $how['icon'] }}</span>
                <h3 class="mt-4 font-display text-xl font-semibold text-mirto">{{ $how['method'] }}</h3>
                <ol class="mt-4 space-y-2">
                    @foreach($how['steps'] as $i => $step)
                    <li class="flex items-start gap-2 text-sm text-slate-600">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-mirto text-white text-xs font-bold">{{ $i+1 }}</span>
                        {{ $step }}
                    </li>
                    @endforeach
                </ol>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="mt-16 text-center fade-in">
        <p class="text-slate-600 mb-6">Hai bisogno di indicazioni specifiche o trasferimento dall'aeroporto?</p>
        <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_e164', '393331234567') }}?text=Ciao!%20Ho%20bisogno%20di%20indicazioni%20per%20raggiungere%20l'appartamento."
           class="inline-flex items-center gap-2 rounded-full bg-green-500 px-7 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-green-600">
            Chiedici su WhatsApp →
        </a>
    </div>
</div>
@endsection
