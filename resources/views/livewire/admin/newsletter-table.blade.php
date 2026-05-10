<div class="py-10">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-800">Iscritti newsletter</h1>
        <div class="mt-6 overflow-x-auto rounded-lg border border-gray-200 bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left">Email</th>
                        <th class="px-3 py-2 text-left">Lingua</th>
                        <th class="px-3 py-2 text-left">Confermato</th>
                        <th class="px-3 py-2 text-left">Marketing</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rows as $r)
                        <tr>
                            <td class="px-3 py-2">{{ $r->email }}</td>
                            <td class="px-3 py-2">{{ $r->locale }}</td>
                            <td class="px-3 py-2">{{ $r->confirmed_at?->format('Y-m-d H:i') ?? '—' }}</td>
                            <td class="px-3 py-2">{{ $r->marketing_consent ? 'sì' : 'no' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-3 py-6 text-center text-gray-500">Nessun iscritto.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $rows->links() }}</div>
    </div>
</div>
