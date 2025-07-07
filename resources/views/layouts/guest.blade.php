<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventory & Asset System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            @keyframes fadeInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            @keyframes fadeInRight {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            @keyframes scaleIn {
                from {
                    opacity: 0;
                    transform: scale(0.9);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }
            .animate-fade-in-up {
                animation: fadeInUp 1s ease-out forwards;
            }
            .animate-fade-in-left {
                animation: fadeInLeft 1s ease-out forwards;
            }
            .animate-fade-in-right {
                animation: fadeInRight 1s ease-out forwards;
            }
            .animate-scale-in {
                animation: scaleIn 0.8s ease-out forwards;
            }
            .delay-200 {
                animation-delay: 200ms;
            }
            .delay-400 {
                animation-delay: 400ms;
            }
            .delay-600 {
                animation-delay: 600ms;
            }
            .bg-overlay {
                position: relative;
            }
            .bg-overlay::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.4);
                animation: fadeIn 1.5s ease-out forwards;
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            .text-shadow {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }
            .hover-scale {
                transition: transform 0.3s ease;
            }
            .hover-scale:hover {
                transform: scale(1.05);
            }
        </style>
    </head>
    <body class="min-h-screen flex flex-col md:flex-row items-center justify-center font-sans bg-cover bg-center bg-no-repeat bg-overlay" style="background-image: url('/image/bg.jpg');">
        <div class="flex flex-col md:flex-row items-center w-full px-4 md:px-0">
            <div class="text-center md:text-left md:ml-32 text-white mb-8 md:mb-0">
                <h1 class="text-4xl md:text-8xl font-bold mb-4 md:mb-6 animate-fade-in-left text-shadow">Welcome to</h1>
                <h2 class="text-3xl md:text-7xl font-semibold animate-fade-in-left delay-200 text-shadow">Inventory & Asset</h2>
                <h2 class="text-3xl md:text-7xl font-semibold animate-fade-in-left delay-200 text-shadow">System</h2>
            </div>
            <div class="w-full max-w-md p-6 bg-white/90 backdrop-blur-sm rounded-xl shadow-xl md:ml-60 animate-fade-in-right delay-400">
                <div class="flex justify-center mb-4">
                    <a href="/" class="hover-scale">
                        <x-application-logo class="w-16 h-16 md:w-20 md:h-20 fill-current text-gray-500 animate-scale-in delay-600" />
                    </a>
                </div>
                <div class="animate-fade-in-up delay-600">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
