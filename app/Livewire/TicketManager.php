<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Client;
use App\Models\Inventory;

class TicketManager extends Component
{
    public $tickets;
    public $client_id, $subject, $description, $status;
    public $selectedTicketId = null; // Asegúrate de que esté inicializado
    public $inventoryItems = [];
    public $inventories; // Para almacenar todos los items de inventario disponibles
    
    public function mount()
    {
        $this->tickets = Ticket::all();
        $this->inventories = Inventory::all(); // Cargar todos los items de inventario

    }
    
    public function addInventoryItem()
    {
        $this->inventoryItems[] = ['inventory_id' => '', 'quantity' => 1];
    }

     public function removeInventoryItem($index)
    {
        unset($this->inventoryItems[$index]);
        $this->inventoryItems = array_values($this->inventoryItems); // Reindexar el array
    }

    
    public function saveTicket()
    {
        $this->validate([
            'client_id' => 'required|exists:clients,id',
            'subject' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
            'inventoryItems.*.inventory_id' => 'required|exists:inventories,id',
            'inventoryItems.*.quantity' => 'required|integer|min:1',
        ]);

            foreach ($this->inventoryItems as $item) {
        $inventory = Inventory::find($item['inventory_id']);
        if ($inventory->quantity < $item['quantity']) {
            session()->flash('error', 'Not enough inventory for ' . $inventory->item_name);
            return;
        }
    }
    if ($this->selectedTicketId) {
        $ticket = Ticket::find($this->selectedTicketId);
        $ticket->update([
            'client_id' => $this->client_id,
            'subject' => $this->subject,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        // Restaurar las cantidades originales antes de sincronizar
        foreach ($ticket->inventories as $inventory) {
            $inventory->quantity += $inventory->pivot->quantity;
            $inventory->save();
        }

        // Sincronizar los items de inventario
        $ticket->inventories()->sync($this->formatInventoryItems());

        // Restar las nuevas cantidades del inventario
        foreach ($this->inventoryItems as $item) {
            $inventory = Inventory::find($item['inventory_id']);
            $inventory->quantity -= $item['quantity'];
            $inventory->save();
        }

    } else {
        $ticket = Ticket::create([
            'client_id' => $this->client_id,
            'subject' => $this->subject,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        // Asociar los items de inventario al nuevo ticket
        $ticket->inventories()->attach($this->formatInventoryItems());

        // Restar las cantidades del inventario
        foreach ($this->inventoryItems as $item) {
            $inventory = Inventory::find($item['inventory_id']);
            $inventory->quantity -= $item['quantity'];
            $inventory->save();
        }
    }

    $this->resetInputFields();
    $this->tickets = Ticket::all();
}

private function formatInventoryItems()
{
    $formattedItems = [];
    foreach ($this->inventoryItems as $item) {
        $formattedItems[$item['inventory_id']] = ['quantity' => $item['quantity']];
    }
    return $formattedItems;
}


public function editTicket($id)
{
    $ticket = Ticket::find($id);
    $this->selectedTicketId = $ticket->id;
    $this->client_id = $ticket->client_id;
    $this->subject = $ticket->subject;
    $this->description = $ticket->description;
    $this->status = $ticket->status;

    // Cargar los items de inventario asociados al ticket
    $this->inventoryItems = $ticket->inventories->map(function ($inventory) {
        return [
            'inventory_id' => $inventory->id,
            'quantity' => $inventory->pivot->quantity,
        ];
    })->toArray();
}
    public function deleteTicket($id)
    {
        Ticket::find($id)->delete();
        $this->tickets = Ticket::all();
    }

    private function resetInputFields()
    {
        $this->client_id = '';
        $this->subject = '';
        $this->description = '';
        $this->status = '';
        $this->inventoryItems = []; // Resetear items de inventario
        $this->selectedTicketId = null;
    }

    public function render()
    {
        return view('livewire.ticket-manager', [
            'tickets' => $this->tickets,
        ]);
    }
}
