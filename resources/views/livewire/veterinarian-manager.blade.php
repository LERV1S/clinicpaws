<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Veterinarians</h1>

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
