@extends('layouts.mirto')
@section('title', 'Privacy Policy — '.__('mirto.brand'))
@section('content')
<div class="pt-20 bg-mirto px-4 py-12 text-white" style="min-height:200px;">
    <div class="mx-auto max-w-4xl">
        <nav class="mb-3 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Privacy Policy</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:2.5rem;">Privacy Policy</h1>
        <p class="mt-2" style="color:rgba(255,255,255,.75);">Informativa ai sensi del Reg. UE 2016/679 (GDPR)</p>
    </div>
</div>
<div class="mx-auto max-w-4xl px-4 py-12">
    <article class="prose prose-slate max-w-none text-slate-800">
        <h1 class="font-display text-4xl text-mirto">Informativa privacy (Reg. UE 2016/679)</h1>
        <p><strong>Titolare:</strong> {{ __('mirto.brand') }}, contatto: {{ \App\Models\SiteSetting::get('email_contact') }}.</p>
        <h2>Finalità e basi giuridiche</h2>
        <ul>
            <li>Gestione richieste e prenotazioni (contratto / misure precontrattuali).</li>
            <li>Newsletter e comunicazioni promozionali solo con consenso esplicito e revocabile.</li>
            <li>Adempimenti contabili e fiscali ove necessario (obbligo di legge).</li>
        </ul>
        <h2>Dati trattati</h2>
        <p>Dati identificativi e di contatto, dettagli soggiorno, log tecnici (IP, user agent) per sicurezza e consensi.</p>
        <h2>Conservazione</h2>
        <p>Per il tempo necessario alle finalità e secondo obblighi legali; log consensi newsletter conservati per prova del consenso.</p>
        <h2>Diritti</h2>
        <p>Accesso, rettifica, cancellazione, limitazione, portabilità, opposizione e reclamo al Garante (www.garanteprivacy.it).</p>
        <h2>Trasferimenti extra UE</h2>
        <p>Se si utilizzano fornitori (es. email marketing), saranno applicate clausole contrattuali standard o garanzie equivalenti.</p>
    </article>
</div>
@endsection
