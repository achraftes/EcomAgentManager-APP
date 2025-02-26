<nav x-data="{ open: false }" class="bg-gradient-to-r from-purple-600 via-pink-500 to-red-500 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <x-application-logo class="block h-9 w-auto text-white" />
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if (Auth::user()->role !== 'agent')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-gray-200 hover:underline">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Additional Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                @if (Auth::user()->role !== 'admin')
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-white hover:text-gray-200 hover:underline">
                    {{ __('Home') }}
                </x-nav-link>
                @endif
                <x-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')" class="text-white hover:text-gray-200 hover:underline">
                    {{ __('Client') }}
                </x-nav-link>
                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="text-white hover:text-gray-200 hover:underline">
                    {{ __('Product') }}
                </x-nav-link>
                @if (Auth::user()->role !== 'agent')
                    <x-nav-link :href="route('mediaBuyers.index')" :active="request()->routeIs('mediaBuyers.index')" class="text-white hover:text-gray-200 hover:underline">
                        {{ __('Media Buyer') }}
                    </x-nav-link>
                @endif
                <x-nav-link :href="route('leads.index')" :active="request()->routeIs('leads.index')" class="text-white hover:text-gray-200 hover:underline">
                    {{ __('Leads') }}
                </x-nav-link>
                @if (Auth::user()->role !== 'agent')
                    <x-nav-link :href="route('agents.index')" :active="request()->routeIs('agents.index')" class="text-white hover:text-gray-200 hover:underline">
                        {{ __('Agents') }}
                    </x-nav-link>
                @endif
                <x-nav-link :href="route('agents.stats', ['agentId' => Auth::user()->id])" :active="request()->routeIs('agents.stats')" class="text-white hover:text-gray-200 hover:underline">
                    {{ __('Agent Stats') }}
                </x-nav-link>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-700 hover:bg-purple-800 focus:outline-none transition ease-in-out duration-150">
                            <div>
                                @if (Auth::check())
                                    {{ Auth::user()->name }}
                                @else
                                    Guest
                                @endif
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" class="bg-gray-800 text-gray-200">
                        @if (Auth::check())
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')">
                                {{ __('Log In') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-purple-800 focus:outline-none focus:bg-purple-800 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-800">
        <div class="pt-2 pb-3 space-y-1 text-white">
            @if (Auth::user()->role !== 'agent')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="hover:bg-purple-700">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::user()->role !== 'admin')
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="hover:bg-purple-700">
                {{ __('Home') }}
            </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')" class="hover:bg-purple-700">
                {{ __('Client') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="hover:bg-purple-700">
                {{ __('Product') }}
            </x-responsive-nav-link>
            @if (Auth::user()->role !== 'agent')
                <x-responsive-nav-link :href="route('mediaBuyers.index')" :active="request()->routeIs('mediaBuyers.index')" class="hover:bg-purple-700">
                    {{ __('Media Buyer') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('leads.index')" :active="request()->routeIs('leads.index')" class="hover:bg-purple-700">
                {{ __('Leads') }}
            </x-responsive-nav-link>
            @if (Auth::user()->role !== 'agent')
                <x-responsive-nav-link :href="route('agents.index')" :active="request()->routeIs('agents.index')" class="hover:bg-purple-700">
                    {{ __('Agents') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('agents.stats', ['agentId' => Auth::user()->id])" :active="request()->routeIs('agents.stats')" class="hover:bg-purple-700">
                {{ __('Agent Stats') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-600">
            <div class="px-4 text-white">
                @if (Auth::check())
                    <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
                @else
                    <div class="font-medium text-base">Guest</div>
                    <div class="font-medium text-sm text-gray-300">guest@example.com</div>
                @endif
            </div>

            <div class="mt-3 space-y-1 text-white">
                @if (Auth::check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @else
                    <x-responsive-nav-link :href="route('login')" class="hover:bg-purple-700">
                        {{ __('Log In') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
    </div>
</nav>
