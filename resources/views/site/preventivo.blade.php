@extends('layouts.mirto')
@section('title', 'Preventivo Immediato — Il Mirto Apartment Olbia')
@section('meta_description', 'Calcola il costo del tuo soggiorno a Olbia. Inserisci date, ospiti e codice promo: ricevi subito il totale preciso senza sorprese.')

@section('content')

{{-- Mini-hero --}}
<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#2fb5c3 0%,#1f5c4b 100%);min-height:280px;">
    <div class="absolute inset-0 opacity-20 bg-wave bg-bottom bg-repeat-x wave-anim" style="background-color:transparent;"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Preventivo</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);">Preventivo immediato</h1>
        <p class="mt-4 max-w-xl" style="color:rgba(255,255,255,.85);font-size:1.05rem;">
            Senza impegno. Inserisci le date e vedi subito il costo totale — incluse pulizie, tassa di soggiorno e sconti.
        </p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16">
    <div class="grid gap-12 lg:grid-cols-2 lg:items-start">

        {{-- Quote wizard --}}
        <div class="fade-in">
            <div class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                <div class="mb-6">
                    <h2 class="font-display text-2xl font-semibold text-mirto">Calcola il tuo preventivo</h2>
                    <p class="mt-1 text-sm text-slate-500">Totale preciso in pochi secondi. Poi contattaci per confermare.</p>
                </div>
                @livewire('public.quote-wizard')
            </div>

            {{-- Come procedere --}}
            <div class="mt-6 rounded-2xl bg-sabbia p-6">
                <p class="text-xs font-bold uppercase tracking-widest text-mirto mb-4">Dopo il preventivo:</p>
                <ol class="space-y-3">
                    @foreach([
                        'Ricevi il riepilogo con il totale preciso',
                        'Inviaci il preventivo via WhatsApp o email',
                        'Confirmiamo disponibilità e blocchiamo le date',
                        'Pagamento sicuro e ingresso sereno 🌴',
                    ] as $i => $step)
                    <li class="flex items-start gap-3 text-sm text-slate-700">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-mirto text-white text-xs font-bold">{{ $i+1 }}</span>
                        {{ $step }}
                    </li>
                    @endforeach
                </ol>
                <div class="mt-5 pt-4 border-t border-slate-200 flex gap-3">
                    <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_e164', '393331234567') }}"
                       target="_blank"
                       class="flex-1 rounded-full py-2.5 text-center text-sm font-semibold text-white transition hover:opacity-90"
                       style="background:#25D366;">
                        WhatsApp
                    </a>
                    <a href="mailto:{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}"
                       class="flex-1 rounded-full bg-mirto py-2.5 text-center text-sm font-semibold text-white transition hover:bg-mirto-light">
                        Email
                    </a>
                </div>
            </div>
        </div>

        {{-- Sidebar info --}}
        <div class="space-y-6 fade-in">

            {{-- Disponibilità --}}
            <div class="rounded-2xl bg-white p-6 shadow-md ring-1 ring-slate-100">
                <h3 class="font-display text-xl font-semibold text-mirto mb-4">Disponibilità</h3>
                @livewire('public.availability-calendar')
            </div>

            {{-- Trust --}}
            <div class="rounded-2xl bg-white p-6 shadow-md ring-1 ring-slate-100">
                <h3 class="font-semibold text-slate-800 mb-4">Perché prenotare con noi</h3>
                <ul class="space-y-3 text-sm text-slate-700">
                    @foreach([
                        ['icon'=>'💰', 'text'=>'Prezzo migliore garantito — zero commissioni ai portali'],
                        ['icon'=>'💬', 'text'=>'Risposta diretta dal proprietario entro 2 ore'],
                        ['icon'=>'🔒', 'text'=>'Pagamenti sicuri e ricevuta fiscale'],
                        ['icon'=>'⚡', 'text'=>'Check-in flessibile su accordo'],
                        ['icon'=>'🏖️', 'text'=>'Consigli personalizzati su spiagge e ristoranti'],
                    ] as $t)
                    <li class="flex items-start gap-3">
                        <span class="text-xl shrink-0">{{ $t['icon'] }}</span>
                        <span>{{ $t['text'] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Regole casa --}}
            <div class="rounded-2xl bg-sabbia p-6 ring-1 ring-slate-100">
                <h3 class="font-semibold text-slate-800 mb-4">Regole principali</h3>
                <dl class="grid grid-cols-2 gap-3 text-xs text-slate-700">
                    <div>
                        <dt class="font-semibold text-mirto">Check-in</dt>
                        <dd>dalle 16:00</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-mirto">Check-out</dt>
                        <dd>entro le 10:00</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-mirto">Ospiti max</dt>
                        <dd>4 persone + culla</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-mirto">Min. notti</dt>
                        <dd>3 notti (estate)</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-mirto">Animali</dt>
                        <dd>Non ammessi</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-mirto">Fumo</dt>
                        <dd>Solo all'esterno</dd>
                    </div>
                </dl>
                <p class="mt-4 text-xs text-slate-500">
                    Per date in bassa stagione o esigenze particolari, <a href="{{ route('contacts') }}" class="underline text-mirto">contattaci direttamente</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
