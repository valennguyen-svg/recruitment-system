@php
    use App\Enums\Permission;
    use App\Enums\UserRole;
    use App\Models\User;
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('jobs.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.*')">
                        {{ __('nav.jobs') }}
                    </x-nav-link>

                    @auth
                        @role(UserRole::CANDIDATE->value)
                            <x-nav-link :href="route('resumes.index')" :active="request()->routeIs('resumes.*')">
                                {{ __('nav.my_cv') }}
                            </x-nav-link>

                            <x-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.*')">
                                {{ __('nav.applied') }}
                            </x-nav-link>
                        @endrole

                        @can('manageStaff', User::class)
                            <x-nav-link :href="route('company.staff.index')"
                                        :active="request()->routeIs('company.staff.*')">
                                {{ __('nav.staff') }}
                            </x-nav-link>
                        @endcan

                        @can(Permission::JOBS_APPROVE->value)
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                                {{ __('nav.admin') }}
                            </x-nav-link>
                        @endcan
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="me-4">
                    @include('layouts.partials.locale-switcher')
                </div>

                @auth
                    <div class="me-4">
                        @include('layouts.partials.notification-bell')
                    </div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('nav.profile') }}
                            </x-dropdown-link>

                            @role(UserRole::CANDIDATE->value)
                                <x-dropdown-link :href="route('resumes.index')">
                                    {{ __('nav.my_cv') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('applications.index')">
                                    {{ __('nav.applied') }}
                                </x-dropdown-link>
                            @endrole

                            @can('manageStaff', User::class)
                                <x-dropdown-link :href="route('company.staff.index')">
                                    {{ __('nav.staff') }}
                                </x-dropdown-link>
                            @endcan

                            @can(Permission::JOBS_APPROVE->value)
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    {{ __('nav.admin') }}
                                </x-dropdown-link>
                            @endcan

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('nav.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        {{ __('nav.login') }}
                    </a>

                    <a href="{{ route('register') }}"
                       class="ms-4 text-sm bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                        {{ __('nav.register') }}
                    </a>
                @endguest
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Menu trên màn hình nhỏ --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.*')">
                {{ __('nav.jobs') }}
            </x-responsive-nav-link>

            @auth
                @role(UserRole::CANDIDATE->value)
                    <x-responsive-nav-link :href="route('resumes.index')" :active="request()->routeIs('resumes.*')">
                        {{ __('nav.my_cv') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.*')">
                        {{ __('nav.applied') }}
                    </x-responsive-nav-link>
                @endrole

                @can('manageStaff', User::class)
                    <x-responsive-nav-link :href="route('company.staff.index')"
                                           :active="request()->routeIs('company.staff.*')">
                        {{ __('nav.staff') }}
                    </x-responsive-nav-link>
                @endcan
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                        {{ __('nav.notifications') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                        {{ __('nav.profile') }}
                    </x-responsive-nav-link>

                    @can(Permission::JOBS_APPROVE->value)
                        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                            {{ __('nav.admin') }}
                        </x-responsive-nav-link>
                    @endcan

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('nav.logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <div class="pt-4 pb-3 border-t border-gray-200 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('nav.login') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('register')">
                    {{ __('nav.register') }}
                </x-responsive-nav-link>
            </div>
        @endguest

        <div class="px-4 py-3 border-t border-gray-200">
            @include('layouts.partials.locale-switcher')
        </div>
    </div>
</nav>