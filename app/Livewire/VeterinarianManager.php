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
    public $searchUserTerm = ''; // Para manejar el término de búsqueda de usuario
    public $searchVeterinarianTerm = ''; // Para manejar el término de búsqueda de veterinario
    public $userSuggestions = []; // Para almacenar las sugerencias de usuarios

    public function mount()
    {
        $this->loadVeterinarians(); // Cargar veterinarios cuando el componente se monta
    }

    // Cargar veterinarios filtrados por nombre de usuario
    public function loadVeterinarians()
    {
        $this->veterinarians = Veterinarian::whereHas('user', function ($query) {
            $query->where('name', 'like', '%' . $this->searchVeterinarianTerm . '%');
        })->get();
    }

    // Escuchar cambios en el término de búsqueda de veterinarios
    public function updatedSearchVeterinarianTerm()
    {
        $this->loadVeterinarians(); // Recargar veterinarios al cambiar el término de búsqueda
    }

    // Autocompletar usuario en el formulario
    public function updatedSearchUserTerm()
    {
        $this->userSuggestions = User::where('name', 'like', '%' . $this->searchUserTerm . '%')->get();
    }

    public function selectUser($userId)
    {
        $this->user_id = $userId;
        $this->searchUserTerm = User::find($userId)->name;
        $this->userSuggestions = [];
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
        $this->loadVeterinarians(); // Recargar la lista de veterinarios después de guardar
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
        $this->loadVeterinarians(); // Recargar la lista de veterinarios después de eliminar
    }

    private function resetInputFields()
    {
        $this->user_id = '';
        $this->specialty = '';
        $this->license_number = '';
        $this->selectedVeterinarianId = null;
        $this->searchUserTerm = ''; // Resetear el término de búsqueda de usuario
        $this->userSuggestions = []; // Resetear las sugerencias de usuarios
    }

    public function render()
    {
        return view('livewire.veterinarian-manager', [
            'veterinarians' => $this->veterinarians,
        ]);
    }
}
