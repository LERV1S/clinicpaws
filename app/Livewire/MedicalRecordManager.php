<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\User;

class MedicalRecordManager extends Component
{
    public $medicalRecords;
    public $pet_id, $veterinarian_id, $record_date, $diagnosis, $treatment;
    public $selectedMedicalRecordId;

    public function mount()
    {
        $this->medicalRecords = MedicalRecord::all();
    }

    public function saveMedicalRecord()
    {
        $this->validate([
            'pet_id' => 'required',
            'veterinarian_id' => 'required',
            'record_date' => 'required|date',
            'diagnosis' => 'required',
            'treatment' => 'required',
        ]);

        if ($this->selectedMedicalRecordId) {
            $record = MedicalRecord::find($this->selectedMedicalRecordId);
            $record->update([
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
                'record_date' => $this->record_date,
                'diagnosis' => $this->diagnosis,
                'treatment' => $this->treatment,
            ]);
        } else {
            MedicalRecord::create([
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
                'record_date' => $this->record_date,
                'diagnosis' => $this->diagnosis,
                'treatment' => $this->treatment,
            ]);
        }

        $this->resetInputFields();
        $this->medicalRecords = MedicalRecord::all();
    }

    public function editMedicalRecord($id)
    {
        $record = MedicalRecord::find($id);
        $this->selectedMedicalRecordId = $record->id;
        $this->pet_id = $record->pet_id;
        $this->veterinarian_id = $record->veterinarian_id;
        $this->record_date = $record->record_date;
        $this->diagnosis = $record->diagnosis;
        $this->treatment = $record->treatment;
    }

    public function deleteMedicalRecord($id)
    {
        MedicalRecord::find($id)->delete();
        $this->medicalRecords = MedicalRecord::all();
    }

    private function resetInputFields()
    {
        $this->pet_id = '';
        $this->veterinarian_id = '';
        $this->record_date = '';
        $this->diagnosis = '';
        $this->treatment = '';
        $this->selectedMedicalRecordId = null;
    }

    public function render()
    {
        $pets = Pet::all();
        $veterinarians = User::role('Veterinario')->get();
        return view('livewire.medical-record-manager', compact('pets', 'veterinarians'));
    }
}
