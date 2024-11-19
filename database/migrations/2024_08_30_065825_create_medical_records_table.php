<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users'); // Relación con la tabla de usuarios para el dueño
            $table->foreignId('pet_id')->constrained('pets'); // Relación con la tabla de mascotas
            $table->string('species_id'); // Especie de la mascota
            $table->string('breed'); // Raza de la mascota
            $table->integer('age'); // Edad de la mascota
            $table->enum('sex', ['male', 'female']); // Sexo de la mascota
            $table->decimal('weight', 5, 2); // Peso de la mascota
            $table->foreignId('veterinarian_id')->constrained('users'); // Relación con la tabla de usuarios para el veterinario
            $table->date('record_date'); // Fecha del registro médico

            // Historial clínico
            $table->text('symptoms')->nullable(); // Síntomas
            $table->text('medical_history')->nullable(); // Historial médico
            $table->text('pharmacological_history')->nullable(); // Historial farmacológico
            $table->text('previous_illnesses')->nullable(); // Enfermedades previas

            // Exámenes físicos
            $table->decimal('temperature', 4, 1)->nullable(); // Temperatura
            $table->integer('pulse')->nullable(); // Pulso
            $table->integer('respiration')->nullable(); // Respiración
            $table->string('blood_pressure')->nullable(); // Presión arterial
            $table->text('visits')->nullable(); // Visitas
            $table->text('consultations')->nullable(); // Consultas

            // Diagnósticos
            $table->text('provisional_diagnosis')->nullable(); // Diagnóstico provisional
            $table->text('definitive_diagnosis')->nullable(); // Diagnóstico definitivo

            // Tratamiento y medicación
            $table->text('medication')->nullable(); // Medicación
            $table->text('therapies')->nullable(); // Terapias
            $table->text('diets')->nullable(); // Dietas
            $table->text('administered_medications')->nullable(); // Medicamentos administrados
            $table->text('administered_treatments')->nullable(); // Tratamientos administrados
            $table->decimal('dosage', 5, 2)->nullable(); // Dosis
            $table->string('frequency')->nullable(); // Frecuencia
            $table->string('duration')->nullable(); // Duración

            // Análisis de laboratorio
            $table->text('blood_analysis')->nullable(); // Análisis de sangre
            $table->text('urine_analysis')->nullable(); // Análisis de orina
            $table->text('rbc_count')->nullable(); // Conteo de eritrocitos
            $table->text('wbc_count')->nullable(); // Conteo de leucocitos

            // Imágenes diagnósticas
            // Cambiar los campos donde se almacenarán múltiples archivos a longText
            $table->longText('x_rays')->nullable(); // Rayos X
            $table->longText('ultrasounds')->nullable(); // Ultrasonido
            $table->longText('ct_scans')->nullable(); // Tomografía computarizada
            $table->longText('biopsies')->nullable(); // Biopsias


            // Procedimientos quirúrgicos
            $table->text('surgical_description')->nullable(); // Descripción quirúrgica
            $table->text('anesthesia')->nullable(); // Anestesia
            $table->text('surgical_techniques')->nullable(); // Técnicas quirúrgicas
            $table->text('surgical_results')->nullable(); // Resultados quirúrgicos

            // Procedimientos terapéuticos
            $table->text('vaccination')->nullable(); // Vacunación
            $table->text('antiparasitic_treatment')->nullable(); // Tratamiento antiparasitario
            $table->text('allergy_treatment')->nullable(); // Tratamiento de alergias
            $table->text('antibiotic_treatment')->nullable(); // Tratamiento con antibióticos

            // Seguimiento y evolución
            $table->text('clinical_evolution')->nullable(); // Evolución clínica
            $table->text('symptom_changes')->nullable(); // Cambios en síntomas
            $table->text('treatment_response')->nullable(); // Respuesta al tratamiento

            // Conclusión y recomendaciones
            $table->text('disease_summary')->nullable(); // Resumen de la enfermedad
            $table->text('treatment_summary')->nullable(); // Resumen del tratamiento
            $table->text('responsible_recommendations')->nullable(); // Recomendaciones para el responsable
            $table->text('follow_up_plan')->nullable(); // Plan de seguimiento

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
