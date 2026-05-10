<div class="py-10">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Offerte e codici promozionali</h1>
                <p class="mt-1 text-sm text-gray-500">Gestisci le promozioni visibili sul sito e utilizzabili nel preventivatore.</p>
            </div>
            @if($editingId)
                <button type="button" wire:click="resetForm" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">+ Nuova offerta</button>
            @endif
        </div>

        @if (session('flash_ok'))
            <p class="mt-4 rounded border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-800">{{ session('flash_ok') }}</p>
        @endif

        <div class="mt-8 grid gap-8 lg:grid-cols-2">
            <form wire:submit="save" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm space-y-4">
                <h2 class="font-semibold text-gray-800">{{ $editingId ? 'Modifica offerta' : 'Nuova offerta' }}</h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Codice (es. EARLY2026)</label>
                        <input type="text" wire:model="code" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 font-mono text-sm uppercase" />
                        @error('code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nome interno</label>
                        <input type="text" wire:model="name" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Tipo sconto</label>
                        <select wire:model="discount_type" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                            <option value="percent">Percentuale sul soggiorno</option>
                            <option value="fixed">Importo fisso (€)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            @if($discount_type === 'percent') Valore (%) @else Importo (€) @endif
                        </label>
                        <input type="text" wire:model="discount_input" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="{{ $discount_type === 'percent' ? '10' : '50' }}" />
                        @error('discount_input') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Valido dal</label>
                        <input type="date" wire:model="valid_from" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Valido al</label>
                        <input type="date" wire:model="valid_to" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                        @error('valid_to') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Notti minime per applicare il codice</label>
                    <input type="number" wire:model="min_nights" min="1" max="60" class="mt-1 w-full max-w-xs rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    @error('min_nights') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Descrizione (sito / note)</label>
                    <textarea wire:model="description" rows="3" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></textarea>
                </div>

                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="active" class="rounded border-gray-300" />
                        Attiva
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="stackable" class="rounded border-gray-300" />
                        Combinabile con altre (sperimentale)
                    </label>
                </div>

                <button type="submit" class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                    {{ $editingId ? 'Aggiorna' : 'Crea offerta' }}
                </button>
            </form>

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 bg-gray-50 px-4 py-3">
                    <h2 class="font-semibold text-gray-800">Elenco ({{ $promotions->total() }})</h2>
                </div>
                <div class="divide-y divide-gray-100 max-h-[600px] overflow-y-auto">
                    @forelse ($promotions as $p)
                        <div class="flex flex-wrap items-start justify-between gap-2 px-4 py-3" wire:key="promo-{{ $p->id }}">
                            <div>
                                <p class="font-mono font-semibold text-gray-900">{{ $p->code }}</p>
                                <p class="text-sm text-gray-600">{{ $p->name }}</p>
                                <p class="mt-1 text-xs text-gray-500">
                                    @if($p->discount_type === 'percent')
                                        −{{ $p->discount_value }}%
                                    @else
                                        −{{ number_format($p->discount_value / 100, 2, ',', ' ') }} €
                                    @endif
                                    · min {{ $p->min_nights }} notti
                                    @if($p->valid_from || $p->valid_to)
                                        · {{ $p->valid_from?->format('d/m/Y') ?? '…' }} – {{ $p->valid_to?->format('d/m/Y') ?? '…' }}
                                    @endif
                                </p>
                                @if(!$p->active)
                                    <span class="mt-1 inline-block rounded bg-gray-200 px-2 py-0.5 text-xs">Disattiva</span>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <button type="button" wire:click="edit({{ $p->id }})" class="text-sm text-indigo-600 hover:underline">Modifica</button>
                                <button type="button" wire:click="delete({{ $p->id }})" wire:confirm="Eliminare questa offerta?" class="text-sm text-rose-600 hover:underline">Elimina</button>
                            </div>
                        </div>
                    @empty
                        <p class="px-4 py-8 text-center text-sm text-gray-500">Nessuna offerta. Creane una a sinistra.</p>
                    @endforelse
                </div>
                <div class="border-t border-gray-100 px-4 py-3">
                    {{ $promotions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
