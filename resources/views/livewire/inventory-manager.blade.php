<div>
    <h1>Manage Inventory</h1>

    <!-- Formulario para agregar o editar un item de inventario -->
    <form wire:submit.prevent="saveInventory">
        <input type="text" wire:model="item_name" placeholder="Item Name" required>
        <input type="number" wire:model="quantity" placeholder="Quantity" required>
        <input type="text" wire:model="unit" placeholder="Unit" required>
        <button type="submit">{{ $selectedInventoryId ? 'Update Item' : 'Add Item' }}</button>
    </form>

    <!-- Listado de inventario -->
    <ul>
        @foreach ($inventories as $inventory)
            <li>
                Item: {{ $inventory->item_name }} - Quantity: {{ $inventory->quantity }} - Unit: {{ $inventory->unit }}
                <button wire:click="editInventory({{ $inventory->id }})">Edit</button>
                <button wire:click="deleteInventory({{ $inventory->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
