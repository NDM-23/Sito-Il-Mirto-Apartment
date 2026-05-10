@extends('layouts.mirto')
@section('title', 'Galleria Foto — Il Mirto Apartment Olbia Sardegna')
@section('meta_description', 'Scopri Il Mirto Apartment attraverso le nostre foto: piscina, camere, soggiorno, cucina e le spiagge di Olbia.')

@section('content')

{{-- Mini-hero --}}
<div class="relative overflow-hidden pt-20" style="background:linear-gradient(135deg,#1a4971 0%,#2b6a9e 100%);min-height:260px;">
    <div class="relative mx-auto max-w-7xl px-4 py-16 text-white">
        <nav class="mb-4 text-sm" style="color:rgba(255,255,255,.6);">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">›</span>
            <span class="text-white">Galleria</span>
        </nav>
        <h1 class="font-display font-semibold text-white" style="font-size:clamp(2rem,5vw,3.5rem);">Galleria</h1>
        <p class="mt-3" style="color:rgba(255,255,255,.8);">Una visita virtuale all'appartamento e ai dintorni.</p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-12"
     x-data="{ open: false, src: '', alt: '' }">

    {{-- Gallery grid --}}
    @php
        $galleryItems = $images->isNotEmpty() ? $images : collect([
            (object)['path'=>'images/site/galleria-piscina.svg','alt'=>['it'=>'Piscina Il Mirto Apartment']],
            (object)['path'=>'images/site/galleria-soggiorno.svg','alt'=>['it'=>'Soggiorno']],
            (object)['path'=>'images/site/galleria-camera.svg','alt'=>['it'=>'Camera da letto principale']],
            (object)['path'=>'images/site/galleria-cucina.svg','alt'=>['it'=>'Cucina completa']],
            (object)['path'=>'images/site/galleria-bagno.svg','alt'=>['it'=>'Bagno']],
            (object)['path'=>'images/site/galleria-terrazza.svg','alt'=>['it'=>'Terrazza/esterno']],
            (object)['path'=>'images/site/spiaggia-pittulongu.svg','alt'=>['it'=>'Spiaggia Pittulongu']],
            (object)['path'=>'images/site/galleria-olbia.svg','alt'=>['it'=>'Costa di Olbia']],
            (object)['path'=>'images/site/galleria-vista-mare.svg','alt'=>['it'=>'Vista mare Sardegna']],
            (object)['path'=>'images/site/galleria-costa-smeralda.svg','alt'=>['it'=>'Costa Smeralda']],
            (object)['path'=>'images/site/galleria-piscina-sera.svg','alt'=>['it'=>'Piscina al tramonto']],
            (object)['path'=>'images/site/galleria-tramonto.svg','alt'=>['it'=>'Tramonto Sardegna']],
        ]);
    @endphp

    <div class="columns-1 sm:columns-2 lg:columns-3 gap-4 space-y-4">
        @foreach ($galleryItems as $img)
        @php
            $src = $img instanceof \App\Models\GalleryImage
                ? $img->url()
                : (str_starts_with($img->path, 'http') ? $img->path : asset(ltrim($img->path, '/')));
            $alt = data_get($img->alt, app()->getLocale(), data_get($img->alt, 'it', 'Il Mirto Apartment'));
        @endphp
        <div class="break-inside-avoid">
            <button type="button"
                    class="group block w-full overflow-hidden rounded-xl shadow-md ring-1 ring-slate-100 focus:outline-none focus:ring-2 focus:ring-mare transition"
                    @click="open = true; src = '{{ $src }}'; alt = '{{ addslashes($alt) }}'">
                <img src="{{ $src }}"
                     alt="{{ $alt }}"
                     class="w-full object-cover transition duration-500 group-hover:scale-[1.03] group-hover:brightness-90"
                     loading="lazy">
            </button>
        </div>
        @endforeach
    </div>

    {{-- Lightbox --}}
    <div x-show="open"
         x-cloak
         x-transition:enter="transition duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="background:rgba(0,0,0,.92);"
         @keydown.escape.window="open = false"
         @click.self="open = false">
        <button type="button"
                class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full text-white transition hover:bg-white/10"
                @click="open = false"
                aria-label="Chiudi">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img :src="src"
             :alt="alt"
             class="max-h-[90vh] max-w-full rounded-xl object-contain shadow-2xl">
        <p x-text="alt" class="absolute bottom-6 left-1/2 -translate-x-1/2 text-xs text-white/60 text-center"></p>
    </div>

    {{-- CTA --}}
    <div class="mt-16 text-center fade-in">
        <p class="text-slate-600 mb-5">Queste sono foto indicative. Le foto reali dell'appartamento saranno disponibili presto.</p>
        <a href="{{ route('preventivo') }}"
           class="inline-flex items-center gap-2 rounded-full bg-mare px-7 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-mare-deep hover:-translate-y-0.5">
            Prenota il tuo soggiorno →
        </a>
    </div>
</div>
@endsection
