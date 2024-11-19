<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'pet_id',
        'species_id',
        'breed',
        'age',
        'sex',
        'weight',
        'veterinarian_id',
        'record_date',
        
        'symptoms',
        'medical_history',
        'pharmacological_history',
        'previous_illnesses',

        'temperature',
        'pulse',
        'respiration',
        'blood_pressure',
        'visits',
        'consultations',

        'provisional_diagnosis',
        'definitive_diagnosis',

        'medication',
        'therapies',
        'diets',
        'administered_medications',
        'administered_treatments',
        'dosage',
        'frequency',
        'duration',

        'blood_analysis',
        'urine_analysis',
        'rbc_count',
        'wbc_count',

        'x_rays',
        'ultrasounds',
        'ct_scans',
        'biopsies',

        'surgical_description',
        'anesthesia',
        'surgical_techniques',
        'surgical_results',

        'vaccination',
        'antiparasitic_treatment',
        'allergy_treatment',
        'antibiotic_treatment',

        'clinical_evolution',
        'symptom_changes',
        'treatment_response',
        
        'disease_summary',
        'treatment_summary',
        'responsible_recommendations',
        'follow_up_plan',
    ];

    // Agregar casts para convertir JSON en arrays
    protected $casts = [
        'x_rays' => 'array',
        'ultrasound' => 'array',
        'ct_scans' => 'array',
        'biopsies' => 'array',
    ];

    // Relación con la mascota (Pet)
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    // Relación con el veterinario (User)
    public function veterinarian()
    {
        return $this->belongsTo(User::class, 'veterinarian_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}

