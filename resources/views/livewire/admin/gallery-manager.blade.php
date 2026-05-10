<div class="py-10">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Galleria immagini</h1>
                <p class="mt-1 text-sm text-gray-500 max-w-2xl">
                    Carica foto, assegna la sezione del sito dove devono comparire, sostituisci o elimina.
                    JPG/PNG/WebP fino a 10 MB — convertite automaticamente in WebP.
                </p>
            </div>
        </div>

        @if (session('flash_ok'))
            <p class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                ✓ {{ session('flash_ok') }}
            </p>
        @endif

        @if(!file_exists(public_path('storage')) && !is_link(public_path('storage')))
        <p class="mt-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            ⚠️ Esegui <code class="bg-amber-100 px-1 rounded font-mono">php artisan storage:link</code> dalla cartella del progetto per visualizzare le anteprime.
        </p>
        @endif

        {{-- Upload panel --}}
        <form wire:submit="saveUploads" class="mt-6 rounded-xl border-2 border-dashed border-blue-200 bg-blue-50 p-5 space-y-4">
            <p class="text-sm font-semibold text-blue-800">📤 Carica nuove immagini</p>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs font-medium text-gray-700">Sezione di destinazione</label>
                    <select wire:model="uploadSectionKey" class="mt-1 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm">
                        @foreach($sections as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-700">File immagine (anche più di uno)</label>
                    <input type="file" wire:model="uploads" multiple accept="image/jpeg,image/png,image/webp,image/gif"
                           class="mt-1 block w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white" />
                    @error('uploads.*') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" wire:loading.attr="disabled"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:opacity-50">
                    <span wire:loading.remove wire:target="saveUploads">Carica immagini</span>
                    <span wire:loading wire:target="saveUploads">Caricamento…</span>
                </button>
                <span wire:loading wire:target="uploads" class="text-sm text-blue-600">Lettura file in corso…</span>
            </div>
        </form>

        {{-- Section tabs --}}
        <div class="mt-8 overflow-x-auto">
            <div class="flex min-w-max gap-1 border-b border-gray-200 pb-0">
                {{-- All --}}
                @php
                    $tabClass = fn($key) => $activeSection === $key
                        ? 'inline-flex items-center gap-1.5 rounded-t-lg border border-b-white border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-blue-700 -mb-px'
                        : 'inline-flex items-center gap-1.5 rounded-t-lg border border-transparent px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 -mb-px cursor-pointer';
                @endphp

                <button type="button" wire:click="$set('activeSection', '__all__')" class="{{ $tabClass('__all__') }}">
                    Tutte
                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $counts['__all__'] ?? 0 }}</span>
                </button>

                {{-- Non assegnate --}}
                @if(($counts['__none__'] ?? 0) > 0 || $activeSection === '__none__')
                <button type="button" wire:click="$set('activeSection', '__none__')" class="{{ $tabClass('__none__') }}">
                    Non assegnate
                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $counts['__none__'] ?? 0 }}</span>
                </button>
                @endif

                {{-- One tab per section --}}
                @foreach($sections as $key => $label)
                    @if($key !== '')
                    <button type="button" wire:click="$set('activeSection', '{{ $key }}')" class="{{ $tabClass($key) }}">
                        {{ $label }}
                        @if(($counts[$key] ?? 0) > 0)
                        <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $counts[$key] }}</span>
                        @endif
                    </button>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Image grid --}}
        <div class="mt-4">
            @if($images->isEmpty())
                <div class="rounded-xl border border-dashed border-gray-200 py-16 text-center text-sm text-gray-400">
                    Nessuna immagine in questa sezione. Caricane una sopra.
                </div>
            @else
                <p class="mb-3 text-xs text-gray-400">
                    {{ $images->total() }} immagini — pagina {{ $images->currentPage() }} di {{ $images->lastPage() }}
                </p>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($images as $img)
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm" wire:key="g-{{ $img->id }}">

                        {{-- Preview --}}
                        <div class="relative h-44 bg-gray-100">
                            <img src="{{ $img->url() }}" alt="" class="h-full w-full object-cover" loading="lazy" />
                            @if(!$img->is_active)
                                <span class="absolute inset-0 flex items-center justify-center bg-black/40 text-xs font-bold text-white">DISATTIVA</span>
                            @endif
                            @if($img->is_hero)
                                <span class="absolute top-2 left-2 rounded bg-yellow-400 px-2 py-0.5 text-xs font-bold text-yellow-900">HERO</span>
                            @endif
                        </div>

                        {{-- Controls --}}
                        <div class="p-3 space-y-2">

                            {{-- Section selector --}}
                            <div>
                                <label class="text-xs font-medium text-gray-500">Sezione sito</label>
                                @php $curSection = $img->section_key ?? ''; @endphp
                                <select
                                    class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5 text-xs bg-white"
                                    wire:change="updateSection({{ $img->id }}, $event.target.value)">
                                    @foreach($sections as $key => $label)
                                        <option value="{{ $key }}" @selected($curSection === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Inline replace panel --}}
                            @if($replacingId === $img->id)
                            <div class="rounded-lg border border-indigo-200 bg-indigo-50 p-2 space-y-2">
                                <p class="text-xs font-semibold text-indigo-800">Seleziona nuovo file:</p>
                                <input type="file" wire:model="replacementFile" accept="image/*"
                                       class="block w-full text-xs file:mr-2 file:rounded file:border-0 file:bg-indigo-600 file:px-3 file:py-1 file:text-xs file:font-semibold file:text-white" />
                                @error('replacementFile') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                                <div class="flex gap-2">
                                    <button type="button" wire:click="saveReplacement" wire:loading.attr="disabled"
                                            class="flex-1 rounded bg-indigo-600 px-2 py-1.5 text-xs font-semibold text-white hover:bg-indigo-700 disabled:opacity-50">
                                        <span wire:loading.remove wire:target="saveReplacement">Salva</span>
                                        <span wire:loading wire:target="saveReplacement">…</span>
                                    </button>
                                    <button type="button" wire:click="cancelReplace"
                                            class="rounded border border-gray-300 px-2 py-1.5 text-xs text-gray-600 hover:bg-gray-100">
                                        Annulla
                                    </button>
                                </div>
                            </div>
                            @endif

                            {{-- Action buttons --}}
                            <div class="flex flex-wrap gap-1.5 pt-1">
                                <button type="button" wire:click="toggle({{ $img->id }}, 'is_active')"
                                        class="rounded border px-2 py-1 text-xs {{ $img->is_active ? 'border-gray-300 text-gray-700 hover:bg-gray-50' : 'border-green-300 bg-green-50 text-green-700 hover:bg-green-100' }}">
                                    {{ $img->is_active ? 'Disattiva' : 'Attiva' }}
                                </button>
                                <button type="button" wire:click="toggle({{ $img->id }}, 'is_hero')"
                                        class="rounded border px-2 py-1 text-xs {{ $img->is_hero ? 'border-yellow-300 bg-yellow-50 text-yellow-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                    ★ Hero
                                </button>
                                <button type="button" wire:click="startReplace({{ $img->id }})"
                                        class="rounded border border-indigo-200 bg-indigo-50 px-2 py-1 text-xs text-indigo-700 hover:bg-indigo-100">
                                    ✎ Modifica
                                </button>
                                <button type="button" wire:click="remove({{ $img->id }})" wire:confirm="Eliminare questa immagine definitivamente?"
                                        class="rounded border border-rose-200 bg-rose-50 px-2 py-1 text-xs text-rose-700 hover:bg-rose-100">
                                    ✕ Elimina
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $images->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
