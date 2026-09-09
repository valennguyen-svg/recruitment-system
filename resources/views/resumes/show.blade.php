@php
    $skills = is_array($profile->skills) ? $profile->skills : [];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $resume->title }}
            </h2>

            <a href="{{ route('resumes.edit', $resume) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-4 py-2">
                {{ __('candidate.actions.edit') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Thông tin cá nhân --}}
            <div class="bg-white shadow sm:rounded-lg p-6 sm:p-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ __('candidate.page.personal') }}
                </h3>

                <dl class="divide-y divide-gray-100 text-sm">
                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-gray-500">{{ __('candidate.fields.headline') }}</dt>
                        <dd class="col-span-2 text-gray-900">{{ $profile->headline ?: '—' }}</dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-gray-500">{{ __('candidate.fields.date_of_birth') }}</dt>
                        <dd class="col-span-2 text-gray-900">
                            {{ $profile->date_of_birth?->format('d/m/Y') ?: '—' }}
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-gray-500">{{ __('candidate.fields.phone') }}</dt>
                        <dd class="col-span-2 text-gray-900">{{ $profile->phone ?: '—' }}</dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-gray-500">{{ __('candidate.fields.address') }}</dt>
                        <dd class="col-span-2 text-gray-900">{{ $profile->address ?: '—' }}</dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-gray-500">{{ __('candidate.fields.experience_years') }}</dt>
                        <dd class="col-span-2 text-gray-900">{{ $profile->experience_years ?? '—' }}</dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-gray-500">{{ __('candidate.fields.skills') }}</dt>
                        <dd class="col-span-2">
                            @forelse ($skills as $skill)
                                <span class="inline-block bg-gray-100 text-gray-700 text-xs rounded px-2 py-1 mr-1 mb-1">
                                    {{ $skill }}
                                </span>
                            @empty
                                <span class="text-gray-900">—</span>
                            @endforelse
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-gray-500">{{ __('candidate.fields.education') }}</dt>
                        <dd class="col-span-2 text-gray-900 whitespace-pre-line">{{ $profile->education ?: '—' }}</dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-gray-500">{{ __('candidate.fields.summary') }}</dt>
                        <dd class="col-span-2 text-gray-900 whitespace-pre-line">{{ $profile->summary ?: '—' }}</dd>
                    </div>
                </dl>

                <p class="mt-4 text-xs text-gray-500">
                    {{ __('candidate.hints.shared_info') }}
                </p>
            </div>

            {{-- File CV --}}
            <div class="bg-white shadow sm:rounded-lg p-6 sm:p-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    {{ __('candidate.page.resume_file') }}
                </h3>

                <p class="text-sm text-gray-900">{{ $resume->original_name }}</p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $resume->mime_type }} · {{ number_format($resume->size / 1024) }} KB
                    · {{ $resume->created_at->format('d/m/Y') }}
                </p>

                <a href="{{ route('resumes.download', $resume) }}"
                   class="inline-block mt-4 text-sm text-blue-600 hover:underline">
                    {{ __('candidate.actions.download') }}
                </a>
            </div>

            <a href="{{ route('resumes.index') }}" class="inline-block text-sm text-gray-600 hover:underline">
                &larr; {{ __('candidate.page.my_cv') }}
            </a>

        </div>
    </div>
</x-app-layout>