@extends('layouts.mirto')
@section('title', 'Il Mirto Apartment — Piscina, sole e libertà a due passi dalla Costa Smeralda')
@section('meta_description', 'Appartamento vacanze con piscina a Olbia, Sardegna. A 5 minuti dall\'aeroporto, vicino spiagge e Costa Smeralda. Prenota diretto e risparmia.')

@section('content')

{{-- ===== HERO CINEMATOGRAFICO ===== --}}
<section class="relative overflow-hidden" style="min-height:100vh;">
    {{-- Background image --}}
    <img src="{{ asset('images/site/hero-piscina-sardegna.svg') }}"
         alt="Il Mirto Apartment piscina Olbia Sardegna"
         class="absolute inset-0 h-full w-full object-cover object-center"
         loading="eager" fetchpriority="high">

    {{-- Gradient overlay --}}
    <div class="hero-gradient absolute inset-0"></div>

    {{-- Wave decoration bottom --}}
    <div class="absolute bottom-0 inset-x-0 h-24 bg-wave bg-bottom bg-repeat-x wave-anim opacity-30" style="background-color:transparent;"></div>

    {{-- Hero content --}}
    <div class="relative flex items-center px-4 pt-20 pb-24" style="min-height:100vh;">
        <div class="mx-auto max-w-5xl w-full">
            <div class="max-w-3xl">
                <span class="inline-block rounded-full border border-white/30 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.3em] text-white/85 backdrop-blur-sm" style="background:rgba(255,255,255,.1);">
                    {{ __('mirto.home.hero_badge') }}
                </span>

                <h1 class="mt-6 font-display font-semibold text-white" style="font-size:clamp(2.6rem,6vw,5rem);line-height:1.08;letter-spacing:-0.02em;">
                    {{ __('mirto.home.hero_title') }}
                </h1>

                <p class="mt-5 text-white/90 max-w-2xl" style="font-size:clamp(1.1rem,2.5vw,1.35rem);line-height:1.6;">
                    {{ __('mirto.home.hero_subtitle') }}<br>
                    <span style="color:rgba(255,255,255,.75);font-size:.95em;">{{ __('mirto.home.hero_sub2') }}</span>
                </p>

                {{-- USP pills --}}
                <div class="mt-8 flex flex-wrap gap-3">
                    @foreach([
                        ['icon'=>'🏊', 'text'=> __('mirto.home.usp_pool')],
                        ['icon'=>'✈️', 'text'=> __('mirto.home.usp_airport')],
                        ['icon'=>'🏖️', 'text'=> __('mirto.home.usp_beach')],
                        ['icon'=>'⭐', 'text'=> __('mirto.cta.direct')],
                    ] as $pill)
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3.5 py-1.5 text-sm font-medium text-white" style="background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.25);">
                        <span>{{ $pill['icon'] }}</span> {{ $pill['text'] }}
                    </span>
                    @endforeach
                </div>

                {{-- CTAs --}}
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('preventivo') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-mare px-7 py-4 text-base font-semibold text-white shadow-xl transition-all duration-300 hover:bg-mare-deep hover:-translate-y-1 hover:shadow-2xl">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 20h16a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ __('mirto.home.hero_cta1') }}
                    </a>
                    <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_e164', '393331234567') }}?text={{ urlencode(__('mirto.cta.whatsapp')) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 rounded-full px-7 py-4 text-base font-semibold text-white transition-all duration-300 hover:-translate-y-1"
                       style="background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:1.5px solid rgba(255,255,255,.4);">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ __('mirto.home.hero_cta2') }}
                    </a>
                </div>

                <p class="mt-5 text-sm" style="color:rgba(255,255,255,.6);">
                    {{ __('mirto.home.hero_trust') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 text-white/70">
        <span class="text-xs uppercase tracking-widest">Scopri</span>
        <span class="animate-bounce text-lg">↓</span>
    </div>
</section>

{{-- ===== USP STRIP ===== --}}
<section class="relative -mt-1 bg-white py-10 shadow-lg">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
            @foreach([
                ['icon'=>'🏊‍♂️', 'title'=> __('mirto.home.usp_pool'),     'text'=> __('mirto.home.usp_pool_sub')],
                ['icon'=>'✈️', 'title'=> __('mirto.home.usp_airport'),   'text'=> __('mirto.home.usp_airport_sub')],
                ['icon'=>'🏖️', 'title'=> __('mirto.home.usp_beach'),     'text'=> __('mirto.home.usp_beach_sub')],
                ['icon'=>'🔑', 'title'=> __('mirto.home.usp_checkin'),   'text'=> __('mirto.home.usp_checkin_sub')],
            ] as $usp)
            <div class="flex items-start gap-3 fade-in">
                <span class="text-3xl">{{ $usp['icon'] }}</span>
                <div>
                    <p class="font-semibold text-mirto text-sm">{{ $usp['title'] }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $usp['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== SEZIONE PISCINA ===== --}}
<section class="py-20" style="background-color:var(--cielo);">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div class="fade-in">
                <div class="relative">
                    <img src="{{ asset('images/site/piscina-estate.svg') }}"
                         alt="Piscina Il Mirto Apartment Olbia"
                         class="w-full rounded-3xl object-cover shadow-2xl"
                         style="height:440px;object-position:center;">
                    {{-- Floating badge --}}
                    <div class="absolute -bottom-5 -right-5 rounded-2xl bg-white px-5 py-3 shadow-xl ring-1 ring-mare/20">
                        <p class="font-display text-2xl font-semibold text-mirto">Piscina</p>
                        <p class="text-xs text-slate-500">Disponibile tutta l'estate</p>
                    </div>
                </div>
            </div>
            <div class="fade-in">
                <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Il nostro punto di forza</span>
                <h2 class="mt-3 font-display font-semibold text-mirto" style="font-size:clamp(2rem,4vw,3rem);line-height:1.15;">
                    Torna dal mare.<br>Tuffati in piscina.
                </h2>
                <p class="mt-5 leading-relaxed text-slate-600" style="font-size:1.05rem;">
                    L'aperitivo alle 18, il sole che scende verso il mare, il profumo di mirto nell'aria. Rientri dalla spiaggia,
                    una doccia fresca, poi un ultimo tuffo in piscina prima di uscire a cena. Questo è Il Mirto.
                </p>
                <ul class="mt-6 space-y-3 text-sm text-slate-700">
                    @foreach([
                        'Accesso libero per tutti gli ospiti',
                        'Zona relax con solarium e lettini',
                        'Aperta da giugno a settembre',
                        'Ambiente curato e pulito',
                    ] as $item)
                    <li class="flex items-center gap-2">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-mare/15 text-mare text-xs">✓</span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('apartment') }}"
                   class="mt-8 inline-flex items-center gap-2 rounded-full bg-mirto px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-mirto-light hover:-translate-y-0.5">
                    Scopri l'appartamento →
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== COMFORT & DOTAZIONI ===== --}}
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4">
        <div class="text-center max-w-2xl mx-auto fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Tutto incluso</span>
            <h2 class="mt-3 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.8rem);">
                Il comfort di casa.<br>Il glamour delle vacanze.
            </h2>
            <p class="mt-4 text-slate-600 leading-relaxed">
                Arredi nuovi, cucina completa, clima silenzioso, Wi‑Fi ultra-fast.
                Ogni dettaglio pensato per farti stare davvero bene.
            </p>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-3">
            @foreach([
                ['img'=>'images/site/soggiorno-luminoso.svg', 'title'=>'Soggiorno luminoso', 'text'=>'Zona relax spaziosa con divano, TV e zona pranzo. Luce naturale tutto il giorno.'],
                ['img'=>'images/site/camera-accogliente.svg', 'title'=>'Camere accoglienti', 'text'=>'Letti comodi, armadi capienti, biancheria inclusa. Il riposo che meriti dopo le avventure in mare.'],
                ['img'=>'images/site/cucina-completa.svg', 'title'=>'Cucina completa', 'text'=>'Piano cottura, forno, frigorifero grande, lavastoviglie. Cucina Sarda? Tutto a portata di mano.'],
            ] as $feature)
            <div class="group overflow-hidden rounded-2xl bg-sabbia shadow-md card-hover fade-in">
                <div class="overflow-hidden h-52">
                    <img src="{{ asset($feature['img']) }}"
                         alt="{{ $feature['title'] }}"
                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                         loading="lazy">
                </div>
                <div class="p-6">
                    <h3 class="font-display text-xl text-mirto">{{ $feature['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $feature['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Servizi icons strip --}}
        <div class="mt-12 grid grid-cols-3 gap-4 md:grid-cols-6 fade-in">
            @foreach([
                ['icon'=>'📶', 'label'=>'Wi‑Fi'],
                ['icon'=>'❄️', 'label'=>'Clima A/C'],
                ['icon'=>'🅿️', 'label'=>'Parcheggio'],
                ['icon'=>'👨‍👩‍👧', 'label'=>'Famiglie OK'],
                ['icon'=>'🏠', 'label'=>'Self check-in'],
                ['icon'=>'🏖️', 'label'=>'Spiagge vicine'],
            ] as $srv)
            <div class="flex flex-col items-center gap-2 rounded-xl bg-white px-3 py-4 text-center shadow-sm ring-1 ring-slate-100">
                <span class="text-2xl">{{ $srv['icon'] }}</span>
                <span class="text-xs font-medium text-slate-600">{{ $srv['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== POSIZIONE STRATEGICA ===== --}}
<section class="py-20" style="background:linear-gradient(135deg,#1a4971 0%,#2b6a9e 100%);">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div class="text-white fade-in">
                <span class="text-xs font-bold uppercase tracking-widest" style="color:rgba(107,174,214,.9);">Posizione imbattibile</span>
                <h2 class="mt-3 font-display font-semibold" style="font-size:clamp(1.8rem,4vw,3rem);color:white;line-height:1.2;">
                    Base perfetta per<br>esplorare la Sardegna
                </h2>
                <p class="mt-5 leading-relaxed" style="color:rgba(255,255,255,.8);">
                    Via Giovanni Gentile 1, Olbia. A 5 minuti dall'aeroporto Costa Smeralda,
                    a 15 minuti dalle prime spiagge, a 30 minuti da Porto Cervo.
                    In posizione centrale per tutto.
                </p>

                <div class="mt-8 grid grid-cols-2 gap-4">
                    @foreach([
                        ['emoji'=>'✈️', 'place'=>'Aeroporto OLB', 'dist'=>'5 min'],
                        ['emoji'=>'🚢', 'place'=>'Porto Olbia', 'dist'=>'10 min'],
                        ['emoji'=>'🏖️', 'place'=>'Spiaggia Pittulongu', 'dist'=>'15 min'],
                        ['emoji'=>'💎', 'place'=>'Costa Smeralda', 'dist'=>'30 min'],
                        ['emoji'=>'🛒', 'place'=>'Supermercato', 'dist'=>'2 min'],
                        ['emoji'=>'🍷', 'place'=>'Ristoranti', 'dist'=>'5 min'],
                    ] as $dist)
                    <div class="flex items-center gap-3 rounded-xl px-4 py-3" style="background:rgba(255,255,255,.1);">
                        <span class="text-xl">{{ $dist['emoji'] }}</span>
                        <div>
                            <p class="text-xs font-semibold text-white">{{ $dist['place'] }}</p>
                            <p class="text-xs" style="color:rgba(47,181,195,.9);">{{ $dist['dist'] }} in auto</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('location') }}"
                   class="mt-8 inline-flex items-center gap-2 rounded-full border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                    Vedi mappa e distanze →
                </a>
            </div>

            <div class="overflow-hidden rounded-3xl shadow-2xl fade-in">
                <iframe
                    src="{{ \App\Models\SiteSetting::get('maps_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3020.0!2d9.5!3d40.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDU0JzAwLjAiTiA5wrAzMCcwMC4wIkU!5e0!3m2!1sit!2sit!4v1') }}"
                    class="w-full"
                    style="height:420px;border:0;"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

{{-- ===== GALLERIA TEASER ===== --}}
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex items-end justify-between mb-10">
            <div class="fade-in">
                <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Le nostre foto</span>
                <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.8rem);">
                    Galleria
                </h2>
            </div>
            <a href="{{ route('gallery') }}" class="hidden md:inline-flex items-center gap-1 text-sm font-semibold text-mare-deep hover:text-mirto transition-colors">
                Vedi tutte le foto →
            </a>
        </div>

        @if ($gallery->isNotEmpty())
        <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
            @foreach ($gallery->take(8) as $img)
            <a href="{{ route('gallery') }}"
               class="group block overflow-hidden rounded-xl shadow-md {{ $loop->index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                <img src="{{ str_starts_with($img->path, 'http') ? $img->path : asset($img->path) }}"
                     alt="{{ data_get($img->alt, app()->getLocale(), data_get($img->alt, 'it', 'Il Mirto Apartment')) }}"
                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105 {{ $loop->index === 0 ? 'min-h-[300px] md:min-h-[360px]' : 'h-40 md:h-44' }}"
                     loading="lazy">
            </a>
            @endforeach
        </div>
        @else
        {{-- Placeholder gallery --}}
        <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
            @foreach([
                ['seed'=>'images/site/galleria-piscina.svg', 'span'=>true],
                ['seed'=>'images/site/galleria-camera.svg', 'span'=>false],
                ['seed'=>'images/site/galleria-soggiorno.svg', 'span'=>false],
                ['seed'=>'images/site/galleria-spiaggia.svg', 'span'=>false],
                ['seed'=>'images/site/galleria-cucina.svg', 'span'=>false],
                ['seed'=>'images/site/galleria-tramonto.svg', 'span'=>false],
            ] as $ph)
            <a href="{{ route('gallery') }}"
               class="group block overflow-hidden rounded-xl shadow-md {{ $ph['span'] ? 'md:col-span-2 md:row-span-2' : '' }}">
                <img src="{{ asset($ph['seed']) }}"
                     alt="Il Mirto Apartment Olbia"
                     class="w-full object-cover transition duration-500 group-hover:scale-105 {{ $ph['span'] ? 'h-48 md:h-full min-h-[300px]' : 'h-40 md:h-44' }}"
                     loading="lazy">
            </a>
            @endforeach
        </div>
        @endif

        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('gallery') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-mare-deep">
                Vedi tutte le foto →
            </a>
        </div>
    </div>
</section>

{{-- ===== PROMOZIONI ===== --}}
@if ($promos->isNotEmpty())
<section class="py-16" style="background-color:var(--cielo);">
    <div class="mx-auto max-w-7xl px-4">
        <div class="text-center mb-10 fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">{{ __('mirto.home.promos_label') }}</span>
            <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.8rem);">
                {{ __('mirto.home.promos_title') }}
            </h2>
        </div>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach ($promos as $p)
            <div class="rounded-2xl bg-white p-6 shadow-md ring-1 ring-amber-100 card-hover fade-in" style="max-width:340px;flex:1;min-width:260px;">
                <div class="flex items-center justify-between">
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-800">{{ $p->code }}</span>
                    @if($p->discount_pct)
                    <span class="text-2xl font-display font-bold text-mirto">-{{ $p->discount_pct }}%</span>
                    @endif
                </div>
                <p class="mt-3 font-semibold text-slate-800">{{ $p->name }}</p>
                <p class="mt-1 text-sm text-slate-600">{{ $p->description }}</p>
                @if($p->valid_to)
                <p class="mt-3 text-xs text-slate-500">Valido fino al {{ $p->valid_to->format('d/m/Y') }}</p>
                @endif
                <a href="{{ route('preventivo') }}"
                   class="mt-4 block w-full rounded-full bg-mare py-2.5 text-center text-sm font-semibold text-white transition hover:bg-mare-deep">
                    Prenota con questa offerta →
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== RECENSIONI ===== --}}
@if ($reviews->isNotEmpty())
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4">
        <div class="text-center mb-12 fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">{{ __('mirto.home.reviews_label') }}</span>
            <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.8rem);">
                {{ __('mirto.home.reviews_title') }}
            </h2>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach ($reviews->take(6) as $r)
            <blockquote class="rounded-2xl p-6 shadow-sm ring-1 ring-slate-100 card-hover fade-in" style="background:var(--cielo);max-width:360px;flex:1;min-width:260px;">
                <div class="flex gap-0.5 text-amber-400 text-sm">
                    @for($s=0;$s<($r->rating??5);$s++) ★ @endfor
                </div>
                <p class="mt-3 text-sm leading-relaxed text-slate-700 italic">"{{ $r->body }}"</p>
                <footer class="mt-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-mirto/10 flex items-center justify-center text-mirto text-sm font-bold">
                        {{ strtoupper(substr($r->author_name,0,1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-mirto">{{ $r->author_name }}</p>
                        @if($r->source) <p class="text-xs text-slate-400">via {{ $r->source }}</p> @endif
                    </div>
                </footer>
            </blockquote>
            @endforeach
        </div>
    </div>
</section>
@else
{{-- Placeholder reviews --}}
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4">
        <div class="text-center mb-12 fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Ospiti soddisfatti</span>
            <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.8rem);">
                Cosa dicono di noi
            </h2>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach([
                ['author'=>'Marco R.', 'city'=>'Milano', 'stars'=>5, 'text'=>'Appartamento stupendo, pulitissimo e perfettamente attrezzato. La piscina è il valore aggiunto: ci siamo rilassati ogni sera al tramonto. Torneremo sicuramente!'],
                ['author'=>'Sophie M.', 'city'=>'Parigi', 'stars'=>5, 'text'=>'Excellent appartement, très bien situé. La piscine est magnifique et la plage de Pittulongu à quelques minutes en voiture. Hôte très disponible.'],
                ['author'=>'Klaus W.', 'city'=>'Monaco', 'stars'=>5, 'text'=>'Wunderbare Wohnung in perfekter Lage. Pool, Klimaanlage, alles was man braucht. Der Flughafen ist wirklich nur 5 Minuten entfernt. Sehr empfehlenswert!'],
            ] as $pr)
            <blockquote class="rounded-2xl p-6 shadow-sm ring-1 ring-slate-100 card-hover fade-in" style="background:var(--cielo);max-width:360px;flex:1;min-width:260px;">
                <div class="flex gap-0.5 text-amber-400 text-sm">
                    @for($s=0;$s<$pr['stars'];$s++) ★ @endfor
                </div>
                <p class="mt-3 text-sm leading-relaxed text-slate-700 italic">"{{ $pr['text'] }}"</p>
                <footer class="mt-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-mirto/10 flex items-center justify-center text-mirto text-sm font-bold">
                        {{ strtoupper(substr($pr['author'],0,1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-mirto">{{ $pr['author'] }}</p>
                        <p class="text-xs text-slate-400">{{ $pr['city'] }} · Booking.com</p>
                    </div>
                </footer>
            </blockquote>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== VANTAGGI PRENOTAZIONE DIRETTA ===== --}}
<section class="py-20" style="background:linear-gradient(135deg,#1a4971 0%,#2b6a9e 60%,#2fb5c3 100%);">
    <div class="mx-auto max-w-7xl px-4">
        <div class="text-center text-white mb-12 fade-in">
            <span class="text-xs font-bold uppercase tracking-widest" style="color:rgba(173,210,228,.9);">Perché prenotare con noi</span>
            <h2 class="mt-3 font-display font-semibold text-white" style="font-size:clamp(1.8rem,4vw,2.8rem);">
                {{ __('mirto.home.direct_title') }}
            </h2>
            <p class="mt-4 max-w-xl mx-auto" style="color:rgba(255,255,255,.8);">
                {{ __('mirto.home.direct_sub') }}
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-4">
            @foreach([
                ['emoji'=>'💰', 'title'=>'Prezzo migliore', 'text'=>'Zero commissioni = prezzi più bassi garantiti rispetto ai portali'],
                ['emoji'=>'💬', 'title'=>'Risposta rapida', 'text'=>'Parli con il proprietario, non con un call center. Risposta entro 2 ore'],
                ['emoji'=>'🔒', 'title'=>'Pagamento sicuro', 'text'=>'Transazioni sicure con ricevuta e tutela GDPR europea'],
                ['emoji'=>'⚡', 'title'=>'Flessibilità', 'text'=>'Date personalizzate, check-in adattabile, esigenze particolari'],
            ] as $adv)
            <div class="rounded-2xl p-6 text-center text-white fade-in" style="background:rgba(255,255,255,.12);">
                <span class="text-4xl">{{ $adv['emoji'] }}</span>
                <h3 class="mt-4 font-semibold text-white">{{ $adv['title'] }}</h3>
                <p class="mt-2 text-sm" style="color:rgba(255,255,255,.8);">{{ $adv['text'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center fade-in">
            <a href="{{ route('preventivo') }}"
               class="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-mirto shadow-xl transition hover:-translate-y-1 hover:shadow-2xl">
                Calcola il tuo preventivo gratuito →
            </a>
            <p class="mt-4 text-sm" style="color:rgba(255,255,255,.65);">Risposta entro 2 ore lavorative</p>
        </div>
    </div>
</section>

{{-- ===== NEWSLETTER ===== --}}
<section class="py-16" style="background-color:var(--cielo);">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid gap-10 lg:grid-cols-2">
            @livewire('public.newsletter-box')
            <div class="flex flex-col justify-center fade-in">
                <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Preventivo rapido</span>
                <h3 class="mt-2 font-display text-2xl text-mirto">Calcola il costo del soggiorno</h3>
                <p class="mt-2 text-sm text-slate-600">Inserisci date e ospiti: ricevi subito il totale preciso, senza sorprese.</p>
                <a href="{{ route('preventivo') }}"
                   class="mt-6 inline-flex items-center gap-2 self-start rounded-full bg-mare px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-mare-deep hover:-translate-y-0.5">
                    Vai al preventivatore →
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== ESPERIENZE TEASER ===== --}}
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex items-end justify-between mb-10">
            <div class="fade-in">
                <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Intorno a te</span>
                <h2 class="mt-2 font-display font-semibold text-mirto" style="font-size:clamp(1.8rem,4vw,2.8rem);">
                    Esperienze indimenticabili
                </h2>
            </div>
            <a href="{{ route('experiences') }}" class="hidden md:inline-flex items-center gap-1 text-sm font-semibold text-mare-deep hover:text-mirto transition-colors">
                Tutte le esperienze →
            </a>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            @foreach([
                ['img'=>'images/site/esperienza-spiagge.svg', 'title'=>'Spiagge da sogno', 'text'=>'Pittulongu, Porto Istana, le calette della Costa Smeralda — sabbia bianca e mare cristallino a pochi minuti.', 'tag'=>'Natura'],
                ['img'=>'images/site/esperienza-barca.svg', 'title'=>'Gite in barca', 'text'=>'Esplora l\'Arcipelago di La Maddalena, approda a Spargi o Budelli. Il mare più bello del Mediterraneo.', 'tag'=>'Avventura'],
                ['img'=>'images/site/esperienza-cucina.svg', 'title'=>'Cucina Sarda', 'text'=>'Culurgiones, porceddu, bottarga di muggine, vini Vermentino. Olbia ha ristoranti autentici a 5 minuti.', 'tag'=>'Gusto'],
            ] as $exp)
            <div class="group relative overflow-hidden rounded-2xl shadow-md card-hover fade-in" style="height:360px;">
                <img src="{{ asset($exp['img']) }}"
                     alt="{{ $exp['title'] }}"
                     class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"
                     loading="lazy">
                <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(0,0,0,.75) 0%,transparent 60%)"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <span class="inline-block rounded-full bg-white/20 px-2.5 py-0.5 text-xs font-semibold backdrop-blur-sm">{{ $exp['tag'] }}</span>
                    <h3 class="mt-2 font-display text-xl font-semibold">{{ $exp['title'] }}</h3>
                    <p class="mt-1 text-sm text-white/80 leading-snug">{{ $exp['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
