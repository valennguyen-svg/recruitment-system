@php
    use App\Enums\EmploymentType;
    use App\Enums\SortOption;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('job.page.index') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Bộ lọc --}}
            <form method="GET" action="{{ route('jobs.index') }}"
                  class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                           placeholder="{{ __('job.placeholders.keyword') }}"
                           class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <input type="text" name="location" value="{{ request('location') }}"
                           placeholder="{{ __('job.fields.location') }}"
                           class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <select name="employment_type"
                            class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">{{ __('job.attributes.employment_type') }}</option>
                        @foreach (EmploymentType::cases() as $type)
                            <option value="{{ $type->value }}" @selected(request('employment_type') === $type->value)>
                                {{ $type->label() }}
                            </option>
                        @endforeach
                    </select>

                    <select name="sort"
                            class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach (SortOption::cases() as $option)
                            <option value="{{ $option->value }}" @selected(request('sort') === $option->value)>
                                {{ $option->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 flex items-center gap-3">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-5 py-2">
                        {{ __('job.actions.search') }}
                    </button>

                    <a href="{{ route('jobs.index') }}" class="text-sm text-gray-600 hover:underline">
                        {{ __('job.actions.reset') }}
                    </a>
                </div>
            </form>

            {{-- Danh sách tin --}}
            <div class="bg-white shadow sm:rounded-lg p-4 sm:p-8">
                <p class="text-sm text-gray-500 mb-4">
                    {{ __('job.messages.found', ['count' => $jobs->total()]) }}
                </p>

                @forelse ($jobs as $job)
                    <div class="py-4 border-b last:border-0">
                        <a href="{{ route('jobs.show', $job) }}"
                           class="font-medium text-blue-600 hover:underline">
                            {{ $job->title }}
                        </a>

                        <p class="text-sm text-gray-700 mt-1">🏢 {{ $job->company->name ?? '' }}</p>

                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-xs text-gray-500">
                            <span>📍 {{ $job->location }}</span>
                            <span>💼 {{ $job->category->name ?? '' }}</span>
                            <span>🕒 {{ $job->employment_type->label() }}</span>
                            @if ($job->deadline)
                                <span>⏳ {{ __('job.fields.deadline') }} {{ $job->deadline->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">{{ __('job.messages.none') }}</p>
                @endforelse

                <div class="mt-6">{{ $jobs->links() }}</div>
            </div>

        </div>
    </div>
</x-app-layout>