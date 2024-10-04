<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Prescriptions</h1>

        <!-- Formulario para agregar o editar una prescripción -->
        <form wire:submit.prevent="savePrescription" class="space-y-4">
            @role('Administrador|Veterinario|Empleado')
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
            </div>

            <!-- Medicinas -->
            <div class="mt-4">
                <h2 class="text-lg font-semibold dark:text-white">Select Medicines</h2>
                @foreach($medicines as $index => $medicine)
                    <div class="flex items-center gap-4 mt-2">
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                wire:model.lazy="searchMedicineTerms.{{ $index }}" 
                                class="input-field" 
                                placeholder="Search or add medicine..." 
                                required
                            >
                            @if(!empty($medicineSuggestions[$index]))
                                <ul class="absolute bg-white border border-gray-300 w-full z-10">
                                    @foreach($medicineSuggestions[$index] as $suggestion)
                                        <li 
                                            wire:click="selectMedicine({{ $suggestion->id }}, {{ $index }})" 
                                            class="cursor-pointer p-2 hover:bg-gray-200"
                                        >
                                            {{ $suggestion->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        
                        <input type="text" wire:model="medicines.{{ $index }}.dosage" placeholder="Dosage" class="input-field flex-1" required>
                        <textarea wire:model="medicines.{{ $index }}.instructions" placeholder="Instructions" class="input-field flex-1"></textarea>

                        <!-- Remover medicina con ícono "X" al final de la fila -->
                        <span class="cursor-pointer text-red-500 text-2xl ml-4" wire:click="removeMedicine({{ $index }})">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                @endforeach
                <button type="button" wire:click="addMedicine" class="cta-button bg-blue-500 mt-4">Add Another Medicine</button>
            </div>

            <div class="flex justify-start mt-4">
                <button type="submit" class="cta-button">
                    {{ $selectedPrescriptionId ? 'Update Prescription' : 'Add Prescription' }}
                </button>
            </div>
            @endrole
        </form>

        <!-- Buscador para filtrar prescripciones por nombre de mascota -->
        <div class="mt-6">
            <input 
                type="text" 
                wire:model.lazy="searchTerm" 
                class="input-field" 
                placeholder="Search by pet name..." 
            />
        </div>

        <!-- Listado de prescripciones -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Prescription List</h2>
            <ul class="space-y-4">
                @foreach ($prescriptions as $prescription)
                    <li class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                        <div>
                            <p class="text-lg font-semibold">Date: {{ $prescription->date }}</p>
                            @foreach ($prescription->medicines as $medicine)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Medicine: {{ $medicine->name }} - Dosage: {{ $medicine->pivot->dosage }} - Instructions: {{ $medicine->pivot->instructions }}
                                </p>
                            @endforeach
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pet: {{ $prescription->pet->name }} - Vet: {{ $prescription->veterinarian->user->name }}</p>
                        </div>
                        <div class="flex space-x-4">
                            @role('Administrador|Empleado|Veterinario')

                            <button wire:click="editPrescription({{ $prescription->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                            <button wire:click="deletePrescription({{ $prescription->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>

                            @endrole

                            <a href="{{ route('prescriptions.download', $prescription->id) }}" target="_blank" class="cta-button bg-green-500 hover:bg-green-600">Download Prescription</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
