<x-admin-layout>
    <x-slot name="header">
        Visión General
    </x-slot>

    <div class="space-y-8">
        <!-- Métricas Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-gray-500 text-sm font-medium">Participantes</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $totalParticipants }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-green-50 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-gray-500 text-sm font-medium">Visitas Registradas</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $totalVisits }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-purple-50 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-gray-500 text-sm font-medium">Encuestas Totales</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $totalSurveys }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-yellow-50 text-yellow-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-gray-500 text-sm font-medium">Rating General</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ number_format($avgRating, 1) }} <span class="text-sm font-normal text-gray-400">/ 5</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficas (Chart.js) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 tracking-tight">Visitas por Stand</h3>
                <div class="relative h-72 w-full">
                    <canvas id="visitsChart"></canvas>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 tracking-tight">Rendimiento (Rating Promedio)</h3>
                <div class="relative h-72 w-full">
                    <canvas id="ratingsChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Script para gráficas -->
        <script id="stands-data" type="application/json">
            {!! json_encode($stands) !!}
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const standsData = JSON.parse(document.getElementById('stands-data').textContent);
                
                const labels = standsData.map(s => s.name);
                const visits = standsData.map(s => s.totalVisits);
                const ratings = standsData.map(s => s.avgRating);
                
                const ctxVisits = document.getElementById('visitsChart').getContext('2d');
                new Chart(ctxVisits, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Visitas Registradas',
                            data: visits,
                            backgroundColor: '#4F46E5',
                            borderRadius: 6,
                            barPercentage: 0.6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, grid: { color: '#F3F4F6' } }, x: { grid: { display: false } } }
                    }
                });

                const ctxRatings = document.getElementById('ratingsChart').getContext('2d');
                new Chart(ctxRatings, {
                    type: 'polarArea',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Rating Promedio',
                            data: ratings,
                            backgroundColor: [
                                'rgba(79, 70, 229, 0.7)',
                                'rgba(124, 58, 237, 0.7)',
                                'rgba(59, 130, 246, 0.7)',
                                'rgba(16, 185, 129, 0.7)',
                                'rgba(245, 158, 11, 0.7)'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'right' } },
                        scales: { r: { min: 0, max: 5 } }
                    }
                });
            });
        </script>
    </div>
</x-admin-layout>
