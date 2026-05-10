<div class="py-10">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-800">Richieste preventivo</h1>
        <div class="mt-6 overflow-x-auto rounded-lg border border-gray-200 bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left">ID</th>
                        <th class="px-3 py-2 text-left">Check-in</th>
                        <th class="px-3 py-2 text-left">Check-out</th>
                        <th class="px-3 py-2 text-left">Ospiti</th>
                        <th class="px-3 py-2 text-left">Totale €</th>
                        <th class="px-3 py-2 text-left">Stato</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rows as $r)
                        <tr>
                            <td class="px-3 py-2 font-mono text-xs">{{ $r->id }}</td>
                            <td class="px-3 py-2">{{ $r->check_in->format('Y-m-d') }}</td>
                            <td class="px-3 py-2">{{ $r->check_out->format('Y-m-d') }}</td>
                            <td class="px-3 py-2">{{ $r->adults }}+{{ $r->children }}</td>
                            <td class="px-3 py-2">
                                @if ($r->calculation)
                                    {{ number_format(($r->calculation['total_cents'] ?? 0) / 100, 2, ',', ' ') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-3 py-2">{{ $r->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Nessuna richiesta ancora.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $rows->links() }}</div>
    </div>
</div>
