@extends('layouts.mirto')
@section('title', 'Termini di Prenotazione — '.__('mirto.brand'))
@section('content')
<div class="pt-20 bg-mirto px-4 py-12 text-white" style="min-height:200px;">
    <div class="mx-auto max-w-4xl">
        <nav class="mb-3 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Termini di Prenotazione</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:2.5rem;">Termini di Prenotazione</h1>
    </div>
</div>
<div class="mx-auto max-w-4xl px-4 py-12">
    <article class="prose prose-slate max-w-none text-slate-800">
        <p>Le prenotazioni sono confermate solo dopo verifica disponibilità, accettazione delle presenti condizioni e pagamento della caparra secondo quanto concordato.</p>
        <h2>Conferma prenotazione</h2>
        <p>La prenotazione si intende confermata all'invio della ricevuta di pagamento della caparra. Prima di tale momento, le date restano disponibili per altri ospiti.</p>
        <h2>Caparra e saldo</h2>
        <ul>
            <li>Caparra: 30% del totale al momento della conferma</li>
            <li>Saldo: entro 30 giorni prima dell'arrivo</li>
            <li>Per prenotazioni last minute (meno di 30 giorni): pagamento integrale alla conferma</li>
        </ul>
        <h2>Cancellazioni</h2>
        <ul>
            <li>60+ giorni prima dell'arrivo: rimborso completo della caparra</li>
            <li>30–60 giorni prima: rimborso del 50% della caparra</li>
            <li>Meno di 30 giorni: nessun rimborso</li>
        </ul>
        <p>Per forza maggiore documentata, si valuta caso per caso. Il credito per future prenotazioni è sempre valutabile.</p>
        <h2>Tassa di soggiorno</h2>
        <p>Applicata ove dovuta secondo delibera del Comune di Olbia. Attualmente: €1,50 per persona/notte (adulti, max 5 notti). Soggetta a variazioni normative.</p>
        <h2>Numero ospiti</h2>
        <p>Il numero di ospiti dichiarato al momento della prenotazione non può essere superato. La violazione può comportare la risoluzione immediata del contratto senza rimborso.</p>
        <h2>Regolamento della struttura</h2>
        <ul>
            <li>Check-in: dalle 16:00 · Check-out: entro le 10:00</li>
            <li>Rispettare gli orari di silenzio: 23:00–08:00</li>
            <li>Piscina: orari indicativamente 09:00–20:00</li>
            <li>Vietato fumare all'interno</li>
            <li>Non sono ammessi animali domestici</li>
        </ul>
        <h2>Responsabilità</h2>
        <p>Il proprietario non è responsabile per furti, smarrimenti o danni a oggetti personali degli ospiti. Gli ospiti sono responsabili dei danni causati all'appartamento o alle parti comuni.</p>
        <h2>Contatti</h2>
        <p>Per qualsiasi chiarimento: <a href="mailto:{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}">{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}</a></p>
    </article>
</div>
@endsection
