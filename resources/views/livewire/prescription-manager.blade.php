<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Gestion de Recetas</h1>

        <!-- Formulario para agregar o editar una prescripción -->
        <form wire:submit.prevent="savePrescription" class="space-y-4">
            @role('Administrador|Veterinario|Empleado')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <input type="date" wire:model="date" class="input-field" required>

                <!-- Autocompletar de mascota -->
                <div class="relative">
                    <input type="text" wire:model.lazy="searchPetTerm" class="input-field" placeholder="Buscar mascota..." required>
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
                    <option value="">Seleccionar Veterinario</option>
                    @foreach($veterinarians as $vet)
                        <option value="{{ $vet->id }}">{{ $vet->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Medicinas -->
            <div class="mt-4">
                <h2 class="text-lg font-semibold dark:text-white">Seleccionar Medicinas</h2>
                @foreach($medicines as $index => $medicine)
                    <div class="flex items-center gap-4 mt-2">
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                wire:model.lazy="searchMedicineTerms.{{ $index }}" 
                                class="input-field" 
                                placeholder="Buscar o añadir medicinas..." 
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
                        
                        <input type="text" wire:model="medicines.{{ $index }}.dosage" placeholder="Dosis" class="input-field flex-1" required>
                        <textarea wire:model="medicines.{{ $index }}.instructions" placeholder="Instrucciones" class="input-field flex-1"></textarea>

                        <!-- Remover medicina con ícono "X" al final de la fila -->
                        <span class="cursor-pointer text-red-500 text-2xl ml-4" wire:click="removeMedicine({{ $index }})">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                @endforeach
                <button type="button" wire:click="addMedicine" class="cta-button bg-blue-500 mt-4">añadir otra medicina</button>
            </div>

            <div class="flex justify-start mt-4">
                <button type="submit" class="cta-button">
                    {{ $selectedPrescriptionId ? 'Actualizar receta' : 'añadir receta' }}
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
                placeholder="Buscar por nombre de mascota..." 
            />
        </div>

        <!-- Listado de prescripciones -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Lista de recetas</h2>
            <ul class="space-y-4">
                @foreach ($prescriptions as $prescription)
                    <li class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                        <div>

                            <p class="text-lg font-semibold">Fecha: {{ $prescription->date }}</p>
                            @foreach ($prescription->medicines as $medicine)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Medicina: {{ $medicine->name }} - Dosis: {{ $medicine->pivot->dosage }} - Instrucciones: {{ $medicine->pivot->instructions }}
                                </p>
                            @endforeach
                            <p class="text-sm text-gray-600 dark:text-gray-400">Mascota: {{ $prescription->pet->name }} - Vet: {{ $prescription->veterinarian->user->name }}</p>
                        </div>
                        <div class="flex space-x-4">
                            @role('Administrador|Empleado|Veterinario')

                            <button wire:click="editPrescription({{ $prescription->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Editar</button>
                            <button wire:click="deletePrescription({{ $prescription->id }})" class="cta-button bg-red-500 hover:bg-red-600">Borrar</button>

                            @endrole

                            <a href="{{ route('prescriptions.download', $prescription->id) }}" target="_blank" class="cta-button bg-green-500 hover:bg-green-600">Descargar Receta</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
