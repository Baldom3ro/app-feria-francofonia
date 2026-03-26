<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Francofonía') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#4F46E5] to-[#7C3AED] relative overflow-hidden">
            
            <!-- Decorative SVG Waves -->
            <div class="absolute bottom-0 left-0 w-full opacity-10 pointer-events-none">
                <svg class="w-full h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,218.7C672,235,768,245,864,229.3C960,213,1056,171,1152,149.3C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
            </div>

            <div class="relative z-10 flex flex-col items-center w-full sm:max-w-md px-4 mt-8">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 text-white hover:text-indigo-100 transition mb-6 transform hover:scale-105 duration-200">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-3xl font-extrabold tracking-wider drop-shadow-md">Francofonía</span>
                </a>

                <!-- Form Card -->
                <div class="w-full px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-white/50 relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-white to-gray-50 opacity-50 z-0"></div>
                    <div class="relative z-10">
                        {{ $slot }}
                    </div>
                </div>
                
                <p class="mt-8 text-indigo-200 text-sm font-medium">&copy; 2026 Feria Gastronómica y Cultural</p>
            </div>
        </div>
    </body>
</html>
