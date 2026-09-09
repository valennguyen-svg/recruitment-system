@php
    use App\Constants\CandidateProfileConstants;

    $skillsText = is_array($profile->skills) ? implode(', ', $profile->skills) : ($profile->skills ?? '');
@endphp

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('candidate.page.personal') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('candidate.hints.sent_with_apply') }}
        </p>
    </header>

    <form method="POST" action="{{ route('candidate.profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label for="headline" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.headline') }}
            </label>
            <input type="text" name="headline" id="headline"
                   value="{{ old('headline', $profile->headline) }}"
                   placeholder="{{ __('candidate.placeholders.headline') }}"
                   class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('candidate.fields.date_of_birth') }}
                </label>
                <input type="date" name="date_of_birth" id="date_of_birth"
                       value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}"
                       class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('candidate.fields.phone') }}
                </label>
                <input type="text" name="phone" id="phone"
                       value="{{ old('phone', $profile->phone) }}"
                       class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('candidate.fields.experience_years') }}
                </label>
                <input type="number" name="experience_years" id="experience_years"
                       min="{{ CandidateProfileConstants::EXPERIENCE_YEARS_MIN }}"
                       max="{{ CandidateProfileConstants::EXPERIENCE_YEARS_MAX }}"
                       value="{{ old('experience_years', $profile->experience_years ?? CandidateProfileConstants::EXPERIENCE_YEARS_DEFAULT) }}"
                       class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('candidate.fields.address') }}
                </label>
                <input type="text" name="address" id="address"
                       value="{{ old('address', $profile->address) }}"
                       class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>

        <div>
            <label for="skills" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.skills') }}
                <span class="text-gray-400 font-normal">{{ __('candidate.hints.skills') }}</span>
            </label>
            <textarea name="skills" id="skills" rows="2"
                      placeholder="{{ __('candidate.placeholders.skills') }}"
                      class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('skills', $skillsText) }}</textarea>
        </div>

        <div>
            <label for="education" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.education') }}
            </label>
            <textarea name="education" id="education" rows="3"
                      placeholder="{{ __('candidate.placeholders.education') }}"
                      class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('education', $profile->education) }}</textarea>
        </div>

        <div>
            <label for="summary" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('candidate.fields.summary') }}
            </label>
            <textarea name="summary" id="summary" rows="5"
                      class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('summary', $profile->summary) }}</textarea>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-4 py-2">
                {{ __('candidate.actions.save') }}
            </button>
        </div>
    </form>
</section>