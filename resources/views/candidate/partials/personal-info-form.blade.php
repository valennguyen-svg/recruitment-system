<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('candidate.page.personal') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('candidate.hints.personal_desc') }}
        </p>
    </header>

    <form method="POST" action="{{ route('candidate.profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('candidate.fields.date_of_birth') }}
                </label>
                <input type="date" name="date_of_birth"
                       value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}"
                       class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('date_of_birth')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('candidate.fields.address') }}
                </label>
                <input type="text" name="address"
                       value="{{ old('address', $profile->address) }}"
                       class="w-full border-gray-300 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('address')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-4 py-2">
            {{ __('candidate.actions.update_info') }}
        </button>
    </form>
</section>