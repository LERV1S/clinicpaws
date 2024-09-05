<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Tickets</h1>

    <!-- Formulario para agregar o editar un ticket -->
    <form wire:submit.prevent="saveTicket" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <select wire:model="client_id" class="input-field" required>
                <option value="">Select Client</option>
                @foreach(\App\Models\Client::all() as $client)
                    <option value="{{ $client->id }}">{{ $client->user->name }}</option>
                @endforeach
            </select>

            <input type="text" wire:model="subject" class="input-field" placeholder="Subject" required>
            <textarea wire:model="description" class="input-field" placeholder="Description" required></textarea>
            <select wire:model="status" class="input-field col-span-1" required>
                <option value="">Select Status</option>
                <option value="Pagado">Pagado</option>
                <option value="En adeudo">En adeudo</option>
            </select>
        </div>

        <!-- Inventario -->
        <div class="mt-4">
            <h2 class="text-lg font-semibold">Select Inventory Items</h2>
            @foreach($inventoryItems as $index => $item)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                    <select wire:model="inventoryItems.{{ $index }}.inventory_id" class="input-field" required>
                        <option value="">Select Inventory Item</option>
                        @foreach($inventories as $inventory)
                            <option value="{{ $inventory->id }}">{{ $inventory->item_name }}</option>
                        @endforeach
                    </select>

                    <input type="number" wire:model="inventoryItems.{{ $index }}.quantity" placeholder="Quantity" class="input-field" required>

                    <button type="button" wire:click="removeInventoryItem({{ $index }})" class="cta-button bg-red-500 hover:bg-red-600">Remove</button>
                </div>
            @endforeach

            <button type="button" wire:click="addInventoryItem" class="cta-button bg-blue-500 hover:bg-blue-600 mt-4">Add Another Item</button>
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

                        <!-- Listado de items del inventario -->
                        @if ($ticket->inventories->isNotEmpty())
                            <h4 class="mt-4 font-semibold">Inventory Items:</h4>
                            <ul class="list-disc list-inside">
                                @foreach ($ticket->inventories as $inventory)
                                    @php
                                        $totalItemPrice = $inventory->price * $inventory->pivot->quantity;
                                    @endphp
                                    <li>{{ $inventory->item_name }} - Quantity: {{ $inventory->pivot->quantity }} - Price per item: ${{ number_format($inventory->price, 2) }} - Total: ${{ number_format($totalItemPrice, 2) }}</li>
                                @endforeach
                            </ul>
                            @php
                                $totalTicketPrice = $ticket->inventories->sum(function ($inventory) {
                                    return $inventory->price * $inventory->pivot->quantity;
                                });
                            @endphp
                            <p class="mt-4 font-bold">Total: ${{ number_format($totalTicketPrice, 2) }}</p>
                        @endif
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
