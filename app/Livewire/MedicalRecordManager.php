<?php

namespace App\Livewire;

use App\Models\Veterinarian;
use Livewire\Component;
use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\User;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class MedicalRecordManager extends Component
{
    use WithFileUploads;


    public $medicalRecords; //PARA EL OTRO BOTTON DE EDITAR O BORRAR
    public $selectedMedicalRecordId = null; //VARIABLE DEL BOTTON

    public $owners; //PARA EL SELECT DE OWNER
    public $pets; //PARA EL SELECT DE PET
    public $species; //PARA EL SELECT DE SPECIES

    // public $veterinarians; 

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

    // SUBPARTE 2 - Archivos de imágenes diagnósticas
    //guardar archivos todos los archivos
    public $x_rays = []; 
    public $single_x_ray; 

    public $ultrasounds = [];
    public $single_ultrasound;

    public $ct_scans = [];
    public $single_ct_scan;

    public $biopsies = [];
    public $single_biopsie;

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
            dd($e->getMessage()); // Esto te mostrará el mensaje de error
        }

        // Guardar archivos de imágenes rayos X, 
        $xRayPaths = [];
        if ($this->x_rays) {
            foreach ($this->x_rays as $x_ray) {
                if ($this->isFileUpload($x_ray)) { // Verificación para imágenes temporales
                    // Guardar solo archivos temporales válidos
                    $path = $x_ray->store('public/x_rays');
                    $xRayPaths[] = $path;
                } elseif (is_string($x_ray) && !empty($x_ray)) {
                    // Asegúrate de que las rutas existentes sean válidas
                    $xRayPaths[] = $x_ray;
                }
            }
        }

        // Guardar archivos de imágenes de ultrasonido
        $ultrasoundPaths = [];
        if ($this->ultrasounds) {
            foreach ($this->ultrasounds as $ultrasound) {
                if ($this->isFileUpload($ultrasound)) {
                    // Guardar solo archivos temporales válidos
                    $path = $ultrasound->store('public/ultrasounds');
                    $ultrasoundPaths[] = $path;
                } elseif (is_string($ultrasound) && !empty($ultrasound)) {
                    // Asegúrate de que las rutas existentes sean válidas
                    $ultrasoundPaths[] = $ultrasound;
                }
            }
        }

        // Guardar archivos de imágenes de tomografía computarizada
        $ctScanPaths = [];
        if ($this->ct_scans) {
            foreach ($this->ct_scans as $ct_scan) {
                if ($this->isFileUpload($ct_scan)) { // Verificación para imágenes temporales
                    // Guardar solo archivos temporales válidos
                    $path = $ct_scan->store('public/ct_scans');
                    $ctScanPaths[] = $path;
                } elseif (is_string($ct_scan) && !empty($ct_scan)) {
                    // Asegúrate de que las rutas existentes sean válidas
                    $ctScanPaths[] = $ct_scan;
                }
            }
        }
        
        // Guardar archivos de imágenes de biopsias
        $biopsiePaths = [];
        if ($this->biopsies) {
            foreach ($this->biopsies as $biopsie) {
                if ($this->isFileUpload($biopsie)) { // Verificación para imágenes temporales
                    // Guardar solo archivos temporales válidos
                    $path = $biopsie->store('public/biopsies');
                    $biopsiePaths[] = $path;
                } elseif (is_string($biopsie) && !empty($biopsie)) {
                    // Asegúrate de que las rutas existentes sean válidas
                    $biopsiePaths[] = $biopsie;
                }
            }
        }
        
        // dd($path); por si hay error

        // Datos del registro médico
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

            // Historial clínico
            'symptoms' => $this->symptoms,
            'medical_history' => $this->medical_history,
            'pharmacological_history' => $this->pharmacological_history,
            'previous_illnesses' => $this->previous_illnesses,

            // Exámenes físicos
            'temperature' => $this->temperature,
            'pulse' => $this->pulse,
            'respiration' => $this->respiration,
            'blood_pressure' => $this->blood_pressure,
            'visits' => $this->visits,
            'consultations' => $this->consultations,

            // Diagnósticos
            'provisional_diagnosis' => $this->provisional_diagnosis,
            'definitive_diagnosis' => $this->definitive_diagnosis,

            // Tratamiento
            'medication' => $this->medication,
            'therapies' => $this->therapies,
            'diets' => $this->diets,
            'administered_medications' => $this->administered_medications,
            'administered_treatments' => $this->administered_treatments,
            'dosage' => $this->dosage,
            'frequency' => $this->frequency,
            'duration' => $this->duration,

            // Procedimientos quirúrgicos
            'blood_analysis' => $this->blood_analysis,
            'urine_analysis' => $this->urine_analysis,
            'rbc_count' => $this->rbc_count,
            'wbc_count' => $this->wbc_count,

            // Imágenes diagnósticas
            // Serializar las rutas de imágenes a JSON para almacenarlas en la base de datos x_rays, ultrasounds, ct_scans, biopsies
            'x_rays' => json_encode($xRayPaths, JSON_UNESCAPED_SLASHES),
            'ultrasounds' => json_encode($ultrasoundPaths, JSON_UNESCAPED_SLASHES),
            'ct_scans' => json_encode($ctScanPaths, JSON_UNESCAPED_SLASHES),
            'biopsies' => json_encode($biopsiePaths, JSON_UNESCAPED_SLASHES),

            // Asignar valores de los procedimientos quirúrgicos
            "surgical_description" => $this->surgical_description,
            "anesthesia" => $this->anesthesia,
            "surgical_techniques" => $this->surgical_techniques,
            "surgical_results" => $this->surgical_results,

            // Asignar valores de los procedimientos terapéuticos
            "vaccination" => $this->vaccination,
            "antiparasitic_treatment" => $this->antiparasitic_treatment,
            "allergy_treatment" => $this->allergy_treatment,
            "antibiotic_treatment" => $this->antibiotic_treatment,

            // Asignar valores del seguimiento y evolución
            "clinical_evolution" => $this->clinical_evolution,
            "symptom_changes" => $this->symptom_changes,
            "treatment_response" => $this->treatment_response,

            // Asignar valores de la conclusión y recomendaciones
            "disease_summary" => $this->disease_summary,
            "treatment_summary" => $this->treatment_summary,
            "responsible_recommendations" => $this->responsible_recommendations,
            "follow_up_plan" => $this->follow_up_plan,

        ];
        // dd($data); por si hay error

        try {
            
            if ($this->selectedMedicalRecordId) {
                $record = MedicalRecord::find($this->selectedMedicalRecordId);
                if ($record) {
                    $record->update($data);
                }
            } else {
                // DB::enableQueryLog(); para ver las consultas
                MedicalRecord::create($data);
                // dd(DB::getQueryLog()); para ver las consultas
            }
            
        } catch (\Exception $e) {
            // session()->flash('error', 'An error occurred while saving the medical record.'); 
            // Mostrar mensaje de error
            dd($e->getMessage());
            return;
        }
        // Limpiar campos y mostrar mensaje de éxito
        $this->resetInputFields();
        $this->medicalRecords = MedicalRecord::all();
        session()->flash('message', 'Medical record saved successfully.');
    }

    public function editMedicalRecord($id)
    {
        // Buscar el registro médico por su ID
        $record = MedicalRecord::find($id);

        if ($record) {
            // Asignar los valores del registro a las propiedades del componente
            $this->selectedMedicalRecordId = $record->id; // Asigna el ID del registro médico seleccionado
            $this->owner_id = $record->owner_id; // Asignar el dueño
            $this->pet_id = $record->pet_id; // Asignar la mascota
            $this->species_id = $record->species_id; // Asignar la especie
            $this->breed = $record->breed; // Asignar la raza
            $this->age = $record->age; // Asignar la edad
            $this->sex = $record->sex; // Asignar el sexo
            $this->weight = $record->weight; // Asignar el peso
            $this->veterinarian_id = $record->veterinarian_id; // Asignar el veterinario
            $this->record_date = $record->record_date; // Asignar la fecha del registro

            // Asignar valores del historial clínico
            $this->symptoms = $record->symptoms;
            $this->medical_history = $record->medical_history;
            $this->pharmacological_history = $record->pharmacological_history;
            $this->previous_illnesses = $record->previous_illnesses;

            // Asignar valores de los exámenes físicos
            $this->temperature = $record->temperature;
            $this->pulse = $record->pulse;
            $this->respiration = $record->respiration;
            $this->blood_pressure = $record->blood_pressure;
            $this->visits = $record->visits;
            $this->consultations = $record->consultations;

            // Asignar valores de los diagnósticos
            $this->provisional_diagnosis = $record->provisional_diagnosis;
            $this->definitive_diagnosis = $record->definitive_diagnosis;

            // Asignar valores del tratamiento y medicación
            $this->medication = $record->medication;
            $this->therapies = $record->therapies;
            $this->diets = $record->diets;
            $this->administered_medications = $record->administered_medications;
            $this->administered_treatments = $record->administered_treatments;
            $this->dosage = $record->dosage;
            $this->frequency = $record->frequency;
            $this->duration = $record->duration;

            // Asignar valores de los análisis de laboratorio
            $this->blood_analysis = $record->blood_analysis;
            $this->urine_analysis = $record->urine_analysis;
            $this->rbc_count = $record->rbc_count;
            $this->wbc_count = $record->wbc_count;

            // Cargar imágenes de rayos X, ultrasonidos, tomografías computarizadas y biopsias
            $this->x_rays = $record->x_rays ? json_decode($record->x_rays, true) : [];
            // dd($this->x_rays);
            $this->ultrasounds = $record->ultrasounds ? json_decode($record->ultrasounds, true) : [];
            // dd($this->ultrasounds);
            $this->ct_scans = $record->ct_scans ? json_decode($record->ct_scans, true) : [];
            // dd($this->ct_scans);
            $this->biopsies = $record->biopsies ? json_decode($record->biopsies, true) : [];
            // dd($this->biopsies);

            // Asignar valores de los procedimientos quirúrgicos
            $this->surgical_description = $record->surgical_description;
            $this->anesthesia = $record->anesthesia;
            $this->surgical_techniques = $record->surgical_techniques;
            $this->surgical_results = $record->surgical_results;

            // Asignar valores de los procedimientos terapéuticos
            $this->vaccination = $record->vaccination;
            $this->antiparasitic_treatment = $record->antiparasitic_treatment;
            $this->allergy_treatment = $record->allergy_treatment;
            $this->antibiotic_treatment = $record->antibiotic_treatment;

            // Asignar valores del seguimiento y evolución
            $this->clinical_evolution = $record->clinical_evolution;
            $this->symptom_changes = $record->symptom_changes;
            $this->treatment_response = $record->treatment_response;

            // Asignar valores de la conclusión y recomendaciones
            $this->disease_summary = $record->disease_summary;
            $this->treatment_summary = $record->treatment_summary;
            $this->responsible_recommendations = $record->responsible_recommendations;
            $this->follow_up_plan = $record->follow_up_plan;
        }
        // dd($record);
    }

    // Método para eliminar un registro médico
    public function deleteMedicalRecord($id)
    {
        MedicalRecord::find($id)->delete();
        // Actualizar la lista de registros médicos
        $this->medicalRecords = MedicalRecord::all();
        // Reiniciar los campos del formulario si el registro eliminado estaba siendo editado
        if ($this->selectedMedicalRecordId == $id) {
            $this->resetInputFields();
        }
        // Mostrar mensaje de confirmación
        session()->flash('message', 'Medical record deleted successfully.');
    }

    // Método para restablecer los campos del formulario
    public function resetInputFields()
    {
        $this->owner_id = '';
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

        $this->x_rays = [];
        $this->ultrasounds = [];
        $this->ct_scans = [];
        $this->biopsies = [];

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
    }

    // Método para renderizar la vista
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

    //ESTA RELACIONADO CON SELECT DEPENDIENTES
    public function mount()
    {
        $this->medicalRecords = MedicalRecord::all(); //PARA EL OTRO BOTTON DE EDITAR O BORRAR
        $this->owners = User::role('Cliente')->get(); //SE TOMAN SOLO LOS USUARIOS QUE SON CLIENTES
        $this->pets = Pet::all(); // Obtener todas las mascotas
        $this->species = Pet::distinct()->pluck('species'); // Obtener todas las especies únicas
    }

    //SELECT DEPENDIENTES
    public function updatedOwnerId($owner_id)
    {
        $this->pets = Pet::where('owner_id', $owner_id)->get(); // Actualizar las mascotas dependiendo del dueño seleccionado
        $this->pet_id = null; // Limpiar el valor seleccionado en el select de mascotas
        $this->species = collect(); // Limpiar la lista de especies
    }

    //SELECT DEPENDIENTES
    public function updatedPetId($pet_id)
    {
        $this->species = Pet::where('id', $pet_id)->pluck('species'); // Actualizar la especie dependiendo de la mascota seleccionada
    }


    // Reglas de validación
    protected $rules = [
        'single_x_ray' => 'nullable|image|max:10240', // Aceptar solo imágenes de hasta 10MB
        'single_ultrasound' => 'nullable|image|max:10240', // Aceptar solo imágenes de hasta 10MB
        'single_ct_scan' => 'nullable|image|max:10240', // Aceptar solo imágenes de hasta 10MB
        'single_biopsie' => 'nullable|image|max:10240', // Aceptar solo imágenes de hasta 10MB
    ];


    /**
     * Elimina un archivo de la lista de archivos seleccionados. 
     */
    // Método para eliminar un archivo de la lista de archivos seleccionados x_rays,
    public function removeXRay($index)
    {
        if (isset($this->x_rays[$index])) {
            unset($this->x_rays[$index]);
            $this->x_rays = array_values($this->x_rays); // Reindexar el array
        }
    }

    // Método para eliminar un archivo de la lista de archivos seleccionados ultrasounds,
    public function removeUltrasound($index)
    {
        if (isset($this->ultrasounds[$index])) {
            unset($this->ultrasounds[$index]);
            $this->ultrasounds = array_values($this->ultrasounds); // Reindexar el array
        }
    }

    // Método para eliminar un archivo de la lista de archivos seleccionados ct_scans,
    public function removeCtscan($index)
    {
        if (isset($this->ct_scans[$index])) {
            unset($this->ct_scans[$index]);
            $this->ct_scans = array_values($this->ct_scans); // Reindexar el array
        }
    }

    // Método para eliminar un archivo de la lista de archivos seleccionados biopsies,
    public function removeBiopsie($index)
    {
        if (isset($this->biopsies[$index])) {
            unset($this->biopsies[$index]);
            $this->biopsies = array_values($this->biopsies); // Reindexar el array
        }
    }

    // Método para manejar la selección de una nueva imagen x_ray
    public function updatedSingleXRay()
    {
        $this->validateOnly('single_x_ray');

        if ($this->single_x_ray) {
            $this->x_rays[] = $this->single_x_ray; // Agregar la nueva imagen al arreglo de imágenes
            $this->single_x_ray = null; // Limpiar la propiedad para la siguiente selección
        }
    }

    // Método para manejar la selección de una nueva imagen ultrasound
    public function updatedSingleUltrasound()
    {
        $this->validateOnly('single_ultrasound');

        if ($this->single_ultrasound) {
            $this->ultrasounds[] = $this->single_ultrasound;
            $this->single_ultrasound = null;
        }
    }

    // Método para manejar la selección de una nueva imagen ct_scan
    public function updatedSingleCtScan()
    {
        $this->validateOnly('single_ct_scan');

        if ($this->single_ct_scan) {
            $this->ct_scans[] = $this->single_ct_scan;
            $this->single_ct_scan = null;
        }
    }

    // Método para manejar la selección de una nueva imagen biopsie
    public function updatedSingleBiopsie()
    {
        $this->validateOnly('single_biopsie');

        if ($this->single_biopsie) {
            $this->biopsies[] = $this->single_biopsie;
            $this->single_biopsie = null;
        }
    }

    // Método para verificar si un archivo es una carga de archivo
    public function isFileUpload($file)
    {
        return $file instanceof \Illuminate\Http\UploadedFile;
    }
}