<x-app-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4">

            <a href="{{ route('jobs.index') }}" class="text-sm text-blue-600 hover:underline">
                ← Quay lại danh sách
            </a>

            @if (session('success'))
                <div class="mt-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mt-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">

                {{-- Nội dung tin --}}
                <div class="lg:col-span-2 space-y-4">

                    <div class="bg-white border rounded-xl p-6">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $jobPost->title }}</h1>
                        <p class="text-gray-600 mt-1">{{ $jobPost->company->name }}</p>

                        <div class="flex flex-wrap gap-x-6 gap-y-2 mt-4 text-sm text-gray-600">
                            <span>📍 {{ $jobPost->location }}</span>
                            <span>💼 {{ $jobPost->category->name }}</span>
                            <span>📄 {{ $jobPost->employment_type->label()}}</span>
                            <span>👁 {{ __('job.fields.views', ['count' => number_format($jobPost->views_count)]) }}</span>
                        </div>

                        <div class="mt-4 pt-4 border-t flex flex-wrap gap-6">
                            <div>
                                 <p class="text-xs text-gray-500">{{ __('job.fields.salary') }}</p>
                                 <p class="font-semibold text-green-700">
                                      @if ($jobPost->salary_negotiable || ! $jobPost->salary_min)
                                             {{ __('job.fields.negotiable') }}
                                      @else
                                             {{ number_format($jobPost->salary_min) }} – {{ number_format($jobPost->salary_max) }}
                                             {{ __('job.fields.currency') }}
                                      @endif
                                </p>
                            </div>

                           @if ($jobPost->deadline)
                            <div>
                               <p class="text-xs text-gray-500">{{ __('job.fields.deadline') }}</p>
                               <p class="font-semibold {{ $jobPost->deadline->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                  {{ $jobPost->deadline->format('d/m/Y') }}
                                </p>
                            </div>
                           @endif
                            @if ($jobPost->deadline)
    @php
        $deadline = $jobPost->deadline instanceof \Carbon\Carbon
            ? $jobPost->deadline
            : \Carbon\Carbon::parse($jobPost->deadline);
    @endphp

    <div>
        <p class="text-xs text-gray-500">Hạn nộp</p>
        <p class="font-semibold {{ $deadline->isPast() ? 'text-red-600' : 'text-gray-900' }}">
            {{ $deadline->format('d/m/Y') }}
        </p>
    </div>
@endif

                           
                        </div>
                    </div>

                    <div class="bg-white border rounded-xl p-6">
                        <h2 class="font-semibold text-lg mb-3">Mô tả công việc</h2>
                        <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line">{{ $jobPost->description }}</div>
                    </div>

                    @if ($jobPost->requirements)
                        <div class="bg-white border rounded-xl p-6">
                            <h2 class="font-semibold text-lg mb-3">Yêu cầu ứng viên</h2>

                            @if (is_array($jobPost->requirements))
                                <ul class="list-disc list-inside space-y-1 text-sm text-gray-700">
                                    @foreach ($jobPost->requirements as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line">{{ $jobPost->requirements }}</div>
                            @endif
                        </div>
                    @endif

                    @if ($jobPost->benefits)
                        <div class="bg-white border rounded-xl p-6">
                            <h2 class="font-semibold text-lg mb-3">Quyền lợi</h2>

                            @if (is_array($jobPost->benefits))
                                <ul class="list-disc list-inside space-y-1 text-sm text-gray-700">
                                    @foreach ($jobPost->benefits as $benefit)
                                        <li>{{ $benefit }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line">{{ $jobPost->benefits }}</div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Cột phải: form ứng tuyển --}}
                <div class="lg:col-span-1">
                    <div class="bg-white border rounded-xl p-5 sticky top-6">
                        @include('jobs.partials.apply-form', ['jobPost' => $jobPost])
                    </div>
                </div>
            </div>

            {{-- Việc làm liên quan --}}
            @if ($related->isNotEmpty())
                <div class="mt-8">
                    <h2 class="font-semibold text-lg mb-3">Việc làm tương tự</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($related as $r)
                            <a href="{{ route('jobs.show', $r) }}"
                               class="block bg-white border rounded-lg p-4 hover:border-blue-400 transition">
                                <p class="font-medium text-gray-900">{{ $r->title }}</p>
                                <p class="text-sm text-gray-500 mt-1">📍 {{ $r->location }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>