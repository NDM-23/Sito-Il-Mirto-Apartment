@extends('layouts.mirto')
@section('title', 'Esperienze in Sardegna — Il Mirto Apartment Olbia')
@section('meta_description', 'Spiagge, gite in barca, Costa Smeralda, ristoranti sardi, escursioni. Tutto ciò che puoi vivere partendo dall\'appartamento a Olbia.')

@section('content')

{{-- Mini-hero --}}
<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#2fb5c3 0%,#1f5c4b 100%);min-height:320px;">
    <img src="https://picsum.photos/seed/sardinia-coast-aerial/1920/600"
         alt="Sardegna costa"
         class="absolute inset-0 h-full w-full object-cover opacity-30"
         loading="eager">
    <div class="relative mx-auto max-w-7xl px-4 py-20 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Esperienze</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);">
            Esperienze indimenticabili
        </h1>
        <p class="mt-4 max-w-2xl" style="color:rgba(255,255,255,.85);font-size:1.1rem;">
            La Sardegna del nord-est è tra le destinazioni più belle del Mediterraneo.
            Dalla tua base a Olbia, tutto è raggiungibile in pochi minuti.
        </p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16">

    {{-- Spiagge --}}
    <section class="mb-20 fade-in">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Mare cristallino</span>
                <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.5rem);">Le spiagge più belle</h2>
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach([
                [
                    'img' => 'pittulongu-beach-sardinia',
                    'name' => 'Pittulongu (La Playa)',
                    'dist' => '12–15 min in auto',
                    'text' => 'La spiaggia preferita dagli Olbiesi. Sabbia bianca finissima, acque turchesi, vista spettacolare sull\'isola di Tavolara. Bar, lettini, parcheggio. Raggiungibile anche in bus.',
                    'tag' => '🏖️ Sabbia finissima',
                ],
                [
                    'img' => 'porto-istana-sardinia',
                    'name' => 'Porto Istana',
                    'dist' => '18 min in auto',
                    'text' => 'Quattro spiagge separate, acque bassissime ideali per i bambini, fondale attrezzato per lo snorkeling. La più bella di Olbia secondo molti. Prenotare ombrelloni in alta stagione.',
                    'tag' => '🐠 Snorkeling',
                ],
                [
                    'img' => 'bados-beach-olbia',
                    'name' => 'Bados & Spiaggia Bianca',
                    'dist' => '15 min in auto',
                    'text' => 'Calette protette con sabbia bianchissima e acqua trasparente. Meno affollata di Pittulongu, perfetta per chi cerca tranquillità. Possibilità di snorkeling nelle calette rocciose.',
                    'tag' => '🤿 Calette riservate',
                ],
                [
                    'img' => 'cala-brandinchi-sardinia',
                    'name' => 'Cala Brandinchi (Tahiti Sarda)',
                    'dist' => '35 min verso San Teodoro',
                    'text' => 'Una delle spiagge più fotografate del mondo. Acque verde-smeraldo, sabbia bianca lunghissima. Vale ogni chilometro. Arriva presto in alta stagione per trovare posto.',
                    'tag' => '📸 Spettacolare',
                ],
                [
                    'img' => 'romazzino-costa-smeralda',
                    'name' => 'Costa Smeralda',
                    'dist' => '30–40 min',
                    'text' => 'Capriccioli, Romazzino, Piccolo Pevero — le spiagge iconiche della Costa Smeralda. Acqua impossibilmente blu, rocce di granito rosa. L\'esperienza Sardegna per eccellenza.',
                    'tag' => '💎 Iconica',
                ],
                [
                    'img' => 'isola-tavolara-olbia',
                    'name' => 'Isola Tavolara',
                    'dist' => 'Gita in barca da Porto San Paolo',
                    'text' => 'Un gigante di calcare che emerge dal mare. Riserva naturale, acque incontaminate, la spiaggia più piccola del "regno" più piccolo del mondo. Escursione indimenticabile.',
                    'tag' => '⛵ Escursione',
                ],
            ] as $beach)
            <div class="group overflow-hidden rounded-2xl bg-white shadow-md card-hover">
                <div class="overflow-hidden h-48">
                    <img src="https://picsum.photos/seed/{{ $beach['img'] }}/600/400"
                         alt="{{ $beach['name'] }}"
                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                         loading="lazy">
                </div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="font-display text-lg font-semibold text-mirto">{{ $beach['name'] }}</h3>
                        <span class="shrink-0 text-xs bg-sabbia rounded-full px-2.5 py-1 text-slate-600">{{ $beach['tag'] }}</span>
                    </div>
                    <p class="mt-1 text-xs font-semibold text-mare-deep">📍 {{ $beach['dist'] }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $beach['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Gite in barca --}}
    <section class="mb-20 fade-in rounded-3xl overflow-hidden shadow-2xl">
        <div class="grid lg:grid-cols-2">
            <div class="relative h-64 lg:h-auto">
                <img src="https://picsum.photos/seed/maddalena-boat-trip/800/600"
                     alt="Arcipelago di La Maddalena gita in barca"
                     class="absolute inset-0 h-full w-full object-cover"
                     loading="lazy">
            </div>
            <div class="p-10" style="background:#f6f1e8;">
                <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Da non perdere</span>
                <h2 class="mt-3 font-display font-semibold text-mirto" style="font-size:clamp(1.6rem,4vw,2.2rem);">Gite in barca</h2>
                <p class="mt-4 text-slate-600 leading-relaxed">
                    L'Arcipelago di La Maddalena è a meno di un'ora da Olbia. Isole disabitate, spiagge di sabbia rosa,
                    acque incredibilmente trasparenti. Le escursioni in barca partono ogni mattina dai porti vicini.
                </p>
                <ul class="mt-5 space-y-2 text-sm text-slate-700">
                    @foreach([
                        'Arcipelago di La Maddalena (Spargi, Budelli, Santa Maria)',
                        'Isola di Tavolara e la Riserva Naturale',
                        'Snorkeling nelle acque protette',
                        'Tour al tramonto con aperitivo a bordo',
                        'Noleggio gommone senza patente (in zona)',
                    ] as $item)
                    <li class="flex items-center gap-2">
                        <span class="h-5 w-5 flex items-center justify-center rounded-full bg-mare/15 text-mare text-xs shrink-0">✓</span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Costa Smeralda & vita serale --}}
    <section class="mb-20 grid gap-8 md:grid-cols-2">
        <div class="rounded-2xl bg-white p-8 shadow-md card-hover fade-in">
            <span class="text-4xl">💎</span>
            <h3 class="mt-4 font-display text-2xl font-semibold text-mirto">Costa Smeralda</h3>
            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                Porto Cervo, Cala di Volpe, Portisco — il glamour del Mediterraneo a 30 minuti.
                Boutique di lusso, yacht da sogno, spiagge esclusive. Un pomeriggio a Porto Cervo
                è un'esperienza che non si dimentica, anche solo per passeggiare nel porto.
            </p>
            <ul class="mt-4 space-y-1.5 text-xs text-slate-600">
                @foreach(['Porto Cervo: 35 min','Cala di Volpe: 40 min','Portisco & Porto Rotondo: 20–25 min'] as $item)
                <li class="flex items-center gap-2"><span class="text-mare">→</span> {{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <div class="rounded-2xl bg-white p-8 shadow-md card-hover fade-in">
            <span class="text-4xl">🌙</span>
            <h3 class="mt-4 font-display text-2xl font-semibold text-mirto">Vita serale & ristoranti</h3>
            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                Olbia ha una vita serale sorprendentemente vivace: il Corso Umberto si anima dal tramonto,
                enoteche con Vermentino locale, trattorie autentiche con culurgiones, bottarga e porceddu.
                Per il glamour vero, le venue della Costa Smeralda sono a 30 minuti.
            </p>
            <ul class="mt-4 space-y-1.5 text-xs text-slate-600">
                @foreach(['Ristoranti a Olbia: 5 min a piedi/auto','Aperitivo sul Corso Umberto','Discoteche e lounge in Costa Smeralda'] as $item)
                <li class="flex items-center gap-2"><span class="text-mare">→</span> {{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Escursioni terra --}}
    <section class="mb-16 fade-in">
        <div class="text-center mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Oltre il mare</span>
            <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.5rem);">Escursioni nell'entroterra</h2>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            @foreach([
                ['emoji'=>'🍷', 'title'=>'Cantine del Vermentino', 'text'=>'La Gallura è la terra del Vermentino. Visite alle cantine, degustazioni guidate, acquisto diretto. Un modo autentico di conoscere la Sardegna.'],
                ['emoji'=>'🏛️', 'title'=>'Nuraghi e storia Sarda', 'text'=>'Il Nuraghe La Prisgiona è uno dei più belli della Sardegna, a 20 minuti da Olbia. Siti UNESCO, testimonianze di una civiltà unica.'],
                ['emoji'=>'🌿', 'title'=>'Riserva di Capo Figari', 'text'=>'Parco naturale con sentieri panoramici, flora mediterranea profumata (mirto, cisto, lavanda) e mufloni allo stato brado. A 20 minuti.'],
                ['emoji'=>'🐎', 'title'=>'Agriturismo e tradizioni', 'text'=>'Pranzi sardi autentici, formaggio pecorino, pane carasau. Gli agriturismi della Gallura offrono esperienze gastronomiche uniche.'],
                ['emoji'=>'🛍️', 'title'=>'Shopping a Olbia', 'text'=>'Il centro di Olbia ha boutique, negozi di artigianato sardo, mercatini. I prodotti tipici da portare a casa: vino, formaggio, bottarga, sughero.'],
                ['emoji'=>'⛩️', 'title'=>'Palau & Arcipelago', 'text'=>'La Fortezza di Roccia dell\'Orso, poi imbarco per La Maddalena. Un giorno intero di avventura a 40 minuti dall\'appartamento.'],
            ] as $excurs)
            <div class="rounded-xl bg-sabbia p-5 shadow-sm ring-1 ring-slate-100 card-hover fade-in">
                <span class="text-3xl">{{ $excurs['emoji'] }}</span>
                <h3 class="mt-3 font-semibold text-mirto">{{ $excurs['title'] }}</h3>
                <p class="mt-2 text-xs leading-relaxed text-slate-600">{{ $excurs['text'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <div class="text-center fade-in">
        <a href="{{ route('preventivo') }}"
           class="inline-flex items-center gap-2 rounded-full bg-mare px-8 py-4 text-base font-semibold text-white shadow-xl transition hover:bg-mare-deep hover:-translate-y-1">
            Prenota e inizia la tua avventura →
        </a>
    </div>
</div>
@endsection
