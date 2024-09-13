<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pet;
use App\Models\User; 

class PetManager extends Component
{
    public $pets;
    public $owners; // Para almacenar la lista de dueños
    public $owner_id, $name, $species, $breed, $birthdate, $medical_conditions;
    public $selectedPetId;
    public $searchOwnerTerm = ''; // Término de búsqueda para propietarios
    public $ownerSuggestions = []; // Sugerencias de propietarios
    public $searchPetTerm = ''; // Término de búsqueda para mascotas

    public function mount()
    {
        $this->loadPets();
        $this->owners = User::all(); // Asumiendo que cada User es un dueño potencial
    }

    public function updatedSearchOwnerTerm()
    {
        if (!empty($this->searchOwnerTerm)) {
            $this->ownerSuggestions = User::where('name', 'like', '%' . $this->searchOwnerTerm . '%')->get();
        } else {
            $this->ownerSuggestions = [];
        }
    }

    public function selectOwner($ownerId)
    {
        $this->owner_id = $ownerId;
        $this->searchOwnerTerm = User::find($ownerId)->name;
        $this->ownerSuggestions = [];
    }

    public function updatedSearchPetTerm()
    {
        $this->loadPets();
    }

    public function loadPets()
    {
        $this->pets = Pet::with('owner')
            ->where('name', 'like', '%' . $this->searchPetTerm . '%')
            ->get();
    }

    public function savePet()
    {
        $this->validate([
            'owner_id' => 'required',
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
            Pet::create([
                'owner_id' => $this->owner_id,
                'name' => $this->name,
                'species' => $this->species,
                'breed' => $this->breed,
                'birthdate' => $this->birthdate,
                'medical_conditions' => $this->medical_conditions,
            ]);
        }

        $this->resetInputFields();
        $this->loadPets();
    }

    public function editPet($id)
    {
        $pet = Pet::find($id);
        $this->selectedPetId = $pet->id;
        $this->owner_id = $pet->owner_id;
        $this->name = $pet->name;
        $this->species = $pet->species;
        $this->breed = $pet->breed;
        $this->birthdate = $pet->birthdate;
        $this->medical_conditions = $pet->medical_conditions;

        $this->searchOwnerTerm = $pet->owner->name;
    }

    public function deletePet($id)
    {
        Pet::find($id)->delete();
        $this->loadPets();
    }

    private function resetInputFields()
    {
        $this->owner_id = '';
        $this->name = '';
        $this->species = '';
        $this->breed = '';
        $this->birthdate = '';
        $this->medical_conditions = '';
        $this->selectedPetId = null;
        $this->searchOwnerTerm = '';
        $this->ownerSuggestions = [];
    }

    public function render()
    {
        return view('livewire.pet-manager', [
            'pets' => $this->pets,
            'owners' => $this->owners,
            'ownerSuggestions' => $this->ownerSuggestions,
        ]);
    }
}