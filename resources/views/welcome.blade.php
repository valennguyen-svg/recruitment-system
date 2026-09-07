<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">

    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="font-semibold text-lg text-gray-800">
                        {{ config('app.name') }}
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    @includeIf('layouts.partials.locale-switcher')

                    @auth
                        <a href="{{ route('jobs.index') }}"
                           class="text-sm text-gray-700 hover:text-gray-900">
                            {{ __('nav.jobs') }}
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="text-sm text-gray-700 hover:text-gray-900">
                            {{ __('nav.profile') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-700 hover:text-gray-900">
                                {{ __('nav.logout') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm text-gray-700 hover:text-gray-900">
                            {{ __('auth.actions.login') }}
                        </a>

                        <a href="{{ route('register') }}"
                           class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2">
                            {{ __('auth.actions.register') }}
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <h1 class="text-4xl font-bold text-gray-900">
            {{ __('home.hero.title') }}
        </h1>

        <p class="mt-4 text-lg text-gray-600">
            {{ __('home.hero.subtitle') }}
        </p>

        <div class="mt-8 flex items-center justify-center gap-4">
            <a href="{{ route('jobs.index') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg px-6 py-3">
                {{ __('home.actions.browse_jobs') }}
            </a>

            @guest
                <a href="{{ route('register') }}"
                   class="border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium rounded-lg px-6 py-3">
                    {{ __('home.actions.create_account') }}
                </a>
            @endguest
        </div>
    </main>

</body>
</html>