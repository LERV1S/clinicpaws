<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Inventory;

class InventoryManager extends Component
{
    public $inventories;
    public $item_name, $quantity, $unit;
    public $selectedInventoryId;

    public function mount()
    {
        $this->inventories = Inventory::all();
    }

    public function saveInventory()
    {
        $this->validate([
            'item_name' => 'required',
            'quantity' => 'required|integer',
            'unit' => 'required',
        ]);

        if ($this->selectedInventoryId) {
            $inventory = Inventory::find($this->selectedInventoryId);
            $inventory->update([
                'item_name' => $this->item_name,
                'quantity' => $this->quantity,
                'unit' => $this->unit,
            ]);
        } else {
            Inventory::create([
                'item_name' => $this->item_name,
                'quantity' => $this->quantity,
                'unit' => $this->unit,
            ]);
        }

        $this->resetInputFields();
        $this->inventories = Inventory::all();
    }

    public function editInventory($id)
    {
        $inventory = Inventory::find($id);
        $this->selectedInventoryId = $inventory->id;
        $this->item_name = $inventory->item_name;
        $this->quantity = $inventory->quantity;
        $this->unit = $inventory->unit;
    }

    public function deleteInventory($id)
    {
        Inventory::find($id)->delete();
        $this->inventories = Inventory::all();
    }

    private function resetInputFields()
    {
        $this->item_name = '';
        $this->quantity = '';
        $this->unit = '';
        $this->selectedInventoryId = null;
    }

    public function render()
    {
        return view('livewire.inventory-manager');
    }
}
