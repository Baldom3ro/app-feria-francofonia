<x-guest-layout>
    {{-- ============================================================
        Vista: auth/forgot-password.blade.php
        Flujo: el usuario ingresa su email y recibe un enlace seguro
        para restablecer la contraseña. Token con expiración de 60 min.
        ============================================================ --}}

    @if (session('status'))
        {{-- ✅ Email enviado exitosamente --}}
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">¡Correo enviado!</h1>
            <p class="text-sm text-gray-600">
                {{ session('status') }}
            </p>
            <p class="text-xs text-gray-400 mt-3">
                Revisa tu bandeja de entrada y carpeta de spam. El enlace expira en <strong>60 minutos</strong>.
            </p>
        </div>

        <a href="{{ route('login') }}"
           class="block w-full text-center bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-500/30 hover:-translate-y-0.5">
            Volver al inicio de sesión
        </a>

    @else
        {{-- 📧 Formulario de solicitud de recuperación --}}

        {{-- Icono y título --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">¿Olvidaste tu contraseña?</h1>
            <p class="text-sm text-gray-500 mt-2 max-w-sm mx-auto">
                Sin problema. Ingresa tu correo y te enviaremos un enlace seguro para crear una nueva contraseña.
            </p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" id="forgot-password-form">
            @csrf

            {{-- Email --}}
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Correo electrónico
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           placeholder="tu@correo.com"
                           class="w-full pl-10 pr-4 py-3 border @error('email') border-red-400 bg-red-50 @else border-gray-200 bg-gray-50 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>
                @error('email')
                    <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Nota de seguridad --}}
            <div class="flex items-start gap-3 p-3 bg-blue-50 border border-blue-100 rounded-xl text-xs text-blue-600 mb-6">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>
                    Por seguridad, el enlace de recuperación <strong>expira en 60 minutos</strong> y solo puede usarse una vez. Si no encuentras el correo, revisa tu carpeta de spam.
                </span>
            </div>

            {{-- Botón enviar --}}
            <button type="submit"
                    id="btn-send-reset"
                    class="w-full bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-500/30 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Enviar enlace de recuperación
            </button>

            {{-- Volver al login --}}
            <p class="text-center text-sm text-gray-500 mt-6">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al inicio de sesión
                </a>
            </p>
        </form>
    @endif
</x-guest-layout>
