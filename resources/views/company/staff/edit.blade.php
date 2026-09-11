<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('staff.page.edit') }}
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

            <form method="POST" action="{{ route('company.staff.update', $staff) }}"
                  class="p-6 sm:p-8 bg-white shadow sm:rounded-lg space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="name" :value="__('auth.fields.name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                  :value="old('name', $staff->name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('auth.fields.email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                  :value="old('email', $staff->email)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    {{-- Truong an gui 0 khi checkbox khong duoc tich: luat 'required|boolean'
                         se truot neu khong co no, vi checkbox bo trong thi khong gui gi ca. --}}
                    <input type="hidden" name="is_active" value="0">

                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1"
                               class="rounded border-gray-300 text-indigo-600"
                               @checked(old('is_active', $staff->is_active))>

                        <span class="text-sm text-gray-700">{{ __('staff.fields.is_active') }}</span>
                    </label>

                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <x-primary-button>{{ __('staff.actions.save') }}</x-primary-button>

                    <a href="{{ route('company.staff.index') }}" class="text-sm text-gray-600 hover:underline">
                        {{ __('staff.actions.cancel') }}
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>