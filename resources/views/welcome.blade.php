<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feria de Sabores de la Francofonía</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F9FAFB] text-[#1F2937]">

    <!-- Navbar Minimalista -->
    <nav class="absolute w-full top-0 left-0 z-50 px-6 py-4 flex justify-between items-center text-white">
        <div class="font-bold text-xl tracking-wider flex items-center gap-2">
            <!-- Icono globo -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Francofonía
        </div>
        <div>
            @auth
                <a href="{{ url('/dashboard') }}" class="py-2 px-4 rounded-lg bg-white/20 hover:bg-white/30 backdrop-blur-md transition font-semibold text-white">Ir al Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-medium hover:text-indigo-200 transition mr-4 hidden sm:inline">Iniciar Sesión (Staff)</a>
                <a href="{{ route('participants.create') }}" class="bg-white text-indigo-600 px-5 py-2.5 rounded-lg font-bold hover:bg-indigo-50 transition shadow-sm">Participar</a>
            @endauth
        </div>
    </nav>

    <!-- 1. Hero Section -->
    <section class="relative bg-gradient-to-br from-[#4F46E5] to-[#7C3AED] pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden px-6 text-center text-white">
        <!-- SVG Decorativo de fondo (Waves) -->
        <div class="absolute bottom-0 left-0 w-full opacity-20 pointer-events-none">
            <svg class="w-full h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,218.7C672,235,768,245,864,229.3C960,213,1056,171,1152,149.3C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
        </div>
        
        <div class="relative z-10 max-w-4xl mx-auto space-y-6">
            <div class="inline-block px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-indigo-50 font-medium text-sm mb-4">
                ✨ Evento Gastronómico y Cultural
            </div>
            <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight leading-tight">
                Feria de Sabores de la <br class="hidden sm:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500 drop-shadow-sm">Francofonía</span>
            </h1>
            <p class="text-lg lg:text-2xl text-indigo-100 max-w-2xl mx-auto font-medium py-4">
                Un viaje gastronómico y cultural que celebra la diversidad, los aromas y la riqueza del mundo francófono.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-6">
                <a href="{{ route('participants.create') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-indigo-700 font-bold text-lg rounded-full shadow-lg hover:shadow-2xl hover:-translate-y-1 transition transform duration-200 text-center">
                    Participar en la Feria
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-transparent border-2 border-indigo-200 text-white font-bold text-lg rounded-full hover:bg-white/10 transition duration-200 text-center">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </section>

    <!-- 2. ¿Qué es la Francofonía? -->
    <section class="py-24 px-6 max-w-4xl mx-auto text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6 text-gray-900 tracking-tight">¿Qué es la Francofonía?</h2>
        <div class="w-20 h-1 bg-indigo-500 mx-auto rounded-full mb-8"></div>
        <p class="text-xl text-gray-600 leading-relaxed font-light">
            La francofonía va mucho más allá de un idioma; es una comunidad global unida por valores compartidos de paz, democracia y gran diversidad cultural. En esta feria, te invitamos a explorar los sabores, costumbres y la maravillosa convivencia que caracteriza a los diferentes países francófonos alrededor del mundo.
        </p>
    </section>

    <!-- 3. Experiencia (3 columnas) -->
    <section class="py-20 bg-white px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Tarjeta 1: Gastronomía -->
                <div class="bg-[#F9FAFB] border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-3.413a2.699 2.699 0 00-1.5-.454c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454V21a2 2 0 002 2h14a2 2 0 002-2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 tracking-tight">Gastronomía</h3>
                    <p class="text-gray-600 leading-relaxed">Descubre impresionantes platillos y bocadillos que definen la cocina internacional, uniendo múltiples culturas a través de un simple sabor.</p>
                </div>

                <!-- Tarjeta 2: Cultura -->
                <div class="bg-[#F9FAFB] border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 tracking-tight">Cultura global</h3>
                    <p class="text-gray-600 leading-relaxed">Sumérgete en un intercambio de música, idiomas, costumbres y tradiciones artísticas que enriquecen los lazos globales que nos unen.</p>
                </div>

                <!-- Tarjeta 3: Interacción -->
                <div class="bg-[#F9FAFB] border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 tracking-tight">Interacción Inteligente</h3>
                    <p class="text-gray-600 leading-relaxed">Registra tus visitas a los stands fácilmente utilizando un código QR único desde tu smartphone, y valora cada experiencia al instante.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Cómo Participar -->
    <section class="py-24 px-6 max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 tracking-tight">Cómo participar</h2>
            <p class="text-gray-500 mt-4 text-lg">Es muy fácil formar parte de nuestra feria y registrar tu actividad.</p>
        </div>
        
        <div class="flex flex-col md:flex-row justify-center items-center gap-10 md:gap-14 relative w-full px-4">
            <!-- Linea conector desktop -->
            <div class="hidden md:block absolute top-[40%] left-10 right-10 h-0.5 bg-gray-200 -z-10"></div>

            <!-- Paso 1 -->
            <div class="flex flex-col items-center flex-1 max-w-[250px]">
                <div class="bg-indigo-50 border-4 border-white shadow-lg rounded-full w-24 h-24 flex items-center justify-center relative mb-6">
                    <span class="text-3xl font-extrabold text-indigo-600">1</span>
                </div>
                <h4 class="font-bold text-xl text-gray-900 text-center">Inscríbete</h4>
                <p class="text-gray-500 mt-2 text-center text-sm leading-relaxed">Llena nuestro breve cuestionario de registro en línea para crear tu gafete digital y obtener un código QR único.</p>
            </div>

            <!-- Paso 2 -->
            <div class="flex flex-col items-center flex-1 max-w-[250px]">
                <div class="bg-purple-50 border-4 border-white shadow-lg rounded-full w-24 h-24 flex items-center justify-center relative mb-6">
                    <span class="text-3xl font-extrabold text-purple-600">2</span>
                </div>
                <h4 class="font-bold text-xl text-gray-900 text-center">Visita los Stands</h4>
                <p class="text-gray-500 mt-2 text-center text-sm leading-relaxed">Recorre los pasillos de nuestra feria, descubre stands llenos de sabor y presenta tu QR para registrar tus visitas.</p>
            </div>

            <!-- Paso 3 -->
            <div class="flex flex-col items-center flex-1 max-w-[250px]">
                <div class="bg-indigo-50 border-4 border-white shadow-lg rounded-full w-24 h-24 flex items-center justify-center relative mb-6">
                    <span class="text-3xl font-extrabold text-indigo-600">3</span>
                </div>
                <h4 class="font-bold text-xl text-gray-900 text-center">Califica y Opina</h4>
                <p class="text-gray-500 mt-2 text-center text-sm leading-relaxed">Después de cada stand, proporciona tu valoración y llena nuestra encuesta sobre los países que representamos.</p>
            </div>
        </div>
    </section>

    <!-- 5. CTA Final -->
    <section class="bg-gradient-to-r from-[#4F46E5] to-[#7C3AED] py-20 px-6 text-center text-white">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl lg:text-5xl font-extrabold tracking-tight mb-6">¿Preparado para la experiencia gastronómica?</h2>
            <p class="text-indigo-100 mb-10 text-lg lg:text-xl font-light">No dejes pasar la oportunidad de conocer la diversidad del mundo francófono de la mejor manera: aprendiendo, compartiendo y saboreando.</p>
            <a href="{{ route('participants.create') }}" class="inline-flex items-center justify-center px-10 py-5 bg-white text-indigo-700 font-bold text-xl rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transition transform duration-200">
                Registrarme Ahora
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </section>

    <!-- 6. Footer -->
    <footer class="bg-gray-900 text-gray-400 py-10 px-6 text-center text-sm flex flex-col items-center justify-center gap-4">
        <div class="flex items-center justify-center gap-2 mb-2 w-full">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-bold text-gray-300">Francofonía</span>
        </div>
        <p>© 2026 Feria de Sabores de la Francofonía. Todos los derechos reservados.</p>
        <p class="text-xs text-gray-600">Desarrollado con Laravel 12 y TailwindCSS.</p>
    </footer>

</body>
</html>
