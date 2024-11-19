<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Veterinarian;
use App\Models\User;

class VeterinarianManager extends Component
{
    public $veterinarians;
    public $user_id, $specialty, $license_number;
    public $works_on_monday = false, $works_on_tuesday = false, $works_on_wednesday = false, $works_on_thursday = false;
    public $works_on_friday = false, $works_on_saturday = false, $works_on_sunday = false;
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

    // Verificar si el usuario ya está registrado como veterinario
    $existingVet = Veterinarian::where('user_id', $this->user_id)->first();
    if ($existingVet && !$this->selectedVeterinarianId) {
        // Si ya existe y no es una edición, devolver un error
        session()->flash('error', 'This user is already a veterinarian.');
        return;
    }

    if ($this->selectedVeterinarianId) {
        // Editar veterinario existente
        $vet = Veterinarian::find($this->selectedVeterinarianId);
        $vet->update([
            'user_id' => $this->user_id,
            'specialty' => $this->specialty,
            'license_number' => $this->license_number,
            'works_on_monday' => $this->works_on_monday ? 1 : 0,
            'works_on_tuesday' => $this->works_on_tuesday ? 1 : 0,
            'works_on_wednesday' => $this->works_on_wednesday ? 1 : 0,
            'works_on_thursday' => $this->works_on_thursday ? 1 : 0,
            'works_on_friday' => $this->works_on_friday ? 1 : 0,
            'works_on_saturday' => $this->works_on_saturday ? 1 : 0,
            'works_on_sunday' => $this->works_on_sunday ? 1 : 0,
        ]);
        session()->flash('message', 'Veterinarian updated successfully.');
    } else {
        // Crear un nuevo veterinario
        Veterinarian::create([
            'user_id' => $this->user_id,
            'specialty' => $this->specialty,
            'license_number' => $this->license_number,
            'works_on_monday' => $this->works_on_monday ? 1 : 0,
            'works_on_tuesday' => $this->works_on_tuesday ? 1 : 0,
            'works_on_wednesday' => $this->works_on_wednesday ? 1 : 0,
            'works_on_thursday' => $this->works_on_thursday ? 1 : 0,
            'works_on_friday' => $this->works_on_friday ? 1 : 0,
            'works_on_saturday' => $this->works_on_saturday ? 1 : 0,
            'works_on_sunday' => $this->works_on_sunday ? 1 : 0,
        ]);
        session()->flash('message', 'Veterinarian added successfully.');
    }

    // Actualizar el rol en la tabla model_has_roles
    \DB::table('model_has_roles')
        ->updateOrInsert(
            ['model_id' => $this->user_id, 'model_type' => 'App\Models\User'],
            ['role_id' => 2] // Rol de veterinario
        );

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
        
        // Cargar los días de trabajo
        $this->works_on_monday = (bool)$vet->works_on_monday;
        $this->works_on_tuesday = (bool)$vet->works_on_tuesday;
        $this->works_on_wednesday = (bool)$vet->works_on_wednesday;
        $this->works_on_thursday = (bool)$vet->works_on_thursday;
        $this->works_on_friday = (bool)$vet->works_on_friday;
        $this->works_on_saturday = (bool)$vet->works_on_saturday;
        $this->works_on_sunday = (bool)$vet->works_on_sunday;
        
        // Obtener el nombre del usuario para mostrarlo en el campo de búsqueda
        $this->searchUserTerm = User::find($vet->user_id)->name;
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
        $this->works_on_monday = false;
        $this->works_on_tuesday = false;
        $this->works_on_wednesday = false;
        $this->works_on_thursday = false;
        $this->works_on_friday = false;
        $this->works_on_saturday = false;
        $this->works_on_sunday = false;
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
