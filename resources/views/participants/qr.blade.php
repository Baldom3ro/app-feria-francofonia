<x-guest-layout>
    <div class="text-center space-y-6 p-6">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mb-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900">¡Registro Exitoso!</h2>
        <p class="text-gray-600 text-lg">Hola <strong>{{ $participant->name }}</strong>, este es tu código QR de acceso a la feria.</p>
        
        <div class="flex justify-center my-8">
            <div class="p-4 bg-white rounded-2xl shadow-xl border-4 border-indigo-50">
                <!-- Data simply contains the Participant ID for fast scanning lookup -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $participant->id }}&margin=10" alt="QR Code" class="w-64 h-64">
            </div>
        </div>
        
        <div class="bg-blue-50 text-blue-800 p-4 rounded-lg text-sm font-medium">
            Toma una captura de pantalla de este código. Muéstralo en los stands para registrar tu visita.
        </div>
        
        <div class="pt-6 border-t border-gray-100">
            <a href="{{ route('participants.create') }}" class="text-indigo-600 hover:text-indigo-800 font-bold transition">Registrar un nuevo participante &rarr;</a>
            <div class="mt-4">
                <a href="{{ url('/') }}" class="text-gray-400 hover:text-gray-600 text-xs text-underline">Ir al inicio de sesión (Staff)</a>
            </div>
        </div>
    </div>
</x-guest-layout>
