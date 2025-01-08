<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="bg-white">
        <!-- Mobile menu -->
        <div class="relative z-40 hidden lg:hidden" role="dialog" aria-modal="true" id="mobileMenu">
            <!--
                Off-canvas menu backdrop, show/hide based on off-canvas menu state.

                Entering: "transition-opacity ease-linear duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                Leaving: "transition-opacity ease-linear duration-300"
                    From: "opacity-100"
                    To: "opacity-0"
            -->
            <div class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>

            <div class="fixed inset-0 z-40 flex">
                <!--
                    Off-canvas menu, show/hide based on off-canvas menu state.

                    Entering: "transition ease-in-out duration-300 transform"
                    From: "-translate-x-full"
                    To: "translate-x-0"
                    Leaving: "transition ease-in-out duration-300 transform"
                    From: "translate-x-0"
                    To: "-translate-x-full"
                -->
                <div class="relative flex w-full max-w-xs flex-col overflow-y-auto bg-white pb-12 shadow-xl">
                    <div class="flex px-4 pb-2 pt-5">
                        <button type="button" class="-m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400" id="mobileMenuCloseBtn">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- I removed the `border-t border-gray-200` -->
                    <div class="space-y-6 px-4 py-6">
                        <div class="flow-root">
                            <a href="/collections/men" class="-m-2 block p-2 font-medium text-gray-900">Men</a>
                        </div>
                        <div class="flow-root">
                            <a href="/collections/women" class="-m-2 block p-2 font-medium text-gray-900">Women</a>
                        </div>
                        <div class="flow-root">
                            <a href="{{ route('collections.index') }}" class="-m-2 block p-2 font-medium text-gray-900">Collections</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <header class="relative z-10">
            <nav aria-label="Top">
                <!-- Top navigation -->
                <div class="bg-gray-900">
                    <div class="mx-auto flex h-10 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                        <!-- Currency selector -->
                        <p class="text-sm font-medium text-white hover:text-gray-100">LKR</p>

                        @guest
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-gray-100">Sign in</a>
                            <a href="{{ route('register') }}" class="text-sm font-medium text-white hover:text-gray-100">Create an account</a>
                        </div>
                        @endguest

                        @auth
                        <p class="text-sm capitalize font-medium text-white hover:text-gray-100">
                            Hello, {{ Auth::user()->name }}
                        </p>
                        @endauth
                    </div>
                </div>

                <!-- Secondary navigation -->
                <div class="relative bg-white">
                    <div class="border-b border-gray-200">
                        <nav aria-label="Top" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                            <div class="flex h-16 items-center justify-between">
                                <div class="flex flex-1 items-center lg:hidden">
                                    <!-- Mobile menu toggle, controls the 'mobileMenuOpen' state. -->
                                    <button type="button" class="-ml-2 rounded-md bg-white p-2 text-gray-400" id="mobileMenuOpenBtn">
                                        <span class="sr-only">Open menu</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                        </svg>
                                    </button>

                                    <a href="{{ route('search') }}" class="ml-2 p-2 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Search</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </a>
                                </div>

                                <!-- Flyout menus -->
                                <!-- TODO - lg:block -->
                                <div class="hidden lg:block lg:flex-1 lg:self-stretch">
                                    <div class="flex h-full space-x-8">
                                        <a href="/collections/men" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Men</a>
                                        <a href="/collections/women" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Women</a>
                                        <a href="{{ route('collections.index') }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Collections</a>
                                    </div>
                                </div>

                                <!-- Logo -->
                                <a href="{{ route('index') }}" class="flex">
                                    <span class="text-lg uppercase font-bold text-gray-700 hover:text-gray-800">Groke</span>
                                </a>

                                <div class="flex flex-1 items-center justify-end">
                                    <!-- I hide this from the application `lg:flex lg:items-center` -->
                                    <a href="#" class="hidden text-gray-700 hover:text-gray-800">
                                        <img src="https://tailwindui.starxg.com/img/flags/flag-canada.svg" alt="" class="block h-auto w-5 flex-shrink-0" />
                                        <span class="ml-3 block text-sm font-medium">CAD</span>
                                        <span class="sr-only">, change currency</span>
                                    </a>

                                    <!-- Search -->
                                    <a href="{{ route('search') }}" class="ml-6 hidden p-2 text-gray-400 hover:text-gray-500 lg:block">
                                        <span class="sr-only">Search</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </a>

                                    <!-- Account -->
                                    @auth
                                    <div class="ml-4 lg:ml-6 relative inline-block text-left hs-dropdown [--placement:bottom-right]">
                                        <div>
                                            <button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900 hs-dropdown-toggle" id="menu-button" aria-expanded="false" aria-haspopup="true">
                                                Account
                                                <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500 hs-dropdown-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="hs-dropdown-menu transition-[opacity,scale] duration hs-dropdown-open:opacity-100 opacity-0 bg-white w-48 hidden z-10 mt-2 shadow-lg rounded-md ring-1 ring-black ring-opacity-5 focus:outline-none" aria-labelledby="hs-dropdown-example">
                                            <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{ route('profile.edit') }}">
                                                {{ __('Profile') }}
                                            </a>
                                            <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{ route('orders') }}">
                                                {{ __('My orders') }}
                                            </a>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                    @endauth

                                    <!-- Cart -->
                                    <div class="ml-4 flow-root lg:ml-6">
                                        <a href="{{ route('cart') }}" class="group -m-2 flex items-center p-2">
                                            <svg class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                            <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">
                                                @auth
                                                {{ Auth::user()->cart()->where('type', 'cart')->first() ? Auth::user()->cart()->where('type', 'cart')->first()->products()->sum('quantity') : 0 }}
                                                @endauth
                                                @guest
                                                0
                                                @endguest
                                            </span>
                                            <span class="sr-only">items in cart, view bag</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900" aria-labelledby="footer-heading">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="mx-auto max-w-7xl px-6 pb-8 pt-20 sm:pt-24 lg:px-8 lg:pt-32">
                <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                    <div class="grid grid-cols-2 gap-8 xl:col-span-2">
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 class="text-sm font-semibold leading-6 text-white">Collections</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="/collections/men" class="text-sm leading-6 text-gray-300 hover:text-white">Men</a>
                                    </li>
                                    <li>
                                        <a href="/collections/women" class="text-sm leading-6 text-gray-300 hover:text-white">Women</a>
                                    </li>
                                    <li>
                                        <a href="/collections" class="text-sm leading-6 text-gray-300 hover:text-white">Collections</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-10 md:mt-0">
                                <h3 class="text-sm font-semibold leading-6 text-white">Legal</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="/" class="text-sm leading-6 text-gray-300 hover:text-white">Claim</a>
                                    </li>
                                    <li>
                                        <a href="/" class="text-sm leading-6 text-gray-300 hover:text-white">Privacy</a>
                                    </li>
                                    <li>
                                        <a href="/" class="text-sm leading-6 text-gray-300 hover:text-white">Terms</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 xl:mt-0 hidden">
                        <h3 class="text-sm font-semibold leading-6 text-white">Subscribe to our newsletter</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-300">The latest news, articles, and resources, sent to your inbox weekly.</p>
                        <form class="mt-6 sm:flex sm:max-w-md">
                            <label for="email-address" class="sr-only">Email address</label>
                            <input type="email" name="email-address" id="email-address" autocomplete="email" required class="w-full min-w-0 appearance-none rounded-md border-0 bg-white/5 px-3 py-1.5 text-base text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:w-64 sm:text-sm sm:leading-6 xl:w-full" placeholder="Enter your email">
                            <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
                                <button type="submit" class="flex w-full items-center justify-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-16 border-t border-white/10 pt-8 sm:mt-20 md:flex md:items-center md:justify-between lg:mt-24">
                    <div class="flex space-x-6 md:order-2">
                        <a href="/" class="text-gray-500 hover:text-gray-400">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="/" class="text-gray-500 hover:text-gray-400">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="/" class="text-gray-500 hover:text-gray-400">
                            <span class="sr-only">X</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M13.6823 10.6218L20.2391 3H18.6854L12.9921 9.61788L8.44486 3H3.2002L10.0765 13.0074L3.2002 21H4.75404L10.7663 14.0113L15.5685 21H20.8131L13.6819 10.6218H13.6823ZM11.5541 13.0956L10.8574 12.0991L5.31391 4.16971H7.70053L12.1742 10.5689L12.8709 11.5655L18.6861 19.8835H16.2995L11.5541 13.096V13.0956Z" />
                            </svg>
                        </a>
                        <a href="/" class="text-gray-500 hover:text-gray-400">
                            <span class="sr-only">YouTube</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <p class="mt-8 text-xs leading-5 text-gray-400 md:order-1 md:mt-0">&copy; 2024 Groke. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        const hambgureMenu = document.getElementById('mobileMenuOpenBtn');
        const closeBtn  = document.getElementById('mobileMenuCloseBtn');

        hambgureMenu.addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.remove('hidden');
        });

        closeBtn.addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.add('hidden');
        });
    </script>
    @stack('scripts')
</body>

</html>