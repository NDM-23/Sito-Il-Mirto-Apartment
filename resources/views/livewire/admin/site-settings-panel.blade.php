<div class="py-10">
    <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 space-y-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Impostazioni sito</h1>
            <p class="mt-1 text-sm text-gray-500">Gestisci prezzi base, contatti pubblici e sincronizzazione calendari.</p>
        </div>

        @if (session('flash_ok'))
            <p class="rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 font-medium">✓ {{ session('flash_ok') }}</p>
        @endif

        <form wire:submit="save" class="space-y-8">

            {{-- ===== SEZIONE: CONTATTI PUBBLICI ===== --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-800 mb-1">📞 Contatti pubblici del sito</h2>
                <p class="text-xs text-gray-500 mb-5">Questi dati appaiono nella barra di navigazione, nel footer, nella pagina contatti e nei pulsanti WhatsApp.</p>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700">WhatsApp (solo numeri, con prefisso, es. <code class="bg-gray-100 px-1 rounded">393331234567</code>)</label>
                        <input type="text" wire:model="whatsapp_e164" placeholder="393331234567"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                        <p class="mt-1 text-xs text-gray-400">Usato per il link wa.me — non inserire spazi o simboli</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Telefono (testo visibile sul sito)</label>
                        <input type="text" wire:model="phone_display" placeholder="+39 333 123 4567"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                        <p class="mt-1 text-xs text-gray-400">Formato libero, appare come testo visibile</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email di contatto</label>
                        <input type="email" wire:model="email_contact" placeholder="info@ilmirtoapartment.it"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Indirizzo (testo visibile)</label>
                        <input type="text" wire:model="address_display" placeholder="Via Giovanni Gentile 1, Olbia"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700">URL iframe Google Maps (embed)</label>
                        <textarea wire:model="maps_embed_url" rows="3" placeholder="https://www.google.com/maps/embed?pb=..."
                                  class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 font-mono text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                        <p class="mt-1 text-xs text-gray-400">Su Google Maps → Condividi → Incorpora mappa → copia l'URL dell'attributo <code>src=""</code></p>
                    </div>
                </div>
            </div>

            {{-- ===== SEZIONE: PREZZI BASE ===== --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-800 mb-1">💶 Prezzi base & disponibilità</h2>
                <p class="text-xs text-gray-500 mb-5">Impostazioni predefinite per il preventivatore. I prezzi per singola data si gestiscono nel Calendario.</p>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Prezzo notte default (€)</label>
                        <input type="text" wire:model="default_night_price_eur" placeholder="165"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Pulizie finali (€)</label>
                        <input type="text" wire:model="cleaning_fee_eur" placeholder="85"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Tassa soggiorno / persona / notte (€)</label>
                        <input type="text" wire:model="tourist_tax_per_person_night_eur" placeholder="1.50"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div class="flex items-center gap-3 pt-5">
                        <input type="checkbox" wire:model="tourist_tax_enabled" id="tax" class="h-4 w-4 rounded border-gray-300 text-blue-600" />
                        <label for="tax" class="text-sm font-medium text-gray-700">Tassa di soggiorno attiva</label>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Notti minime globali</label>
                        <input type="number" wire:model="global_min_nights" min="1" max="30"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Orizzonte prenotazione (giorni)</label>
                        <input type="number" wire:model="booking_horizon_days" min="30" max="730"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Max adulti</label>
                        <input type="number" wire:model="max_guests_adults" min="1" max="20"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Max bambini</label>
                        <input type="number" wire:model="max_guests_children" min="0" max="10"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Anticipo minimo prenotazione (giorni)</label>
                        <input type="number" wire:model="min_booking_lead_days" min="0" max="60"
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                </div>
            </div>

            {{-- ===== SEZIONE: SINCRONIZZAZIONE ICAL ===== --}}
            <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-800 mb-1">🔁 Sincronizzazione calendario (iCal)</h2>
                <p class="text-xs text-gray-600 mb-5">
                    Inserisci qui gli URL iCal di Booking.com e Airbnb per sincronizzare le prenotazioni.
                    Le date occupate importate da questi calendari vengono bloccate automaticamente nel tuo calendario.
                </p>

                {{-- URL Feed pubblico --}}
                <div class="mb-5 rounded-lg border border-indigo-200 bg-white p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-700 mb-2">📤 Il tuo URL iCal (da dare a Booking/Airbnb)</p>
                    <p class="text-xs text-gray-600 mb-2">Usa questo URL per sincronizzare il tuo calendario con Booking.com, Airbnb o altri portali:</p>
                    <div class="flex items-center gap-2">
                        <input type="text"
                               value="{{ url('/ical/mirto.ics') }}"
                               readonly
                               class="flex-1 rounded border border-gray-200 bg-gray-50 px-3 py-2 font-mono text-xs text-gray-700 select-all" />
                        <button type="button"
                                onclick="navigator.clipboard.writeText('{{ url('/ical/mirto.ics') }}');this.textContent='✓ Copiato!';"
                                class="shrink-0 rounded border border-indigo-300 bg-indigo-100 px-3 py-2 text-xs font-medium text-indigo-700 hover:bg-indigo-200 transition-colors">
                            📋 Copia
                        </button>
                    </div>
                    <p class="mt-2 text-xs text-gray-400">Su Booking.com: Extranet → Calendario → Sincronizza → Importa URL. Su Airbnb: Calendario → Disponibilità → Collega calendari.</p>
                </div>

                <div class="grid gap-4 md:grid-cols-1">
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            📥 URL iCal da Booking.com
                            <span class="ml-1 text-xs font-normal text-gray-400">(opzionale)</span>
                        </label>
                        <input type="url" wire:model="booking_ical_url"
                               placeholder="https://icalx.booking.com/external/ical/..."
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 font-mono text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                        <p class="mt-1 text-xs text-gray-400">Booking.com → Extranet → Calendario → Sincronizza → Esporta → Copia URL feed</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            📥 URL iCal da Airbnb
                            <span class="ml-1 text-xs font-normal text-gray-400">(opzionale)</span>
                        </label>
                        <input type="url" wire:model="airbnb_ical_url"
                               placeholder="https://www.airbnb.it/calendar/ical/..."
                               class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 font-mono text-xs focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                        <p class="mt-1 text-xs text-gray-400">Airbnb → Calendario → Disponibilità → Esporta calendario → Copia link</p>
                    </div>
                </div>

                @if($booking_ical_url || $airbnb_ical_url)
                <div class="mt-4 space-y-3">
                    <div class="rounded-lg border border-indigo-200 bg-white p-3 text-xs text-gray-600">
                        <strong>Sincronizzazione automatica:</strong> Aggiungi questo comando al cron job del tuo hosting per importare le prenotazioni ogni ora:<br>
                        <code class="mt-1 block bg-gray-100 rounded px-2 py-1 font-mono">* * * * * php {{ base_path() }}/artisan schedule:run >> /dev/null 2>&1</code>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" wire:click="runIcalImport" wire:loading.attr="disabled"
                                class="rounded-lg border border-indigo-300 bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-100 disabled:opacity-50">
                            <span wire:loading.remove wire:target="runIcalImport">🔄 Sincronizza subito</span>
                            <span wire:loading wire:target="runIcalImport">Sincronizzazione in corso…</span>
                        </button>
                        <span class="text-xs text-gray-500">Importa adesso le prenotazioni dai feed iCal configurati.</span>
                    </div>
                    @if(session('ical_result'))
                        <p class="rounded border border-sky-200 bg-sky-50 px-3 py-2 text-xs text-sky-800">{{ session('ical_result') }}</p>
                    @endif
                </div>
                @endif
            </div>

            {{-- Salva --}}
            <div class="flex items-center gap-4">
                <button type="submit"
                        class="rounded-full bg-blue-600 px-8 py-3 text-sm font-semibold text-white shadow hover:bg-blue-700 transition-colors">
                    <span wire:loading.remove>💾 Salva tutte le impostazioni</span>
                    <span wire:loading>Salvataggio…</span>
                </button>
                <p class="text-xs text-gray-400">Le modifiche ai contatti saranno visibili immediatamente sul sito.</p>
            </div>
        </form>
    </div>
</div>
