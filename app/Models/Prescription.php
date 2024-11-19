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
        'pet_id',
        'veterinarian_id',
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

     public function user()
     {
         return $this->belongsTo(User::class);
     }
     
    public function veterinarian()
    {
        return $this->belongsTo(Veterinarian::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)->withPivot('dosage', 'instructions')->withTimestamps();
    }
    

}
