<div>
<div>

    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Tickets</h1>

    <!-- Formulario para agregar o editar un ticket -->
    <form wire:submit.prevent="saveTicket" class="space-y-4">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @role('Administrador|Empleado')

            <div class="relative">
                <input type="text" wire:model.lazy="searchClientTerm" class="input-field" placeholder="Search Client..." required>
                @if(!empty($clientSuggestions))
                    <ul class="absolute bg-white border border-gray-300 w-full z-10">
                        @foreach($clientSuggestions as $client)
                            <li
                                wire:click="selectClient({{ $client->id }})"
                                class="cursor-pointer p-2 hover:bg-gray-200"
                            >
                                {{ $client->user->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <input type="text" wire:model="subject" class="input-field" placeholder="Subject" required>
            <textarea wire:model="description" class="input-field" placeholder="Description" required></textarea>
            <select wire:model="status" class="input-field col-span-1" required>
                <option value="">Select Status</option>
                <option value="Pagado">Paid</option>
                <option value="En adeudo">Pending</option>
            </select>
        </div>

        <!-- Campo para generar factura -->
        <div class="mt-4">
            

                <label for="generateInvoice" class="flex items-center dark:text-white">
                    <input type="checkbox" wire:model="generateInvoice" id="generateInvoice" class="mr-2">
                    Generate Invoice for this ticket
                </label>

        </div>


        
        <!-- Inventario -->
        <div class="mt-4">

            <h2 class="text-lg font-semibold dark:text-white">Select Inventory Items</h2>
            @endrole



            @role('Administrador|Empleado')

            @foreach($inventoryItems as $index => $item)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                    <select wire:model="inventoryItems.{{ $index }}.inventory_id" class="input-field" required>
                        <option value="">Select Inventory Item</option>
                        @foreach($inventories as $inventory)
                            <option value="{{ $inventory->id }}">{{ $inventory->item_name }}</option>
                        @endforeach
                    </select>

                    <input type="number" wire:model="inventoryItems.{{ $index }}.quantity" placeholder="Quantity" class="input-field" required>
                    @if(($inventoryItems[$index]['inventory_id']) && $inventoryItems[$index]['quantity'] > $inventories->find($inventoryItems[$index]['inventory_id'])->quantity)
                        <p class="text-red-500">Not enough stock for {{ $inventories->find($inventoryItems[$index]['inventory_id'])->item_name }}</p>
                    @endif


                        <button type="button" wire:click="removeInventoryItem({{ $index }})" class="cta-button bg-red-500 hover:bg-red-600">Remove</button>

                </div>
            @endforeach
                                @endrole

            @role('Administrador|Empleado')

                <button type="button" wire:click="addInventoryItem" class="cta-button bg-blue-500 hover:bg-blue-600 mt-4">Add Another Item</button>

            @endrole
        </div>

        <div class="flex justify-start mt-4">
            @role('Administrador|Empleado')

                <button type="submit" class="cta-button">{{ $selectedTicketId ? 'Update Ticket' : 'Add Ticket' }}</button>

            @endrole
        </div>
    </form>

    <!-- Campo de búsqueda -->
    @role('Administrador|Empleado')

    <div class="mt-6">
        <label for="filterStatus" class="block text-gray-700 dark:text-white">Filter by Client :</label>

        <input
            type="text"
            wire:model.lazy="searchTicketTerm"
            class="input-field"
            placeholder="Search by client name..."
        />
    </div>
    @endrole
    @role('Cliente|Administrador|Empleado')

                    <!-- Filtro por status -->
                    <div class="mt-6">
                        <label for="filterStatus" class="block text-gray-700 dark:text-white">Filter by Status:</label>
                        <select wire:model.lazy="filterStatus" id="filterStatus" class="input-field mt-2">
                            <option value="">All</option>
                            <option value="Pagado">Pagado</option>
                            <option value="En adeudo">En adeudo</option>
                        </select>
                    </div>
                    @endrole

    <div class="mt-6">
        <ul class="space-y-4">
            @forelse ($tickets as $ticket)
                <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Client: {{ $ticket->client->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Subject: {{ $ticket->subject }} - Status: {{ $ticket->status }}</p>

                        <!-- Listado de items del inventario -->
                        @if ($ticket->inventories->isNotEmpty())
                            <h4 class="mt-4 font-semibold text-lg">Inventory Items:</h4>
                            <ul class="list-disc list-inside">
                                @php
                                    $totalTicketPrice = 0;
                                @endphp
                                @foreach ($ticket->inventories as $inventory)
                                    @php
                                        $itemPriceWithIVA = $inventory->price * 1.16;
                                        $totalItemPrice = $itemPriceWithIVA * $inventory->pivot->quantity;
                                        $totalTicketPrice += $totalItemPrice;
                                    @endphp
                                    <li class="text-gray-400">{{ $inventory->item_name }} - Quantity: {{ $inventory->pivot->quantity }} - Price per item: ${{ number_format($itemPriceWithIVA, 2) }} - Total: ${{ number_format($totalItemPrice, 2) }}</li>
                                @endforeach
                            </ul>
                            <p class="mt-4 font-bold text-lg">Total (IVA incl.): ${{ number_format($totalTicketPrice, 2) }}</p>
                        @endif
                    </div>

                    <div class="flex space-x-4">
                        <!-- Botones: Editar, Borrar, Descargar Ticket, Generar/Ver Factura -->
                        @role('Administrador|Empleado')

                            <button wire:click="editTicket({{ $ticket->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                            <button wire:click="deleteTicket({{ $ticket->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>

                        @endrole
                        <!-- Botón de descarga del ticket -->
                        <a href="{{ route('tickets.download', $ticket->id) }}" target="_blank" class="cta-button bg-green-500 hover:bg-green-600">Download Ticket</a>

                        <!-- Mostrar botón de factura si no tiene factura aún -->
                        @role('Administrador|Empleado')

                            @if (!$ticket->invoice)
                                <button wire:click="createInvoiceForTicket({{ $ticket->id }})" class="cta-button bg-blue-500 hover:bg-blue-600">Generate Invoice</button>
                            @else
                                <!-- Si ya tiene factura, mostrar el botón de ver factura -->
                                <a href="{{ route('invoices.download', $ticket->invoice->id) }}" target="_blank" class="cta-button bg-green-500 hover:bg-green-600">View Invoice</a>
                            @endif

                        @endrole
                    </div>


                </li>
            @empty
                <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                    <p class="text-gray-600 dark:text-gray-400">No tickets found.</p>
                </li>
            @endforelse
        </ul>
    </div>


</div>
</div>
