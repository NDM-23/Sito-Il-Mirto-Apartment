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
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600,700|dm-sans:400,500,600,700&display=swap" rel="stylesheet" />
        @endif

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        {{-- Livewire scripts with full absolute URLs (required for XAMPP subdirectory installs) --}}
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
