<x-stand-layout>
    <x-slot name="standName">
        Stand {{ $stand->name }}
    </x-slot>

    <style>
        /* html5-qrcode UI overrides to make it look modern and matching Tailwind */
        #reader { border: none !important; background: transparent !important; }
        #reader__header_message { display: none !important; }
        /* Style the select dropdown */
        #reader__camera_selection {
            padding: 8px !important; border-radius: 8px !important; border: 1px solid #D1D5DB !important;
            margin-bottom: 12px !important; width: 100%; max-width: 100%; background: white !important; color: black !important;
        }
        /* Style the buttons injected by html5-qrcode */
        #reader__dashboard_section_csr button {
            background-color: #4F46E5 !important; color: white !important; border: none !important;
            padding: 8px 16px !important; border-radius: 8px !important; font-weight: bold !important;
            margin-bottom: 12px !important; cursor: pointer !important; width: 100% !important;
        }
        #reader__dashboard_section_csr button:hover { background-color: #4338CA !important; }
        /* Hide unnecessary links (scan image file) */
        #reader__dashboard_section_swaplink { display: none !important; }
        /* Force the video to scale properly within the rounded container */
        #reader video {
            border-radius: 1rem !important;
            width: 100% !important;
            object-fit: cover !important;
        }
    </style>

    <!-- Alpine App Logic Container -->
    <div x-data="standApp()" @scan-success.window="registerVisit($event.detail)" class="relative h-full">

        <!-- Custom Toast Notification -->
        <div x-show="showToast" x-transition.opacity style="display: none;" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50">
            <div :class="toastType === 'error' ? 'bg-red-600' : 'bg-gray-900'" class="text-white px-6 py-3 rounded-full shadow-2xl font-bold flex items-center gap-2 text-sm whitespace-nowrap">
                <svg x-show="toastType !== 'error'" class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <svg x-show="toastType === 'error'" class="w-5 h-5 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-text="toastMsg"></span>
            </div>
        </div>

        <!-- TAB: ESCÁNER (Principal) -->
        <div x-show="activeTab === 'scan'" class="space-y-4 max-w-lg mx-auto w-full" x-transition.opacity.duration.300ms>
            
            <div class="bg-indigo-600 rounded-3xl p-6 text-center text-white shadow-xl relative overflow-hidden" :class="isProcessing ? 'animate-pulse' : ''">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 opacity-80"></div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="bg-white/20 p-4 rounded-full mb-4 backdrop-blur-sm transition-transform duration-500" :class="isProcessing ? 'rotate-180 scale-110' : ''">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-black tracking-tight mb-1" id="scannerStatusTitle">Listo para escanear</h2>
                    <p class="text-indigo-100 font-medium text-sm">Escanea para registrar una nueva visita y encuestar.</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100">
                <div id="reader" width="100%" class="w-full rounded-2xl relative min-h-[50px]"></div>
                
                <button type="button" @click="startScannerDOM()" class="mt-4 w-full bg-gray-900 text-white py-4 rounded-2xl font-bold text-lg shadow hover:bg-black transition active:scale-[0.98]">
                    ACTIVAR CÁMARA
                </button>
            </div>

            <!-- SIMULADOR MANUAL -->
            <div x-data="{ simOpen: false }" class="mt-6 mx-auto bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
                <button @click="simOpen = !simOpen" class="w-full px-4 py-3 text-sm font-bold text-gray-600 flex justify-between items-center text-left">
                    <span>¿Problemas con cámara? Ingreso Manual</span>
                    <svg class="w-4 h-4 transform transition-transform" :class="simOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="simOpen" class="p-4 border-t border-gray-200 bg-white" style="display:none;">
                    <form @submit.prevent="registerVisit($refs.manualId.value)" class="flex gap-2">
                        <input type="number" x-ref="manualId" placeholder="ID Visitante (Numérico)" required class="flex-1 rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm">
                        <button type="submit" :disabled="isProcessing" class="bg-indigo-600 text-white font-bold px-4 py-2 rounded-xl text-sm whitespace-nowrap hover:bg-indigo-700">Registrar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB: DASHBOARD / MÉTRICAS -->
        <div x-cloak x-show="activeTab === 'dashboard'" class="space-y-6" x-transition.opacity.duration.300ms>
            <div class="mb-4">
                <h3 class="text-xl font-black text-gray-900">Rendimiento Actual</h3>
                <p class="text-gray-500 text-sm">Actualizado al último registro en {{ $stand->name }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Visitas -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="bg-indigo-50 text-indigo-600 p-4 rounded-full mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Visitas Registradas</p>
                    <p class="text-5xl font-black text-gray-900 mt-2">{{ $stand->totalVisits }}</p>
                </div>

                <!-- Encuestas -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="bg-blue-50 text-blue-600 p-4 rounded-full mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <p class="text-gray-500 text-sm font-bold uppercase tracking-wide">Encuestas Contestadas</p>
                    <p class="text-5xl font-black text-gray-900 mt-2">{{ $stand->totalSurveys }}</p>
                </div>

                <!-- Promedio -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-yellow-100 sm:col-span-2 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-yellow-50 opacity-50 z-0"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <p class="text-yellow-700 text-sm font-bold uppercase tracking-wide">Rating Promedio del Stand</p>
                        <div class="flex items-center gap-2 mt-2">
                            <svg class="w-10 h-10 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <p class="text-6xl font-black text-gray-900">{{ number_format($stand->avgRating, 1) }}</p>
                            <span class="text-2xl text-gray-400 font-bold self-end mb-2">/ 5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB: HISTORIAL -->
        <div x-cloak x-show="activeTab === 'history'" class="space-y-4" x-transition.opacity.duration.300ms>
            <div class="mb-4">
                <h3 class="text-xl font-black text-gray-900">Historial Reciente</h3>
                <p class="text-gray-500 text-sm">Últimos visitantes escaneados exitosamente en tu stand.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                @if($recentVisits->isEmpty())
                    <div class="p-10 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Aún no has registrado ninguna visita.
                    </div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($recentVisits as $visit)
                        <li class="p-4 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 min-w-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ optional($visit->participant)->name ?? 'Participante ID '.$visit->participantId }}</p>
                                    <p class="text-xs text-gray-500">{{ $visit->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- MODAL DE ENCUESTA RÁPIDA INMEDIATA -->
        <div x-cloak x-show="surveyModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="surveyModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div x-show="surveyModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-white rounded-3xl pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm w-full p-6 sm:p-8 border border-gray-100 z-50">
                    
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4 shadow-inner">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <h3 class="text-2xl leading-6 font-black text-gray-900 mb-2 truncate" id="modal-title">¡Visita Registrada!</h3>
                        <p class="text-sm font-bold text-gray-500 mb-6 bg-gray-50 py-2 rounded-lg" x-text="scanParticipantName"></p>
                        
                        <div class="bg-indigo-50 rounded-2xl p-6 mb-6">
                            <h4 class="text-lg font-bold text-indigo-900 mb-4">¿Qué te pareció este stand?</h4>
                            
                            <!-- Star Rating Interactivo -->
                            <div class="flex justify-center gap-2 mb-2" @mouseleave="hoverRating = 0">
                                <template x-for="i in 5">
                                    <button @click="rating = i" 
                                            @mouseover="hoverRating = i"
                                            class="focus:outline-none transition-transform hover:scale-110 active:scale-90">
                                        <svg class="w-10 h-10 transition-colors" 
                                             :class="(hoverRating >= i || rating >= i) ? 'text-yellow-400 drop-shadow-md' : 'text-gray-300'" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </button>
                                </template>
                            </div>
                            <p class="text-xs font-bold text-indigo-400 uppercase tracking-widest mt-2">
                                <span x-show="rating === 0">Selecciona tu nota</span>
                                <span x-show="rating === 1">1 - Deficiente</span>
                                <span x-show="rating === 2">2 - Regular</span>
                                <span x-show="rating === 3">3 - Bueno</span>
                                <span x-show="rating === 4">4 - Muy Bueno</span>
                                <span x-show="rating === 5">5 - Excelente</span>
                            </p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button @click="submitSurvey()" 
                                    :disabled="rating === 0 || isProcessing"
                                    :class="rating === 0 ? 'bg-indigo-300 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700 active:scale-95 shadow-lg'"
                                    class="w-full inline-flex justify-center items-center rounded-xl border border-transparent px-4 py-4 text-base font-bold text-white transition-all sm:text-lg">
                                <span x-show="isProcessing">Enviando...</span>
                                <span x-show="!isProcessing" class="flex items-center gap-2">Enviar Calificación <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></span>
                            </button>
                            <button @click="skipSurvey()" 
                                    :disabled="isProcessing"
                                    class="w-full inline-flex justify-center rounded-xl border-2 border-gray-200 px-4 py-3 bg-white text-base font-bold text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition sm:text-lg shrink-0">
                                Omitir Encuesta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Modal -->

    </div>

    <!-- Scanner Setup -->
    <script>
        let html5QrcodeScanner = null;

        function standApp() {
            return {
                isProcessing: false,
                surveyModal: false,
                scanParticipantId: null,
                scanParticipantName: '',
                rating: 0,
                hoverRating: 0,
                toastMsg: '',
                toastType: 'success',
                showToast: false,

                async registerVisit(participantId) {
                    if(this.isProcessing) return;
                    this.isProcessing = true;
                    
                    if (html5QrcodeScanner) html5QrcodeScanner.pause(true); // pause camera temporarily visually
                    document.getElementById('scannerStatusTitle').innerText = 'Procesando...';
                    
                    try {
                        let res = await fetch('{{ route('visits.store') }}', {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 
                                'Accept': 'application/json' 
                            },
                            body: JSON.stringify({ standId: {{ $stand->id }}, participantId: participantId })
                        });
                        let data = await res.json();
                        
                        if(data.success && data.participantId) {    
                            // Lanzar Modal
                            this.scanParticipantId = data.participantId;
                            this.scanParticipantName = data.participantName ? data.participantName : ('Visitante ID: ' + data.participantId);
                            this.rating = 0;
                            this.hoverRating = 0;
                            this.surveyModal = true;
                            document.getElementById('scannerStatusTitle').innerText = 'Visita Registrada';
                        } else {
                            this.triggerToast(data.error || data.message || 'Error del sistema', 'error');
                            this.resumeScanner();
                        }
                    } catch(e) {
                        this.triggerToast('Error de conexión', 'error');
                        this.resumeScanner();
                    }
                    this.isProcessing = false;
                },

                async submitSurvey() {
                    if(this.rating < 1 || this.rating > 5 || this.isProcessing) return;
                    this.isProcessing = true;
                    
                    try {
                        let res = await fetch('{{ route('surveys.store') }}', {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 
                                'Accept': 'application/json' 
                            },
                            body: JSON.stringify({ standId: {{ $stand->id }}, participantId: this.scanParticipantId, rating: this.rating })
                        });
                        let data = await res.json();
                        
                        this.surveyModal = false;
                        this.triggerToast('¡Encuesta enviada exitosamente!');
                        this.resumeScanner();
                    } catch(e) {
                        this.triggerToast('Error enviando encuesta', 'error');
                        this.resumeScanner();
                    }
                    this.isProcessing = false;
                },

                skipSurvey() {
                    this.surveyModal = false;
                    this.triggerToast('Visita registrada (Encuesta Omitida)');
                    this.resumeScanner();
                },

                triggerToast(msg, type='success') {
                    this.toastMsg = msg;
                    this.toastType = type;
                    this.showToast = true;
                    setTimeout(() => { this.showToast = false; }, 3500);
                },

                resumeScanner() {
                    setTimeout(() => {
                        document.getElementById('scannerStatusTitle').innerText = 'Listo para escanear';
                        if (html5QrcodeScanner && html5QrcodeScanner.getState() === 3) {
                            html5QrcodeScanner.resume(); // reactivar
                        } else if (html5QrcodeScanner) {
                            html5QrcodeScanner.clear(); // forzar limpieza
                            this.startScannerDOM();
                        }
                    }, 500);
                },

                startScannerDOM() {
                    if (html5QrcodeScanner) {
                        try { html5QrcodeScanner.clear(); } catch(e){}
                    }
                    html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: {width: 250, height: 250}, aspectRatio: 1.0 }, false);
                    html5QrcodeScanner.render((decodedText) => {
                        if (html5QrcodeScanner.getState() !== 2) return;
                        window.dispatchEvent(new CustomEvent('scan-success', { detail: decodedText }));
                    });
                }
            }
        }
    </script>
</x-stand-layout>
