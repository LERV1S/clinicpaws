<div>
    <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Manage Medical Records</h1>

    <!-- Formulario para agregar o editar un registro médico -->
    <form wire:submit.prevent="saveMedicalRecord" class="space-y-4">
        <!-- SALTO DE LINEA-->
        <br>
        <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
        <br>
        <!-- SALTO DE LINEA-->
        
        <!--PRIMERA PARTE DEL HISTORIAL *Identificación del Paciente -->
        <div class="w-full flex justify-center">
            <!-- Identificación del Paciente -->
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Identificación del Paciente</h2>
        </div>
        
        <!-- SALTO DE LINEA-->
        <br>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <!-- SELECCIONAR EL PROPIETARIO -->
            <select id="owner_id" name="owner_id" wire:model="owner_id" class="input-field" required>
                <option value="">Select Owner</option>
                @foreach($owners as $owner)
                    <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                @endforeach
            </select>

            <!-- SELECCIONAR A LA MASCOTA -->
            <select id="pet_id" name="pet_id" wire:model="pet_id" class="input-field" >
                <option value="">Select Pet</option>
                @foreach($pets as $pet)
                    <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                @endforeach
            </select>

            <!-- SELECCIONAR LA ESPECIE -->
            <select id="species_id" name="species_id" wire:model="species_id" class="input-field" >
                <option value="">Select Species</option>
                @foreach($species as $specie)
                    <option value="{{ $specie }}">{{ $specie }}</option>
                @endforeach
            </select>

            <!-- SELECCIONAR LA RAZA -->
            <input type="text" id="breed" name="breed" wire:model="breed" class="input-field" placeholder="Breed" >

            <!-- SELECCIONAR LA EDAD -->
            <input type="number" id="age" name="age" wire:model="age" class="input-field" placeholder="Age" >

            <!-- SELECCIONAR EL SEXO -->
            <select id="sex" name="sex" wire:model="sex" class="input-field" >
                <option value="">Select Sex</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <!-- SELECCIONAR EL PESO -->
            <input type="number" id="weight" name="weight" wire:model="weight" step="0.1" class="input-field" placeholder="Weight" >

            <!-- SELECCIONAR EL VETERINARIO -->
            <select id="veterinarian_id" name="veterinarian_id" wire:model="veterinarian_id" class="input-field" >
                <option value="">Select Veterinarian</option>
                @foreach($veterinarians as $vet)
                    <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                @endforeach
            </select>

            <!-- SELECCIONAR LA FECHA DEL REGISTRO O DEL NACIMIENTO -->
            <input type="date" id="record_date" name="record_date" wire:model="record_date" class="input-field" >
        </div>
        <!-- FIN DE LA PRIMERA PARTE-->
        
        <!-- SALTO DE LINEA-->
        <br>
        <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
        <br>
        <!-- SALTO DE LINEA-->

        <!-- Historial Clínico -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white text-center">Historial Clínico</h2>

            <!-- Anamnesis -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Anamnesis</h3>
                <br>
                <textarea id="symptoms" name="symptoms" wire:model="symptoms" class="input-field text-sm" placeholder="Symptoms"></textarea>
                <textarea id="medical_history" name="medical_history" wire:model="medical_history" class="input-field text-sm" placeholder="Medical History" ></textarea>
                <textarea id="pharmacological_history" name="pharmacological_history" wire:model="pharmacological_history" class="input-field text-sm" placeholder="Pharmacological History" ></textarea>
                <textarea id="previous_illnesses" name="previous_illnesses" wire:model="previous_illnesses" class="input-field text-sm" placeholder="Previous Illnesses" ></textarea>
            </div>

            <!-- Exámenes Físicos -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mt-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Exámenes Físicos</h3>
                <br>
                <input type="number" id="temperature" name="temperature" wire:model="temperature" step="0.1" class="input-field text-sm" placeholder="Temperature (°C)" >
                <input type="number" id="pulse" name="pulse" wire:model="pulse" class="input-field text-sm" placeholder="Pulse (bpm)" >
                <input type="number" id="respiration" name="respiration" wire:model="respiration" class="input-field text-sm" placeholder="Respiration (rpm)" >
                <input type="number" id="blood_pressure" name="blood_pressure" wire:model="blood_pressure" class="input-field text-sm" placeholder="Blood Pressure(mmHg)"> 
                <textarea id="visits" name="visits" wire:model="visits" class="input-field text-sm" placeholder="Visits" ></textarea>
                <textarea id="consultations" name="consultations" wire:model="consultations" class="input-field text-sm" placeholder="consultations" ></textarea>
            </div>

            <!-- Diagnósticos -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mt-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Diagnósticos</h3>
                <br>
                <textarea id="provisional_diagnosis" name="provisional_diagnosis" wire:model="provisional_diagnosis" class="input-field text-sm" placeholder="Provisional Diagnosis" ></textarea>
                <textarea id="definitive_diagnosis" name="definitive_diagnosis" wire:model="definitive_diagnosis" class="input-field text-sm" placeholder="Definitive Diagnosis" ></textarea>
            </div>

            <!-- Tratamiento y Medicación -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mt-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tratamiento y Medicación</h3>
                <br>
                <textarea id="medication" name="medication" wire:model="medication" class="input-field text-sm" placeholder="Medication" ></textarea>
                <textarea id="therapies" name="therapies" wire:model="therapies" class="input-field text-sm" placeholder="Therapies" ></textarea>
                <textarea id="diets" name="diets" wire:model="diets" class="input-field text-sm" placeholder="Diets" ></textarea>
                <textarea id="administered_medications" name="administered_medications" wire:model="administered_medications" class="input-field text-sm" placeholder="Administered Medications" ></textarea>
                <textarea id="administered_treatments" name="administered_treatments" wire:model="administered_treatments" class="input-field text-sm" placeholder="Administered_Treatments" ></textarea>
                <input type="number" id="dosage" name="dosage" wire:model="dosage" step="0.1" class="input-field text-sm" placeholder="Dosage" >
                <input type="text" id="frequency" name="frequency" wire:model="frequency" class="input-field text-sm" placeholder="Frequency" >
                <input type="text" id="duration" name="duration" wire:model="duration" class="input-field text-sm" placeholder="Duration" >
            </div>
        </div>
        <br>
        <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
        <br>
        <!-- Resultados de Pruebas y Exámenes -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white text-center">Resultados de Pruebas y Exámenes</h2>

            <!-- Análisis de Laboratorio -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Análisis de Laboratorio</h3>
                <br>
                <textarea id="blood_analysis" name="blood_analysis" wire:model="blood_analysis" class="input-field text-sm" placeholder="Blood Analysis"></textarea>
                <textarea id="urine_analysis" name="urine_analysis" wire:model="urine_analysis" class="input-field text-sm" placeholder="Urine Analysis"></textarea>
                <textarea id="rbc_count" name="rbc_count" wire:model="rbc_count" class="input-field text-sm" placeholder="RBC Count"></textarea>
                <textarea id="wbc_count" name="wbc_count" wire:model="wbc_count" class="input-field text-sm" placeholder="WBC Count"></textarea>
            </div>

            <!-- Imágenes Diagnósticas -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mt-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Imágenes Diagnósticas</h3>
                <br>
                <textarea id="x_rays" name="x_rays" wire:model="x_rays" class="input-field text-sm" placeholder="X Rrays"></textarea>
                <textarea id="ultrasound" name="ultrasound" wire:model="ultrasound" class="input-field text-sm" placeholder="Ultrasound"></textarea>
                <textarea id="ct_scans" name="ct_scans" wire:model="ct_scans" class="input-field text-sm" placeholder="CT Scans"></textarea>
                <textarea id="biopsies" name="biopsies" wire:model="biopsies" class="input-field text-sm" placeholder="Biopsies"></textarea>
            </div>
        </div>
        <br>
        <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
        <br>
        <!-- Procedimientos Quirúrgicos -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white text-center">Procedimientos Quirúrgicos</h2>
            <br>
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <textarea id="surgical_description" name="surgical_description" wire:model="surgical_description" class="input-field text-sm" placeholder="Descripción de los Procedimientos Quirúrgicos"></textarea>
                <textarea id="anesthesia" name="anesthesia" wire:model="anesthesia" class="input-field text-sm" placeholder="Anestesia"></textarea>
                <textarea id="surgical_techniques" name="surgical_techniques" wire:model="surgical_techniques" class="input-field text-sm" placeholder="Técnicas Quirúrgicas"></textarea>
                <textarea id="surgical_results" name="surgical_results" wire:model="surgical_results" class="input-field text-sm" placeholder="Resultados"></textarea>
            </div>
        </div>
        <br>
        <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
        <br>
        <!-- Procedimientos Terapéuticos -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white text-center">Procedimientos Terapéuticos</h2>
            <br>
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <textarea id="vaccination" name="vaccination" wire:model="vaccination" class="input-field text-sm" placeholder="Vacunación"></textarea>
                <textarea id="antiparasitic_treatment" name="antiparasitic_treatment" wire:model="antiparasitic_treatment" class="input-field text-sm" placeholder="Tratamiento con Antiparasitarios"></textarea>
                <textarea id="allergy_treatment" name="allergy_treatment" wire:model="allergy_treatment" class="input-field text-sm" placeholder="Tratamiento para Alergias"></textarea>
                <textarea id="antibiotic_treatment" name="antibiotic_treatment" wire:model="antibiotic_treatment" class="input-field text-sm" placeholder="Tratamiento con Antibióticos"></textarea>
            </div>
        </div>
        <br>
        <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
        <br>
        <!-- Seguimiento y Evolución -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white text-center">Seguimiento y Evolución</h2>
            <br>
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <textarea id="clinical_evolution" name="clinical_evolution" wire:model="clinical_evolution" class="input-field text-sm" placeholder="Registro de la Evolución Clínica"></textarea>
                <textarea id="symptom_changes" name="symptom_changes" wire:model="symptom_changes" class="input-field text-sm" placeholder="Cambios en los Síntomas"></textarea>
                <textarea id="treatment_response" name="treatment_response" wire:model="treatment_response" class="input-field text-sm" placeholder="Respuesta al Tratamiento"></textarea>
            </div>
        </div>
        <br>
        <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
        <br>
        <!-- Conclusión y Recomendaciones -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white text-center">Conclusión y Recomendaciones</h2>
            <br>
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <textarea id="disease_summary" name="disease_summary" wire:model="disease_summary" class="input-field text-sm" placeholder="Resumen de la Enfermedad"></textarea>
                <textarea id="treatment_summary" name="treatment_summary" wire:model="treatment_summary" class="input-field text-sm" placeholder="Resumen del Tratamiento"></textarea>
                <textarea id="responsible_recommendations" name="responsible_recommendations" wire:model="responsible_recommendations" class="input-field text-sm" placeholder="Recomendaciones para el Responsable"></textarea>
                <textarea id="follow_up_plan" name="follow_up_plan" wire:model="follow_up_plan" class="input-field text-sm" placeholder="Plan de Seguimiento y Control"></textarea>
            </div>
        </div>

        <div class="flex justify-start mt-4">
            <button type="submit" class="cta-button">{{ $selectedMedicalRecordId ? 'Update Record' : 'Add Record' }}</button>
        </div>
    </form>
    
    <!-- Listado de registros médicos -->
    <div class="mt-6">
        <ul class="space-y-4">
            @foreach ($medicalRecords as $record)
                <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Pet: {{ $record->pet->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Veterinarian: {{ $record->veterinarian->name }} - Date: {{ $record->record_date }}
                        </p>
                    </div>
                    <div class="flex space-x-4">
                        <button wire:click="editMedicalRecord({{ $record->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                        <button wire:click="deleteMedicalRecord({{ $record->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
