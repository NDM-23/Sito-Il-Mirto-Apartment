@extends('layouts.mirto')
@section('title', 'Servizi & Dotazioni — Il Mirto Apartment Olbia')
@section('meta_description', 'Piscina, WiFi, aria condizionata, cucina completa, parcheggio. Tutti i servizi inclusi nel tuo appartamento vacanze a Olbia, Sardegna.')

@section('content')

{{-- Mini-hero --}}
<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#1a6f78 0%,#2fb5c3 100%);min-height:280px;">
    <div class="absolute inset-0 opacity-20 bg-wave bg-bottom bg-repeat-x" style="background-color:transparent;"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Servizi</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);line-height:1.1;">Servizi inclusi</h1>
        <p class="mt-4 max-w-xl" style="color:rgba(255,255,255,.8);">Tutto il comfort che ti aspetti, senza compromessi. Ecco cosa trovi ad aspettarti.</p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16">

    {{-- Servizi principali --}}
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach([
            [
                'icon' => '🏊‍♂️',
                'title' => 'Piscina condominiale',
                'text' => 'Accesso libero alla piscina esterna per tutta la durata del soggiorno. Zona solarium attrezzata. Disponibile giugno–settembre.',
                'badge' => 'Il plus',
                'color' => 'mare',
            ],
            [
                'icon' => '📶',
                'title' => 'Wi‑Fi ultra-fast',
                'text' => 'Connessione a banda larga in tutto l\'appartamento. Perfetta per smart working, streaming e video-chiamate in vacanza.',
                'badge' => 'Incluso',
                'color' => 'mirto',
            ],
            [
                'icon' => '❄️',
                'title' => 'Aria condizionata',
                'text' => 'Climatizzazione silenzioso in soggiorno e nelle camere. Anche il riscaldamento per la mezza stagione, se necessario.',
                'badge' => 'Incluso',
                'color' => 'mirto',
            ],
            [
                'icon' => '🍳',
                'title' => 'Cucina completa',
                'text' => 'Piano cottura, forno, frigorifero americano, lavastoviglie, microonde, macchinetta caffè, bollitore. Tutte le stoviglie e utensili.',
                'badge' => 'Incluso',
                'color' => 'mirto',
            ],
            [
                'icon' => '🅿️',
                'title' => 'Parcheggio',
                'text' => 'Parcheggio disponibile in zona per tutta la durata del soggiorno. Comodo per chi arriva in auto o noleggia un mezzo.',
                'badge' => 'Disponibile',
                'color' => 'mirto',
            ],
            [
                'icon' => '🔑',
                'title' => 'Self check-in',
                'text' => 'Arrivi tardi? Nessun problema. Il check-in autonomo ti permette di entrare in qualsiasi orario, senza aspettare nessuno.',
                'badge' => 'Smart',
                'color' => 'mare',
            ],
            [
                'icon' => '👨‍👩‍👧‍👦',
                'title' => 'Adatto alle famiglie',
                'text' => 'Spazi ampi, cucina completa, possibilità di culla su richiesta. La piscina è sicura e sorvegliata. I bambini adoreranno.',
                'badge' => 'Family friendly',
                'color' => 'mirto',
            ],
            [
                'icon' => '🧺',
                'title' => 'Lavatrice',
                'text' => 'Lavatrice a disposizione per soggiorni lunghi. Detergente fornito. Asciugatura naturale all\'aria aperta nella zona riservata.',
                'badge' => 'Incluso',
                'color' => 'mirto',
            ],
            [
                'icon' => '🛁',
                'title' => 'Bagno completo',
                'text' => 'Doccia spaziosa, asciugamani inclusi (cambio su richiesta), phon, kit cortesia di benvenuto, specchio illuminato.',
                'badge' => 'Incluso',
                'color' => 'mirto',
            ],
        ] as $srv)
        <div class="rounded-2xl bg-white p-6 shadow-md ring-1 ring-slate-100 card-hover fade-in">
            <div class="flex items-start justify-between">
                <span class="text-4xl">{{ $srv['icon'] }}</span>
                <span class="rounded-full px-2.5 py-1 text-xs font-semibold" style="background-color:{{ $srv['color']==='mare' ? 'rgba(47,181,195,.1)' : 'rgba(31,92,75,.08)' }};color:{{ $srv['color']==='mare' ? '#1a6f78' : '#1f5c4b' }};">
                    {{ $srv['badge'] }}
                </span>
            </div>
            <h3 class="mt-4 font-display text-xl font-semibold text-mirto">{{ $srv['title'] }}</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $srv['text'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Prossimità --}}
    <div class="mt-20 fade-in">
        <div class="text-center mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">A pochi passi</span>
            <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.5rem);">Tutto a portata di mano</h2>
            <p class="mt-3 text-slate-600">La posizione è uno dei punti di forza dell'appartamento.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach([
                ['emoji'=>'✈️','place'=>'Aeroporto Olbia Costa Smeralda','dist'=>'~5 min in auto','note'=>'Perfetto per chi arriva tardi o riparte presto'],
                ['emoji'=>'🚢','place'=>'Porto Isola Bianca','dist'=>'~10–12 min','note'=>'Traghetti per Genova, Civitavecchia, Livorno'],
                ['emoji'=>'🏖️','place'=>'Spiaggia di Pittulongu','dist'=>'~12–15 min','note'=>'Sabbia bianca, acque turchesi, servizi completi'],
                ['emoji'=>'🌊','place'=>'Porto Istana (4 spiagge)','dist'=>'~18 min','note'=>'Acque cristalline, ideale per famiglie con bambini'],
                ['emoji'=>'🛒','place'=>'Supermercato','dist'=>'~2–3 min','note'=>'Eurospin, Lidl nelle immediate vicinanze'],
                ['emoji'=>'🍕','place'=>'Ristoranti e locali','dist'=>'~5 min','note'=>'Cucina sarda, pizzerie, lounge bar, gelaterie'],
                ['emoji'=>'🏥','place'=>'Ospedale Civile Olbia','dist'=>'~10 min','note'=>'Pronto Soccorso H24'],
                ['emoji'=>'💎','place'=>'Costa Smeralda (Porto Cervo)','dist'=>'~30–35 min','note'=>'La destinazione glamour del Mediterraneo'],
                ['emoji'=>'⛰️','place'=>'Isola Tavolara','dist'=>'~20 min','note'=>'Riserva naturale, snorkeling e gite in barca'],
            ] as $loc)
            <div class="flex items-start gap-4 rounded-xl bg-sabbia p-4 shadow-sm">
                <span class="text-3xl shrink-0">{{ $loc['emoji'] }}</span>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">{{ $loc['place'] }}</p>
                    <p class="text-xs font-bold text-mare-deep">{{ $loc['dist'] }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $loc['note'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="mt-16 rounded-3xl p-10 text-center fade-in" style="background:linear-gradient(135deg,#1f5c4b,#1a6f78);">
        <h3 class="font-display text-2xl font-semibold text-white">Convinto? Prenota ora.</h3>
        <p class="mt-2 text-sm" style="color:rgba(255,255,255,.8);">Zero commissioni. Risposta in 2 ore. Prezzo migliore garantito.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-4">
            <a href="{{ route('preventivo') }}" class="rounded-full bg-white px-6 py-3 text-sm font-semibold text-mirto shadow-lg transition hover:-translate-y-0.5">Preventivo immediato →</a>
            <a href="{{ route('availability') }}" class="rounded-full border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Vedi disponibilità</a>
        </div>
    </div>
</div>
@endsection
