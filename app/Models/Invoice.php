<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'ticket_id',  // Asegurar que se pueda guardar ticket_id
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
    public function ticket()
{
    return $this->belongsTo(Ticket::class);
}

}
