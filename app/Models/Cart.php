<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity',
        'total_per_item',
        'status_order'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
