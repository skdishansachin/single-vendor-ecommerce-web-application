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

<body class="font-sans antialiased bg-gray-50">
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    {{ $header }}
                </div>
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hamburger menu functionality
            const hamburgerButton = document.getElementById('hamburger-button');
            const responsiveMenu = document.getElementById('responsive-menu');
            const hamburgerIcon = hamburgerButton.querySelector('svg');

            hamburgerButton.addEventListener('click', function() {
                responsiveMenu.classList.toggle('hidden');
                hamburgerIcon.querySelectorAll('path').forEach(path => {
                    path.classList.toggle('hidden');
                    path.classList.toggle('inline-flex');
                });
            });

            // Dropdown functionality
            const dropdownToggle = document.getElementById('hs-dropdown-example');
            const dropdownMenu = document.querySelector('.hs-dropdown-menu');

            dropdownToggle.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
                dropdownToggle.querySelector('svg').classList.toggle('rotate-180');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                    dropdownToggle.querySelector('svg').classList.remove('rotate-180');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>