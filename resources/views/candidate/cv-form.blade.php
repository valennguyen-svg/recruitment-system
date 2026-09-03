@php
    use App\Constants\CandidateProfileConstants;
    use App\Constants\ResumeConstants;

    $hasCv      = $profile->resumes->count() > 0;
    $skillsText = is_array($profile->skills) ? implode(', ', $profile->skills) : ($profile->skills ?? '');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $hasCv ? __('candidate.page.upload_new') : __('candidate.page.register_cv') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($hasCv)
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800">
                    {{ __('candidate.messages.have_n_cv', ['count' => $profile->resumes->count()]) }}
                </div>
            @endif

            <form method="POST" action="{{ route('candidate.cv.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="p-6 sm:p-8 bg-white shadow sm:rounded-lg space-y-4">
                    <div class="pb-2">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('candidate.page.personal') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ __('candidate.hints.sent_with_apply') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('candidate.fields.full_name') }}
                        </label>
                        <input type="text" value="{{ $user->name }}" disabled
                               class="w-full bg-gray-100 border-gray-300 rounded-lg text-sm text-gray-600">
                        <p class="text-xs text-gray-500 mt-1">{{ __('candidate.hints.name_in_profile') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('candidate.fields.headline') }}
                        </label>
                        <input type="text" name="headline"
                               value="{{ old('headline', $profile->headline) }}"
                               placeholder="{{ __('candidate.placeholders.headline') }}"
                               class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('candidate.fields.date_of_birth') }}
                            </label>
                            <input type="date" name="date_of_birth"
                                   value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('candidate.fields.phone') }}
                            </label>
                            <input type="text" name="phone"
                                   value="{{ old('phone', $profile->phone) }}"
                                   class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('candidate.fields.experience_years') }}
                            </label>
                            <input type="number" name="experience_years"
                                   min="{{ CandidateProfileConstants::EXPERIENCE_YEARS_MIN }}"
                                   max="{{ CandidateProfileConstants::EXPERIENCE_YEARS_MAX }}"
                                   value="{{ old('experience_years', $profile->experience_years ?? CandidateProfileConstants::EXPERIENCE_YEARS_DEFAULT) }}"
                                   class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('candidate.fields.address') }}
                            </label>
                            <input type="text" name="address"
                                   value="{{ old('address', $profile->address) }}"
                                   class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('candidate.fields.skills') }}
                            <span class="text-gray-400 font-normal">{{ __('candidate.hints.skills') }}</span>
                        </label>
                        <textarea name="skills" rows="2"
                                  placeholder="{{ __('candidate.placeholders.skills') }}"
                                  class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('skills', $skillsText) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('candidate.fields.education') }}
                        </label>
                        <textarea name="education" rows="3"
                                  placeholder="{{ __('candidate.placeholders.education') }}"
                                  class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('education', $profile->education) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('candidate.fields.summary') }}
                        </label>
                        <textarea name="summary" rows="5"
                                  class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('summary', $profile->summary) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 p-6 sm:p-8 bg-white shadow sm:rounded-lg space-y-4">
                    <div class="pb-2">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('candidate.page.resume_file') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $hasCv ? __('candidate.hints.keep_old_cv') : __('candidate.hints.finish_upload') }}
                        </p>
                    </div>

                    @if ($hasCv)
                        <div class="pb-3 border-b">
                            <p class="text-xs text-gray-500 mb-2">{{ __('candidate.hints.existing_cv') }}</p>
                            @foreach ($profile->resumes as $resume)
                                <p class="text-sm text-gray-700">
                                    📄 {{ $resume->title }}
                                    <span class="text-gray-400">— {{ $resume->original_name }}</span>
                                </p>
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('candidate.fields.title') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" required value="{{ old('title') }}"
                               placeholder="{{ __('candidate.placeholders.title') }}"
                               class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('candidate.fields.file') }} <span class="text-red-500">*</span>
                            <span class="text-gray-400 font-normal">
                                {{ __('candidate.hints.file', ['size' => ResumeConstants::maxSizeMb()]) }}
                            </span>
                        </label>
                        <input type="file" name="file" required accept="{{ ResumeConstants::ACCEPT_ATTR }}"
                               class="w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-6 py-2.5">
                        {{ $hasCv ? __('candidate.actions.upload') : __('candidate.actions.finish_register') }}
                    </button>

                    <a href="{{ $hasCv ? route('profile.edit') : route('jobs.index') }}"
                       class="text-sm text-gray-600 hover:underline">
                        {{ __('candidate.actions.cancel') }}
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>