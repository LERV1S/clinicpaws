<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Medicines</h1>

        <!-- Formulario para agregar o editar una medicina -->
        <form wire:submit.prevent="saveMedicine" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <input type="text" wire:model="name" class="input-field" placeholder="Medicine Name" required>
                <input type="text" wire:model="dosage" class="input-field" placeholder="Dosage">
                <textarea wire:model="instructions" class="input-field" placeholder="Instructions"></textarea>
            </div>

            <div class="flex justify-start mt-4">
                <button type="submit" class="cta-button">{{ $selectedMedicineId ? 'Update Medicine' : 'Add Medicine' }}</button>
            </div>
        </form>
    </div>

    <!-- Listado de Medicinas -->
    <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Medicines List</h2>
        <ul class="space-y-4">
            @foreach ($medicines as $medicine)
                <li class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Name: {{ $medicine->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Dosage: {{ $medicine->dosage }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Instructions: {{ $medicine->instructions }}</p>
                    </div>
                    <div class="flex space-x-4">
                        <button wire:click="editMedicine({{ $medicine->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                        <button wire:click="deleteMedicine({{ $medicine->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
