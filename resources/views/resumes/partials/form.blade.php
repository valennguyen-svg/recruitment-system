@php
    use App\Constants\ResumeConstants;

    $skillsText = is_array($resume?->skills)
        ? implode(', ', $resume->skills)
        : '';
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.title') }} <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title" required
               value="{{ old('title', $resume?->title) }}"
               placeholder="{{ __('candidate.placeholders.title') }}"
               class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('title')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.headline') }}
        </label>
        <input type="text" name="headline"
               value="{{ old('headline', $resume?->headline) }}"
               placeholder="{{ __('candidate.placeholders.headline') }}"
               class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('headline')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.experience_years') }}
        </label>
        <input type="number" name="experience_years"
               min="{{ ResumeConstants::EXPERIENCE_YEARS_MIN }}"
               max="{{ ResumeConstants::EXPERIENCE_YEARS_MAX }}"
               value="{{ old('experience_years', $resume?->experience_years) }}"
               class="w-full sm:w-40 border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('experience_years')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.skills') }}
            <span class="text-gray-400 font-normal">{{ __('candidate.hints.skills') }}</span>
        </label>
        <textarea name="skills" rows="2"
                  placeholder="{{ __('candidate.placeholders.skills') }}"
                  class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('skills', $skillsText) }}</textarea>
        @error('skills')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.education') }}
        </label>
        <textarea name="education" rows="3"
                  placeholder="{{ __('candidate.placeholders.education') }}"
                  class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('education', $resume?->education) }}</textarea>
        @error('education')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.summary') }}
        </label>
        <textarea name="summary" rows="5"
                  class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('summary', $resume?->summary) }}</textarea>
        @error('summary')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.file') }}
            @if ($resume)
                <span class="text-gray-400 font-normal">{{ __('candidate.hints.keep_old_file') }}</span>
            @else
                <span class="text-red-500">*</span>
            @endif
        </label>

        @if ($resume)
            <p class="text-xs text-gray-500 mb-2">{{ $resume->original_name }}</p>
        @endif

        <input type="file" name="file" @unless ($resume) required @endunless
               accept="{{ ResumeConstants::ACCEPT_ATTR }}"
               class="w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">

        <p class="text-xs text-gray-500 mt-1">
            {{ __('candidate.hints.file', ['size' => ResumeConstants::maxSizeMb()]) }}
        </p>

        @error('file')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>
</div>