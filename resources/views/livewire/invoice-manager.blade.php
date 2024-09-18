<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Invoices</h1>

    <!-- Formulario para agregar o editar una factura -->
    <form wire:submit.prevent="saveInvoice" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Autocompletar para seleccionar cliente -->
            <div class="relative">
                <input 
                    type="text" 
                    wire:model.lazy="searchClientTerm" 
                    class="input-field" 
                    placeholder="Search Client..." 
                    required
                >
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
        
            <input type="text" wire:model="status" class="input-field" placeholder="Status" required>
        </div>
        

        <!-- Inventario para las facturas -->
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
            <button type="submit" class="cta-button">{{ $selectedInvoiceId ? 'Update Invoice' : 'Add Invoice' }}</button>
        </div>
    </form>

    <!-- Campo de búsqueda para filtrar facturas por nombre de cliente -->
    <div class="mt-6">
        <input 
            type="text" 
            wire:model.lazy="searchTerm" 
            class="input-field" 
            placeholder="Search by client name..."
        />
    </div>

    <!-- Listado de facturas -->
    <div class="mt-6">
        <ul class="space-y-4">
            @foreach ($invoices as $invoice)
                <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Client: {{ $invoice->client->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total  with IVA: ${{ $invoice->total_amount }} - Status: {{ $invoice->status }}</p>
                        <!-- Listado de items del inventario -->
                        @if ($invoice->inventories->isNotEmpty())
                            <h4 class="mt-4 font-semibold">Inventory Items:</h4>
                            <ul class="list-disc list-inside">
                                @foreach ($invoice->inventories as $inventory)
                                    @php
                                        $totalItemPrice = $inventory->price * $inventory->pivot->quantity;
                                    @endphp
                                    <li>{{ $inventory->item_name }} - Quantity: {{ $inventory->pivot->quantity }} - Price per item: ${{ number_format($inventory->price, 2) }} - Total: ${{ number_format($totalItemPrice, 2) }}</li>
                                @endforeach
                            </ul>
                            @php
                                $totalInvoicePrice = $invoice->inventories->sum(function ($inventory) {
                                    return $inventory->price * $inventory->pivot->quantity;
                                });
                            @endphp
                            <p class="mt-4 font-bold">Total: ${{ number_format($totalInvoicePrice, 2) }}</p>
                        @endif
                    </div>

                    <div class="flex space-x-4">
                        <button wire:click="editInvoice({{ $invoice->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                        <button wire:click="deleteInvoice({{ $invoice->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                        <a href="{{ route('invoices.download', $invoice->id) }}" class="cta-button bg-green-500 hover:bg-green-600">Download PDF</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
