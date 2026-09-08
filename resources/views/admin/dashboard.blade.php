@php
    use App\Constants\DashboardConstants;

    $cards = [
        ['label' => __('dashboard.cards.total_jobs'),       'value' => $overview['total_jobs'],       'color' => 'bg-blue-50 text-blue-700'],
        ['label' => __('dashboard.cards.published_jobs'),   'value' => $overview['published_jobs'],   'color' => 'bg-green-50 text-green-700'],
        ['label' => __('dashboard.cards.pending_jobs'),     'value' => $overview['pending_jobs'],     'color' => 'bg-amber-50 text-amber-700'],
        ['label' => __('dashboard.cards.total_apps'),       'value' => $overview['total_apps'],       'color' => 'bg-purple-50 text-purple-700'],
        ['label' => __('dashboard.cards.total_companies'),  'value' => $overview['total_companies'],  'color' => 'bg-slate-50 text-slate-700'],
        ['label' => __('dashboard.cards.total_candidates'), 'value' => $overview['total_candidates'], 'color' => 'bg-rose-50 text-rose-700'],
    ];

    $maxJobStatus = max(1, collect($jobsByStatus)->max('count') ?? 0);
    $maxMonth     = max(array_values($perMonth) ?: [1]);
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard.page.title') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 space-y-6">

        {{-- Thẻ số liệu tổng quan --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($cards as $card)
                <div class="rounded-lg p-4 {{ $card['color'] }}">
                    <p class="text-2xl font-bold">{{ number_format($card['value']) }}</p>
                    <p class="text-xs mt-1">{{ $card['label'] }}</p>
                </div>
            @endforeach
        </div>

        @if ($overview['pending_jobs'] > 0)
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex justify-between items-center">
                <p class="text-sm text-amber-800">
                    {{ __('dashboard.messages.pending_notice', ['count' => $overview['pending_jobs']]) }}
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Tin theo trạng thái --}}
            <div class="bg-white border rounded-lg p-5">
                <h3 class="font-semibold mb-4">{{ __('dashboard.sections.jobs_by_status') }}</h3>

                <div class="space-y-2">
                    @foreach ($jobsByStatus as $row)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>{{ $row['label'] }}</span>
                                <span class="font-medium">{{ $row['count'] }}</span>
                            </div>
                            <div class="h-2 bg-gray-100 rounded">
                                <div class="h-2 bg-blue-500 rounded"
                                     style="width: {{ round($row['count'] / $maxJobStatus * DashboardConstants::PERCENT_BASE) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tin đăng theo tháng --}}
            <div class="bg-white border rounded-lg p-5">
                <h3 class="font-semibold mb-4">
                    {{ __('dashboard.sections.jobs_per_month', ['months' => DashboardConstants::CHART_MONTHS]) }}
                </h3>

                @if (empty($perMonth))
                    <p class="text-sm text-gray-500">{{ __('dashboard.messages.no_data') }}</p>
                @else
                    <div class="flex items-end gap-3 h-40">
                        @foreach ($perMonth as $label => $count)
                            <div class="flex-1 flex flex-col items-center justify-end h-full">
                                <span class="text-xs mb-1">{{ $count }}</span>
                                <div class="w-full bg-blue-500 rounded-t"
                                     style="height: {{ max(DashboardConstants::CHART_BAR_MIN_HEIGHT, round($count / $maxMonth * DashboardConstants::CHART_BAR_MAX_HEIGHT)) }}px"></div>
                                <span class="text-xs text-gray-500 mt-1">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Top công ty --}}
            <div class="bg-white border rounded-lg p-5">
                <h3 class="font-semibold mb-4">{{ __('dashboard.sections.top_companies') }}</h3>

                <ol class="space-y-2 text-sm">
                    @forelse ($topCompanies as $index => $company)
                        <li class="flex justify-between">
                            <span>{{ $index + 1 }}. {{ $company->name }}</span>
                            <span class="text-gray-500">
                                {{ __('dashboard.units.jobs', ['count' => $company->job_posts_count]) }}
                            </span>
                        </li>
                    @empty
                        <li class="text-gray-500">{{ __('dashboard.messages.no_data') }}</li>
                    @endforelse
                </ol>
            </div>

            {{-- Hiệu quả tuyển dụng --}}
            <div class="bg-white border rounded-lg p-5">
                <h3 class="font-semibold mb-4">{{ __('dashboard.sections.hire_rate') }}</h3>

                <p class="text-4xl font-bold text-green-600">{{ $hireRate }}%</p>
                <p class="text-sm text-gray-500 mt-1">{{ __('dashboard.hints.hire_rate') }}</p>

                <div class="mt-4 space-y-1 text-sm">
                    @foreach ($appsByStatus as $row)
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ $row['label'] }}</span>
                            <span>{{ $row['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tin nhiều đơn nhất --}}
            <div class="bg-white border rounded-lg p-5 lg:col-span-2">
                <h3 class="font-semibold mb-4">{{ __('dashboard.sections.top_jobs') }}</h3>

                <ol class="space-y-2 text-sm">
                    @forelse ($topJobs as $index => $job)
                        <li class="flex justify-between">
                            <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:underline">
                                {{ $index + 1 }}. {{ $job->title }}
                            </a>
                            <span class="text-gray-500">
                                {{ __('dashboard.units.applications', ['count' => $job->applications_count]) }}
                            </span>
                        </li>
                    @empty
                        <li class="text-gray-500">{{ __('dashboard.messages.no_data') }}</li>
                    @endforelse
                </ol>
            </div>
        </div>
    </div>
</x-app-layout>
