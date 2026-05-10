<div class="py-10">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl font-semibold text-gray-800">Calendario prezzi & disponibilità</h1>
            <div class="flex items-center gap-2">
                <button type="button" wire:click="prevMonth"
                        class="rounded border border-gray-300 bg-white px-3 py-1.5 text-sm hover:bg-gray-50">&larr;</button>
                <span class="min-w-[10rem] text-center font-semibold capitalize text-gray-800">{{ $title }}</span>
                <button type="button" wire:click="nextMonth"
                        class="rounded border border-gray-300 bg-white px-3 py-1.5 text-sm hover:bg-gray-50">&rarr;</button>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @if($hasIcalUrls)
                <button type="button" wire:click="syncIcal" wire:loading.attr="disabled"
                        class="rounded border border-indigo-300 bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-100 disabled:opacity-50">
                    <span wire:loading.remove wire:target="syncIcal">🔄 Sincronizza iCal</span>
                    <span wire:loading wire:target="syncIcal">Sincronizzazione…</span>
                </button>
                @else
                <a href="{{ route('dashboard.settings') }}" class="text-xs text-indigo-600 hover:underline">
                    + Configura iCal
                </a>
                @endif
                <button type="button" wire:click="saveMonth" wire:loading.attr="disabled"
                        class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 disabled:opacity-50">
                    <span wire:loading.remove wire:target="saveMonth">Salva mese</span>
                    <span wire:loading wire:target="saveMonth">Salvataggio…</span>
                </button>
            </div>
        </div>
        @if (session('flash_ok'))
            <p class="mb-4 rounded border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-900">{{ session('flash_ok') }}</p>
        @endif
        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left">Data</th>
                        <th class="px-3 py-2 text-left">Prezzo (€)</th>
                        <th class="px-3 py-2 text-left">Min notti</th>
                        <th class="px-3 py-2 text-left">Occupato</th>
                        <th class="px-3 py-2 text-left">Bloccato</th>
                        <th class="px-3 py-2 text-left">Etichetta promo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($draft as $k => $row)
                        @php $dateLabel = str_replace('_', '-', $k); @endphp
                        <tr wire:key="row-{{ $k }}">
                            <td class="whitespace-nowrap px-3 py-2 font-mono text-xs">{{ $dateLabel }}</td>
                            <td class="px-3 py-2">
                                <input type="text" wire:model="draft.{{ $k }}.price_eur" class="w-24 rounded border border-gray-300 px-2 py-1" />
                            </td>
                            <td class="px-3 py-2">
                                <input type="number" wire:model="draft.{{ $k }}.min_nights" class="w-16 rounded border border-gray-300 px-2 py-1" />
                            </td>
                            <td class="px-3 py-2">
                                <input type="checkbox" wire:model="draft.{{ $k }}.is_booked" />
                            </td>
                            <td class="px-3 py-2">
                                <input type="checkbox" wire:model="draft.{{ $k }}.is_blocked" />
                            </td>
                            <td class="px-3 py-2">
                                <input type="text" wire:model="draft.{{ $k }}.promo_label" class="w-32 rounded border border-gray-300 px-2 py-1" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
