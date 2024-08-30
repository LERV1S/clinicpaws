<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'species',
        'breed',
        'birthdate',
        'medical_conditions',
    ];

    // Relación con el dueño (User)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relación con citas médicas
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Relación con registros médicos
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}
