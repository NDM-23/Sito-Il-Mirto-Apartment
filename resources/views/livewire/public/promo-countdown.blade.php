<div class="rounded-2xl border border-amber-200 bg-gradient-to-r from-amber-50 to-orange-50 p-5 shadow-sm">
    <div class="flex items-start gap-3">
        <span class="text-2xl shrink-0">⏰</span>
        <div>
            <p class="font-semibold text-amber-900">Offerta attiva</p>
            <p class="text-sm text-amber-700 mt-0.5">
                Scade il <strong>{{ $until->timezone(config('app.timezone'))->format('d/m/Y') }}</strong>
                alle <strong>{{ $until->timezone(config('app.timezone'))->format('H:i') }}</strong>
            </p>
            <p class="mt-1 text-xs text-amber-600">Prenota ora per bloccare il prezzo.</p>
        </div>
    </div>
    <div class="mt-4" x-data="countdown({{ $until->timestamp }})" x-init="start()">
        <div class="grid grid-cols-4 gap-2 text-center">
            @foreach(['days','hours','minutes','seconds'] as $unit)
            <div class="rounded-lg bg-white py-2 shadow-sm ring-1 ring-amber-100">
                <p class="font-display text-2xl font-bold text-amber-900" x-text="{{ $unit }}"></p>
                <p class="text-xs text-amber-500">{{ ['days'=>'giorni','hours'=>'ore','minutes'=>'min','seconds'=>'sec'][$unit] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
function countdown(deadline) {
    return {
        days: 0, hours: 0, minutes: 0, seconds: 0,
        start() {
            this.tick();
            setInterval(() => this.tick(), 1000);
        },
        tick() {
            const diff = Math.max(0, deadline - Math.floor(Date.now()/1000));
            this.days    = Math.floor(diff / 86400);
            this.hours   = Math.floor((diff % 86400) / 3600);
            this.minutes = Math.floor((diff % 3600) / 60);
            this.seconds = diff % 60;
        }
    }
}
</script>
@endpush
