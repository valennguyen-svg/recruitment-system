<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('commission.page.recruiter_index') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($statuses as $status)
                    <div class="bg-white shadow sm:rounded-lg p-4">
                        <span class="text-xs px-2 py-0.5 rounded {{ $status->badgeClass() }}">
                            {{ $status->label() }}
                        </span>

                        <p class="mt-2 text-lg font-semibold text-gray-900">
                            {{ number_format($totals[$status->value] ?? 0, 0, ',', '.') }} ₫
                        </p>
                    </div>
                @endforeach
            </div>

            <form method="GET" class="bg-white shadow sm:rounded-lg p-4 flex flex-wrap gap-3 items-end">
                <div>
                    <x-input-label for="status" :value="__('commission.filters.status')" />
                    <select id="status" name="status" class="mt-1 border-gray-300 rounded-md text-sm">
                        <option value="">{{ __('commission.filters.all_statuses') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="from" :value="__('commission.filters.from')" />
                    <x-text-input id="from" name="from" type="date" class="mt-1" :value="request('from')" />
                </div>

                <div>
                    <x-input-label for="to" :value="__('commission.filters.to')" />
                    <x-text-input id="to" name="to" type="date" class="mt-1" :value="request('to')" />
                </div>

                <x-primary-button>{{ __('commission.actions.filter') }}</x-primary-button>
            </form>

            <div class="bg-white shadow sm:rounded-lg divide-y">
                @forelse ($commissions as $commission)
                    <div class="p-5 flex items-center justify-between gap-6">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="font-medium text-gray-900">{{ $commission->jobPost->title }}</h3>

                                <span class="text-xs px-2 py-0.5 rounded {{ $commission->status->badgeClass() }}">
                                    {{ $commission->status->label() }}
                                </span>
                            </div>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ $commission->created_at->format('d/m/Y H:i') }}
                            </p>

                            @if ($commission->note)
                                <p class="text-sm text-gray-600 mt-2">{{ $commission->note }}</p>
                            @endif
                        </div>

                        <span class="font-semibold text-gray-900 shrink-0">
                            {{ number_format($commission->amount, 0, ',', '.') }} ₫
                        </span>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500">
                        {{ __('commission.messages.empty') }}
                    </div>
                @endforelse
            </div>

            {{ $commissions->withQueryString()->links() }}

        </div>
    </div>
</x-app-layout>