@php
    use App\Constants\UserConstants;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
@endphp

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('profile.page.info') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('profile.hints.info') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

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
            <x-input-label for="phone" :value="__('auth.fields.phone')" />

            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full"
                          :value="old('phone', $user->phone)" autocomplete="tel" />

            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- Email khoá: là định danh đăng nhập, đổi tự do sẽ mở đường chiếm tài khoản --}}
        <div>
            <x-input-label for="email" :value="__('auth.fields.email')" />

            <x-text-input id="email" type="email"
                          class="mt-1 block w-full bg-gray-100 cursor-not-allowed"
                          :value="$user->email" disabled />

            <p class="mt-1 text-xs text-gray-500">
                {{ __('profile.hints.email_locked') }}
            </p>

            @if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        {{ __('profile.hints.unverified') }}

                        <button type="submit" form="send-verification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('profile.hints.resend') }}
                        </button>
                    </p>

                    @if (session('status') === UserConstants::STATUS_LINK_SENT)
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('profile.hints.link_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.actions.save') }}</x-primary-button>

            @if (session('status') === UserConstants::STATUS_PROFILE_UPDATED)
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-600">
                    {{ __('profile.messages.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>