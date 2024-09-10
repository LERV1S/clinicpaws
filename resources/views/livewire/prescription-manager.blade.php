<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Prescriptions</h1>

        <!-- Formulario para agregar o editar una prescripción -->
        <form wire:submit.prevent="savePrescription" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <input type="date" wire:model="date" class="input-field" required>

                <!-- Autocompletar de mascota -->
                <div class="relative">
                    <input type="text" wire:model.lazy="searchPetTerm" class="input-field" placeholder="Search Pet..." required>
                    @if(!empty($petSuggestions))
                        <ul class="absolute bg-white border border-gray-300 w-full z-10">
                            @foreach($petSuggestions as $pet)
                                <li wire:click="selectPet({{ $pet->id }})" class="cursor-pointer p-2 hover:bg-gray-200">
                                    {{ $pet->name }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <select wire:model="veterinarian_id" class="input-field" required>
                    <option value="">Select Veterinarian</option>
                    @foreach($veterinarians as $vet)
                        <option value="{{ $vet->id }}">{{ $vet->user->name }}</option>
                    @endforeach
                </select>

                <input type="text" wire:model="medicine_name" class="input-field" placeholder="Medicine Name" required>
                <input type="text" wire:model="dosage" class="input-field" placeholder="Dosage" required>
                <textarea wire:model="instructions" class="input-field" placeholder="Instructions"></textarea>
            </div>

            <div class="flex justify-start mt-4">
                <button type="submit" class="cta-button">
                    {{ $selectedPrescriptionId ? 'Update Prescription' : 'Add Prescription' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Buscador para filtrar prescripciones por nombre de mascota -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
        <input 
            type="text" 
            wire:model.lazy="searchTerm" 
            class="input-field" 
            placeholder="Search by pet name..." 
        />
    </div>

    <!-- Listado de prescripciones -->
    <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Prescription List</h2>
        <ul class="space-y-4">
            @foreach ($prescriptions as $prescription)
                <li class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Date: {{ $prescription->date }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Medicine: {{ $prescription->medicine_name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pet: {{ $prescription->pet->name }} - Vet: {{ $prescription->veterinarian->user->name }}</p>
                    </div>
                    <div class="flex space-x-4">
                        <button wire:click="editPrescription({{ $prescription->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                        <button wire:click="deletePrescription({{ $prescription->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                        <a href="{{ route('prescriptions.download', $prescription->id) }}" class="cta-button bg-green-500 hover:bg-green-600">Download PDF</a>

                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
