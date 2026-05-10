<div class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-slate-100">
    @if ($sent)
        <div class="text-center py-6">
            <span class="text-5xl">📬</span>
            <p class="mt-4 font-display text-xl text-mirto">Quasi fatto!</p>
            <p class="mt-2 text-sm text-slate-600">{{ __('mirto.newsletter.confirm_sent') }}</p>
        </div>
    @else
        <div class="flex items-start gap-3 mb-5">
            <span class="text-3xl">💌</span>
            <div>
                <h3 class="font-display text-xl text-mirto">{{ __('mirto.newsletter.title') }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ __('mirto.newsletter.subtitle') }}</p>
            </div>
        </div>
        <form wire:submit="subscribe" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-mirto mb-1">{{ __('mirto.newsletter.email') }}</label>
                <input type="email" wire:model="email"
                       placeholder="tua@email.com"
                       class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm transition focus:border-mare focus:outline-none focus:ring-2 focus:ring-mare/20" />
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" wire:model="privacy" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-mirto" />
                <span class="text-xs text-slate-600">{{ __('mirto.newsletter.privacy') }} — <a href="{{ route('privacy') }}" class="underline text-mirto hover:text-mirto-light" target="_blank">Privacy Policy</a></span>
            </label>
            @error('privacy') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" wire:model="marketing" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-mirto" />
                <span class="text-xs text-slate-600">{{ __('mirto.newsletter.marketing') }}</span>
            </label>
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full rounded-full bg-mirto py-3 text-sm font-semibold text-white shadow-md transition hover:bg-mirto-light disabled:opacity-60">
                <span wire:loading.remove wire:target="subscribe">{{ __('mirto.newsletter.submit') }} →</span>
                <span wire:loading wire:target="subscribe">Invio in corso…</span>
            </button>
            <p class="text-center text-xs text-slate-400">Zero spam. Disiscrizione in un click. GDPR compliant.</p>
        </form>
    @endif
</div>
