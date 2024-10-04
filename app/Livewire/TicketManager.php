<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Client;
use App\Models\Inventory;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;  // Importante para identificar al usuario logeado

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
    public $generateInvoice = false; // Checkbox para generar facturas
    public $filterStatus = '';  // Agregar $filterStatus
   
    public function mount()
    {
        $this->loadTickets();
        $this->inventories = Inventory::all();
    }

    public function updatedSearchClientTerm()
    {
        if (!empty($this->searchClientTerm)) {
            $this->clientSuggestions = Client::whereHas('user', function ($query) {
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
        $query = Ticket::with('client.user', 'invoice');
    
        if (Auth::user()->hasRole('Cliente')) {
            // Mostrar solo los tickets del cliente logueado
            $query->where('client_id', Auth::user()->client->id);
        }
    
        // Aplicar el filtro por nombre de cliente (si es un administrador o empleado)
        if (!empty($this->searchTicketTerm)) {
            $query->whereHas('client.user', function ($query) {
                $query->where('name', 'like', '%' . $this->searchTicketTerm . '%');
            });
        }
    
        // Aplicar el filtro por estado (si está seleccionado)
        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }
    
        // Obtener los resultados
        $this->tickets = $query->get();
    }
    
    

    public function updatedSearchTicketTerm()
    {
        $this->loadTickets();
    }

    public function updatedFilterStatus()  // Actualizar al filtrar por estado
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

        // Actualizar el inventario (devolver cantidad anterior)
        foreach ($ticket->inventories as $inventory) {
            $inventory->quantity += $inventory->pivot->quantity;
            $inventory->save();
        }

        // Actualizar los items del inventario en el ticket
        $ticket->inventories()->sync($this->formatInventoryItems());

        // Reducir el inventario actualizado
        foreach ($this->inventoryItems as $item) {
            $inventory = Inventory::find($item['inventory_id']);
            $inventory->quantity -= $item['quantity'];
            $inventory->save();
        }

    } else {
        // Crear el nuevo ticket
        $ticket = Ticket::create([
            'client_id' => $this->client_id,
            'subject' => $this->subject,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        // Asignar items del inventario al ticket
        $ticket->inventories()->attach($this->formatInventoryItems());

        // Reducir el inventario
        foreach ($this->inventoryItems as $item) {
            $inventory = Inventory::find($item['inventory_id']);
            $inventory->quantity -= $item['quantity'];
            $inventory->save();
        }

        // Verificar si se debe crear la factura
        if ($this->generateInvoice) {
            // Pasar el objeto del ticket
            $this->createInvoiceForTicket($ticket);
        }
    }

    $this->resetInputFields();
    $this->loadTickets();
}


public function createInvoiceForTicket($ticket)
{
    // Verificar si el parámetro es un ID y buscar el ticket si es necesario
    if (is_int($ticket)) {
        $ticket = Ticket::find($ticket);
    }

    // Verificar si el ticket existe
    if (!$ticket) {
        session()->flash('error', 'Ticket not found.');
        return;
    }

    // Verificar si ya existe una factura para este ticket
    if ($ticket->invoice) {
        session()->flash('error', 'Invoice already exists for this ticket.');
        return;
    }

    // Calcular el total de la factura e incluir los items del inventario
    $totalAmount = 0;
    $inventoryItems = [];

    foreach ($ticket->inventories as $inventory) {
        $itemTotal = $inventory->price * $inventory->pivot->quantity;
        $iva = $itemTotal * 0.16;  // Calcular IVA (16%)
        $totalAmount += $itemTotal + $iva;
        $inventoryItems[$inventory->id] = ['quantity' => $inventory->pivot->quantity];
    }

    // Determinar el estado de la factura basado en el estado del ticket
    $invoiceStatus = ($ticket->status === 'En adeudo') ? 'Pending' : 'Paid';

    // Crear la factura y asociarla al ticket
    $invoice = Invoice::create([
        'client_id' => $ticket->client_id,
        'ticket_id' => $ticket->id,  // Asociar la factura al ticket
        'total_amount' => $totalAmount,
        'status' => $invoiceStatus,  // Usar la variable de estado determinada
    ]);

    // Asociar los productos del inventario a la factura
    if (!empty($inventoryItems)) {
        $invoice->inventories()->attach($inventoryItems);
    }

    session()->flash('success', 'Invoice created successfully for the ticket.');
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
