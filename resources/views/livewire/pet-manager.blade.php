<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Pets</h1>

    <!-- Formulario para agregar o editar una mascota -->
    <form wire:submit.prevent="savePet" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Campo de búsqueda de propietarios -->
            @role('Administrador|Veterinario|Empleado')
            <div class="relative">
                <input type="text" wire:model.lazy="searchOwnerTerm" class="input-field" placeholder="Search Owner..." required>
                @if(!empty($ownerSuggestions))
                    <ul class="absolute bg-white border border-gray-300 w-full z-10">
                        @foreach($ownerSuggestions as $owner)
                            <li 
                                wire:click="selectOwner({{ $owner->id }})" 
                                class="cursor-pointer p-2 hover:bg-gray-200"
                            >
                                {{ $owner->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            @endrole
            <input type="text" wire:model="name" class="input-field" placeholder="Name" required> 
            <input type="text" wire:model="species" class="input-field" placeholder="Species" required>
            <input type="text" wire:model="breed" class="input-field" placeholder="Breed">
            <input type="date" wire:model="birthdate" class="input-field" placeholder="Birthdate">
            <textarea wire:model="medical_conditions" class="input-field" placeholder="Medical Conditions"></textarea>
        </div>
        <div class="flex justify-start mt-4">
            <button type="submit" class="cta-button">{{ $selectedPetId ? 'Update Pet' : 'Add Pet' }}</button>
        </div>
    </form>

    <!-- Campo de búsqueda de mascotas -->
    <div class="mt-6">
        <input 
            type="text" 
            wire:model.lazy="searchPetTerm" 
            class="input-field" 
            placeholder="Search by pet name..."
        />
    </div>

        <!-- Listado de mascotas -->
        <div class="mt-6">
            <ul class="space-y-4">
                @foreach ($pets as $pet)
                    <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                        <div>
                            <p class="text-lg font-semibold">{{ $pet->name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $pet->species }} - {{ $pet->breed }}
                                @role('Administrador|Empleado')
                                - Owner: {{ $pet->owner->name }}
                                @endrole
                            </p>
                        </div>
                        <div class="flex space-x-4">
                            <button wire:click="editPet({{ $pet->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                            @role('Administrador|Empleado|Veterinario')
                            <button wire:click="deletePet({{ $pet->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                            @endrole
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
</div>
