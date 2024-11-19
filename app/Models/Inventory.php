<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'quantity',
        'price',
    ];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class)->withPivot('quantity')->withTimestamps();
    }
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class)->withPivot('quantity');
    }

}