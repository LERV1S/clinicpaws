<div>
    <h1>Manage Tickets</h1>

    <!-- Formulario para agregar o editar un ticket -->
    <form wire:submit.prevent="saveTicket">
        <select wire:model="client_id" required>
            <option value="">Select Client</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->user->name }}</option>
            @endforeach
        </select>

        <input type="text" wire:model="subject" placeholder="Subject" required>
        <textarea wire:model="description" placeholder="Description" required></textarea>
        <input type="text" wire:model="status" placeholder="Status" required>
        <button type="submit">{{ $selectedTicketId ? 'Update Ticket' : 'Add Ticket' }}</button>
    </form>

    <!-- Listado de tickets -->
    <ul>
        @foreach ($tickets as $ticket)
            <li>
                Client: {{ $ticket->client->user->name }} - Subject: {{ $ticket->subject }} - Status: {{ $ticket->status }}
                <button wire:click="editTicket({{ $ticket->id }})">Edit</button>
                <button wire:click="deleteTicket({{ $ticket->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
