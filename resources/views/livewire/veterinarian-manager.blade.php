<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Gestion de Veterinarios</h1>

        <!-- Mostrar mensajes de éxito o error -->
        @if (session()->has('message'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulario para agregar o editar un veterinario -->
        <form wire:submit.prevent="saveVeterinarian" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Autocompletar de usuario -->
                <div class="relative">
                    <input type="text" wire:model.lazy="searchUserTerm" class="input-field" placeholder="Bucar Usuario..." required>
                    @if(!empty($userSuggestions))
                        <ul class="absolute bg-white border border-gray-300 w-full z-10">
                            @foreach($userSuggestions as $user)
                                <li wire:click="selectUser({{ $user->id }})" class="cursor-pointer p-2 hover:bg-gray-200">
                                    {{ $user->name }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <input type="text" wire:model="specialty" class="input-field" placeholder="Especialidad">
                <input type="text" wire:model="license_number" class="input-field" placeholder="Numero de Licencia" required>
            </div>

            <!-- Agregar días de trabajo -->
            <div class="mt-4">
                <h3 class="font-semibold dark:text-white">Horario de Trabajo</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2 dark:text-white">
                    <label><input type="checkbox" wire:model="works_on_monday"> Trabaja en lunes</label>
                    <label><input type="checkbox" wire:model="works_on_tuesday"> Trabaja en Martes</label>
                    <label><input type="checkbox" wire:model="works_on_wednesday"> Trabaja en Miercoles</label>
                    <label><input type="checkbox" wire:model="works_on_thursday"> Trabaja en Jueves</label>
                    <label><input type="checkbox" wire:model="works_on_friday"> Trabaja en Viernes</label>
                    <label><input type="checkbox" wire:model="works_on_saturday"> Trabaja en on Sabado</label>
                    <label><input type="checkbox" wire:model="works_on_sunday"> Trabaja en Domingo</label>
                </div>
            </div>

            <div class="flex justify-start mt-4">
                <button type="submit" class="cta-button">
                    {{ $selectedVeterinarianId ? 'actualizar veterinario' : 'añadir veterinario' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Buscador para filtrar veterinarios por nombre de usuario -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
        <input 
            type="text" 
            wire:model.lazy="searchVeterinarianTerm" 
            class="input-field" 
            placeholder="Buscar Veterinario..." 
        />
    </div>

    <!-- Listado de veterinarios -->
    <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Lista de Veterinarios</h2>
        <ul class="space-y-4">
            @foreach ($veterinarians as $vet)
                <li class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Usuario: {{ $vet->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Licencia: {{ $vet->license_number }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Horario: 
                            {{ $vet->works_on_monday ? 'Lunes ' : '' }}
                            {{ $vet->works_on_tuesday ? 'Martes ' : '' }}
                            {{ $vet->works_on_wednesday ? 'Miercoles' : '' }}
                            {{ $vet->works_on_thursday ? 'Jueves ' : '' }}
                            {{ $vet->works_on_friday ? 'Viernes ' : '' }}
                            {{ $vet->works_on_saturday ? 'Sabado ' : '' }}
                            {{ $vet->works_on_sunday ? 'Domingo ' : '' }}
                        </p>
                    </div>
                    <div class="flex space-x-4">
                        <button wire:click="editVeterinarian({{ $vet->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">editar</button>
                        <button wire:click="deleteVeterinarian({{ $vet->id }})" class="cta-button bg-red-500 hover:bg-red-600">Borrar</button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
