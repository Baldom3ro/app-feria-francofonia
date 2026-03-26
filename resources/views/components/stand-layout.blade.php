<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Francofonía Stand') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body class="font-sans antialiased bg-[#F9FAFB] text-[#1F2937]" x-data="{ sidebarOpen: false, activeTab: 'scan' }">

    <div class="min-h-screen flex">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed z-50 inset-y-0 left-0 w-64 transition-transform duration-300 transform bg-gradient-to-b from-[#4F46E5] to-[#7C3AED] shadow-xl text-white lg:translate-x-0 lg:static lg:inset-auto flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-center h-20 border-b border-white/10 px-6">
                <span class="text-xl font-extrabold tracking-wider flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"></path></svg>
                    Staff Stand
                </span>
            </div>

            <!-- Nav Links (SPA Tabs) -->
            <nav class="flex-1 px-4 py-8 space-y-3 overflow-y-auto">
                <a href="#" @click.prevent="activeTab = 'scan'; sidebarOpen = false" :class="activeTab === 'scan' ? 'bg-white/20 font-bold' : 'hover:bg-white/10 font-medium'" class="flex items-center px-4 py-4 rounded-xl transition-colors text-white">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Escanear Visita
                </a>
                
                <a href="#" @click.prevent="activeTab = 'dashboard'; sidebarOpen = false" :class="activeTab === 'dashboard' ? 'bg-white/20 font-bold' : 'hover:bg-white/10 font-medium text-indigo-100'" class="flex items-center px-4 py-3 rounded-xl transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Métricas del Stand
                </a>

                <a href="#" @click.prevent="activeTab = 'history'; sidebarOpen = false" :class="activeTab === 'history' ? 'bg-white/20 font-bold' : 'hover:bg-white/10 font-medium text-indigo-100'" class="flex items-center px-4 py-3 rounded-xl transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Historial Reciente
                </a>
            </nav>

            <!-- Logout Bottom -->
            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 rounded-xl transition-colors hover:bg-white/10 font-medium text-red-100 hover:text-white">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
            
            <!-- Topbar (optimizada móvil) -->
            <header class="h-16 lg:h-20 bg-white border-b border-gray-100 flex items-center justify-between px-4 lg:px-10 z-10 shadow-sm relative">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-indigo-600 focus:outline-none lg:hidden mr-3 p-2 rounded-lg bg-gray-50 border border-gray-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <!-- Título dinámico por tab -->
                    <h2 class="text-lg lg:text-xl font-extrabold text-[#4F46E5] tracking-tight truncate max-w-[150px] sm:max-w-none">{{ $standName ?? 'Dashboard' }}</h2>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Staff Registrador</p>
                    </div>
                    <div class="h-10 w-10 min-w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg shadow-inner ring-2 ring-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F9FAFB] p-4 lg:p-8 w-full relative">
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center shadow-sm text-sm" role="alert">
                        <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="block font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error') || $errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm text-sm">
                        <span class="font-bold flex items-center gap-2"><svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Error en el registro</span>
                        <ul class="list-disc pl-7 mt-1">
                            @if(session('error')) <li>{{ session('error') }}</li> @endif
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 lg:hidden backdrop-blur-sm transition-opacity" style="display: none;"></div>
    </div>
</body>
</html>
