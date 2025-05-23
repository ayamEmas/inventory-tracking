<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventory System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html, body {
                overflow-x: hidden;
                height: 100%;
            }
            @keyframes glow {
                0% {
                    text-shadow: 0 0 10px #fff,
                                0 0 20px #fff,
                                0 0 30px #fff;
                }
                50% {
                    text-shadow: 0 0 20px #fff,
                                0 0 30px #fff,
                                0 0 40px #fff,
                                0 0 50px #fff,
                                0 0 60px #fff;
                }
                100% {
                    text-shadow: 0 0 10px #fff,
                                0 0 20px #fff,
                                0 0 30px #fff;
                }
            }
            .title-shine {
                animation: glow 2s ease-in-out infinite;
                position: relative;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
            .title-shine::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(45deg, 
                    rgba(255,255,255,0) 0%,
                    rgba(255,255,255,0.1) 50%,
                    rgba(255,255,255,0) 100%);
                animation: shimmer 2s infinite;
                pointer-events: none;
            }
            @keyframes shimmer {
                0% {
                    transform: translateX(-100%);
                }
                100% {
                    transform: translateX(100%);
                }
            }
            .bg-blur {
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
            }
            .fade-in {
                opacity: 0;
                animation: fadeIn 1s ease-in forwards;
                will-change: opacity, transform;
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .nav-blur {
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                background-color: rgba(0, 0, 0, 0.2);
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 50;
            }
            .delay-200 {
                animation-delay: 200ms;
            }
            .delay-400 {
                animation-delay: 400ms;
            }
            .title-container {
                position: relative;
            }
            .title-shine {
                transition: transform 0.3s ease;
            }
            .title-shine:hover {
                transform: scale(1.05);
            }
            .main-content {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding-top: 4rem;
            }
            .feature-card {
                transition: all 0.3s ease;
                cursor: pointer;
                position: relative;
                overflow: hidden;
            }
            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(circle at center, rgba(255,255,255,0.1) 0%, transparent 70%);
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-10px) scale(1.02);
                box-shadow: 0 0 20px rgba(255,255,255,0.3),
                           0 0 40px rgba(255,255,255,0.2),
                           0 0 60px rgba(255,255,255,0.1);
            }
            .feature-card:hover::before {
                opacity: 1;
            }
            .feature-card:hover h2 {
                color: rgb(255, 255, 255);
                text-shadow: 0 0 10px rgba(255,255,255,0.8),
                            0 0 20px rgba(255,255,255,0.6),
                            0 0 30px rgba(255,255,255,0.4);
            }
            .feature-card:hover p {
                color: rgb(255, 255, 255);
                text-shadow: 0 0 5px rgba(255,255,255,0.6),
                            0 0 10px rgba(255,255,255,0.4);
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Custom Navigation -->
        <nav class="nav-blur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex-shrink-0">
                        <span class="text-white font-bold text-xl">Inventory System</span>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="group inline-flex items-center px-6 py-2 bg-white/90 hover:bg-white text-gray-900 rounded-lg shadow-lg transition-all duration-300 hover:scale-105 focus:outline focus:outline-2 focus:outline-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            <span class="font-semibold">Login to System</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="relative bg-cover bg-center" style="background-image: url('{{ asset('image/bg.jpg') }}')">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="main-content">
                <div class="max-w-7xl mx-auto p-6 lg:p-8 relative z-10">
                    <div class="flex justify-center">
                        <div class="title-container">
                            <h1 class="text-6xl font-bold text-white mb-8 title-shine fade-in">Inventory System</h1>
                        </div>
                    </div>

                    <div class="mt-16">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                            <div class="feature-card scale-100 p-6 bg-white/80 backdrop-blur-sm dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex fade-in delay-200">
                                <div>
                                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Track Your Inventory</h2>
                                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                        Efficiently manage and track your inventory items. Keep records of all your assets in one place.
                                    </p>
                                </div>
                            </div>

                            <div class="feature-card scale-100 p-6 bg-white/80 backdrop-blur-sm dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex fade-in delay-400">
                                <div>
                                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Real-time Analytics</h2>
                                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                        Get instant insights into your inventory status with detailed reports and analytics dashboard.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
