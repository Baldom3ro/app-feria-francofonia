<x-guest-layout>
    {{-- ============================================================
        Vista: auth/reset-password.blade.php
        Formulario para establecer la nueva contraseña.
        Incluye:
          - Indicador visual de fortaleza de contraseña (JS)
          - Validación mínimo 8 chars, mayúsculas, minúsculas y números
          - Toggle para mostrar/ocultar contraseña
          - Mensajes de error amigables
        ============================================================ --}}

    {{-- Encabezado --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Nueva contraseña</h1>
        <p class="text-sm text-gray-500 mt-2">
            Crea una contraseña segura para proteger tu cuenta.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" id="reset-password-form">
        @csrf

        {{-- Token oculto --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                       value="{{ old('email', $request->email) }}"
                       required
                       autofocus
                       autocomplete="username"
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

        {{-- Nueva contraseña --}}
        <div class="mb-2">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                Nueva contraseña
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input id="password"
                       type="password"
                       name="password"
                       required
                       autocomplete="new-password"
                       placeholder="Mínimo 8 caracteres"
                       oninput="checkPasswordStrength(this.value)"
                       class="w-full pl-10 pr-12 py-3 border @error('password') border-red-400 bg-red-50 @else border-gray-200 bg-gray-50 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                <button type="button"
                        onclick="togglePassword('password', this)"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg class="w-5 h-5 eye-close hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Indicador de fortaleza de contraseña --}}
        <div id="strength-container" class="mb-5 hidden">
            <div class="flex gap-1.5 mb-2 mt-2">
                <div id="bar-1" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300"></div>
                <div id="bar-2" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300"></div>
                <div id="bar-3" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300"></div>
                <div id="bar-4" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-all duration-300"></div>
            </div>
            <p id="strength-label" class="text-xs text-gray-500"></p>

            {{-- Requisitos --}}
            <ul class="mt-3 space-y-1.5 text-xs text-gray-500">
                <li id="req-length" class="flex items-center gap-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5 req-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Mínimo 8 caracteres
                </li>
                <li id="req-upper" class="flex items-center gap-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5 req-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Al menos una letra mayúscula (A-Z)
                </li>
                <li id="req-lower" class="flex items-center gap-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5 req-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Al menos una letra minúscula (a-z)
                </li>
                <li id="req-number" class="flex items-center gap-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5 req-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Al menos un número (0-9)
                </li>
            </ul>
        </div>

        {{-- Confirmar contraseña --}}
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                Confirmar contraseña
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <input id="password_confirmation"
                       type="password"
                       name="password_confirmation"
                       required
                       autocomplete="new-password"
                       placeholder="Repite tu contraseña"
                       class="w-full pl-10 pr-12 py-3 border @error('password_confirmation') border-red-400 bg-red-50 @else border-gray-200 bg-gray-50 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                <button type="button"
                        onclick="togglePassword('password_confirmation', this)"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg class="w-5 h-5 eye-close hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Botón restablecer --}}
        <button type="submit"
                id="btn-reset-password"
                class="w-full bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-500/30 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Restablecer contraseña
        </button>
    </form>

    <script>
        /**
         * Muestra u oculta el campo de contraseña
         */
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClose = btn.querySelector('.eye-close');
            input.type = input.type === 'password' ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden');
            eyeClose.classList.toggle('hidden');
        }

        /**
         * Evalúa la fortaleza de la contraseña y actualiza el indicador visual.
         * Criterios: longitud ≥ 8, mayúscula, minúscula, número.
         * @param {string} password - Valor actual del campo de contraseña
         */
        function checkPasswordStrength(password) {
            const container = document.getElementById('strength-container');
            const label = document.getElementById('strength-label');
            const bars = [
                document.getElementById('bar-1'),
                document.getElementById('bar-2'),
                document.getElementById('bar-3'),
                document.getElementById('bar-4'),
            ];

            // Mostrar sección si hay algo escrito
            if (password.length === 0) {
                container.classList.add('hidden');
                return;
            }
            container.classList.remove('hidden');

            // Evaluar criterios
            const criteria = {
                length: password.length >= 8,
                upper:  /[A-Z]/.test(password),
                lower:  /[a-z]/.test(password),
                number: /[0-9]/.test(password),
            };

            // Colorear requisitos
            updateReq('req-length', criteria.length);
            updateReq('req-upper',  criteria.upper);
            updateReq('req-lower',  criteria.lower);
            updateReq('req-number', criteria.number);

            // Calcular puntaje (0–4)
            const score = Object.values(criteria).filter(Boolean).length;

            // Paleta de colores por nivel
            const levels = [
                { color: 'bg-red-500',    text: 'Muy débil',  textColor: 'text-red-500'    },
                { color: 'bg-orange-500', text: 'Débil',      textColor: 'text-orange-500' },
                { color: 'bg-yellow-400', text: 'Regular',    textColor: 'text-yellow-500' },
                { color: 'bg-green-400',  text: 'Buena',      textColor: 'text-green-500'  },
                { color: 'bg-green-600',  text: '¡Excelente!',textColor: 'text-green-700'  },
            ];

            const level = levels[score];

            // Actualizar barras
            bars.forEach((bar, index) => {
                bar.className = 'h-1.5 flex-1 rounded-full transition-all duration-300 ' +
                    (index < score ? level.color : 'bg-gray-200');
            });

            // Etiqueta de fortaleza
            label.textContent = level.text;
            label.className = `text-xs font-medium ${level.textColor}`;
        }

        /**
         * Actualiza visualmente un ítem de requisito (verde = ok, gris = pendiente)
         */
        function updateReq(id, met) {
            const el = document.getElementById(id);
            el.classList.toggle('text-green-600', met);
            el.classList.toggle('text-gray-400', !met);
        }
    </script>
</x-guest-layout>
