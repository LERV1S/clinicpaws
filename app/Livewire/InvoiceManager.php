<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Client;

class InvoiceManager extends Component
{
    public $invoices;
    public $clients;
    public $client_id, $total_amount, $status;
    public $selectedInvoiceId;
    public $searchTerm = ''; // Propiedad para el término de búsqueda
    public $searchClientTerm = ''; // Para manejar el término de búsqueda de cliente
    public $clientSuggestions = []; // Para almacenar las sugerencias de clientes
    public function mount()
    {
        $this->loadInvoices();
        $this->clients = Client::all();
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
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        if ($this->selectedInvoiceId) {
            $invoice = Invoice::find($this->selectedInvoiceId);
            $invoice->update([
                'client_id' => $this->client_id,
                'total_amount' => $this->total_amount,
                'status' => $this->status,
            ]);
        } else {
            Invoice::create([
                'client_id' => $this->client_id,
                'total_amount' => $this->total_amount,
                'status' => $this->status,
            ]);
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

    public function render()
    {
        return view('livewire.invoice-manager', [
            'clients' => $this->clients,
            'invoices' => $this->invoices,
        ]);
    }
}
