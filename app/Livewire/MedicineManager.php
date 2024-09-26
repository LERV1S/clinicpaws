<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Medicine;

class MedicineManager extends Component
{
    public $medicines;
    public $name, $description, $dosage, $instructions;
    public $selectedMedicineId;

    public function mount()
    {
        $this->loadMedicines();
    }

    public function loadMedicines()
    {
        $this->medicines = Medicine::all();
    }

    public function saveMedicine()
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'dosage' => 'nullable|string',
            'instructions' => 'nullable|string',
        ]);

        if ($this->selectedMedicineId) {
            $medicine = Medicine::find($this->selectedMedicineId);
            $medicine->update([
                'name' => $this->name,
                'description' => $this->description,
                'dosage' => $this->dosage,
                'instructions' => $this->instructions,
            ]);
        } else {
            Medicine::create([
                'name' => $this->name,
                'description' => $this->description,
                'dosage' => $this->dosage,
                'instructions' => $this->instructions,
            ]);
        }

        $this->resetInputFields();
        $this->loadMedicines();
    }

    public function editMedicine($id)
    {
        $medicine = Medicine::find($id);
        $this->selectedMedicineId = $medicine->id;
        $this->name = $medicine->name;
        $this->description = $medicine->description;
        $this->dosage = $medicine->dosage;
        $this->instructions = $medicine->instructions;
    }

    public function deleteMedicine($id)
    {
        Medicine::find($id)->delete();
        $this->loadMedicines();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->dosage = '';
        $this->instructions = '';
        $this->selectedMedicineId = null;
    }

    public function render()
    {
        return view('livewire.medicine-manager');
    }
}
