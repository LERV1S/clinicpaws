<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Client;

class TicketManager extends Component
{
    public $tickets;
    public $clients; // Declarar la propiedad como pública
    public $client_id, $subject, $description, $status;
    public $selectedTicketId;

    public function mount()
    {
        // Cargar los tickets y los clientes
        $this->tickets = Ticket::all();
        $this->clients = Client::all();  // Ahora $clients está definida y accesible en la vista
    }

    public function saveTicket()
    {
        $this->validate([
            'client_id' => 'required|exists:clients,id',
            'subject' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($this->selectedTicketId) {
            $ticket = Ticket::find($this->selectedTicketId);
            $ticket->update([
                'client_id' => $this->client_id,
                'subject' => $this->subject,
                'description' => $this->description,
                'status' => $this->status,
            ]);
        } else {
            Ticket::create([
                'client_id' => $this->client_id,
                'subject' => $this->subject,
                'description' => $this->description,
                'status' => $this->status,
            ]);
        }

        $this->resetInputFields();
        $this->tickets = Ticket::all();
    }

    public function editTicket($id)
    {
        $ticket = Ticket::find($id);
        $this->selectedTicketId = $ticket->id;
        $this->client_id = $ticket->client_id;
        $this->subject = $ticket->subject;
        $this->description = $ticket->description;
        $this->status = $ticket->status;
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
        $this->selectedTicketId = null;
    }

    public function render()
    {
        return view('livewire.ticket-manager', [
            'clients' => $this->clients,
        ]);
    }
}
