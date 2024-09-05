<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Inventory</h1>

    <!-- Formulario para agregar o editar un item de inventario -->
    <form wire:submit.prevent="saveInventory" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <input type="text" wire:model="item_name" class="input-field" placeholder="Item Name" required>
            <input type="number" wire:model="quantity" class="input-field" placeholder="Quantity" required>
            <input type="decimal" wire:model="price" class="input-field" placeholder="Price" required>
        </div>
        <div class="flex justify-start mt-4">
            <button type="submit" class="cta-button">{{ $selectedInventoryId ? 'Update Item' : 'Add Item' }}</button>
        </div>
    </form>

    <!-- Listado de inventario -->
    <div class="mt-6">
        <ul class="space-y-4">
        @if($inventories && $inventories->count() > 0)
            @foreach ($inventories as $inventory)
                    <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                        <div>
                            <p class="text-lg font-semibold">Item: {{ $inventory->item_name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Quantity: {{ $inventory->quantity }} - Price: ${{ $inventory->price }}</p>
                        </div>
                        <div class="flex space-x-4">
                            <button wire:click="editInventory({{ $inventory->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                            <button wire:click="deleteInventory({{ $inventory->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                        </div>
                    </li>
                @endforeach
            @else
                <p>No inventory items found.</p>
            @endif
        </ul>
    </div>
</div>
