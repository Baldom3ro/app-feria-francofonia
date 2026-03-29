{{-- ============================================================
    Partial: profile/partials/active-sessions.blade.php
    Propósito: Mostrar y gestionar sesiones activas del usuario.
    Diseño premium coherente con el sistema de diseño.
    ============================================================ --}}

@php
    $activeSessions = \App\Http\Controllers\Auth\SessionManagerController::getActiveSessions(request());
    $otherSessions = array_filter($activeSessions, fn($s) => !$s['is_current']);
@endphp

<section class="space-y-6" aria-labelledby="sessions-heading">

    {{-- Encabezado con icono --}}
    <div class="flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <div>
                    <h2 id="sessions-heading" class="text-base font-bold text-gray-900">
                        Sesiones Activas
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Gestiona los dispositivos donde has iniciado sesión
                    </p>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-full">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    {{ count($activeSessions) }} {{ count($activeSessions) === 1 ? 'sesión' : 'sesiones' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Mensajes de estado --}}
    @if (session('session_success'))
        <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm animate-pulse">
            <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="font-medium">{{ session('session_success') }}</span>
        </div>
    @endif

    @if (session('session_error'))
        <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
            <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="font-medium">{{ session('session_error') }}</span>
        </div>
    @endif

    {{-- Lista de sesiones --}}
    <div class="space-y-3">
        @forelse ($activeSessions as $session)
            <div class="group relative flex items-center justify-between p-4 rounded-2xl border transition-all duration-200
                {{ $session['is_current']
                    ? 'bg-gradient-to-r from-indigo-50 to-violet-50 border-indigo-200 shadow-sm shadow-indigo-100'
                    : 'bg-gray-50/50 border-gray-200 hover:bg-gray-50 hover:border-gray-300 hover:shadow-sm' }}">

                <div class="flex items-center gap-4">
                    {{-- Icono de dispositivo --}}
                    <div class="relative">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors
                            {{ $session['is_current']
                                ? 'bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-md shadow-indigo-200'
                                : 'bg-white text-gray-500 border border-gray-200 group-hover:border-gray-300' }}">
                            @if ($session['device'] === 'Móvil')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            @elseif ($session['device'] === 'Tablet')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        @if ($session['is_current'])
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></div>
                            </div>
                        @endif
                    </div>

                    {{-- Detalles --}}
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-sm {{ $session['is_current'] ? 'text-indigo-900' : 'text-gray-800' }}">
                                {{ $session['browser'] }}
                            </span>
                            <span class="text-gray-400">·</span>
                            <span class="text-sm {{ $session['is_current'] ? 'text-indigo-700' : 'text-gray-600' }}">
                                {{ $session['platform'] }}
                            </span>
                            @if ($session['is_current'])
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-white bg-gradient-to-r from-indigo-500 to-violet-600 px-2.5 py-0.5 rounded-full shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                    Esta sesión
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-4 mt-1.5">
                            <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                {{ $session['ip_address'] }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $session['last_activity'] }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $session['device'] }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Botón cerrar (solo otras sesiones) --}}
                @if (!$session['is_current'])
                    <form method="POST" action="{{ route('sessions.destroy', $session['id']) }}"
                          onsubmit="return confirm('¿Estás seguro de cerrar esta sesión?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 hover:text-white bg-red-50 hover:bg-red-500 border border-red-200 hover:border-red-500 px-3.5 py-2 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-red-200 group-hover:opacity-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Revocar
                        </button>
                    </form>
                @else
                    <span class="text-xs text-indigo-400 italic hidden sm:block">Activa ahora</span>
                @endif
            </div>
        @empty
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-400">No se encontraron sesiones activas</p>
                <p class="text-xs text-gray-300 mt-1">Las sesiones aparecerán aquí cuando inicies sesión</p>
            </div>
        @endforelse
    </div>

    {{-- Botón para cerrar todas las demás --}}
    @if (count($otherSessions) > 0)
        <div class="pt-3 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <p class="text-xs text-gray-500">
                    <span class="font-semibold text-gray-700">{{ count($otherSessions) }}</span> {{ count($otherSessions) === 1 ? 'sesión adicional encontrada' : 'sesiones adicionales encontradas' }}
                </p>
                <form method="POST" action="{{ route('sessions.destroyOthers') }}"
                      onsubmit="return confirm('¿Estás seguro? Se cerrarán todas las sesiones excepto la actual.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            id="btn-close-other-sessions"
                            class="inline-flex items-center gap-2 text-xs font-bold text-red-600 hover:text-white bg-red-50 hover:bg-red-500 border border-red-200 hover:border-red-500 px-4 py-2.5 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-red-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Cerrar todas las demás
                    </button>
                </form>
            </div>
        </div>
    @endif

</section>
