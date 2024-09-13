<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'veterinarian_id',
        'appointment_date',
        'status',
        'notes',
    ];

    // Relación con la mascota (Pet)
    public function veterinarian()
    {
        return $this->belongsTo(Veterinarian::class, 'veterinarian_id');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }


    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
