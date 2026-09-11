<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('job.page.company_index') }}
            </h2>

            @can('create', App\Models\JobPost::class)
                <a href="{{ route('company.jobs.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-4 py-2">
                    {{ __('job.actions.create') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg divide-y">
                @forelse ($jobs as $job)
                    <div class="p-5 flex items-start justify-between gap-6">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="font-medium text-gray-900">{{ $job->title }}</h3>

                                <span class="text-xs px-2 py-0.5 rounded bg-gray-100 text-gray-700">
                                    {{ __('job.status.' . $job->status->value) }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 mt-1">
                                {{ $job->category?->name }} · {{ $job->location }}
                            </p>

                            <p class="text-xs text-gray-500 mt-2">
                                {{ __('job.stats.by', ['name' => $job->creator?->name]) }} ·
                                {{ __('job.stats.applications', ['count' => $job->applications_count]) }}
                            </p>

                            @if ($job->rejection_reason)
                                <p class="text-sm text-red-600 mt-2">{{ $job->rejection_reason }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-3 text-sm shrink-0">
                            @can('update', $job)
                                <a href="{{ route('company.jobs.edit', $job) }}" class="text-blue-600 hover:underline">
                                    {{ __('job.actions.edit') }}
                                </a>
                            @endcan

                            @can('submit', $job)
                                <form method="POST" action="{{ route('recruiter.jobs.submit', $job) }}">
                                    @csrf
                                    <button type="submit" class="text-indigo-600 hover:underline">
                                        {{ __('job.actions.submit') }}
                                    </button>
                                </form>
                            @endcan

                            @can('delete', $job)
                                <form method="POST" action="{{ route('company.jobs.destroy', $job) }}"
                                      onsubmit="return confirm('{{ __('job.messages.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        {{ __('job.actions.delete') }}
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500">
                        {{ __('job.messages.empty') }}
                    </div>
                @endforelse
            </div>

            <div class="mt-6">{{ $jobs->links() }}</div>
        </div>
    </div>
</x-app-layout>