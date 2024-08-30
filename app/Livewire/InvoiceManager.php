<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Client;

class InvoiceManager extends Component
{
    public $invoices;
    public $client_id, $total_amount, $status;
    public $selectedInvoiceId;

    public function mount()
    {
        $this->invoices = Invoice::all();
    }

    public function saveInvoice()
    {
        $this->validate([
            'client_id' => 'required',
            'total_amount' => 'required|numeric',
            'status' => 'required',
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
        $this->invoices = Invoice::all();
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
        $this->invoices = Invoice::all();
    }

    private function resetInputFields()
    {
        $this->client_id = '';
        $this->total_amount = '';
        $this->status = '';
        $this->selectedInvoiceId = null;
    }

    public function render()
    {
        $clients = Client::all();
        return view('livewire.invoice-manager', compact('clients'));
    }
}
