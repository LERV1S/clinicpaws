<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Appointments</h1>

    <!-- Formulario para agregar o editar una cita -->
    <form wire:submit.prevent="saveAppointment" class="space-y-4">
        <!-- Agrupación de inputs en una grid de 3 columnas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Campo de búsqueda de mascotas (dentro del formulario para seleccionar una mascota) -->
            <div class="relative">
                <input type="text" wire:model.lazy="searchPetTerm" class="input-field" placeholder="Search Pet..." required>
                @if(!empty($petSuggestions))
                    <ul class="absolute bg-white border border-gray-300 w-full z-10">
                        @foreach($petSuggestions as $pet)
                            <li 
                                wire:click="selectPet({{ $pet->id }})" 
                                class="cursor-pointer p-2 hover:bg-gray-200"
                            >
                                {{ $pet->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Select de veterinario -->
            <div>
                <select wire:model="veterinarian_id" class="input-field" required>
                    <option value="">Select Veterinarian</option>
                    @foreach($veterinarians as $vet)
                        <option value="{{ $vet->id }}">
                            {{ $vet->user ? $vet->user->name : 'User not found' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo de fecha de cita -->
            <div>
                <input type="datetime-local" wire:model="appointment_date" class="input-field" required>
            </div>

            <!-- Campo de estado -->
            <div>
                <input type="text" wire:model="status" class="input-field" placeholder="Status" required>
            </div>

            <!-- Campo de notas -->
            <div class="col-span-3">
                <textarea wire:model="notes" class="input-field" placeholder="Notes"></textarea>
            </div>
        </div>

        <div class="flex justify-start mt-4">
            <button type="submit" class="cta-button">{{ $selectedAppointmentId ? 'Update Appointment' : 'Add Appointment' }}</button>
        </div>
    </form>

    <!-- Campo de búsqueda para filtrar citas por nombre de mascota -->
    <div class="mt-6">
        <input 
            type="text" 
            wire:model.lazy="searchPetTerm" 
            class="input-field" 
            placeholder="Search by pet name..."
        />
    </div>

    <!-- Listado de citas -->
    <div class="mt-6">
        <ul class="space-y-4">
            @foreach ($appointments as $appointment)
            <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold">Pet: {{ $appointment->pet->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Veterinarian: {{ $appointment->veterinarian && $appointment->veterinarian->user ? $appointment->veterinarian->user->name : 'No Veterinarian Assigned' }} - Date: {{ $appointment->appointment_date }}
                    </p>
                </div>
                <div class="flex space-x-4">
                    <button wire:click="editAppointment({{ $appointment->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                    <button wire:click="deleteAppointment({{ $appointment->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
