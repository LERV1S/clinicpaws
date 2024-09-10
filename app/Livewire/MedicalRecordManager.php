<?php
namespace App\Livewire;

use App\Models\Veterinarian;
use Livewire\Component;
use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\User;

class MedicalRecordManager extends Component
{
    public $medicalRecords; //PARA EL OTRO BOTTON DE EDITAR O BORRAR
    public $selectedMedicalRecordId; //VARIABLE DEL BOTTON

    public $owners; //PARA EL SELECT DE OWNER
    public $pets; //PARA EL SELECT DE PET
    public $species; //PARA EL SELECT DE SPECIES

    public $veterinarians; 

    // COMPONENTES DEL FORMULARIO DE IZQUIERDA A DERECHA DE ARRIBA A ABAJO
    // PARTE 1
    public $owner_id;
    public $pet_id;
    public $species_id;
    public $breed;
    public $age;
    public $sex;
    public $weight;
    public $veterinarian_id;
    public $record_date;

    // PARTE 2
    // SUBPARTE 1
    public $symptoms;
    public $medical_history;
    public $pharmacological_history;
    public $previous_illnesses;

    // SUBPARTE 2
    public $temperature;
    public $pulse;
    public $respiration;
    public $blood_pressure;
    public $visits;
    public $consultations;

    // SUBPARTE 3
    public $provisional_diagnosis;
    public $definitive_diagnosis;

    // SUBPARTE 4
    public $medication;
    public $therapies;
    public $diets;
    public $administered_medications;
    public $administered_treatments;
    public $dosage;
    public $frequency;
    public $duration;

    // PARTE 3
    // SUBPARTE 1
    public $blood_analysis;
    public $urine_analysis;
    public $rbc_count;
    public $wbc_count;
    // SUBPARTE 2
    public $x_rays;
    public $ultrasound;
    public $ct_scans;
    public $biopsies;

    // PARTE 4
    public $surgical_description;
    public $anesthesia;
    public $surgical_techniques;
    public $surgical_results;

    // PARTE 5
    public $vaccination;
    public $antiparasitic_treatment;
    public $allergy_treatment;
    public $antibiotic_treatment;

    // PARTE 6
    public $clinical_evolution;
    public $symptom_changes;
    public $treatment_response;
    
    // PARTE 7
    public $disease_summary;
    public $treatment_summary;
    public $responsible_recommendations;
    public $follow_up_plan;

    public function mount()
    {
        $this->medicalRecords = MedicalRecord::all(); //PARA EL OTRO BOTTON DE EDITAR O BORRAR
        $this->owners = User::role('Cliente')->get(); //SE TOMAN SOLO LOS USUARIOS QUE SON CLIENTES
        $this->pets = Pet::all(); // Obtener todas las mascotas
        $this->species = Pet::distinct()->pluck('species'); // Obtener todas las especies únicas
        $this->veterinarians = User::role('Veterinario')->get(); // Obtener todas las especies únicas

    }

    public function saveMedicalRecord()
    {
        try {
            $this->validate([
                'owner_id' => 'required',
                'pet_id' => 'required',
                'species_id' => 'required',
                'breed' => 'required',
                'age' => 'required',
                'sex' => 'required',
                'weight' => 'required',
                'veterinarian_id' => 'required',
                'record_date' => 'required|date',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            //dd($e->errors()); // Esto te mostrará los errores de validación
            dd($e->getMessage()); // Esto te mostrará el mensaje de error
        }

        $data = [
            'owner_id' => $this->owner_id,
            'pet_id' => $this->pet_id,
            'species_id' => $this->species_id,
            'breed' => $this->breed,
            'age' => $this->age,
            'sex' => $this->sex,
            'weight' => $this->weight,
            'veterinarian_id' => $this->veterinarian_id,
            'record_date' => $this->record_date,

            'symptoms' => $this->symptoms,
            'medical_history' => $this->medical_history,
            'pharmacological_history' => $this->pharmacological_history,
            'previous_illnesses' => $this->previous_illnesses,

            'temperature' => $this->temperature,
            'pulse' => $this->pulse,
            'respiration' => $this->respiration,
            'blood_pressure' => $this->blood_pressure,
            'visits' => $this->visits,
            'consultations' => $this->consultations,

            'provisional_diagnosis' => $this->provisional_diagnosis,
            'definitive_diagnosis' => $this->definitive_diagnosis,

            'medication' => $this->medication,
            'therapies' => $this->therapies,
            'diets' => $this->diets,
            'administered_medications' => $this->administered_medications,
            'administered_treatments' => $this->administered_treatments,
            'dosage' => $this->dosage,
            'frequency' => $this->frequency,
            'duration' => $this->duration,

            'blood_analysis' => $this->blood_analysis,
            'urine_analysis' => $this->urine_analysis,
            'rbc_count' => $this->rbc_count,
            'wbc_count' => $this->wbc_count,

            'x_rays' => $this->x_rays,
            'ultrasound' => $this->ultrasound,
            'ct_scans' => $this->ct_scans,
            'biopsies' => $this->biopsies,

            'surgical_description' => $this->surgical_description,
            'anesthesia' => $this->anesthesia,
            'surgical_techniques' => $this->surgical_techniques,
            'surgical_results' => $this->surgical_results,

            'vaccination' => $this->vaccination,
            'antiparasitic_treatment' => $this->antiparasitic_treatment,
            'allergy_treatment' => $this->allergy_treatment,
            'antibiotic_treatment' => $this->antibiotic_treatment,

            'clinical_evolution' => $this->clinical_evolution,
            'symptom_changes' => $this->symptom_changes,
            'treatment_response' => $this->treatment_response,

            'disease_summary' => $this->disease_summary,
            'treatment_summary' => $this->treatment_summary,
            'responsible_recommendations' => $this->responsible_recommendations,
            'follow_up_plan' => $this->follow_up_plan,
        ];

        try {

            if ($this->selectedMedicalRecordId) {

                $record = MedicalRecord::find($this->selectedMedicalRecordId);
                if ($record) {
                    $record->update($data);
                }
            } else {
                MedicalRecord::create($data);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while saving the medical record.');
            return;
        }
        
        $this->resetInputFields();
        $this->medicalRecords = MedicalRecord::all();
        session()->flash('message', 'Medical record saved successfully.');
    }

    public function resetInputFields() //SE RESETEAN LOS CAMPOS DEL FORMULARIO
    {
        $this->owner_id = '';
        $this->owner_id = null;
        $this->pet_id = '';
        $this->species_id = '';
        $this->breed = '';
        $this->age = '';
        $this->sex = '';
        $this->weight = '';
        $this->veterinarian_id = '';
        $this->record_date = '';
                
        $this->symptoms = '';
        $this->medical_history = '';
        $this->pharmacological_history = '';
        $this->previous_illnesses = '';

        $this->temperature = '';
        $this->pulse = '';
        $this->respiration = '';
        $this->blood_pressure = '';
        $this->visits = '';
        $this->consultations = '';

        $this->provisional_diagnosis = '';
        $this->definitive_diagnosis = '';

        $this->medication = '';
        $this->therapies = '';
        $this->diets = '';
        $this->administered_medications = '';
        $this->administered_treatments = '';
        $this->dosage = '';
        $this->frequency = '';
        $this->duration = '';

        $this->blood_analysis = '';
        $this->urine_analysis = '';
        $this->rbc_count = '';
        $this->wbc_count = '';

        $this->x_rays = '';
        $this->ultrasound = '';
        $this->ct_scans = '';
        $this->biopsies = '';

        $this->surgical_description = '';
        $this->anesthesia = '';
        $this->surgical_techniques = '';
        $this->surgical_results = '';

        $this->vaccination = '';
        $this->antiparasitic_treatment = '';
        $this->allergy_treatment = '';
        $this->antibiotic_treatment = '';

        $this->clinical_evolution = '';
        $this->symptom_changes = '';
        $this->treatment_response = '';

        $this->disease_summary = '';
        $this->treatment_summary = '';
        $this->responsible_recommendations = '';
        $this->follow_up_plan = '';

        $this->selectedMedicalRecordId = null;
        
        // $this->pets = collect();
        // $this->species = collect();
    }

    public function render()
    {
        // Obtiene la lista de veterinarios y dueños desde la base de datos
        $veterinarians = User::role('Veterinario')->get();
        $owners = User::role('Cliente')->get();

        // Renderiza la vista 'livewire.medical-record-manager', pasando las propiedades 'pets' y 'species' del componente,
        // así como las listas de 'veterinarians' y 'owners' obtenidas.
        return view('livewire.medical-record-manager', [
            'pets' => $this->pets,
            'species' => $this->species,
            'veterinarians' => $veterinarians,
            'owners' => $owners,
        ]);
    }
}
