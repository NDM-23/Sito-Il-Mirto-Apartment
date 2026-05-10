@extends('layouts.mirto')
@section('title', 'Contatti — Il Mirto Apartment Olbia Sardegna')
@section('meta_description', 'Contatta Il Mirto Apartment Olbia via WhatsApp, email o telefono. Risposta entro 2 ore. Prenota direttamente e risparmia le commissioni.')

@section('content')

{{-- Mini-hero --}}
<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#1f5c4b 0%,#1a6f78 100%);min-height:280px;">
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Contatti</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);">Parliamo</h1>
        <p class="mt-3 max-w-xl" style="color:rgba(255,255,255,.8);">Hai domande? Vuoi verificare disponibilità? Scrivici: rispondiamo entro 2 ore lavorative.</p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16">

    <div class="grid gap-12 lg:grid-cols-2">

        {{-- Metodi di contatto --}}
        <div class="fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Come contattarci</span>
            <h2 class="mt-3 font-display font-semibold text-mirto" style="font-size:clamp(1.6rem,4vw,2.2rem);">
                Siamo sempre disponibili
            </h2>
            <p class="mt-4 text-slate-600 leading-relaxed">
                Preferiamo il contatto diretto: nessuna intermediazione, nessuna attesa.
                WhatsApp è il canale più veloce — leggiamo e rispondiamo anche la sera.
            </p>

            <div class="mt-8 space-y-4">
                {{-- WhatsApp --}}
                <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_e164', '393331234567') }}?text=Ciao!%20Vorrei%20informazioni%20sull'appartamento%20Il%20Mirto."
                   target="_blank"
                   class="flex items-center gap-5 rounded-2xl bg-white p-5 shadow-md ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-xl card-hover">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full text-white" style="background:#25D366;">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">WhatsApp</p>
                        <p class="text-sm text-slate-600">{{ \App\Models\SiteSetting::get('phone_display', '+39 333 123 4567') }}</p>
                        <p class="text-xs text-green-600 font-medium mt-0.5">⚡ Risposta più veloce — consigliato</p>
                    </div>
                </a>

                {{-- Email --}}
                <a href="mailto:{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}"
                   class="flex items-center gap-5 rounded-2xl bg-white p-5 shadow-md ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-xl card-hover">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-mare text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Email</p>
                        <p class="text-sm text-slate-600">{{ \App\Models\SiteSetting::get('email_contact', 'info@ilmirtoapartment.it') }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Risposta entro 2–4 ore lavorative</p>
                    </div>
                </a>

                {{-- Indirizzo --}}
                <div class="flex items-center gap-5 rounded-2xl bg-white p-5 shadow-md ring-1 ring-slate-100">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-mirto text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Indirizzo</p>
                        <p class="text-sm text-slate-600">Via Giovanni Gentile 1</p>
                        <p class="text-sm text-slate-600">07026 Olbia (SS), Sardegna, Italia</p>
                    </div>
                </div>
            </div>

            {{-- Trust indicators --}}
            <div class="mt-8 rounded-2xl bg-sabbia p-5">
                <p class="text-xs font-bold uppercase tracking-widest text-mirto mb-3">Le nostre garanzie</p>
                <ul class="space-y-2 text-sm text-slate-700">
                    @foreach([
                        '✓ Risposta entro 2 ore lavorative',
                        '✓ Prezzo migliore garantito (prenota diretto)',
                        '✓ Zero commissioni vs portali',
                        '✓ Comunicazione diretta col proprietario',
                        '✓ Flessibilità su date e richieste speciali',
                    ] as $trust)
                    <li>{{ $trust }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Form contatto rapido --}}
        <div class="fade-in">
            <span class="text-xs font-bold uppercase tracking-widest text-mare-deep">Modulo rapido</span>
            <h2 class="mt-3 font-display font-semibold text-mirto" style="font-size:clamp(1.6rem,4vw,2.2rem);">
                O lasciaci un messaggio
            </h2>
            <p class="mt-3 text-sm text-slate-600 mb-6">Compilare il form è il modo più comodo se vuoi anche specificare le date già in partenza.</p>

            {{-- Redirect al preventivo come "form di contatto" --}}
            <div class="rounded-2xl bg-white p-8 shadow-lg ring-1 ring-slate-100">
                <p class="text-sm text-slate-600 mb-6">
                    Per richiedere disponibilità e preventivo, usa il nostro calcolatore: riceverai un riepilogo immediato e potrai
                    inviarcelo direttamente via WhatsApp o email per completare la prenotazione.
                </p>
                <a href="{{ route('preventivo') }}"
                   class="block w-full rounded-full bg-mare py-3.5 text-center text-sm font-semibold text-white shadow-lg transition hover:bg-mare-deep">
                    Vai al preventivatore →
                </a>

                <div class="mt-6 flex items-center gap-3">
                    <div class="flex-1 h-px bg-slate-100"></div>
                    <span class="text-xs text-slate-400">oppure</span>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </div>

                <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_e164', '393331234567') }}?text=Ciao!%20Vorrei%20prenotare%20l'appartamento.%20Potete%20aiutarmi%3F"
                   target="_blank"
                   class="mt-6 block w-full rounded-full py-3.5 text-center text-sm font-semibold text-white shadow-lg transition hover:-translate-y-0.5"
                   style="background:#25D366;">
                    Scrivici direttamente su WhatsApp →
                </a>

                <div class="mt-8 border-t border-slate-100 pt-6">
                    <p class="text-xs font-bold text-slate-600 mb-3">Orari di risposta:</p>
                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-600">
                        <div><span class="font-medium">Lun–Ven</span> 09:00–21:00</div>
                        <div><span class="font-medium">Sab–Dom</span> 09:00–20:00</div>
                        <div class="col-span-2 text-slate-500">WhatsApp anche fuori orario (risposta il prima possibile)</div>
                    </div>
                </div>
            </div>

            {{-- Map mini --}}
            <div class="mt-6 overflow-hidden rounded-xl shadow-md">
                <iframe
                    src="{{ \App\Models\SiteSetting::get('maps_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3020.0!2d9.5!3d40.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDU0JzAwLjAiTiA5wrAzMCcwMC4wIkU!5e0!3m2!1sit!2sit!4v1') }}"
                    class="w-full"
                    style="height:220px;border:0;"
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection
