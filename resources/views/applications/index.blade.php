<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('candidate.page.applied') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-4 sm:p-8">

                @if ($applications->isEmpty())
                    <p class="text-sm text-gray-500">
                        {{ __('application.messages.none_yet') }}
                        <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:underline">
                            {{ __('nav.jobs') }} →
                        </a>
                    </p>
                @else
                    <div class="divide-y border rounded-lg">
                        @foreach ($applications as $app)
                            <div class="flex items-start justify-between gap-4 px-4 py-3 text-sm">
                                <div class="min-w-0">
                                    <a href="{{ route('jobs.show', $app->jobPost) }}"
                                       class="font-medium text-blue-600 hover:underline">
                                        {{ $app->jobPost->title }}
                                    </a>
                                    <p class="text-gray-700">🏢 {{ $app->jobPost->company->name ?? '' }}</p>
                                    <div class="flex flex-wrap gap-x-4 mt-1 text-xs text-gray-500">
                                        <span>📍 {{ $app->jobPost->location }}</span>
                                        @if ($app->resume)
                                            <span>📄 {{ $app->resume->title }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-right shrink-0">
                                    <span class="inline-block text-xs px-2 py-0.5 rounded {{ $app->status->badgeClass() }}">
                                        {{ $app->status->label() }}
                                    </span>
                                    <p class="text-gray-400 text-xs mt-1">{{ $app->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">{{ $applications->links() }}</div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>