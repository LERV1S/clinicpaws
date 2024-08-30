<div>
    <h1>Manage Veterinarians</h1>

    <!-- Formulario para agregar o editar un veterinario -->
    <form wire:submit.prevent="saveVeterinarian">
        <select wire:model="user_id" required>
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <input type="text" wire:model="specialty" placeholder="Specialty">
        <input type="text" wire:model="license_number" placeholder="License Number" required>
        <button type="submit">{{ $selectedVeterinarianId ? 'Update Veterinarian' : 'Add Veterinarian' }}</button>
    </form>

    <!-- Listado de veterinarios -->
    <ul>
        @foreach ($veterinarians as $vet)
            <li>
                User: {{ $vet->user->name }} - License: {{ $vet->license_number }}
                <button wire:click="editVeterinarian({{ $vet->id }})">Edit</button>
                <button wire:click="deleteVeterinarian({{ $vet->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
