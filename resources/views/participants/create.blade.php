<x-guest-layout>
    <form method="POST" action="{{ route('participants.store') }}" class="space-y-4">
        @csrf
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-600">Registro a la Feria</h2>
            <p class="text-gray-500 text-sm mt-1">Ingresa tus datos para obtener tu código QR de acceso.</p>
        </div>

        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="paternalLastName" :value="__('Apellido Paterno')" />
            <x-text-input id="paternalLastName" class="block mt-1 w-full" type="text" name="paternalLastName" :value="old('paternalLastName')" required />
        </div>

        <div>
            <x-input-label for="maternalLastName" :value="__('Apellido Materno')" />
            <x-text-input id="maternalLastName" class="block mt-1 w-full" type="text" name="maternalLastName" :value="old('maternalLastName')" required />
        </div>

        <div>
             <x-input-label for="email" :value="__('Email')" />
             <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
             <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                 <x-input-label for="city" :value="__('Ciudad')" />
                 <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" required />
            </div>
            <div>
                 <x-input-label for="municipality" :value="__('Municipio')" />
                 <x-text-input id="municipality" class="block mt-1 w-full" type="text" name="municipality" required />
            </div>
        </div>

        <div>
             <x-input-label for="sex" :value="__('Sexo')" />
             <select id="sex" name="sex" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
                <option value="O">Otro</option>
             </select>
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center text-lg py-3">
                {{ __('Registrarme') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
