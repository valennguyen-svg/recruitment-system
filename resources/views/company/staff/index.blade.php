<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('staff.page.index') }}
            </h2>

            <a href="{{ route('company.staff.create', ['company' => $companyId]) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-4 py-2">
                {{ __('staff.actions.create') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($staff->isNotEmpty())
                <div class="bg-white shadow sm:rounded-lg divide-y">
                    @foreach ($staff as $member)
                        <div class="p-5 flex items-center justify-between gap-6">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-medium text-gray-900">{{ $member->name }}</h3>

                                    @unless ($member->is_active)
                                        <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded">
                                            {{ __('staff.badges.locked') }}
                                        </span>
                                    @endunless
                                </div>

                                <p class="text-sm text-gray-600 mt-1">{{ $member->email }}</p>

                                <p class="text-xs text-gray-500 mt-2">
                                    {{ __('staff.stats.job_count', ['count' => $member->job_posts_count]) }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3 text-sm shrink-0">
                                @can('update', $member)
                                    <a href="{{ route('company.staff.edit', $member) }}"
                                       class="text-blue-600 hover:underline">
                                        {{ __('staff.actions.edit') }}
                                    </a>
                                @endcan

                                @if ($member->is_active)
                                    @can('update', $member)
                                        <form method="POST" action="{{ route('company.staff.destroy', $member) }}"
                                              onsubmit="return confirm('{{ __('staff.messages.confirm_deactivate') }}')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="text-red-600 hover:underline">
                                                {{ __('staff.actions.deactivate') }}
                                            </button>
                                        </form>
                                    @endcan
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $staff->links() }}
            @else
                <div class="bg-white shadow sm:rounded-lg p-12 text-center">
                    <p class="text-gray-500">{{ __('staff.messages.empty') }}</p>

                    <a href="{{ route('company.staff.create', ['company' => $companyId]) }}"
                       class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg px-5 py-2.5">
                        {{ __('staff.actions.create') }}
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>