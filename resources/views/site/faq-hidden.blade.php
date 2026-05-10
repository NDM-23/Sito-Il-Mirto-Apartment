@extends('layouts.mirto')
@section('title', 'FAQ — Il Mirto Apartment')
@section('content')

<div class="pt-24 mx-auto max-w-3xl px-4 py-16">
    <h1 class="font-display text-4xl font-semibold text-mirto">Domande frequenti</h1>
    <p class="mt-3 text-slate-600">Questa pagina è riservata e non indicizzata sui motori di ricerca.</p>

    <div class="mt-10 space-y-4" x-data="{ open: null }">
        @foreach([
            ['q'=>'Quando si paga?', 'a'=>'Il saldo completo è dovuto entro 30 giorni dall\'arrivo (caparra 30% alla prenotazione). Per prenotazioni last minute, pagamento integrale alla conferma.'],
            ['q'=>'Come avviene il check-in?', 'a'=>'Self check-in: riceverai le istruzioni dettagliate via WhatsApp/email 24 ore prima dell\'arrivo. Non è necessario incontrare nessuno.'],
            ['q'=>'Posso portare un bambino in culla?', 'a'=>'Sì. Fornire culla su richiesta (aggiungere nota al preventivo). Il bambino in culla non conta nel numero di ospiti.'],
            ['q'=>'C\'è posto auto?', 'a'=>'Parcheggio disponibile nelle immediate vicinanze (pubblico). Non è un box privato ma in zona la disponibilità è buona.'],
            ['q'=>'Il WiFi funziona per lo smart working?', 'a'=>'Sì. Connessione fibra con download >50 Mbps. Perfetta per video-call e lavoro da remoto.'],
            ['q'=>'Posso portare animali?', 'a'=>'Purtroppo no. L\'appartamento è pet-free per rispetto di tutti gli ospiti.'],
            ['q'=>'La piscina è sempre disponibile?', 'a'=>'La piscina è disponibile da giugno a settembre. Orari: 09:00–20:00 circa. Accesso incluso nel prezzo.'],
            ['q'=>'Come funziona il rimborso in caso di cancellazione?', 'a'=>'Politica standard: rimborso 100% con 60+ giorni di anticipo, 50% con 30–60 giorni, 0% sotto 30 giorni. Contattaci per casi particolari.'],
        ] as $i => $faq)
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-slate-100">
            <button
                @click="open = open === {{ $i }} ? null : {{ $i }}"
                class="flex w-full items-center justify-between px-6 py-4 text-left">
                <span class="font-semibold text-slate-800">{{ $faq['q'] }}</span>
                <svg class="h-5 w-5 text-mirto transition-transform duration-300" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open === {{ $i }}" x-cloak x-transition class="px-6 pb-4 text-sm text-slate-600 leading-relaxed">
                {{ $faq['a'] }}
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-10 text-center">
        <p class="text-slate-600 mb-4">Non hai trovato risposta?</p>
        <a href="{{ route('contacts') }}" class="inline-flex rounded-full bg-mare px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-mare-deep transition">Contattaci →</a>
    </div>
</div>
@endsection
