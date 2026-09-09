<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('candidate.page.edit_cv') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 sm:p-8">
                <form method="POST" action="{{ route('resumes.update', $resume) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    @include('resumes.partials.form', ['resume' => $resume])

                    <div class="mt-6 flex items-center gap-3">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-6 py-2.5">
                            {{ __('candidate.actions.save_changes') }}
                        </button>

                        <a href="{{ route('resumes.index') }}" class="text-sm text-gray-600 hover:underline">
                            {{ __('candidate.actions.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>