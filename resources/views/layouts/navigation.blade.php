<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-gray-200 bg-white/95 backdrop-blur">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-16 items-center justify-between gap-4 py-2">

            <div class="flex min-w-0 items-center gap-6">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex items-center gap-3">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        <span class="hidden text-base font-semibold tracking-tight text-gray-900 sm:inline">TaskFlow</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden items-center gap-1 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">
                        Projectes
                    </x-nav-link>

                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                        Tasques
                    </x-nav-link>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('tags.index')" :active="request()->routeIs('tags.*')">
                                Etiquetes
                            </x-nav-link>
                        @endif
                    @endauth

                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium leading-4 text-gray-600 shadow-sm hover:border-gray-300 hover:text-gray-800 focus:outline-none transition ease-in-out duration-150">
                            <div class="max-w-32 truncate">{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>

                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-700 transition duration-150 ease-in-out">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        <div class="space-y-2 border-t border-gray-100 px-4 py-4">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">
                Projectes
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                Tasques
            </x-responsive-nav-link>

            @auth
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('tags.index')" :active="request()->routeIs('tags.*')">
                        Etiquetes
                    </x-responsive-nav-link>
                @endif
            @endauth

        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="border-t border-gray-200 px-4 py-4">

            <div>
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-2">

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

            </div>
        </div>
        @endauth

    </div>
</nav>
