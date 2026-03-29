@php
    $userLayout = auth()->user()->rol;
@endphp

@if($userLayout === 'admin' || $userLayout === 'supervisor')
<x-admin-layout>
    <x-slot name="header">Mi Perfil</x-slot>

    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Hero Card del perfil --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-500 to-violet-600 rounded-2xl shadow-xl p-8 text-white">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/3 -translate-x-1/4"></div>
            <div class="relative flex items-center gap-6">
                <div class="h-20 w-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-3xl font-extrabold border-2 border-white/30 shadow-lg">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight">{{ auth()->user()->name }}</h1>
                    <p class="text-indigo-100 text-sm mt-1">{{ auth()->user()->email }}</p>
                    <div class="mt-3 flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full capitalize">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            {{ auth()->user()->rol }}
                        </span>
                        <span class="text-xs text-indigo-200">
                            Miembro desde {{ auth()->user()->created_at->format('d M, Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Información del perfil --}}
        <div id="profile" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Información Personal</h3>
                    <p class="text-xs text-gray-500">Actualiza tu nombre y correo electrónico</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Cambiar contraseña --}}
        <div id="password" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Seguridad — Contraseña</h3>
                    <p class="text-xs text-gray-500">Usa una contraseña larga y segura para proteger tu cuenta</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Sesiones activas --}}
        <div id="sessions" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                @include('profile.partials.active-sessions')
            </div>
        </div>

        {{-- Zona de peligro --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-red-100 flex items-center gap-3 bg-red-50/50">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-red-800">Zona de Peligro</h3>
                    <p class="text-xs text-red-500">Esta acción es permanente e irreversible</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-admin-layout>
@else
<x-stand-layout>
    <x-slot name="standName">Mi Perfil</x-slot>

    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Hero Card --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-500 to-violet-600 rounded-2xl shadow-xl p-8 text-white">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="relative flex items-center gap-6">
                <div class="h-20 w-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-3xl font-extrabold border-2 border-white/30 shadow-lg">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight">{{ auth()->user()->name }}</h1>
                    <p class="text-indigo-100 text-sm mt-1">{{ auth()->user()->email }}</p>
                    <div class="mt-3">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            Staff Registrador
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Información del perfil --}}
        <div id="profile" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Información Personal</h3>
                    <p class="text-xs text-gray-500">Actualiza tu nombre y correo electrónico</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Cambiar contraseña --}}
        <div id="password" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Seguridad — Contraseña</h3>
                    <p class="text-xs text-gray-500">Usa una contraseña larga y segura</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Sesiones activas --}}
        <div id="sessions" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                @include('profile.partials.active-sessions')
            </div>
        </div>

        {{-- Zona de peligro --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-red-100 flex items-center gap-3 bg-red-50/50">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-red-800">Zona de Peligro</h3>
                    <p class="text-xs text-red-500">Esta acción es permanente e irreversible</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-stand-layout>
@endif
