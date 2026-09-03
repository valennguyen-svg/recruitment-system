@php
    use App\Constants\CandidateProfileConstants;
@endphp

<form method="POST" action="{{ route('candidate.profile.update') }}" class="mt-3 space-y-4">
    @csrf
    @method('PATCH')

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.headline') }}
            </label>
            <input type="text" name="headline"
                   value="{{ old('headline', $profile->headline) }}"
                   placeholder="{{ __('candidate.placeholders.headline') }}"
                   class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            @error('headline')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.phone') }}
            </label>
            <input type="text" name="phone"
                   value="{{ old('phone', $profile->phone) }}"
                   class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.date_of_birth') }}
            </label>
            <input type="date" name="date_of_birth"
                   value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}"
                   class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            @error('date_of_birth')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.experience_years') }}
            </label>
            <input type="number" name="experience_years"
                   min="{{ CandidateProfileConstants::EXPERIENCE_YEARS_MIN }}"
                   max="{{ CandidateProfileConstants::EXPERIENCE_YEARS_MAX }}"
                   value="{{ old('experience_years', $profile->experience_years) }}"
                   class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            @error('experience_years')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.address') }}
            </label>
            <input type="text" name="address"
                   value="{{ old('address', $profile->address) }}"
                   class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
            @error('address')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
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
                  class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('education', $profile->education) }}</textarea>
        @error('education')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('candidate.fields.summary') }}
        </label>
        <textarea name="summary" rows="5"
                  class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('summary', $profile->summary) }}</textarea>
        @error('summary')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
        {{ __('candidate.actions.update_info') }}
    </button>
</form>