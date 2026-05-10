@extends('layouts.mirto')
@section('title', 'Blog Sardegna — Il Mirto Apartment')
@section('content')
<div class="pt-20 bg-mirto px-4 py-16 text-white" style="min-height:260px;">
    <div class="mx-auto max-w-7xl">
        <h1 class="font-display font-semibold text-white" style="font-size:2.5rem;">Blog & Guide</h1>
        <p class="mt-3" style="color:rgba(255,255,255,.8);">Consigli di viaggio, guide alle spiagge e idee per la tua vacanza in Sardegna.</p>
    </div>
</div>
<div class="mx-auto max-w-7xl px-4 py-16 text-center">
    <p class="text-4xl mb-6">✍️</p>
    <h2 class="font-display text-2xl text-mirto">Articoli in arrivo</h2>
    <p class="mt-3 text-slate-600 max-w-md mx-auto">Stiamo preparando guide sulle spiagge, ristoranti e itinerari di Olbia e della Sardegna nord-est.</p>
    <a href="{{ route('newsletter.page') }}"
       class="mt-6 inline-flex rounded-full bg-mare px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-mare-deep transition">
        Iscriviti per ricevere le guide →
    </a>
</div>
@endsection
