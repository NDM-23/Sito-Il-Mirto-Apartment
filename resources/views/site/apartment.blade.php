@extends('layouts.mirto')
@section('title', 'L\'Appartamento — Il Mirto Apartment Olbia Sardegna')
@section('meta_description', 'Appartamento vacanze moderno con piscina a Olbia. 2 camere, cucina completa, aria condizionata, WiFi. Scopri tutti i dettagli e prenota direttamente.')

@section('content')

{{-- Mini-hero --}}
<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#1a4971 0%,#2b6a9e 100%);min-height:300px;">
    <div class="absolute inset-0 opacity-20 bg-wave bg-bottom bg-repeat-x wave-anim" style="background-color:transparent;"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span class="mx-2">›</span>
            <span class="text-white">L'Appartamento</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);line-height:1.1;">
            L'Appartamento
        </h1>
        <p class="mt-4 max-w-2xl" style="color:rgba(255,255,255,.8);font-size:1.1rem;">
            Moderno, luminoso, curato. Tutto quello che ti serve per una vacanza davvero rilassante in Sardegna.
        </p>
    </div>
</div>

{{-- Content --}}
<div class="mx-auto max-w-7xl px-4 py-16">

    {{-- Intro + hero image --}}
    <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
        <div class="fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Il tuo rifugio in Sardegna</span>
            <h2 class="mt-3 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.8rem);">
                Eleganza senza formalità
            </h2>
            <p class="mt-5 leading-relaxed text-slate-600" style="font-size:1.05rem;">
                Arredi nuovi, linee pulite, luce naturale ovunque. Il Mirto Apartment nasce dalla passione per i dettagli:
                ogni materiale scelto con cura, ogni spazio pensato per farti sentire a casa — con il lusso delle vacanze.
            </p>
            <p class="mt-4 leading-relaxed text-slate-600">
                Rientri dalla spiaggia: la doccia è fresca, il frigo è pieno, il divano ti aspetta. Alle 19 aperitivo in terrazza
                con vista sul giardino, poi cena fuori — i ristoranti di Olbia sono a 5 minuti in auto.
                Torna tardi, dormi bene, ripeti.
            </p>

            <div class="mt-8 grid grid-cols-2 gap-4">
                @foreach([
                    ['icon'=>'📐', 'label'=>'Superficie', 'val'=>'~65 m²'],
                    ['icon'=>'🛏️', 'label'=>'Camere da letto', 'val'=>'2'],
                    ['icon'=>'🚿', 'label'=>'Bagni', 'val'=>'1 completo'],
                    ['icon'=>'👥', 'label'=>'Ospiti max', 'val'=>'4 + culla'],
                ] as $stat)
                <div class="rounded-xl bg-sabbia p-4 text-center">
                    <span class="text-2xl">{{ $stat['icon'] }}</span>
                    <p class="mt-1 text-xs text-slate-500">{{ $stat['label'] }}</p>
                    <p class="font-semibold text-mirto">{{ $stat['val'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="fade-in">
            <div class="relative">
                <img src="https://picsum.photos/seed/mirto-apartment-main/800/600"
                     alt="Il Mirto Apartment soggiorno principale"
                     class="w-full rounded-3xl object-cover shadow-2xl"
                     style="height:460px;object-position:center;"
                     loading="lazy">
                <div class="absolute top-4 right-4 rounded-2xl bg-white/95 px-4 py-3 shadow-lg">
                    <div class="flex gap-0.5 text-amber-400 text-sm">★★★★★</div>
                    <p class="text-xs text-slate-500 mt-0.5">9.4/10 Ospiti soddisfatti</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Rooms --}}
    <div class="mt-20">
        <div class="text-center mb-12 fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Ogni spazio</span>
            <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.5rem);">
                Gli ambienti
            </h2>
        </div>

        <div class="space-y-16">
            {{-- Soggiorno --}}
            <div class="grid gap-8 lg:grid-cols-2 lg:items-center fade-in">
                <div class="overflow-hidden rounded-2xl shadow-xl">
                    <img src="{{ asset('img/salotto.png') }}"
                         alt="Soggiorno Il Mirto Apartment"
                         class="w-full object-cover" style="height:340px;" loading="lazy">
                </div>
                <div>
                    <h3 class="font-display text-2xl font-semibold text-mirto">Soggiorno & zona pranzo</h3>
                    <p class="mt-3 leading-relaxed text-slate-600">
                        Ampio e luminoso, con divano comodo e zona pranzo per 4 persone. La TV smart è collegata
                        al WiFi ad alta velocità. Le finestre portano aria fresca e luce del sole già al mattino.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-700">
                        @foreach(['Smart TV', 'Divano ampio', 'Tavolo pranzo 4 posti', 'Wi‑Fi veloce', 'Aria condizionata silenzioso', 'Luce naturale'] as $item)
                        <li class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-mare shrink-0"></span> {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Camere --}}
            <div class="grid gap-8 lg:grid-cols-2 lg:items-center fade-in">
                <div class="order-2 lg:order-1">
                    <h3 class="font-display text-2xl font-semibold text-mirto">Le camere da letto</h3>
                    <p class="mt-3 leading-relaxed text-slate-600">
                        Due camere tranquille per un riposo rigenerante. Letti con materasso comfort, armadi capienti,
                        biancheria inclusa. Finestre con oscuranti per dormire anche nelle mattine di sole pieno.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-700">
                        @foreach(['Camera matrimoniale/king', 'Camera doppia/twin', 'Armadi con ampio spazio', 'Lenzuola e asciugamani inclusi', 'Oscuranti alle finestre', 'Aria condizionata'] as $item)
                        <li class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-mare shrink-0"></span> {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="order-1 lg:order-2 overflow-hidden rounded-2xl shadow-xl">
                    <img src="https://picsum.photos/seed/sardinia-bedroom-white/800/600"
                         alt="Camera da letto Il Mirto Apartment"
                         class="w-full object-cover" style="height:340px;" loading="lazy">
                </div>
            </div>

            {{-- Cucina --}}
            <div class="grid gap-8 lg:grid-cols-2 lg:items-center fade-in">
                <div class="overflow-hidden rounded-2xl shadow-xl">
                    <img src="https://picsum.photos/seed/modern-kitchen-bright/800/600"
                         alt="Cucina Il Mirto Apartment"
                         class="w-full object-cover" style="height:340px;" loading="lazy">
                </div>
                <div>
                    <h3 class="font-display text-2xl font-semibold text-mirto">Cucina completamente attrezzata</h3>
                    <p class="mt-3 leading-relaxed text-slate-600">
                        Cucina vera, non da hotel. Piano cottura, forno, frigorifero grande, lavastoviglie, microonde.
                        Tutto il necessario per cucinare un pranzo sardo o una cena veloce prima di uscire.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-700">
                        @foreach(['Piano cottura a gas/elettrico', 'Forno', 'Frigorifero ampio', 'Lavastoviglie', 'Microonde', 'Macchinetta caffè', 'Bollitore', 'Stoviglie complete'] as $item)
                        <li class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-mare shrink-0"></span> {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Piscina focus --}}
    <div class="mt-20 overflow-hidden rounded-3xl shadow-2xl fade-in" style="background:linear-gradient(135deg,#1a6f78,#2fb5c3);">
        <div class="grid lg:grid-cols-2">
            <div class="p-10 text-white">
                <span class="text-xs font-bold uppercase tracking-widest" style="color:rgba(255,255,255,.7);">Il plus dell'appartamento</span>
                <h2 class="mt-3 font-display text-3xl font-semibold text-white">Piscina condominiale</h2>
                <p class="mt-4 leading-relaxed" style="color:rgba(255,255,255,.85);">
                    Disponibile per tutti gli ospiti dell'appartamento durante la stagione estiva.
                    Un tuffo al mattino, un bagno al tramonto — il lusso che non ti aspetti.
                </p>
                <ul class="mt-6 space-y-2 text-sm" style="color:rgba(255,255,255,.85);">
                    @foreach(['Accesso incluso nel soggiorno', 'Zona solarium con sdraio', 'Ambiente curato e pulito', 'Disponibile giugno–settembre'] as $item)
                    <li class="flex items-center gap-2">
                        <span class="text-lg">✓</span> {{ $item }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('preventivo') }}"
                   class="mt-8 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-mirto transition hover:-translate-y-0.5 hover:shadow-lg">
                    Controlla disponibilità →
                </a>
            </div>
            <div class="hidden lg:block">
                <img src="https://picsum.photos/seed/mirto-pool-sunset/800/600"
                     alt="Piscina Il Mirto Apartment Olbia"
                     class="h-full w-full object-cover" style="min-height:350px;"
                     loading="lazy">
            </div>
        </div>
    </div>

    {{-- CTA finale --}}
    <div class="mt-16 text-center fade-in">
        <h3 class="font-display text-2xl text-mirto">Pronto a prenotare?</h3>
        <p class="mt-2 text-slate-600">Verifica le date, calcola il costo e prenota direttamente con noi. Zero commissioni.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-4">
            <a href="{{ route('preventivo') }}"
               class="inline-flex items-center gap-2 rounded-full bg-mare px-7 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-mare-deep hover:-translate-y-0.5">
                Calcola preventivo →
            </a>
            <a href="{{ route('availability') }}"
               class="inline-flex items-center gap-2 rounded-full border border-mirto/30 bg-white px-7 py-3.5 text-sm font-semibold text-mirto transition hover:bg-sabbia">
                Vedi disponibilità
            </a>
        </div>
    </div>
</div>
@endsection
