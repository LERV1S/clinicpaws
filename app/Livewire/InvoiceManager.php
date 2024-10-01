<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Inventory;

class InvoiceManager extends Component
{
    
    public $invoices;
    public $clients;
    public $client_id, $total_amount, $status;
    public $selectedInvoiceId;
    public $searchTerm = ''; // Propiedad para el término de búsqueda
    public $searchClientTerm = ''; // Para manejar el término de búsqueda de cliente
    public $clientSuggestions = []; // Para almacenar las sugerencias de clientes
    public $inventoryItems = [];
    public $inventories;
    public function mount()
    {
        $this->loadInvoices();
        $this->clients = Client::all();
        $this->inventories = Inventory::all();

    }

    // Cargar facturas filtradas por cliente
    public function loadInvoices()
    {
        $this->invoices = Invoice::whereHas('client.user', function ($query) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        })->get();
    }
     // Autocompletar cliente en el formulario
     public function updatedSearchClientTerm()
     {
         $this->clientSuggestions = Client::whereHas('user', function ($query) {
             $query->where('name', 'like', '%' . $this->searchClientTerm . '%');
         })->get();
     }   
    public function selectClient($clientId)
    {
        $this->client_id = $clientId;
        $this->searchClientTerm = Client::find($clientId)->user->name;
        $this->clientSuggestions = [];
    }


    public function updatedSearchTerm()
    {
        $this->loadInvoices();
    }
    // Guardar o actualizar una factura
    public function saveInvoice()
    {
        $this->validate([
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|string',
            'inventoryItems.*.inventory_id' => 'required|exists:inventories,id',
            'inventoryItems.*.quantity' => 'required|integer|min:1',
        ]);
    
        // Calculamos el total y restamos del inventario
        $totalAmount = 0;
    
        foreach ($this->inventoryItems as $item) {
            $inventory = Inventory::find($item['inventory_id']);
            $itemTotal = $inventory->price * $item['quantity'];
            $iva = $itemTotal * 0.16;  // Calculamos el IVA (16%)
            $totalAmount += $itemTotal + $iva;
    
            if ($inventory->quantity < $item['quantity']) {
                session()->flash('error', 'Not enough inventory for ' . $inventory->item_name);
                return;
            }
        }
    
        if ($this->selectedInvoiceId) {
            $invoice = Invoice::find($this->selectedInvoiceId);
            $invoice->update([
                'client_id' => $this->client_id,
                'total_amount' => $totalAmount, // Asignamos el total calculado
                'status' => $this->status,
            ]);
    
            // Restablecemos las cantidades anteriores del inventario
            foreach ($invoice->inventories as $inventory) {
                $inventory->quantity += $inventory->pivot->quantity;
                $inventory->save();
            }
    
            $invoice->inventories()->sync($this->formatInventoryItems());
    
        } else {
            $invoice = Invoice::create([
                'client_id' => $this->client_id,
                'total_amount' => $totalAmount, // Asignamos el total calculado
                'status' => $this->status,
            ]);
    
            $invoice->inventories()->attach($this->formatInventoryItems());
        }
    
        // Restamos las cantidades del inventario según lo seleccionado
        foreach ($this->inventoryItems as $item) {
            $inventory = Inventory::find($item['inventory_id']);
            $inventory->quantity -= $item['quantity'];
            $inventory->save();
        }
    
        $this->resetInputFields();
        $this->loadInvoices();
    }
    

    public function editInvoice($id)
    {
        $invoice = Invoice::find($id);
        $this->selectedInvoiceId = $invoice->id;
        $this->client_id = $invoice->client_id;
        $this->total_amount = $invoice->total_amount;
        $this->status = $invoice->status;
    }

    public function deleteInvoice($id)
    {
        Invoice::find($id)->delete();
        $this->loadInvoices();
    }

    private function resetInputFields()
    {
        $this->client_id = '';
        $this->total_amount = '';
        $this->status = '';
        $this->selectedInvoiceId = null;
        $this->searchClientTerm = ''; // Resetear el término de búsqueda
        $this->clientSuggestions = []; // Resetear las sugerencias
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
    
    private function formatInventoryItems()
    {
        $formattedItems = [];
        foreach ($this->inventoryItems as $item) {
            $formattedItems[$item['inventory_id']] = ['quantity' => $item['quantity']];
        }
        return $formattedItems;
    }

    public function render()
    {
        return view('livewire.invoice-manager', [
            'clients' => $this->clients,
            'invoices' => $this->invoices,
        ]);
    }
}
