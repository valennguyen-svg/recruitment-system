<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('staff.page.create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach (array_unique($errors->all()) as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('company.staff.store') }}"
                  class="p-6 sm:p-8 bg-white shadow sm:rounded-lg space-y-4">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('auth.fields.name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                  :value="old('name')" required autofocus />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="email" :value="__('auth.fields.email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                  :value="old('email')" required />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="password" :value="__('auth.fields.password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">{{ __('staff.hints.password') }}</p>
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('auth.fields.confirm_password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation"
                                  type="password" class="mt-1 block w-full" required />
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <x-primary-button>{{ __('staff.actions.create') }}</x-primary-button>

                    <a href="{{ route('company.staff.index') }}" class="text-sm text-gray-600 hover:underline">
                        {{ __('staff.actions.cancel') }}
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>