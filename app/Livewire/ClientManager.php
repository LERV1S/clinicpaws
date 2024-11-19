<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\User;

class ClientManager extends Component
{
    public $clients;
    public $user_id, $phone_number, $address;
    public $selectedClientId;

    public function mount()
    {
        $this->clients = Client::all();
    }

    public function saveClient()
    {
        $this->validate([
            'user_id' => 'required',
            'phone_number' => 'required',
        ]);

        if ($this->selectedClientId) {
            $client = Client::find($this->selectedClientId);
            $client->update([
                'user_id' => $this->user_id,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
            ]);
        } else {
            Client::create([
                'user_id' => $this->user_id,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
            ]);
        }

        $this->resetInputFields();
        $this->clients = Client::all();
    }

    public function editClient($id)
    {
        $client = Client::find($id);
        $this->selectedClientId = $client->id;
        $this->user_id = $client->user_id;
        $this->phone_number = $client->phone_number;
        $this->address = $client->address;
    }

    public function deleteClient($id)
    {
        Client::find($id)->delete();
        $this->clients = Client::all();
    }

    private function resetInputFields()
    {
        $this->user_id = '';
        $this->phone_number = '';
        $this->address = '';
        $this->selectedClientId = null;
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.client-manager', compact('users'));
    }
}
