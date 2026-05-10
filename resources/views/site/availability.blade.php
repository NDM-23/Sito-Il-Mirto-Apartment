@extends('layouts.mirto')
@section('title', 'Disponibilità — Il Mirto Apartment Olbia')
@section('meta_description', 'Controlla le date disponibili per Il Mirto Apartment a Olbia. Calendario aggiornato in tempo reale. Verde = libero, rosa = occupato.')

@section('content')

<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#1f5c4b 0%,#1a6f78 100%);min-height:260px;">
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Disponibilità</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);">Disponibilità</h1>
        <p class="mt-3" style="color:rgba(255,255,255,.8);">Calendario aggiornato in tempo reale dall'amministrazione.</p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16">
    <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
        <div class="fade-in">
            <div class="rounded-2xl bg-white p-6 shadow-xl">
                @livewire('public.availability-calendar')
            </div>
            <div class="mt-6 rounded-xl bg-sabbia p-5 text-sm text-slate-700">
                <p class="font-semibold text-mirto mb-2">Legenda:</p>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="h-4 w-8 rounded bg-emerald-100 ring-1 ring-emerald-300 inline-block"></span>
                        <span>Libero — puoi prenotare</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="h-4 w-8 rounded bg-rose-100 ring-1 ring-rose-300 inline-block"></span>
                        <span>Occupato — già prenotato</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="h-4 w-8 rounded bg-slate-100 ring-1 ring-slate-300 inline-block"></span>
                        <span>Bloccato — non disponibile</span>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-500">Il calendario è indicativo. Conferma disponibilità finale tramite preventivo o contatto diretto.</p>
            </div>
        </div>

        <div class="space-y-6 fade-in">
            <div class="rounded-2xl bg-white p-8 shadow-lg">
                <h2 class="font-display text-2xl text-mirto mb-4">Vuoi prenotare?</h2>
                <p class="text-sm text-slate-600 leading-relaxed mb-6">
                    Se hai trovato le date che ti interessano, vai al preventivatore per calcolare il costo esatto.
                    Poi inviaci il preventivo via WhatsApp o email per confermare la prenotazione.
                </p>
                <a href="{{ route('preventivo') }}"
                   class="block w-full rounded-full bg-mare py-3.5 text-center text-sm font-semibold text-white shadow-lg transition hover:bg-mare-deep">
                    Calcola preventivo →
                </a>
                <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_e164', '393331234567') }}?text=Ciao!%20Ho%20visto%20il%20calendario%20e%20vorrei%20prenotare."
                   target="_blank"
                   class="mt-3 block w-full rounded-full py-3.5 text-center text-sm font-semibold text-white transition hover:opacity-90"
                   style="background:#25D366;">
                    Scrivici su WhatsApp
                </a>
            </div>

            <div class="rounded-2xl bg-sabbia p-6">
                <h3 class="font-semibold text-mirto mb-3">Info utili</h3>
                <ul class="space-y-2 text-sm text-slate-700">
                    @foreach([
                        'Check-in: dalle 16:00',
                        'Check-out: entro le 10:00',
                        'Minimo 3 notti in alta stagione',
                        'Per soggiorni brevi contattaci direttamente',
                        'Caparra richiesta per conferma prenotazione',
                    ] as $info)
                    <li class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-mare shrink-0"></span> {{ $info }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
