<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Prescription;
use App\Models\Pet;
use App\Models\Veterinarian;
use App\Models\Medicine;

class PrescriptionManager extends Component
{

    
    public $searchMedicineTerm = '';
    public $medicineSuggestions = [];
    public $searchMedicineTerms = []; // Almacenar términos de búsqueda para cada medicina

    public $prescriptions;
    public $date, $pet_id, $veterinarian_id, $medicines = [];
    public $selectedPrescriptionId;
    public $searchPetTerm = ''; // Para manejar el término de búsqueda de mascota
    public $petSuggestions = []; // Para almacenar las sugerencias de mascotas
    public $searchTerm = ''; // Para el buscador de recetas
    public $availableMedicines; // Variable para almacenar las medicinas disponibles

    public function mount()
    {
        $this->loadPrescriptions();
        $this->availableMedicines = Medicine::all(); // Cargar todas las medicinas disponibles
    }
    public function updatedSearchMedicineTerm()
    {
        $this->medicineSuggestions = Medicine::where('name', 'like', '%' . $this->searchMedicineTerm . '%')->get();
    }
    public function updatedSearchMedicineTerms($value, $index)
{
    $this->medicineSuggestions[$index] = Medicine::where('name', 'like', '%' . $value . '%')->get();
}
public function selectMedicine($medicineId, $index)
{
    $medicine = Medicine::find($medicineId);
    if ($medicine) {
        // Asignar la medicina seleccionada y su dosis e instrucciones
        $this->medicines[$index]['medicine_id'] = $medicine->id;
        $this->medicines[$index]['dosage'] = $medicine->dosage;
        $this->medicines[$index]['instructions'] = $medicine->instructions;

        // Actualizar el campo de búsqueda con el nombre de la medicina seleccionada
        $this->searchMedicineTerms[$index] = $medicine->name;

        // Limpiar las sugerencias
        $this->medicineSuggestions[$index] = [];
    }
}
    
    public function loadPrescriptions()
    {
        $this->prescriptions = Prescription::whereHas('pet', function ($query) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        })->with('veterinarian.user', 'pet', 'medicines')->get(); // Asegúrate de que las medicinas se carguen junto con las prescripciones
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

    public function addMedicine()
    {
        // Agregar un nuevo campo de medicina al array de medicinas
        $this->medicines[] = ['medicine_id' => '', 'dosage' => '', 'instructions' => ''];
    }

    public function removeMedicine($index)
    {
        // Eliminar una medicina específica del array
        unset($this->medicines[$index]);
        $this->medicines = array_values($this->medicines); // Reindexar el array
    }

    public function savePrescription()
    {
        $this->validate([
            'date' => 'required|date',
            'pet_id' => 'required|exists:pets,id',
            'veterinarian_id' => 'required|exists:veterinarians,id',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.instructions' => 'nullable|string',
        ]);
    
        foreach ($this->medicines as $index => $medicine) {
            // Verificar si se ha ingresado una nueva medicina manualmente
            if (empty($medicine['medicine_id']) && !empty($this->searchMedicineTerms[$index])) {
                // Crear una nueva medicina con los datos ingresados
                $newMedicine = Medicine::create([
                    'name' => $this->searchMedicineTerms[$index], // Nombre ingresado manualmente
                    'dosage' => $medicine['dosage'],
                    'instructions' => $medicine['instructions'],
                ]);
                $this->medicines[$index]['medicine_id'] = $newMedicine->id;
            }
        }
        
        if ($this->selectedPrescriptionId) {
            $prescription = Prescription::find($this->selectedPrescriptionId);
            $prescription->update([
                'date' => $this->date,
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
            ]);
            $prescription->medicines()->sync($this->formatMedicines());
        } else {
            $prescription = Prescription::create([
                'date' => $this->date,
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
            ]);
            $prescription->medicines()->attach($this->formatMedicines());
        }
    
        $this->resetInputFields();
        $this->loadPrescriptions();
    }

    private function formatMedicines()
    {
        $formattedMedicines = [];
        foreach ($this->medicines as $medicine) {
            $formattedMedicines[$medicine['medicine_id']] = [
                'dosage' => $medicine['dosage'],
                'instructions' => $medicine['instructions'],
            ];
        }
        return $formattedMedicines;
    }

    private function resetInputFields()
    {
        $this->date = '';
        $this->medicines = [];
        $this->pet_id = '';
        $this->veterinarian_id = '';
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
            'availableMedicines' => $this->availableMedicines, // Pasar las medicinas disponibles a la vista
        ]);
    }
}