<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'veterinarian_id',
        'record_date',
        'diagnosis',
        'treatment',
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
}
