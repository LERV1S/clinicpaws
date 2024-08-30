<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pet;

class PetManager extends Component
{
    public $pets;
    public $name, $species, $breed, $birthdate, $medical_conditions;
    public $selectedPetId;

    public function mount()
    {
        // Inicializar las mascotas
        $this->pets = Pet::all();
    }

    public function savePet()
    {
        // Validar la entrada del formulario
        $this->validate([
            'name' => 'required',
            'species' => 'required',
        ]);

        if ($this->selectedPetId) {
            $pet = Pet::find($this->selectedPetId);
            $pet->update([
                'name' => $this->name,
                'species' => $this->species,
                'breed' => $this->breed,
                'birthdate' => $this->birthdate,
                'medical_conditions' => $this->medical_conditions,
            ]);
        } else {
            // Crear una nueva mascota
            Pet::create([
                'name' => $this->name,
                'species' => $this->species,
                'breed' => $this->breed,
                'birthdate' => $this->birthdate,
                'medical_conditions' => $this->medical_conditions,
            ]);
        }

        // Reiniciar los campos del formulario
        $this->resetInputFields();
        $this->pets = Pet::all(); // Refresca la lista de mascotas
    }

    public function editPet($id)
    {
        $pet = Pet::find($id);
        $this->selectedPetId = $pet->id;
        $this->name = $pet->name;
        $this->species = $pet->species;
        $this->breed = $pet->breed;
        $this->birthdate = $pet->birthdate;
        $this->medical_conditions = $pet->medical_conditions;
    }

    public function deletePet($id)
    {
        Pet::find($id)->delete();
        $this->pets = Pet::all(); // Refresca la lista de mascotas
    }

    // Limpiar los campos de entrada del formulario
    private function resetInputFields()
    {
        $this->name = '';
        $this->species = '';
        $this->breed = '';
        $this->birthdate = '';
        $this->medical_conditions = '';
        $this->selectedPetId = null;
    }

    // Renderizar la vista del componente
    public function render()
    {
        return view('livewire.pet-manager');
    }
}
