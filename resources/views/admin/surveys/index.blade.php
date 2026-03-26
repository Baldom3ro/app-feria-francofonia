<x-admin-layout>
    <x-slot name="header">
        Resultados de Encuestas
    </x-slot>

    <div class="space-y-8">
        
        <!-- Stand Surveys Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Valoraciones de Stands</h3>
                <p class="text-sm text-gray-500 mt-1">Historial del rating otorgado a cada stand por los visitantes.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stand</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Visitante</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Rating</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($surveys as $survey)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ optional($survey->stand)->name ?? 'Stand Eliminado' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ optional($survey->participant)->name ?? 'Participante ID '.$survey->participantId }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-yellow-100 text-yellow-800 border border-yellow-200 px-3 py-1.5 rounded-xl text-sm font-bold flex inline-flex items-center gap-1 justify-center max-w-min mx-auto">
                                    {{ $survey->rating }} 
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-500">{{ $survey->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Aún no hay valoraciones de stands registradas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($surveys->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $surveys->links() }}
            </div>
            @endif
        </div>

        <!-- Event Surveys Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Encuestas Generales (Feedback del Evento)</h3>
                <p class="text-sm text-gray-500 mt-1">Calificaciones generales otorgadas por participante para las 5 preguntas del sistema.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-indigo-600 uppercase tracking-wider">Visitante</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">P1. General</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">P2. Accesibilidad</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">P3. Atención</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">P4. Variedad</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">P5. Limpieza</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($eventSurveys as $es)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-left font-bold text-gray-900">{{ optional($es->participant)->name ?? 'Participante ID '.$es->participantId }}</td>
                            <td class="px-6 py-4 text-center font-medium">{{ $es->q1 ?? '-' }} / 5</td>
                            <td class="px-6 py-4 text-center font-medium">{{ $es->q2 ?? '-' }} / 5</td>
                            <td class="px-6 py-4 text-center font-medium">{{ $es->q3 ?? '-' }} / 5</td>
                            <td class="px-6 py-4 text-center font-medium">{{ $es->q4 ?? '-' }} / 5</td>
                            <td class="px-6 py-4 text-center font-medium">{{ $es->q5 ?? '-' }} / 5</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Aún no hay encuestas generales del evento registradas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($eventSurveys->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $eventSurveys->links() }}
            </div>
            @endif
        </div>

    </div>
</x-admin-layout>
