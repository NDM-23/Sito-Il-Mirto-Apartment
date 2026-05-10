@extends('layouts.mirto')
@section('title', 'Cookie Policy — '.__('mirto.brand'))
@section('content')
<div class="pt-20 bg-mirto px-4 py-12 text-white" style="min-height:200px;">
    <div class="mx-auto max-w-4xl">
        <nav class="mb-3 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Cookie Policy</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:2.5rem;">Cookie Policy</h1>
    </div>
</div>
<div class="mx-auto max-w-4xl px-4 py-12">
    <article class="prose prose-slate max-w-none text-slate-800">
        <h2>Tipologie di cookie utilizzati</h2>
        <p>Questo sito utilizza cookie tecnici necessari alla navigazione e alla sicurezza (sessione, CSRF, preferenze lingua). Questi cookie non richiedono consenso perché strettamente necessari.</p>
        <h2>Cookie opzionali</h2>
        <p>Eventuali cookie di analytics o marketing saranno attivati solo previo consenso tramite banner dedicato. Nessun dato viene condiviso con terze parti senza consenso.</p>
        <h2>Gestione cookie</h2>
        <p>Puoi gestire le preferenze cookie dal browser o dal pannello cookie ove presente. Il rifiuto dei cookie tecnici potrebbe compromettere il funzionamento del sito.</p>
        <h2>Cookie di sessione</h2>
        <p>Utilizzati per mantenere la sessione utente, la selezione della lingua e la protezione CSRF. Si eliminano alla chiusura del browser.</p>
        <h2>Contatti</h2>
        <p>Per informazioni: <a href="mailto:{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}">{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}</a></p>
    </article>
</div>
@endsection
