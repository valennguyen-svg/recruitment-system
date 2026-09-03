<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('profile.page.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Thông tin tài khoản --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- CV của tôi --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @php
                    $resumes    = $candidate?->resumes ?? collect();
                    $skillsText = is_array($candidate?->skills)
                        ? implode(', ', $candidate->skills)
                        : ($candidate->skills ?? '');
                @endphp

                <header class="mb-5">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('candidate.page.my_cv') }} ({{ $resumes->count() }})
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">{{ __('candidate.hints.my_cv_desc') }}</p>
                </header>

                @if ($resumes->isEmpty())
                    <p class="text-sm text-gray-500">{{ __('candidate.messages.no_cv_hint') }}</p>
                @else
                    @foreach ($resumes as $resume)
                        <div class="py-3 border-b last:border-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-900 text-sm">{{ $resume->title }}</span>
                                        @if ($resume->is_default)
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">
                                                {{ __('candidate.messages.default_badge') }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        {{ $resume->original_name }} · {{ $resume->created_at->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3 text-sm">
                                    <a href="{{ route('resumes.download', $resume) }}"
                                       class="text-blue-600 hover:underline">
                                        {{ __('candidate.actions.download') }}
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

                            <details class="mt-3" {{ $errors->any() && $loop->first ? 'open' : '' }}>
                                <summary class="text-sm text-gray-700 cursor-pointer hover:underline">
                                    {{ __('candidate.actions.view_info') }}
                                </summary>

                                <div class="mt-3 p-4 bg-gray-50 rounded-lg">
                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm mb-4">
                                        <div>
                                            <dt class="text-gray-500">{{ __('candidate.fields.full_name') }}</dt>
                                            <dd class="text-gray-900">{{ $user->name }}</dd>
                                        </div>

                                        @if ($candidate->headline)
                                            <div>
                                                <dt class="text-gray-500">{{ __('candidate.fields.headline') }}</dt>
                                                <dd class="text-gray-900">{{ $candidate->headline }}</dd>
                                            </div>
                                        @endif

                                        @if ($candidate->phone)
                                            <div>
                                                <dt class="text-gray-500">{{ __('candidate.fields.phone') }}</dt>
                                                <dd class="text-gray-900">{{ $candidate->phone }}</dd>
                                            </div>
                                        @endif

                                        @if ($candidate->date_of_birth)
                                            <div>
                                                <dt class="text-gray-500">{{ __('candidate.fields.date_of_birth') }}</dt>
                                                <dd class="text-gray-900">{{ $candidate->date_of_birth->format('d/m/Y') }}</dd>
                                            </div>
                                        @endif

                                        @if ($candidate->experience_years)
                                            <div>
                                                <dt class="text-gray-500">{{ __('candidate.fields.experience_years') }}</dt>
                                                <dd class="text-gray-900">{{ $candidate->experience_years }}</dd>
                                            </div>
                                        @endif

                                        @if ($candidate->address)
                                            <div class="sm:col-span-2">
                                                <dt class="text-gray-500">{{ __('candidate.fields.address') }}</dt>
                                                <dd class="text-gray-900">{{ $candidate->address }}</dd>
                                            </div>
                                        @endif

                                        @if ($skillsText !== '')
                                            <div class="sm:col-span-2">
                                                <dt class="text-gray-500">{{ __('candidate.fields.skills') }}</dt>
                                                <dd class="text-gray-900">{{ $skillsText }}</dd>
                                            </div>
                                        @endif

                                        @if ($candidate->education)
                                            <div class="sm:col-span-2">
                                                <dt class="text-gray-500">{{ __('candidate.fields.education') }}</dt>
                                                <dd class="text-gray-900 whitespace-pre-line">{{ $candidate->education }}</dd>
                                            </div>
                                        @endif

                                        @if ($candidate->summary)
                                            <div class="sm:col-span-2">
                                                <dt class="text-gray-500">{{ __('candidate.fields.summary') }}</dt>
                                                <dd class="text-gray-900 whitespace-pre-line">{{ $candidate->summary }}</dd>
                                            </div>
                                        @endif
                                    </dl>

                                    <details class="pt-3 border-t" {{ $errors->any() && $loop->first ? 'open' : '' }}>
                                        <summary class="text-sm text-blue-600 cursor-pointer hover:underline">
                                            {{ __('candidate.actions.edit_info') }}
                                        </summary>

                                        @include('candidate.partials.profile-fields', [
                                            'profile'    => $candidate,
                                            'skillsText' => $skillsText,
                                        ])
                                    </details>

                                    <details class="pt-3 mt-3 border-t">
                                        <summary class="text-sm text-gray-600 cursor-pointer hover:underline">
                                            {{ __('candidate.actions.edit_file') }}
                                        </summary>

                                        <form method="POST" action="{{ route('resumes.update', $resume) }}"
                                              enctype="multipart/form-data" class="mt-3 space-y-3 max-w-md">
                                            @csrf
                                            @method('PATCH')

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    {{ __('candidate.fields.title') }}
                                                </label>
                                                <input type="text" name="title" required value="{{ $resume->title }}"
                                                       class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    {{ __('candidate.fields.file') }}
                                                    <span class="text-gray-400 font-normal">
                                                        {{ __('candidate.hints.keep_old_file') }}
                                                    </span>
                                                </label>
                                                <input type="file" name="file"
                                                       accept="{{ \App\Constants\ResumeConstants::ACCEPT_ATTR }}"
                                                       class="w-full text-sm text-gray-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-white file:text-gray-700">
                                            </div>

                                            <button type="submit"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
                                                {{ __('candidate.actions.save_changes') }}
                                            </button>
                                        </form>
                                    </details>
                                </div>
                            </details>
                        </div>
                    @endforeach

                    <details class="mt-4">
                        <summary class="text-sm text-blue-600 hover:underline cursor-pointer">
                            {{ __('candidate.actions.add_more') }}
                        </summary>

                        <form method="POST" action="{{ route('resumes.store') }}"
                              enctype="multipart/form-data" class="mt-3 space-y-3 max-w-md">
                            @csrf

                            <input type="text" name="title" required value="{{ old('title') }}"
                                   placeholder="{{ __('candidate.placeholders.title') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">

                            <input type="file" name="file" required
                                   accept="{{ \App\Constants\ResumeConstants::ACCEPT_ATTR }}"
                                   class="w-full text-sm text-gray-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">

                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
                                {{ __('candidate.actions.upload') }}
                            </button>
                        </form>
                    </details>
                @endif

                {{-- Hồ sơ đã nộp --}}
                <div class="pt-6 mt-6 border-t">
                    <h3 class="font-medium text-gray-900 mb-3">
                        {{ __('candidate.page.applied') }} ({{ $applications->total() }})
                    </h3>

                    @if ($applications->isEmpty())
                        <p class="text-sm text-gray-500">{{ __('application.messages.none_yet') }}</p>
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

            {{-- Đổi mật khẩu --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Xoá tài khoản --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>