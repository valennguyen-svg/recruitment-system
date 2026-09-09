<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('candidate.page.my_cv') }}
            </h2>

            @if ($resumes->isNotEmpty())
                <a href="{{ route('resumes.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-4 py-2">
                    {{ __('candidate.actions.create_cv') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($resumes->isNotEmpty())
                <div class="bg-white shadow sm:rounded-lg divide-y">
                    @foreach ($resumes as $resume)
                        <div class="p-5 flex items-start justify-between gap-6">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('resumes.show', $resume) }}"
                                       class="font-medium text-gray-900 hover:underline">
                                        {{ $resume->title }}
                                    </a>

                                    @if ($resume->is_default)
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">
                                            {{ __('candidate.messages.default_badge') }}
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs text-gray-500 mt-2">
                                    {{ $resume->original_name }} · {{ $resume->created_at->format('d/m/Y') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3 text-sm shrink-0">
                                @unless ($resume->is_default)
                                    <form method="POST" action="{{ route('resumes.default', $resume) }}">
                                        @csrf
                                        <button type="submit" class="text-gray-600 hover:underline">
                                            {{ __('candidate.actions.set_default') }}
                                        </button>
                                    </form>
                                @endunless

                                <a href="{{ route('resumes.show', $resume) }}"
                                   class="text-gray-600 hover:underline">
                                    {{ __('candidate.actions.view') }}
                                </a>

                                <a href="{{ route('resumes.download', $resume) }}"
                                   class="text-gray-600 hover:underline">
                                    {{ __('candidate.actions.download') }}
                                </a>

                                <a href="{{ route('resumes.edit', $resume) }}"
                                   class="text-blue-600 hover:underline">
                                    {{ __('candidate.actions.edit') }}
                                </a>

                                <form method="POST" action="{{ route('resumes.destroy', $resume) }}"
                                      onsubmit="return confirm('{{ __('candidate.messages.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600 hover:underline">
                                        {{ __('candidate.actions.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white shadow sm:rounded-lg p-12 text-center">
                    <p class="text-gray-500">{{ __('candidate.messages.no_cv_hint') }}</p>

                    <a href="{{ route('resumes.create') }}"
                       class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-5 py-2.5">
                        {{ __('candidate.actions.create_cv') }}
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>