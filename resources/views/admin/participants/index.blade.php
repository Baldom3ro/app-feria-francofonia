<x-admin-layout>
    <x-slot name="header">
        Administración General de Participantes
    </x-slot>

    <div x-data="{ createModal: false }">
        <!-- Actions & Search -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <form action="{{ route('participants.index') }}" method="GET" class="w-full sm:w-1/3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o correo..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </form>
            <button @click="createModal = true" class="bg-indigo-600 text-white px-6 py-2 rounded-xl shadow-lg hover:bg-indigo-700 transition font-bold w-full sm:w-auto flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                Inscribir Participante
            </button>
        </div>

        <!-- Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Correo / Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ubicación</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Registro</th>
                            @if(auth()->user()->rol === 'admin')
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Borrar</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($participants as $participant)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $participant->name }} {{ $participant->paternalLastName }} {{ $participant->maternalLastName }}</div>
                                <div class="text-xs text-gray-400">ID N°: #{{ $participant->id }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $participant->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $participant->city }}, {{ $participant->municipality }}</td>
                            <td class="px-6 py-4 text-right text-sm text-gray-500">{{ $participant->created_at->format('d M Y') }}</td>
                            
                            @if(auth()->user()->rol === 'admin')
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <form action="{{ route('participants.destroy', $participant) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar el registro de este participante? Toda su data pasará a nula.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-xl transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 text-lg font-medium">No se encontraron participantes registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($participants->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $participants->links() }}
            </div>
            @endif
        </div>

        <!-- Create Modal -->
        <div x-show="createModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div @click="createModal = false" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity"></div>
                
                <div x-show="createModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-xl w-full p-6 sm:p-8">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-black text-gray-900">Inscripción Manual</h3>
                        <button @click="createModal = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form action="{{ route('participants.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Nombres -->
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-bold text-gray-700">Nombre(s) *</label>
                                <input type="text" name="name" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Apellido Paterno *</label>
                                <input type="text" name="paternalLastName" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Apellido Materno *</label>
                                <input type="text" name="maternalLastName" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Ubicación -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Ciudad de Origen *</label>
                                <input type="text" name="city" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Municipio *</label>
                                <input type="text" name="municipality" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Demografía / Correo -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Sexo *</label>
                                <select name="sex" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white">
                                    <option value="male">Hombre</option>
                                    <option value="female">Mujer</option>
                                    <option value="other">Otro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Correo Electrónico *</label>
                                <input type="email" name="email" required placeholder="correo@ejemplo.com" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        
                        <div class="bg-indigo-50 p-4 rounded-xl text-sm text-indigo-800 border-l-4 border-indigo-500 mt-6 font-medium">
                            <span class="block mb-1 font-bold">Importante: Generación Automática</span>
                            Al hacer clic en el botón de registro, el sistema guardará al participante en base de datos, generará un su acceso QR único y se lo enviará instantáneamente a <b>correo electrónico</b> proporcionado.
                        </div>

                        <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 mt-6">
                            <button type="button" @click="createModal = false" class="bg-gray-100 px-6 py-3 rounded-xl text-gray-700 font-medium hover:bg-gray-200 transition">Cancelar</button>
                            <button type="submit" class="bg-[#4F46E5] px-6 py-3 rounded-xl text-white font-bold hover:bg-[#4338CA] shadow-md transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Inscribir y Enviar QR
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
