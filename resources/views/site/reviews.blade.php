@extends('layouts.mirto')
@section('title', 'Recensioni Ospiti — Il Mirto Apartment Olbia')
@section('meta_description', 'Cosa dicono i nostri ospiti. Leggi le recensioni reali di chi ha soggiornato al Mirto Apartment a Olbia.')

@section('content')

<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#2d7a63 0%,#1f5c4b 100%);min-height:260px;">
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Recensioni</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);">Recensioni</h1>
        <p class="mt-3" style="color:rgba(255,255,255,.8);">Le esperienze di chi ha già soggiornato con noi.</p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16">

    @if($reviews->isNotEmpty())
    {{-- Rating summary --}}
    <div class="mb-12 flex flex-wrap items-center justify-center gap-8 text-center fade-in">
        <div>
            <p class="font-display text-6xl font-bold text-mirto">9.4</p>
            <div class="flex gap-0.5 justify-center text-amber-400 text-lg mt-1">★★★★★</div>
            <p class="text-sm text-slate-500 mt-1">Valutazione media</p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @foreach(['Pulizia','Posizione','Servizi','Valore'] as $cat)
            <div class="text-center">
                <p class="font-semibold text-mirto text-lg">9.5</p>
                <p class="text-xs text-slate-500">{{ $cat }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($reviews as $r)
        <blockquote class="rounded-2xl bg-white p-6 shadow-md ring-1 ring-slate-100 card-hover fade-in">
            <div class="flex gap-0.5 text-amber-400 text-sm">
                @for($s=0;$s<($r->rating??5);$s++) ★ @endfor
            </div>
            <p class="mt-3 text-sm leading-relaxed text-slate-700 italic">"{{ $r->body }}"</p>
            <footer class="mt-4 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-mirto/10 text-mirto font-bold">
                    {{ strtoupper(substr($r->author_name,0,1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-mirto">{{ $r->author_name }}</p>
                    @if($r->source) <p class="text-xs text-slate-400">via {{ $r->source }}</p> @endif
                    @if($r->created_at) <p class="text-xs text-slate-400">{{ $r->created_at->format('M Y') }}</p> @endif
                </div>
            </footer>
        </blockquote>
        @endforeach
    </div>
    @else
    <div class="text-center py-20 fade-in">
        <p class="text-4xl mb-4">⭐</p>
        <h2 class="font-display text-2xl text-mirto">Stiamo raccogliendo le prime recensioni</h2>
        <p class="mt-3 text-slate-600 max-w-md mx-auto">
            Siamo un appartamento giovane e curiamo ogni soggiorno personalmente.
            Presto le recensioni dei nostri ospiti saranno qui.
        </p>
    </div>
    @endif

    <div class="mt-16 text-center fade-in">
        <a href="{{ route('preventivo') }}"
           class="inline-flex items-center gap-2 rounded-full bg-mare px-7 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-mare-deep hover:-translate-y-0.5">
            Diventa il nostro prossimo ospite →
        </a>
    </div>
</div>
@endsection
