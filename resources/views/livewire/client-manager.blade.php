<div>
    <h1>Manage Clients</h1>

    <!-- Formulario para agregar o editar un cliente -->
    <form wire:submit.prevent="saveClient">
        <select wire:model="user_id" required>
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <input type="text" wire:model="phone_number" placeholder="Phone Number" required>
        <input type="text" wire:model="address" placeholder="Address">
        <button type="submit">{{ $selectedClientId ? 'Update Client' : 'Add Client' }}</button>
    </form>

    <!-- Listado de clientes -->
    <ul>
        @foreach ($clients as $client)
            <li>
                User: {{ $client->user->name }} - Phone: {{ $client->phone_number }}
                <button wire:click="editClient({{ $client->id }})">Edit</button>
                <button wire:click="deleteClient({{ $client->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>

