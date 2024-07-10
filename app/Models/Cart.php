<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'paket_id',
        'quantity',
        'total_per_item',
        'status_order'
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
