<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'medicine_name',
        'dosage',
        'pet_id',
        'veterinarian_id',
        'instructions',
    ];

    /**
     * Relación con el modelo Pet (Mascota).
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Relación con el modelo Veterinarian (Veterinario).
     */
    public function veterinarian()
    {
        return $this->belongsTo(Veterinarian::class);
    }
}
