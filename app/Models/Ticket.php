<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'subject',
        'description',
        'status',
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function inventories()
    {
        return $this->belongsToMany(Inventory::class)->withPivot('quantity')->withTimestamps();
    }
    // Nueva relación con factura

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
