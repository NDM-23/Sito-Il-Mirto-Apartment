<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ asset('css/mirto.css') }}?v={{ file_exists(public_path('css/mirto.css')) ? filemtime(public_path('css/mirto.css')) : '1' }}">
        @endif

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireStyles
        @php
            $lvManifest = json_decode(@file_get_contents(base_path('vendor/livewire/livewire/dist/manifest.json')), true) ?? [];
            $lvId = $lvManifest['/livewire.js'] ?? 'dev';
        @endphp
        <script
            src="{{ url('/livewire/livewire.js') }}?id={{ $lvId }}"
            data-csrf="{{ csrf_token() }}"
            data-update-uri="{{ url('/livewire/update') }}"
            data-navigate-once="true"
        ></script>
    </body>
</html>
