<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Veterinarians</h1>

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
                    <input type="text" wire:model.lazy="searchUserTerm" class="input-field" placeholder="Search User..." required>
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

                <input type="text" wire:model="specialty" class="input-field" placeholder="Specialty">
                <input type="text" wire:model="license_number" class="input-field" placeholder="License Number" required>
            </div>

            <!-- Agregar días de trabajo -->
            <div class="mt-4">
                <h3 class="font-semibold dark:text-white">Work Schedule</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2 dark:text-white">
                    <label><input type="checkbox" wire:model="works_on_monday">  Works on Monday</label>
                    <label><input type="checkbox" wire:model="works_on_tuesday">  Works on Tuesday</label>
                    <label><input type="checkbox" wire:model="works_on_wednesday">  Works on Wednesday</label>
                    <label><input type="checkbox" wire:model="works_on_thursday">  Works on Thursday</label>
                    <label><input type="checkbox" wire:model="works_on_friday">  Works on Friday</label>
                    <label><input type="checkbox" wire:model="works_on_saturday">  Works on Saturday</label>
                    <label><input type="checkbox" wire:model="works_on_sunday">  Works on Sunday</label>
                </div>
            </div>

            <div class="flex justify-start mt-4">
                <button type="submit" class="cta-button">
                    {{ $selectedVeterinarianId ? 'Update Veterinarian' : 'Add Veterinarian' }}
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
            placeholder="Search by veterinarian name..." 
        />
    </div>

    <!-- Listado de veterinarios -->
    <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Veterinarian List</h2>
        <ul class="space-y-4">
            @foreach ($veterinarians as $vet)
                <li class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">User: {{ $vet->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">License: {{ $vet->license_number }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Schedule: 
                            {{ $vet->works_on_monday ? 'Mon ' : '' }}
                            {{ $vet->works_on_tuesday ? 'Tue ' : '' }}
                            {{ $vet->works_on_wednesday ? 'Wed ' : '' }}
                            {{ $vet->works_on_thursday ? 'Thu ' : '' }}
                            {{ $vet->works_on_friday ? 'Fri ' : '' }}
                            {{ $vet->works_on_saturday ? 'Sat ' : '' }}
                            {{ $vet->works_on_sunday ? 'Sun ' : '' }}
                        </p>
                    </div>
                    <div class="flex space-x-4">
                        <button wire:click="editVeterinarian({{ $vet->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                        <button wire:click="deleteVeterinarian({{ $vet->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
