<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">{{ __('profile.page.info') }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ __('profile.hints.info') }}</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('auth.fields.name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('auth.fields.email')" />
            <x-text-input id="email" type="email" class="mt-1 block w-full bg-gray-100 text-gray-600"
                          :value="$user->email" disabled />
            <p class="mt-1 text-sm text-gray-500">{{ __('profile.hints.email_locked') }}</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.actions.save') }}</x-primary-button>

            @if (session('status') === \App\Constants\UserConstants::STATUS_PROFILE_UPDATED)
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-600">{{ __('profile.messages.saved') }}</p>
            @endif
        </div>
    </form>
</section>