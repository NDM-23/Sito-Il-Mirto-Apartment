<div id="mirto-exit-root"
     class="fixed inset-0 z-[100] hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,.6);backdrop-filter:blur(4px);">
    <div class="relative max-w-md w-full overflow-hidden rounded-3xl bg-white shadow-2xl">
        {{-- Decorative gradient header --}}
        <div class="h-2" style="background:linear-gradient(to right,#2fb5c3,#1f5c4b);"></div>

        <div class="p-8">
            {{-- Close button --}}
            <button type="button" id="mirto-exit-close"
                    class="absolute right-4 top-4 flex h-8 w-8 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                    aria-label="Chiudi">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Icon --}}
            <div class="text-5xl text-center mb-4">🎁</div>

            {{-- Content --}}
            <h3 class="font-display text-2xl font-semibold text-mirto text-center">{{ __('mirto.exit.title') }}</h3>
            <p class="mt-3 text-sm text-slate-600 text-center leading-relaxed">{{ __('mirto.exit.text') }}</p>

            {{-- Bullet points --}}
            <ul class="mt-5 space-y-2 text-xs text-slate-600">
                @foreach(['Offerte last minute in anteprima', 'Codici sconto esclusivi', 'Guide sulle spiagge più belle'] as $item)
                <li class="flex items-center gap-2">
                    <span class="h-4 w-4 flex items-center justify-center rounded-full bg-mare/15 text-mare text-xs">✓</span>
                    {{ $item }}
                </li>
                @endforeach
            </ul>

            {{-- CTAs --}}
            <div class="mt-6 flex flex-col gap-3">
                <a href="{{ route('newsletter.page') }}"
                   class="block w-full rounded-full bg-mare py-3 text-center text-sm font-semibold text-white shadow-lg transition hover:bg-mare-deep">
                    {{ __('mirto.exit.cta') }} →
                </a>
                <button type="button" id="mirto-exit-close-2"
                        class="block w-full rounded-full border border-slate-200 py-3 text-center text-sm text-slate-500 transition hover:bg-slate-50">
                    {{ __('mirto.exit.close') }}
                </button>
            </div>

            <p class="mt-4 text-center text-xs text-slate-400">Zero spam. Disiscrizione sempre possibile.</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('mirto-exit-root');
    if (!root || sessionStorage.getItem('mirto_exit_done')) return;

    const show = () => {
        if (!sessionStorage.getItem('mirto_exit_shown')) {
            sessionStorage.setItem('mirto_exit_shown', '1');
            root.style.display = 'flex';
        }
    };
    const hide = () => {
        root.style.display = 'none';
        sessionStorage.setItem('mirto_exit_done', '1');
    };

    document.getElementById('mirto-exit-close')?.addEventListener('click', hide);
    document.getElementById('mirto-exit-close-2')?.addEventListener('click', hide);
    root.addEventListener('click', (e) => { if (e.target === root) hide(); });

    // Trigger: mouse leaving viewport top (desktop) or 40s timer (mobile)
    document.addEventListener('mouseleave', (e) => {
        if (e.clientY < 5) show();
    });
    setTimeout(show, 40000);
});
</script>
