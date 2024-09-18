<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'total_amount',
        'status',
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
    public function inventories()
    {
        return $this->belongsToMany(Inventory::class)->withPivot('quantity');
    }
}
