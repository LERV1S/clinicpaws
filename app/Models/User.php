<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Client;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación con mascotas (como dueño)
    public function pets()
    {
        return $this->hasMany(Pet::class, 'owner_id');
    }

    // Relación con citas médicas (como veterinario)
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'veterinarian_id');
    }

    // Relación con registros médicos (como veterinario)
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'veterinarian_id');
    }

    // Relacón con clientes
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    // Relación con veterinarios
    public function veterinarian()
    {
        return $this->hasOne(Veterinarian::class);
    }

    // Relacióm con empleados
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    // Nueva relación con prescripciones como veterinario
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'veterinarian_id');
    }

}
