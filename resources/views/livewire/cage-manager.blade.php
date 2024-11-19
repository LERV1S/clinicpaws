<div>
    <h1>Manage Cages</h1>

    <!-- Formulario para agregar o editar una jaula -->
    <form wire:submit.prevent="saveCage">
        <input type="text" wire:model="cage_number" placeholder="Cage Number" required>
        <input type="text" wire:model="size" placeholder="Size" required>
        <label>
            <input type="checkbox" wire:model="is_occupied"> Occupied
        </label>
        <button type="submit">{{ $selectedCageId ? 'Update Cage' : 'Add Cage' }}</button>
    </form>

    <!-- Listado de jaulas -->
    <ul>
        @foreach ($cages as $cage)
            <li>
                Number: {{ $cage->cage_number }} - Size: {{ $cage->size }} - Occupied: {{ $cage->is_occupied ? 'Yes' : 'No' }}
                <button wire:click="editCage({{ $cage->id }})">Edit</button>
                <button wire:click="deleteCage({{ $cage->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
