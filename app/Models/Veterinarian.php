<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veterinarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty',
        'license_number',
        'works_on_monday',
        'works_on_tuesday',
        'works_on_wednesday',
        'works_on_thursday',
        'works_on_friday',
        'works_on_saturday',
        'works_on_sunday',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Asegúrate de que la columna en la tabla veterinarians es 'user_id'
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Nueva relación con prescripciones
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'veterinarian_id');
    }
    public function dashboard()
    {
        return $this->hasMany(Appointment::class);
    }
}
