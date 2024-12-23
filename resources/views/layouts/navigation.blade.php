<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center grow">
                    <a href="{{ route('home_page') }}">
                        <x-application-logo class="w-32 h-auto block fill-current text-gray-600" />
                    </a>
                </div>
            </div>
            <!-- Search -->
            <div class="hidden sm:flex sm:items-center">
                <livewire:search />
            </div>


            <!-- Settings Dropdown -->
            <div class="sm:flex sm:items-center">
                @guest
                <div class="hidden md:flex md:items-center md:space-x-2">
                    <div class="space-x-3 text-[1.6rem] ltr:mr-5 rtl:ml-5">
                        <a href="/login"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest ltr:mr-2 rtl:ml-2">{{ __('Login') }}</a>
                        <a href="/register"
                            class="inline-flex items-center px-4 py-2 font-semibold text-xs uppercase tracking-widest">{{ __('Register') }}</a>
                    </div>
                </div>
                @endguest
                @auth
                <div class="hidden md:flex md:flex-row space-x-3 items-center justify-center">
                    {{-- Home --}}
                    <a class="text-[1.6rem] rtl:ml-3" href="{{ route('home_page') }}">
                        {!! url()->current() == route('home_page')
                        ? '<i class="bx bxs-home-alt-2"></i>'
                        : '<i class="bx bx-home-alt-2"></i>' !!}
                    </a>

                    {{-- Explore --}}
                    <a class="text-[1.6rem]" href="{{ route('explore') }}">
                        {!! url()->current() == route('explore') ? '<i class="bx bxs-compass"></i>' : '<i class="bx bx-compass"></i>' !!}
                    </a>

                    {{-- Create Post --}}
                    <button onclick="Livewire.emit('openModal', 'create-post-modal')">
                        <i class="bx bx-message-square-add text-[1.6rem]"></i>
                    </button>
                    <div class="hidden md:block">
                        <x-dropdown align="right" width="96">
                            <x-slot name="trigger">
                                <button class="text-[1.6rem] ltr:mr-2 rtl:ml-2 leading-5">
                                    <div class="relative">
                                        <i class="bx bxs-inbox"></i>
                                        <livewire:pending-followers-count />
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <livewire:pending-followers-list />
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <div class="hidden md:block">
                        <x-dropdown align="{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>
                                        <img class="w-6 h-6 -mt-1 object-cover rounded-full border border-gray-500"
                                            src="{{ auth()->user()->image }}">
                                    </div>

                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('user_profile', auth()->user())">{{ __('Profile') }}</x-dropdown-link>
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

            </div>
            @endauth
            <!-- Hamburger -->
            <div class="-mr-2 flex md:hidden items-center">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden">

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @guest
            <x-responsive-nav-link :href="route('login')">{{ __('Login') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">{{ __('Register') }}</x-responsive-nav-link>
            @endguest
            @auth
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('home_page')">{{ __('Home') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('explore')">{{ __('Explore') }}

                </x-responsive-nav-link>
                <x-responsive-nav-link class="cursor-pointer"
                    onclick="Livewire.emit('openModal', 'create-post-modal')">{{ __('New Post') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user_profile', auth()->user())">{{ __('Profile') }}</x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @endauth
        </div>
    </div>

</nav>