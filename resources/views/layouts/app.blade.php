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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash message dung chung cho moi man hinh -->
            @if (session('success') || session('error') || $errors->has('domain_rule'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 space-y-3">
                    @if (session('success'))
                        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @error('domain_rule')
                        <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>