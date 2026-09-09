<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('profile.page.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Thông tin tài khoản --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Thông tin cá nhân dùng chung cho mọi CV --}}
            @if ($candidate)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('candidate.partials.personal-info-form', ['profile' => $candidate])
                    </div>
                </div>

                {{-- Lối tắt sang các trang quản lý riêng --}}
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('resumes.index') }}"
                           class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                            <div>
                                <p class="font-medium text-gray-900">{{ __('candidate.page.my_cv') }}</p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ __('candidate.units.cv_count', ['count' => $resumeCount]) }}
                                </p>
                            </div>

                            <span class="text-gray-400">&rarr;</span>
                        </a>

                        <a href="{{ route('applications.index') }}"
                           class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                            <div>
                                <p class="font-medium text-gray-900">{{ __('candidate.page.applied') }}</p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ __('candidate.units.application_count', ['count' => $applicationCount]) }}
                                </p>
                            </div>

                            <span class="text-gray-400">&rarr;</span>
                        </a>
                    </div>
                </div>
            @endif

            {{-- Đổi mật khẩu — ẩn với tài khoản đăng nhập qua Google --}}
            @if ($user->hasPassword())
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            @endif

            {{-- Xoá tài khoản --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>