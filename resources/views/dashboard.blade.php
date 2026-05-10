<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Il Mirto — Area riservata
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <p class="text-sm text-gray-600">Accesso per amministratori e editor. Gestisci calendario, impostazioni, newsletter e contenuti.</p>
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @if(auth()->user()?->hasAnyRole(['admin','editor']))
                    <a href="{{ route('dashboard.calendar') }}" class="rounded-lg border border-gray-200 bg-white p-4 shadow hover:border-indigo-300">
                        <h3 class="font-semibold text-gray-900">Calendario prezzi</h3>
                        <p class="mt-1 text-sm text-gray-500">Disponibilità, prezzi giornalieri, blocchi.</p>
                    </a>
                    <a href="{{ route('dashboard.quotes') }}" class="rounded-lg border border-gray-200 bg-white p-4 shadow hover:border-indigo-300">
                        <h3 class="font-semibold text-gray-900">Preventivi calcolati</h3>
                        <p class="mt-1 text-sm text-gray-500">Storico richieste dal sito.</p>
                    </a>
                    <a href="{{ route('dashboard.newsletter') }}" class="rounded-lg border border-gray-200 bg-white p-4 shadow hover:border-indigo-300">
                        <h3 class="font-semibold text-gray-900">Newsletter</h3>
                        <p class="mt-1 text-sm text-gray-500">Iscritti e consensi.</p>
                    </a>
                    <a href="{{ route('dashboard.settings') }}" class="rounded-lg border border-gray-200 bg-white p-4 shadow hover:border-indigo-300">
                        <h3 class="font-semibold text-gray-900">Impostazioni</h3>
                        <p class="mt-1 text-sm text-gray-500">Prezzi base, tasse, contatti, mappe.</p>
                    </a>
                    <a href="{{ route('dashboard.gallery') }}" class="rounded-lg border border-gray-200 bg-white p-4 shadow hover:border-indigo-300">
                        <h3 class="font-semibold text-gray-900">Galleria</h3>
                        <p class="mt-1 text-sm text-gray-500">Upload e ottimizzazione WebP.</p>
                    </a>
                    <a href="{{ route('dashboard.pages') }}" class="rounded-lg border border-gray-200 bg-white p-4 shadow hover:border-indigo-300">
                        <h3 class="font-semibold text-gray-900">Pagine</h3>
                        <p class="mt-1 text-sm text-gray-500">Mostra/nascondi recensioni e blog.</p>
                    </a>
                    <a href="{{ route('dashboard.promotions') }}" class="rounded-lg border border-gray-200 bg-white p-4 shadow hover:border-indigo-300">
                        <h3 class="font-semibold text-gray-900">Offerte</h3>
                        <p class="mt-1 text-sm text-gray-500">Codici promozionali e sconti sul sito.</p>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
