<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-white/20 sticky top-0 z-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 cursor-pointer">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg>
                        <span class="text-2xl font-extrabold tracking-tight text-slate-900">Rent<span class="text-blue-600">Car</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-sm font-semibold">
                            {{ __('Dasbor') }}
                        </x-nav-link>
                    @endauth
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-sm font-semibold">
                        {{ __('Beranda') }}
                    </x-nav-link>
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.vehicles.index')" :active="request()->routeIs('admin.vehicles.*')" class="text-sm font-semibold text-blue-600">
                            {{ __('Kelola Mobil') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="text-sm font-semibold text-blue-600">
                            {{ __('Kelola Pengguna') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-slate-200 shadow-sm text-sm leading-4 font-semibold rounded-full text-slate-600 bg-white hover:text-slate-800 hover:bg-slate-50 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="font-medium text-sm">
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="font-medium text-sm text-red-600 hover:text-red-700">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-blue-600 transition-colors mr-4">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-semibold bg-gray-900 text-white px-5 py-2.5 rounded-full hover:bg-gray-800 transition-all shadow-md hover:shadow-lg">Daftar</a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-semibold text-base">
                    {{ __('Dasbor') }}
                </x-responsive-nav-link>
            @endauth
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="font-semibold text-base">
                {{ __('Beranda') }}
            </x-responsive-nav-link>
            @if(Auth::check() && Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.vehicles.index')" :active="request()->routeIs('admin.vehicles.*')" class="font-semibold text-base text-blue-600">
                    {{ __('Kelola Mobil') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="font-semibold text-base text-blue-600">
                    {{ __('Kelola Pengguna') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            @auth
                <div class="px-4">
                    <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="font-semibold text-base">
                        {{ __('Profil') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class="font-semibold text-base text-red-600">
                            {{ __('Keluar') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')" class="font-semibold text-base">
                        {{ __('Masuk') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')" class="font-semibold text-base">
                            {{ __('Daftar') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
