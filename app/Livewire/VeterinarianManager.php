<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Veterinarian;
use App\Models\User;

class VeterinarianManager extends Component
{
    public $veterinarians;
    public $user_id, $specialty, $license_number;
    public $selectedVeterinarianId;

    public function mount()
    {
        $this->veterinarians = Veterinarian::all();
    }

    public function saveVeterinarian()
    {
        $this->validate([
            'user_id' => 'required',
            'license_number' => 'required',
        ]);

        if ($this->selectedVeterinarianId) {
            $vet = Veterinarian::find($this->selectedVeterinarianId);
            $vet->update([
                'user_id' => $this->user_id,
                'specialty' => $this->specialty,
                'license_number' => $this->license_number,
            ]);
        } else {
            Veterinarian::create([
                'user_id' => $this->user_id,
                'specialty' => $this->specialty,
                'license_number' => $this->license_number,
            ]);
        }

        $this->resetInputFields();
        $this->veterinarians = Veterinarian::all();
    }

    public function editVeterinarian($id)
    {
        $vet = Veterinarian::find($id);
        $this->selectedVeterinarianId = $vet->id;
        $this->user_id = $vet->user_id;
        $this->specialty = $vet->specialty;
        $this->license_number = $vet->license_number;
    }

    public function deleteVeterinarian($id)
    {
        Veterinarian::find($id)->delete();
        $this->veterinarians = Veterinarian::all();
    }

    private function resetInputFields()
    {
        $this->user_id = '';
        $this->specialty = '';
        $this->license_number = '';
        $this->selectedVeterinarianId = null;
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.veterinarian-manager', compact('users'));
    }
}
