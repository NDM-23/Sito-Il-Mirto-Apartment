<div class="rounded-2xl border border-white/40 bg-white/90 p-4 shadow-lg backdrop-blur">
    <div class="mb-4 flex items-center justify-between">
        <button type="button" wire:click="prevMonth" class="rounded-full border border-mare/30 px-3 py-1 text-sm text-mirto hover:bg-sabbia">&larr;</button>
        <p class="font-display text-lg capitalize text-mirto">{{ $title }}</p>
        <button type="button" wire:click="nextMonth" class="rounded-full border border-mare/30 px-3 py-1 text-sm text-mirto hover:bg-sabbia">&rarr;</button>
    </div>
    <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium uppercase tracking-wide text-mare/80">
        <span>lun</span><span>mar</span><span>mer</span><span>gio</span><span>ven</span><span>sab</span><span>dom</span>
    </div>
    <div class="mt-2 grid grid-cols-7 gap-1 text-sm">
        @for ($i = 0; $i < $pad; $i++)
            <div></div>
        @endfor
        @foreach ($cells as $c)
            @php
                $state = $c['blocked'] ? 'blocked' : ($c['booked'] ? 'booked' : 'free');
            @endphp
            <div @class([
                'flex h-10 items-center justify-center rounded-lg border text-xs font-medium',
                'border-emerald-200 bg-emerald-50 text-emerald-900' => $state === 'free',
                'border-rose-200 bg-rose-50 text-rose-800 line-through' => $state === 'booked',
                'border-slate-300 bg-slate-100 text-slate-500' => $state === 'blocked',
            ]) title="{{ $c['date'] }}">
                {{ $c['day'] }}
            </div>
        @endforeach
    </div>
    <div class="mt-4 flex flex-wrap gap-4 text-xs text-slate-600">
        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-emerald-100 ring ring-emerald-200"></span> {{ __('mirto.cal.free') }}</span>
        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-rose-100 ring ring-rose-200"></span> {{ __('mirto.cal.booked') }}</span>
        <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-slate-100 ring ring-slate-200"></span> {{ __('mirto.cal.blocked') }}</span>
    </div>
</div>
