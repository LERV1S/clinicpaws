<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Prescription;
use App\Models\Pet;
use App\Models\Veterinarian;

class PrescriptionManager extends Component
{
    public $prescriptions;
    public $date, $medicine_name, $dosage, $pet_id, $veterinarian_id, $instructions;
    public $selectedPrescriptionId;
    public $searchPetTerm = ''; // Para manejar el término de búsqueda de mascota
    public $petSuggestions = []; // Para almacenar las sugerencias de mascotas
    public $searchTerm = ''; // Para el buscador de recetas

    public function mount()
    {
        $this->loadPrescriptions();
    }

    public function loadPrescriptions()
    {
        $this->prescriptions = Prescription::whereHas('pet', function ($query) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        })->with('veterinarian.user', 'pet')->get();
    }

    public function updatedSearchTerm()
    {
        $this->loadPrescriptions();
    }

    public function updatedSearchPetTerm()
    {
        $this->petSuggestions = Pet::where('name', 'like', '%' . $this->searchPetTerm . '%')->get();
    }

    public function selectPet($petId)
    {
        $this->pet_id = $petId;
        $this->searchPetTerm = Pet::find($petId)->name;
        $this->petSuggestions = [];
    }

    public function savePrescription()
    {
        $this->validate([
            'date' => 'required|date',
            'medicine_name' => 'required|string',
            'dosage' => 'required|string',
            'pet_id' => 'required|exists:pets,id',
            'veterinarian_id' => 'required|exists:veterinarians,id',
            'instructions' => 'nullable|string',
        ]);

        if ($this->selectedPrescriptionId) {
            $prescription = Prescription::find($this->selectedPrescriptionId);
            $prescription->update([
                'date' => $this->date,
                'medicine_name' => $this->medicine_name,
                'dosage' => $this->dosage,
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
                'instructions' => $this->instructions,
            ]);
        } else {
            Prescription::create([
                'date' => $this->date,
                'medicine_name' => $this->medicine_name,
                'dosage' => $this->dosage,
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
                'instructions' => $this->instructions,
            ]);
        }

        $this->resetInputFields();
        $this->loadPrescriptions();
    }

    public function editPrescription($id)
    {
        $prescription = Prescription::find($id);
        $this->selectedPrescriptionId = $prescription->id;
        $this->date = $prescription->date;
        $this->medicine_name = $prescription->medicine_name;
        $this->dosage = $prescription->dosage;
        $this->pet_id = $prescription->pet_id;
        $this->veterinarian_id = $prescription->veterinarian_id;
        $this->instructions = $prescription->instructions;
    }

    public function deletePrescription($id)
    {
        Prescription::find($id)->delete();
        $this->loadPrescriptions();
    }

    private function resetInputFields()
    {
        $this->date = '';
        $this->medicine_name = '';
        $this->dosage = '';
        $this->pet_id = '';
        $this->veterinarian_id = '';
        $this->instructions = '';
        $this->selectedPrescriptionId = null;
        $this->searchPetTerm = ''; // Resetear el término de búsqueda de mascotas
        $this->petSuggestions = []; // Resetear las sugerencias de mascotas
    }

    public function render()
    {
        $veterinarians = Veterinarian::with('user')->get();
        return view('livewire.prescription-manager', [
            'prescriptions' => $this->prescriptions,
            'veterinarians' => $veterinarians,
        ]);
    }
}