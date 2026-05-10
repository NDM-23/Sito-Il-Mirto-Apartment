@extends('layouts.mirto')
@section('title', 'Newsletter — Il Mirto Apartment Olbia')
@section('meta_description', 'Iscriviti alla newsletter del Mirto Apartment. Ricevi offerte last minute, early booking e consigli sulla Sardegna in anteprima.')

@section('content')

<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#2fb5c3 0%,#1f5c4b 100%);min-height:280px;">
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);">Newsletter</h1>
        <p class="mt-3 max-w-xl" style="color:rgba(255,255,255,.85);">Offerte esclusive, last minute e guide sulla Sardegna direttamente nella tua inbox.</p>
    </div>
</div>

<div class="mx-auto max-w-3xl px-4 py-16">
    <div class="grid gap-12 lg:grid-cols-2 lg:items-start">
        <div class="fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Cosa ricevi</span>
            <ul class="mt-4 space-y-4">
                @foreach([
                    ['icon'=>'⚡', 'title'=>'Last minute', 'text'=>'Offerte sulle date ancora libere, riservate solo agli iscritti.'],
                    ['icon'=>'📅', 'title'=>'Early booking', 'text'=>'Sconti per chi prenota con anticipo — le date migliori vanno presto.'],
                    ['icon'=>'🗺️', 'title'=>'Guide Sardegna', 'text'=>'Spiagge, ristoranti, esperienze — idee per il tuo soggiorno perfetto.'],
                    ['icon'=>'🎁', 'title'=>'Codici sconto', 'text'=>'Coupon esclusivi riservati agli iscritti alla newsletter.'],
                ] as $item)
                <li class="flex items-start gap-3">
                    <span class="text-2xl">{{ $item['icon'] }}</span>
                    <div>
                        <p class="font-semibold text-slate-800">{{ $item['title'] }}</p>
                        <p class="text-sm text-slate-600">{{ $item['text'] }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
            <p class="mt-6 text-xs text-slate-500">Zero spam. Nessuna vendita dei tuoi dati. Disiscrizione in un click. GDPR compliant.</p>
        </div>

        <div class="fade-in">
            <div class="rounded-2xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                @livewire('public.newsletter-box')
            </div>
        </div>
    </div>
</div>
@endsection
