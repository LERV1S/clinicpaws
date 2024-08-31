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

    public function mount()
    {
        $this->prescriptions = Prescription::with('veterinarian.user', 'pet')->get();
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
        $this->prescriptions = Prescription::with('veterinarian.user', 'pet')->get();
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
        $this->prescriptions = Prescription::with('veterinarian.user', 'pet')->get();
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
    }

    public function render()
    {
        $pets = Pet::all();
        $veterinarians = Veterinarian::with('user')->get();
        return view('livewire.prescription-manager', compact('pets', 'veterinarians'));
    }
}
