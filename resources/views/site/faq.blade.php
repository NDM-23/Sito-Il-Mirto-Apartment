@extends('layouts.mirto')
@section('title', __('faq.title').' — '.__('mirto.brand'))
@section('meta_description', __('faq.intro'))

@section('content')

<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#1a4971 0%,#2b6a9e 100%);min-height:220px;">
    <div class="relative mx-auto max-w-7xl px-4 py-14 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.65);">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('mirto.nav.home') }}</a>
            <span class="mx-2">›</span>
            <span>{{ __('faq.title') }}</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(1.85rem,4vw,2.75rem);">{{ __('faq.title') }}</h1>
        <p class="mt-3 max-w-2xl text-sm md:text-base" style="color:rgba(255,255,255,.88);">{{ __('faq.intro') }}</p>
    </div>
</div>

<div class="mx-auto max-w-3xl px-4 py-14">
    <div class="space-y-3">
        @foreach(__('faq.items') as $item)
        <details class="group rounded-2xl border border-slate-200/80 bg-white px-5 py-1 shadow-sm ring-1 ring-slate-100 open:shadow-md open:ring-blue-100 transition-shadow">
            <summary class="cursor-pointer list-none py-4 font-semibold text-slate-800 flex items-center justify-between gap-3">
                <span>{{ $item['q'] }}</span>
                <span class="shrink-0 text-mare text-lg leading-none transition-transform group-open:rotate-180" aria-hidden="true">▼</span>
            </summary>
            <div class="border-t border-slate-100 pb-4 pt-1 text-sm leading-relaxed text-slate-600">
                {{ $item['a'] }}
            </div>
        </details>
        @endforeach
    </div>

    <p class="mt-10 text-center text-sm text-slate-500">
        <a href="{{ route('contacts') }}" class="font-medium text-mare-deep hover:underline">{{ __('mirto.nav.contacts') }}</a>
        ·
        <a href="{{ route('preventivo') }}" class="font-medium text-mare-deep hover:underline">{{ __('mirto.nav.preventivo') }}</a>
    </p>
</div>

@endsection
