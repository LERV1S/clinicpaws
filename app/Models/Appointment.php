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
        'is_payment_required', // Nuevo campo
        'payment_status',      // Nuevo campo
        'payment_method',      // Nuevo campo
        'payment_amount',      // Nuevo campo
        'payment_reference',   // Nuevo campo
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
