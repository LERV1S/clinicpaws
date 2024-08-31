<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Pet;
use App\Models\User; // Asegúrate de incluir el modelo User

class PetManager extends Component
{
    public $pets;
    public $owners; // Para almacenar la lista de dueños
    public $owner_id, $name, $species, $breed, $birthdate, $medical_conditions;
    public $selectedPetId;

    public function mount()
    {
        // Inicializar las mascotas y los dueños
        $this->pets = Pet::all();
        $this->owners = User::all(); // Asumiendo que cada User es un dueño potencial
    }

    public function savePet()
    {
        // Validar la entrada del formulario
        $this->validate([
            'owner_id' => 'required', // Asegura que owner_id esté presente
            'name' => 'required',
            'species' => 'required',
        ]);

        if ($this->selectedPetId) {
            $pet = Pet::find($this->selectedPetId);
            $pet->update([
                'owner_id' => $this->owner_id,
                'name' => $this->name,
                'species' => $this->species,
                'breed' => $this->breed,
                'birthdate' => $this->birthdate,
                'medical_conditions' => $this->medical_conditions,
            ]);
        } else {
            // Crear una nueva mascota
            Pet::create([
                'owner_id' => $this->owner_id,
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
        $this->owner_id = $pet->owner_id; // Asegúrate de que owner_id sea cargado
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
        $this->owner_id = '';
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
        return view('livewire.pet-manager', [
            'owners' => $this->owners, // Pasar los dueños a la vista
        ]);
    }
}
