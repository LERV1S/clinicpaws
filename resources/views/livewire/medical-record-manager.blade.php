<div>

    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Medical Records</h1>

    <!-- Formulario para agregar o editar un registro médico -->
    <form wire:submit.prevent="saveMedicalRecord" class="space-y-4" enctype="multipart/form-data">
        <!-- Propiedad que determina si los campos son solo para visualización -->
        @php
        $isReadonly = true; // Puedes cambiar esta variable según las necesidades
        @endphp

        <br>
        <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
        <br>

        <!--PRIMERA PARTE DEL HISTORIAL *Identificación del Paciente -->
        <div class="w-full flex justify-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Identificación del Paciente</h2>
        </div><br>

        <!--PRIMERA PARTE DEL HISTORIAL *Identificación del Paciente -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <!-- SELECCIONAR EL PROPIETARIO -->
            <select id="owner_id" name="owner_id" wire:model.live="owner_id" class="input-field" required>
                <option value="">Select Owner</option>
                @foreach($owners as $owner)
                <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                @endforeach
            </select>

            <!-- SELECCIONAR A LA MASCOTA (Dependiente de Owner) -->
            <select id="pet_id" name="pet_id" wire:model.live="pet_id" class="input-field">
                <option value="">Select Pet</option>
                @foreach($pets as $pet)
                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                @endforeach
            </select>

            <!-- SELECCIONAR LA ESPECIE (Dependiente de Pet) -->
            <select id="species_id" name="species_id" wire:model.live="species_id" class="input-field">
                <option value="">Select Species</option>
                @foreach($species as $specie)
                <option value="{{ $specie }}">{{ $specie }}</option>
                @endforeach
            </select>


            <!-- SELECCIONAR LA RAZA -->
            <input type="text" id="breed" name="breed" wire:model="breed" class="input-field" placeholder="Breed"  @if($isReadonly) readonly @endif>

            <!-- SELECCIONAR LA EDAD -->
            <input type="number" id="age" name="age" wire:model="age" class="input-field" placeholder="Age">

            <!-- SELECCIONAR EL SEXO -->
            <select id="sex" name="sex" wire:model="sex" class="input-field">
                <option value="">Select Sex</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <!-- SELECCIONAR EL PESO -->
            <input type="number" id="weight" name="weight" wire:model="weight" step="0.1" class="input-field" placeholder="Weight Kilograms">

            <!-- SELECCIONAR EL VETERINARIO -->
            <select id="veterinarian_id" name="veterinarian_id" wire:model="veterinarian_id" class="input-field">
                <option value="">Select Veterinarian</option>
                @foreach($veterinarians as $vet)
                <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                @endforeach
            </select>

            <!-- SELECCIONAR LA FECHA DEL REGISTRO O DEL NACIMIENTO -->
            <input type="date" id="record_date" name="record_date" wire:model="record_date" class="input-field">

        </div>
        <!-- FIN DE LA PRIMERA PARTE-->

        <br>
        <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
        <br>

        <!-- Historial Clínico -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white text-center">Historial Clínico</h2>

            <!-- Anamnesis -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Anamnesis</h3>
                <br>
                <textarea id="symptoms" name="symptoms" wire:model="symptoms" class="input-field text-sm" placeholder="Symptoms"></textarea>
                <textarea id="medical_history" name="medical_history" wire:model="medical_history" class="input-field text-sm" placeholder="Medical History"></textarea>
                <textarea id="pharmacological_history" name="pharmacological_history" wire:model="pharmacological_history" class="input-field text-sm" placeholder="Pharmacological History"></textarea>
                <textarea id="previous_illnesses" name="previous_illnesses" wire:model="previous_illnesses" class="input-field text-sm" placeholder="Previous Illnesses"></textarea>
            </div>

            <!-- Exámenes Físicos -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mt-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Exámenes Físicos</h3>
                <br>
                <input type="number" id="temperature" name="temperature" wire:model="temperature" step="0.1" class="input-field text-sm" placeholder="Temperature (°C)">
                <input type="number" id="pulse" name="pulse" wire:model="pulse" class="input-field text-sm" placeholder="Pulse (bpm)">
                <input type="number" id="respiration" name="respiration" wire:model="respiration" class="input-field text-sm" placeholder="Respiration (rpm)">
                <input type="number" id="blood_pressure" name="blood_pressure" wire:model="blood_pressure" class="input-field text-sm" placeholder="Blood Pressure(mmHg)">
                <textarea id="visits" name="visits" wire:model="visits" class="input-field text-sm" placeholder="Visits"></textarea>
                <textarea id="consultations" name="consultations" wire:model="consultations" class="input-field text-sm" placeholder="consultations"></textarea>
            </div>

            <!-- Diagnósticos -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mt-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Diagnósticos</h3>
                <br>
                <textarea id="provisional_diagnosis" name="provisional_diagnosis" wire:model="provisional_diagnosis" class="input-field text-sm" placeholder="Provisional Diagnosis"></textarea>
                <textarea id="definitive_diagnosis" name="definitive_diagnosis" wire:model="definitive_diagnosis" class="input-field text-sm" placeholder="Definitive Diagnosis"></textarea>
            </div>

            <!-- Tratamiento y Medicación -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mt-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tratamiento y Medicación</h3>
                <br>
                <textarea id="medication" name="medication" wire:model="medication" class="input-field text-sm" placeholder="Medication"></textarea>
                <textarea id="therapies" name="therapies" wire:model="therapies" class="input-field text-sm" placeholder="Therapies"></textarea>
                <textarea id="diets" name="diets" wire:model="diets" class="input-field text-sm" placeholder="Diets"></textarea>
                <textarea id="administered_medications" name="administered_medications" wire:model="administered_medications" class="input-field text-sm" placeholder="Administered Medications"></textarea>
                <textarea id="administered_treatments" name="administered_treatments" wire:model="administered_treatments" class="input-field text-sm" placeholder="Administered_Treatments"></textarea>
                <input type="number" id="dosage" name="dosage" wire:model="dosage" step="0.1" class="input-field text-sm" placeholder="Dosage">
                <input type="text" id="frequency" name="frequency" wire:model="frequency" class="input-field text-sm" placeholder="Frequency">
                <input type="text" id="duration" name="duration" wire:model="duration" class="input-field text-sm" placeholder="Duration">
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
                <!-- experimental zone -->
                <!-- experimental zone -->
                <!-- experimental zone -->

                <style>
                    /* Ocultar el texto "Sin archivos seleccionados" o "No file chosen" */
                    input[type="file"]::file-selector-button {
                        display: none;
                    }

                    /* Personalizar el botón de subida de archivos */
                    .custom-file-upload {
                        display: inline-block;
                        padding: 6px 12px;
                        cursor: pointer;
                        background-color: #007bff;
                        color: white;
                        border-radius: 4px;
                    }

                    /* Estilo para la lista de archivos seleccionados */
                    #selected-files {
                        list-style-type: none;
                        padding: 0;
                        margin: 10px 0;
                    }

                    /* Estilo para cada elemento de la lista (archivo seleccionado) */
                    #selected-files li {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 10px;
                        margin-bottom: 10px;
                        background-color: #f8f9fa;
                        border-radius: 4px;
                        border: 1px solid #ddd;
                    }

                    /* Contenedor para los botones de cada archivo */
                    .file-actions {
                        display: flex;
                        gap: 10px;
                    }

                    /* Estilo del botón de eliminación */
                    .delete-button,
                    .view-button {
                        background-color: #dc3545;
                        color: white;
                        border: none;
                        padding: 5px 10px;
                        cursor: pointer;
                        border-radius: 4px;
                        font-size: 12px;
                    }

                    .view-button {
                        background-color: #28a745;
                    }

                    .delete-button:hover,
                    .view-button:hover {
                        background-color: #c82333;
                    }

                    .view-button:hover {
                        background-color: #218838;
                    }

                    .delete-button:focus,
                    .view-button:focus {
                        outline: none;
                    }
                </style>

                <!-- IMAGENES DE RAYOS X -->
                <label for="x_rays" class="text-gray-900 dark:text-white">Rayos X (Imagen)</label>
                <br><br>

                <!-- IMAGENES DE RAYOS X -->
                <div>

                    <label for="single_x_ray" class="custom-file-upload">Seleccionar imagen</label>
                    <input type="file" id="single_x_ray" name="single_x_ray" wire:model="single_x_ray" class="input-field text-sm" accept="image/*" style="display:none;">

                    @error('x_rays') <span class="error">{{ $message }}</span> @enderror
                    @error('single_x_ray') <span class="error">{{ $message }}</span> @enderror

                    <div wire:loading wire:target="single_x_ray" class="text-blue-500">Subiendo archivo...</div>

                    <!-- Mostrar archivos seleccionados -->
                    <ul id="selected-files">
                        @if ($x_rays)
                        @foreach ($x_rays as $index => $x_ray)
                        <li class="flex items-center justify-between">
                            <!-- Previsualización de la imagen -->
                            @if (method_exists($x_ray, 'temporaryUrl'))
                            <img src="{{ $x_ray->temporaryUrl() }}" title="$x_ray->temporaryUrl() " alt="$x_ray->temporaryUrl()" style="width: 200px; height: 200px;" class="preview-img">
                            @else
                            <img src="{{ Storage::url($x_ray) }}" title="{{ Storage::url($x_ray) }}" alt="Storage::url($x_ray)" style="width: 200px; height: 200px;" class="preview-img">
                            @endif
                            <div class="file-actions">
                                <!-- Botón de eliminación -->
                                <button type="button" class="delete-button" wire:click="removeXRay({{ $index }})">Eliminar</button>
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>

                <br>
                <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
                <br>

                <!-- IMAGENES DE ULTRASONIDO -->
                <label for="ultrasound" class="text-gray-900 dark:text-white">Ultrasonido (Imágenes)</label>
                <br><br>

                <!-- IMAGENES DE ULTRASONIDO -->
                <div>

                    <label for="single_ultrasound" class="custom-file-upload">Seleccionar imagen</label>
                    <input type="file" id="single_ultrasound" name="single_ultrasound" wire:model="single_ultrasound" class="input-field text-sm" accept="image/*" style="display:none;">

                    @error('ultrasounds') <span class="error">{{ $message }}</span> @enderror
                    @error('single_ultrasound') <span class="error">{{ $message }}</span> @enderror

                    <div wire:loading wire:target="single_ultrasound" class="text-blue-500">Subiendo archivo...</div>

                    <!-- Mostrar archivos seleccionados -->
                    <ul id="selected-files">
                        @if ($ultrasounds)
                        @foreach ($ultrasounds as $index => $ultrasound)
                        <li class="flex items-center justify-between">
                            <!-- Previsualización de la imagen -->
                            @if (method_exists($ultrasound, 'temporaryUrl'))
                            <img src="{{ $ultrasound->temporaryUrl() }}" title="$ultrasound->temporaryUrl()" alt="$ultrasound->temporaryUrl()" style="width: 200px; height: 200px;" class="preview-img">
                            @else
                            <img src="{{ Storage::url($ultrasound) }}" title="{{ Storage::url($ultrasound) }}" alt="Storage::url($ultrasound)" style="width: 200px; height: 200px;" class="preview-img">
                            @endif
                            <div class="file-actions">
                                <!-- Botón de eliminación -->
                                <button type="button" class="delete-button" wire:click="removeUltrasound({{ $index }})">Eliminar</button>
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>

                <br>
                <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
                <br>

                <!-- IMAGNENES DE CT SCANS -->
                <label for="sigle_ct_scan" class="text-gray-900 dark:text-white">CT Scans (Imagen)</label>
                <br><br>

                <!-- IMAGNENES DE CT SCANS -->
                <div>
                    <label for="single_ct_scan" class="custom-file-upload">Seleccionar Imagen</label>
                    <input type="file" id="single_ct_scan" name="single_ct_scan" wire:model="single_ct_scan" class="input-field text-sm" accept="image/*" style="display:none;">

                    @error('ct_scans') <span class="error">{{ $message }}</span> @enderror
                    @error('single_ct_scan') <span class="error">{{ $message }}</span> @enderror

                    <div wire:loading wire:target="single_ct_scan" class="text-blue-500">Subiendo archivo...</div>

                    <!-- Mostrar archivos seleccionados -->
                    <ul id="selected-files">
                        @if ($ct_scans)
                        @foreach ($ct_scans as $index => $ct_scan)
                        <li class="flex items-center justify-between">
                            <!-- Previsualización de la imagen -->
                            @if (method_exists($ct_scan, 'temporaryUrl'))
                            <img src="{{ $ct_scan->temporaryUrl() }}" title="$ct_scan->temporaryUrl()" alt="$ct_scan->temporaryUrl()" style="width: 200px; height: 200px;" class="preview-img">
                            @else
                            <img src="{{ Storage::url($ct_scan) }}" title="{{ Storage::url($ct_scan) }}" alt="Storage::url($ct_scan)" style="width: 200px; height: 200px;" class="preview-img">
                            @endif
                            <div class="file-actions">
                                <!-- Botón de eliminación -->
                                <button type="button" class="delete-button" wire:click="removeCtscan({{ $index }})">Eliminar</button>
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>

                <br>
                <hr class="my-6 border-gray-300 dark:border-gray-600" style="border-width: 3px;">
                <br>

                <!-- IMAGNENES DE BIOPSIAS -->
                <label for="single_biopsie" class="text-gray-900 dark:text-white">CT Scans (Imagen)</label>
                <br><br>

                <!-- IMAGNENES DE BIOPSIAS -->
                <div>
                    <label for="single_biopsie" class="custom-file-upload">Seleccionar Imagen</label>
                    <input type="file" id="single_biopsie" name="single_biopsie" wire:model="single_biopsie" class="input-field text-sm" accept="image/*" style="display:none;">

                    @error('biopsies') <span class="error">{{ $message }}</span> @enderror
                    @error('single_biopsie') <span class="error">{{ $message }}</span> @enderror

                    <div wire:loading wire:target="single_biopsie" class="text-blue-500">Subiendo archivo...</div>

                    <!-- Mostrar archivos seleccionados -->
                    <ul id="selected-files">
                        @if ($biopsies)
                        @foreach ($biopsies as $index => $biopsie)
                        <li class="flex items-center justify-between">
                            <!-- Previsualización de la imagen -->
                            @if (method_exists($biopsie, 'temporaryUrl'))
                            <img src="{{ $biopsie->temporaryUrl() }}" title="$biopsie->temporaryUrl()" alt="$biopsie->temporaryUrl()" style="width: 200px; height: 200px;" class="preview-img">
                            @else
                            <img src="{{ Storage::url($biopsie) }}" title="{{ Storage::url($biopsie) }}" alt="Storage::url($biopsie)" style="width: 200px; height: 200px;" class="preview-img">
                            @endif
                            <div class="file-actions">
                                <!-- Botón de eliminación -->
                                <button type="button" class="delete-button" wire:click="removeBiopsie({{ $index }})">Eliminar</button>
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>

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
                <textarea id="surgical_description" name="surgical_description" wire:model="surgical_description" class="input-field text-sm" placeholder="Surgical Description"></textarea>
                <textarea id="anesthesia" name="anesthesia" wire:model="anesthesia" class="input-field text-sm" placeholder="Anesthesia"></textarea>
                <textarea id="surgical_techniques" name="surgical_techniques" wire:model="surgical_techniques" class="input-field text-sm" placeholder="Surgical Techniques"></textarea>
                <textarea id="surgical_results" name="surgical_results" wire:model="surgical_results" class="input-field text-sm" placeholder="Surgical Results"></textarea>
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
                <textarea id="vaccination" name="vaccination" wire:model="vaccination" class="input-field text-sm" placeholder="Vaccination"></textarea>
                <textarea id="antiparasitic_treatment" name="antiparasitic_treatment" wire:model="antiparasitic_treatment" class="input-field text-sm" placeholder="Antiparasitic Treatment"></textarea>
                <textarea id="allergy_treatment" name="allergy_treatment" wire:model="allergy_treatment" class="input-field text-sm" placeholder="Allergy Treatment"></textarea>
                <textarea id="antibiotic_treatment" name="antibiotic_treatment" wire:model="antibiotic_treatment" class="input-field text-sm" placeholder="Antibiotic Treatment"></textarea>
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
                <textarea id="clinical_evolution" name="clinical_evolution" wire:model="clinical_evolution" class="input-field text-sm" placeholder="Clinical Evolution"></textarea>
                <textarea id="symptom_changes" name="symptom_changes" wire:model="symptom_changes" class="input-field text-sm" placeholder="Symptom Changes"></textarea>
                <textarea id="treatment_response" name="treatment_response" wire:model="treatment_response" class="input-field text-sm" placeholder="Treatment Response"></textarea>
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
                <textarea id="disease_summary" name="disease_summary" wire:model="disease_summary" class="input-field text-sm" placeholder="Disease Summary"></textarea>
                <textarea id="treatment_summary" name="treatment_summary" wire:model="treatment_summary" class="input-field text-sm" placeholder="Treatment Summary"></textarea>
                <textarea id="responsible_recommendations" name="responsible_recommendations" wire:model="responsible_recommendations" class="input-field text-sm" placeholder="Responsible Recommendations"></textarea>
                <textarea id="follow_up_plan" name="follow_up_plan" wire:model="follow_up_plan" class="input-field text-sm" placeholder="Follow up Plan"></textarea>
            </div>
        </div>

        <!-- Boton de anadir o actualizar -->
        @role('Administrador|Veterinario|Empleado')
        <div class="flex justify-start mt-4">
            <button type="submit" class="cta-button">
                {{ $selectedMedicalRecordId ? 'Update Record' : 'Add Record' }}
            </button>
        </div>
        @endrole

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
                <!-- Botones de editar y eliminar -->
                @role('Administrador|Veterinario|Empleado')
                <div class="flex space-x-4">
                    <button wire:click="editMedicalRecord({{ $record->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                    <button wire:click="deleteMedicalRecord({{ $record->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                </div>
                @endrole
                @role('Cliente')
                <div class="flex space-x-4">
                    <button wire:click="editMedicalRecord({{ $record->id }})" class="cta-button bg-green-500 hover:bg-green-600">Ver Expediente</button>
                </div>
                @endrole
            </li>
            @endforeach
        </ul>
    </div>

    <button onclick="scrollToTop()" class="fixed bottom-5 right-5 bg-blue-500 text-white rounded-full p-3 shadow-lg hover:bg-blue-700">
        ↑
    </button>

    <!-- JavaScript para el scroll al inicio -->
    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>

    <!-- Estilos para hacer que el botón flote en la esquina -->
    <style>
        .fixed {
            position: fixed;
        }
    </style>
</div>