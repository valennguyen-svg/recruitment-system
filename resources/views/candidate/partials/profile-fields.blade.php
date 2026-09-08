@php
    use App\Constants\ResumeConstants;
@endphp

<form method="POST" action="{{ route('resumes.update', $resume) }}"
      enctype="multipart/form-data" class="mt-3 space-y-4">
    @csrf
    @method('PATCH')

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.title') }} <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title" required
               value="{{ old('title', $resume->title) }}"
               class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
        @error('title')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.headline') }}
            </label>
            <input type="text" name="headline"
                   value="{{ old('headline', $resume->headline) }}"
                   placeholder="{{ __('candidate.placeholders.headline') }}"
                   class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            @error('headline')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.experience_years') }}
            </label>
            <input type="number" name="experience_years"
                   min="{{ ResumeConstants::EXPERIENCE_YEARS_MIN }}"
                   max="{{ ResumeConstants::EXPERIENCE_YEARS_MAX }}"
                   value="{{ old('experience_years', $resume->experience_years) }}"
                   class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            @error('experience_years')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.skills') }}
            <span class="text-gray-400 font-normal">{{ __('candidate.hints.skills') }}</span>
        </label>
        <textarea name="skills" rows="2"
                  placeholder="{{ __('candidate.placeholders.skills') }}"
                  class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('skills', $skillsText) }}</textarea>
        @error('skills')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.education') }}
        </label>
        <textarea name="education" rows="3"
                  placeholder="{{ __('candidate.placeholders.education') }}"
                  class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('education', $resume->education) }}</textarea>
        @error('education')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.summary') }}
        </label>
        <textarea name="summary" rows="5"
                  class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('summary', $resume->summary) }}</textarea>
        @error('summary')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.file') }}
            <span class="text-gray-400 font-normal">{{ __('candidate.hints.keep_old_file') }}</span>
        </label>
        <input type="file" name="file" accept="{{ ResumeConstants::ACCEPT_ATTR }}"
               class="w-full text-sm text-gray-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-white file:text-gray-700">
        @error('file')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
        {{ __('candidate.actions.save_changes') }}
    </button>
</form>