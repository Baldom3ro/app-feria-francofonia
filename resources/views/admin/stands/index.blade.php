<x-admin-layout>
    <x-slot name="header">
        Gestión de Stands
    </x-slot>

    <div x-data="{ createModal: false, editModal: false, editData: {} }">
        <!-- Actions & Search -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <form action="{{ route('stands.index') }}" method="GET" class="w-full sm:w-2/3 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <select name="status" onchange="this.form.submit()" class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todos (Estado)</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
                </select>
                <button type="submit" class="bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-gray-700 font-medium">Filtrar</button>
            </form>
            @if(auth()->user()->rol === 'admin')
            <button @click="createModal = true" class="bg-indigo-600 text-white px-6 py-2 rounded-xl shadow-lg hover:bg-indigo-700 transition font-bold w-full sm:w-auto flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Stand
            </button>
            @endif
        </div>

        <!-- Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Métricas</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                            @if(auth()->user()->rol === 'admin')
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($stands as $stand)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $stand->name }}</div>
                                <div class="text-sm text-gray-500">Resp: {{ optional($stand->owner)->name ?? 'Sin asignar' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                {{ $stand->description }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <span class="text-green-600 cursor-help" title="Visitas">{{ $stand->totalVisits }}</span> / 
                                <span class="text-blue-600 cursor-help" title="Encuestas">{{ $stand->totalSurveys }}</span> / 
                                <span class="text-yellow-500 cursor-help" title="Rating Promedio">{{ $stand->avgRating }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($stand->active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactivo</span>
                                @endif
                            </td>
                            @if(auth()->user()->rol === 'admin')
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                <button @click="editData = {{ $stand->toJson() }}; editModal = true" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg transition">Editar</button>
                                
                                <form action="{{ route('stands.destroy', $stand) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este stand?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg transition">Borrar</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No se encontraron stands registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $stands->links() }}
            </div>
        </div>

        @if(auth()->user()->rol === 'admin')
        <!-- Create Modal -->
        <div x-show="createModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div @click="createModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75"></div>
                
                <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Registrar Nuevo Stand</h3>
                    <form action="{{ route('stands.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div><label class="block text-sm font-medium text-gray-700">Nombre</label><input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700">Descripción</label><textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea></div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Responsable (Usuario Staff)</label>
                                <select name="ownerUserId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecciona un usuario...</option>
                                    @foreach($users as $user) <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option> @endforeach
                                </select>
                            </div>
                            <div class="flex items-center mt-4">
                                <input type="checkbox" name="active" checked value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Stand Activo (Visible y auditable)</label>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="createModal = false" class="bg-gray-100 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-200 transition">Cancelar</button>
                            <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg text-white font-bold hover:bg-indigo-700 transition">Guardar Stand</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div @click="editModal = false" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75"></div>
                
                <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Editar Stand</h3>
                    <form :action="'{{ url('stands') }}/' + editData.id" method="POST">
                        @csrf @method('PUT')
                        <div class="space-y-4">
                            <div><label class="block text-sm font-medium text-gray-700">Nombre</label><input type="text" name="name" x-model="editData.name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                            <div><label class="block text-sm font-medium text-gray-700">Descripción</label><textarea name="description" x-model="editData.description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea></div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Responsable (Usuario Staff)</label>
                                <select name="ownerUserId" x-model="editData.ownerUserId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecciona un usuario...</option>
                                    @foreach($users as $user) <option value="{{ $user->id }}">{{ $user->name }}</option> @endforeach
                                </select>
                            </div>
                            <div class="flex items-center mt-4">
                                <input type="checkbox" name="active" value="1" :checked="editData.active == 1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Stand Activo</label>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="editModal = false" class="bg-gray-100 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-200 transition">Cancelar</button>
                            <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg text-white font-bold hover:bg-indigo-700 transition">Aceptar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

    </div>
</x-admin-layout>
