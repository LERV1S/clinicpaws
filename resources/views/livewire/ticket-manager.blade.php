<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Tickets</h1>

    <!-- Formulario para agregar o editar un ticket -->
    <form wire:submit.prevent="saveTicket" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <select wire:model="client_id" class="input-field" required>
                <option value="">Select Client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->user->name }}</option>
                @endforeach
            </select>

            <input type="text" wire:model="subject" class="input-field" placeholder="Subject" required>

            <textarea wire:model="description" class="input-field" placeholder="Description" required></textarea>

            <select wire:model="status" class="input-field" required>
                <option value="">Select Status</option>
                <option value="Pagado">Pagado</option>
                <option value="En adeudo">En adeudo</option>
            </select>
        </div>
        <div class="flex justify-start mt-4">
            <button type="submit" class="cta-button">{{ $selectedTicketId ? 'Update Ticket' : 'Add Ticket' }}</button>
        </div>
    </form>

    <!-- Listado de tickets -->
    <div class="mt-6">
        <ul class="space-y-4">
            @foreach ($tickets as $ticket)
                <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Client: {{ $ticket->client->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Subject: {{ $ticket->subject }} - Status: {{ $ticket->status }}</p>
                    </div>
                    <div class="flex space-x-4">
                        <button wire:click="editTicket({{ $ticket->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                        <button wire:click="deleteTicket({{ $ticket->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                        <a href="{{ route('tickets.download', $ticket->id) }}" class="cta-button bg-green-500 hover:bg-green-600">Download PDF</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
