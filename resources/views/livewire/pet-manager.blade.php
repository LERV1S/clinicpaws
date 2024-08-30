<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <h1>Manage Pets</h1>

    <!-- Formulario para agregar o editar una mascota -->
    <form wire:submit.prevent="savePet">
        <input type="text" wire:model="name" placeholder="Name" required>
        <input type="text" wire:model="species" placeholder="Species" required>
        <input type="text" wire:model="breed" placeholder="Breed">
        <input type="date" wire:model="birthdate" placeholder="Birthdate">
        <textarea wire:model="medical_conditions" placeholder="Medical Conditions"></textarea>
        <button type="submit">{{ $selectedPetId ? 'Update Pet' : 'Add Pet' }}</button>
    </form>

    <!-- Listado de mascotas -->
    <ul>
        @foreach ($pets as $pet)
            <li>
                {{ $pet->name }} - {{ $pet->species }} - {{ $pet->breed }}
                <button wire:click="editPet({{ $pet->id }})">Edit</button>
                <button wire:click="deletePet({{ $pet->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
