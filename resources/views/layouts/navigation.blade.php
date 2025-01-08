<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <span class="text-lg uppercase font-bold text-gray-700 hover:text-gray-800">Groke</span>
                    </a>
                </div>

                <!-- Navigation links -->
                @can('view orders')
                <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                    <x-nav-link :href="route('dashboard.orders.index')" :active="request()->routeIs('dashboard.orders.*')">
                        {{ __('Orders') }}
                    </x-nav-link>
                </div>
                @endcan

                @can('view products')
                <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                    <x-nav-link :href="route('dashboard.products.index')" :active="request()->routeIs('dashboard.products.*')">
                        {{ __('Products') }}
                    </x-nav-link>
                </div>
                @endcan

                @can('view collections')
                <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                    <x-nav-link :href="route('dashboard.collections.index')" :active="request()->routeIs('dashboard.collections.*')">
                        {{ __('Collections') }}
                    </x-nav-link>
                </div>
                @endcan

                @can('view shippings')
                <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                    <x-nav-link :href="route('dashboard.shippings.index')" :active="request()->routeIs('dashboard.shippings.*')">
                        {{ __('Shippings') }}
                    </x-nav-link>
                </div>
                @endcan

                @can('view users')
                <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                    <x-nav-link :href="route('dashboard.users.index')" :active="request()->routeIs('dashboard.users.*')">
                        {{ __('Users') }}
                    </x-nav-link>
                </div>
                @endcan

                @can('view invitations')
                <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                    <x-nav-link :href="route('dashboard.invitations.index')" :active="request()->routeIs('dashboard.invitations.*')">
                        {{ __('Invitations') }}
                    </x-nav-link>
                </div>
                @endcan
            </div>

            <div class="flex items-center gap-4">
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="sm:ms-4 hs-dropdown hs-dropdown-example [--placement:bottom-right] relative inline-flex">
                        <button id="hs-dropdown-example" type="button" class="hs-dropdown-toggle inline-flex items-center gap-x-2 px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700  disabled:opacity-50 disabled:pointer-events-none">
                            {{ Auth::user()->name }}
                            <svg class="hs-dropdown-open:rotate-180 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                        </button>

                        <div class="hs-dropdown-menu transition-[opacity,scale] duration hs-dropdown-open:opacity-100 opacity-0 bg-white w-48 hidden z-10 mt-2 shadow-lg rounded-md" aria-labelledby="hs-dropdown-example">
                            <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{ route('dashboard.profile.edit') }}">
                                {{ __('Profile') }}
                            </a>
                            <form method="post" action="{{ route('dashboard.logout') }}">
                                @csrf

                                <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center md:hidden">
                    <button id="hamburger-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="responsive-menu" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @can('view orders')
            <x-responsive-nav-link :href="route('dashboard.orders.index')" :active="request()->routeIs('dashboard.orders.*')">
                {{ __('Orders') }}
            </x-responsive-nav-link>
            @endcan

            @can('view products')
            <x-responsive-nav-link :href="route('dashboard.products.index')" :active="request()->routeIs('dashboard.products.*')">
                {{ __('Products') }}
            </x-responsive-nav-link>
            @endcan

            @can('view collections')
            <x-responsive-nav-link :href="route('dashboard.collections.index')" :active="request()->routeIs('dashboard.collections.*')">
                {{ __('Collections') }}
            </x-responsive-nav-link>
            @endcan

            @can('view shippings')
            <x-responsive-nav-link :href="route('dashboard.shippings.index')" :active="request()->routeIs('dashboard.shippings.*')">
                {{ __('Shippings') }}
            </x-responsive-nav-link>
            @endcan

            @can('view users')
            <x-responsive-nav-link :href="route('dashboard.users.index')" :active="request()->routeIs('dashboard.users.*')">
                {{ __('Users') }}
            </x-responsive-nav-link>
            @endcan

            @can('view invitations')
            <x-responsive-nav-link :href="route('dashboard.invitations.index')" :active="request()->routeIs('dashboard.invitations.*')">
                {{ __('Invitations') }}
            </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>

                </form>
            </div>
        </div>
    </div>
</nav>