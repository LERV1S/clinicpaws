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
    public $selectedTicketId = null;
    public $inventoryItems = [];
    public $inventories;
    public $searchClientTerm = ''; // Para el autocompletado del cliente en el formulario
    public $searchTicketTerm = ''; // Para la búsqueda de tickets en la lista
    public $clientSuggestions = [];

    public function mount()
    {
        $this->loadTickets();
        $this->inventories = Inventory::all();
    }

    public function updatedSearchClientTerm()
    {
        if (!empty($this->searchClientTerm)) {
            $this->clientSuggestions = Client::whereHas('user', function($query) {
                $query->where('name', 'like', '%' . $this->searchClientTerm . '%');
            })->get();
        } else {
            $this->clientSuggestions = [];
        }
    }

    public function selectClient($clientId)
    {
        $this->client_id = $clientId;
        $this->searchClientTerm = Client::find($clientId)->user->name;
        $this->clientSuggestions = [];
    }

    public function loadTickets()
    {
        $this->tickets = Ticket::with('client.user')
            ->whereHas('client.user', function($query) {
                $query->where('name', 'like', '%' . $this->searchTicketTerm . '%');
            })
            ->get();
    }

    public function updatedSearchTicketTerm()
    {
        $this->loadTickets();
    }

    public function addInventoryItem()
    {
        $this->inventoryItems[] = ['inventory_id' => '', 'quantity' => 1];
    }

    public function removeInventoryItem($index)
    {
        unset($this->inventoryItems[$index]);
        $this->inventoryItems = array_values($this->inventoryItems);
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

            foreach ($ticket->inventories as $inventory) {
                $inventory->quantity += $inventory->pivot->quantity;
                $inventory->save();
            }

            $ticket->inventories()->sync($this->formatInventoryItems());

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

            $ticket->inventories()->attach($this->formatInventoryItems());

            foreach ($this->inventoryItems as $item) {
                $inventory = Inventory::find($item['inventory_id']);
                $inventory->quantity -= $item['quantity'];
                $inventory->save();
            }
        }

        $this->resetInputFields();
        $this->loadTickets();
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
        $this->loadTickets();
    }

    private function resetInputFields()
    {
        $this->client_id = '';
        $this->subject = '';
        $this->description = '';
        $this->status = '';
        $this->inventoryItems = [];
        $this->selectedTicketId = null;
        $this->searchClientTerm = ''; // Limpiar la búsqueda del cliente
        $this->clientSuggestions = []; // Limpiar las sugerencias del cliente
    }

    public function render()
    {
        return view('livewire.ticket-manager', [
            'tickets' => $this->tickets,
            'clientSuggestions' => $this->clientSuggestions,
        ]);
    }
}
