<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('job.page.create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach (array_unique($errors->all()) as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('company.jobs.store') }}"
                  class="p-6 sm:p-8 bg-white shadow sm:rounded-lg space-y-6">
                @csrf

                @include('company.jobs.partials.form', ['job' => null])

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('job.actions.save_draft') }}</x-primary-button>

                    <a href="{{ route('company.jobs.index') }}" class="text-sm text-gray-600 hover:underline">
                        {{ __('job.actions.cancel') }}
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>