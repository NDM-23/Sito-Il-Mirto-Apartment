<div class="rounded-2xl border border-white/40 bg-white/90 p-6 shadow-xl backdrop-blur-md">
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-mirto">{{ __('mirto.quote.checkin') }}</label>
            <input type="date" wire:model.live="check_in" class="mt-1 w-full rounded-lg border border-mare/30 px-3 py-2" />
            @error('check_in') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-mirto">{{ __('mirto.quote.checkout') }}</label>
            <input type="date" wire:model.live="check_out" class="mt-1 w-full rounded-lg border border-mare/30 px-3 py-2" />
            @error('check_out') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-mirto">{{ __('mirto.quote.adults') }}</label>
            <input type="number" min="1" wire:model.live="adults" class="mt-1 w-full rounded-lg border border-mare/30 px-3 py-2" />
            @error('adults') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-mirto">{{ __('mirto.quote.children') }}</label>
            <input type="number" min="0" wire:model.live="children" class="mt-1 w-full rounded-lg border border-mare/30 px-3 py-2" />
            @error('children') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="mt-4 grid gap-3 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-mirto">{{ __('mirto.quote.promo') }}</label>
            <input type="text" wire:model.live="promo_code" class="mt-1 w-full rounded-lg border border-mare/30 px-3 py-2 uppercase" placeholder="EARLY2026" />
        </div>
        <div class="flex items-end gap-3">
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" wire:model.live="linen" class="rounded border-mare/40 text-mare" />
                {{ __('mirto.quote.extra_linen') }}
            </label>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3">
        <button type="button" wire:click="calculate" wire:loading.attr="disabled"
            class="inline-flex items-center justify-center rounded-full bg-mare px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-mare-deep">
            <span wire:loading.remove wire:target="calculate">{{ __('mirto.quote.cta') }}</span>
            <span wire:loading wire:target="calculate">{{ __('mirto.quote.loading') }}</span>
        </button>
    </div>

    @if ($show_result && count($result))
        <div class="mt-8 rounded-xl border border-mare/20 bg-sabbia/80 p-5 text-sm text-slate-800">
            @if (!empty($result['errors']))
                <ul class="mb-3 list-disc space-y-1 pl-5 text-red-700">
                    @foreach ($result['errors'] as $e)
                        <li>{{ __('mirto.quote.err_'.$e) }}</li>
                    @endforeach
                </ul>
            @endif

            @if (empty($result['errors']))
                <p class="font-display text-lg text-mirto">{{ __('mirto.quote.summary') }}</p>
                <dl class="mt-3 grid gap-2">
                    <div class="flex justify-between"><dt>{{ __('mirto.quote.nights') }}</dt><dd>{{ $result['nights'] }}</dd></div>
                    <div class="flex justify-between"><dt>{{ __('mirto.quote.subtotal') }}</dt><dd>{{ number_format($result['subtotal_cents']/100,2,',',' ') }} €</dd></div>
                    @if (($result['discount_cents'] ?? 0) > 0)
                        <div class="flex justify-between text-emerald-700"><dt>{{ __('mirto.quote.discount') }}</dt><dd>-{{ number_format($result['discount_cents']/100,2,',',' ') }} €</dd></div>
                    @endif
                    <div class="flex justify-between"><dt>{{ __('mirto.quote.cleaning') }}</dt><dd>{{ number_format($result['cleaning_cents']/100,2,',',' ') }} €</dd></div>
                    <div class="flex justify-between"><dt>{{ __('mirto.quote.tax') }}</dt><dd>{{ number_format($result['tax_cents']/100,2,',',' ') }} €</dd></div>
                    <div class="flex justify-between border-t border-mare/20 pt-2 font-semibold text-mirto"><dt>{{ __('mirto.quote.total') }}</dt><dd>{{ number_format($result['total_cents']/100,2,',',' ') }} €</dd></div>
                </dl>
                <p class="mt-4 text-xs text-slate-600">{{ __('mirto.quote.disclaimer') }}</p>
            @endif
        </div>
    @endif
</div>
