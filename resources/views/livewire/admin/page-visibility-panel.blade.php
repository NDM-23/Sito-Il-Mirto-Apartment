<div class="py-10">
    <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-800">Visibilità pagine</h1>
        @if (session('flash_ok'))
            <p class="mt-4 rounded border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm">{{ session('flash_ok') }}</p>
        @endif
        <form wire:submit="save" class="mt-6 space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" wire:model="pages.reviews" /> Recensioni pubbliche
            </label>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" wire:model="pages.blog" /> Blog (predisposto)
            </label>
            <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Salva</button>
        </form>
    </div>
</div>
