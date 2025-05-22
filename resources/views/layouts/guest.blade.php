<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventory') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex flex-col md:flex-row items-center justify-center font-sans bg-cover bg-center bg-no-repeat" style="background-image: url('/image/bg.jpg');">
        <div class="flex flex-col md:flex-row items-center w-full px-4 md:px-0">
            <div class="text-center md:text-left md:ml-32 text-white mb-8 md:mb-0">
                <h1 class="text-4xl md:text-8xl font-bold mb-4 md:mb-6">Welcome to</h1>
                <h2 class="text-3xl md:text-7xl font-semibold">Inventory Systems</h2>
            </div>
            <div class="w-full max-w-md p-6 bg-white rounded-xl shadow-xl md:ml-60">
                <div class="flex justify-center mb-4">
                    <a href="/">
                        <x-application-logo class="w-16 h-16 md:w-20 md:h-20 fill-current text-gray-500" />
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>

</html>
