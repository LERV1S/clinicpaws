<div>
<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Gestion de Facturas</h1>
    <!-- Formulario para agregar o editar una factura -->
    <form wire:submit.prevent="saveInvoice" class="space-y-4">
        @role('Administrador|Empleado|Veterinario')

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <!-- Autocompletar para seleccionar cliente -->
            <div class="relative">
                <input
                    type="text"
                    wire:model.lazy="searchClientTerm"
                    class="input-field"
                    placeholder="Buscar Cliente..."
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

            <input type="text" wire:model="status" class="input-field" placeholder="Estatus" required>
            @endrole

        </div>


        <!-- Inventario para las facturas -->
        <div class="mt-4">
            @role('Administrador|Empleado|Veterinario')

            <h2 class="text-lg font-semibold dark:text-white">Seleccionar objetos del inventario</h2>
            @foreach($inventoryItems as $index => $item)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                    <select wire:model="inventoryItems.{{ $index }}.inventory_id" class="input-field" required>
                        <option value="">Seleccionar objeto inventario</option>
                        @foreach($inventories as $inventory)
                            <option value="{{ $inventory->id }}">{{ $inventory->item_name }}</option>
                        @endforeach
                    </select>

                    <input type="number" wire:model="inventoryItems.{{ $index }}.quantity" placeholder="Cantidad" class="input-field" required>

                    @role('Administrador|Empleado')

                        <button type="button" wire:click="removeInventoryItem({{ $index }})" class="cta-button bg-red-500 hover:bg-red-600">Remover</button>

                    @endrole
                </div>
            @endforeach
            @endrole

            @role('Administrador|Empleado')

                <button type="button" wire:click="addInventoryItem" class="cta-button bg-blue-500 hover:bg-blue-600 mt-4">Añadir otro objeto</button>

        </div>

        <div class="flex justify-start mt-4">


                <button type="submit" class="cta-button">{{ $selectedInvoiceId ? 'Actualizar factura' : 'Añadir factura' }}</button>

            
        </div>
    </form>

    <!-- Campo de búsqueda para filtrar facturas por nombre de cliente -->
    <div class="mt-6">
        <input
            type="text"
            wire:model.lazy="searchTerm"
            class="input-field"
            placeholder="Buscar por nombre de cliente..."
        />
    </div>
    @endrole

    <!-- Campo de búsqueda para filtrar facturas por estatus -->

    <div class="mt-6">
        <label for="filterStatus" class="block text-gray-700 dark:text-white">Filtrar por Estatus:</label>
        <select wire:model.lazy="filterStatus" id="filterStatus" class="input-field mt-2">
            <option value="">Todos</option>
            <option value="Pending">Pendientte</option>
            <option value="Paid">Pagado</option>
        </select>
    </div>
    
    <!-- Listado de facturas -->
    <div class="mt-6">
        <ul class="space-y-4">
            @foreach ($invoices as $invoice)
                <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Clinete: {{ $invoice->client->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total  con IVA: ${{ $invoice->total_amount }} - Estatus: {{ $invoice->status }}</p>
                        <!-- Listado de items del inventario -->
                        @if ($invoice->inventories->isNotEmpty())
                            <h4 class="mt-4 font-semibold text-lg">Objetos del inventario:</h4>
                            <ul class="list-disc list-inside">
                                @foreach ($invoice->inventories as $inventory)
                                    @php
                                        $totalItemPrice = $inventory->price * $inventory->pivot->quantity;
                                    @endphp
                                    <li class="text-gray-400">{{ $inventory->item_name }} - Cantidad: {{ $inventory->pivot->quantity }} - Precio por objeto: ${{ number_format($inventory->price, 2) }} - Total: ${{ number_format($totalItemPrice, 2) }}</li>
                                @endforeach
                            </ul>
                            @php
                                $totalInvoicePrice = $invoice->inventories->sum(function ($inventory) {
                                    return $inventory->price * $inventory->pivot->quantity;
                                });
                            @endphp
                            <p class="mt-4 font-bold text-lg">Total: ${{ number_format($totalInvoicePrice, 2) }}</p>
                        @endif
                    </div>

                    <div class="flex space-x-4">

                        @role('Administrador|Empleado')

                            <button wire:click="editInvoice({{ $invoice->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Editar</button>
                            <button wire:click="deleteInvoice({{ $invoice->id }})" class="cta-button bg-red-500 hover:bg-red-600">Borrar</button>

                        @endrole

                        <a href="{{ route('invoices.download', $invoice->id) }}" target="_blank" class="cta-button bg-green-500 hover:bg-green-600">Descargar Factura</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
</div>
