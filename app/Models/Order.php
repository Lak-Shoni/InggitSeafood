<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'partner_name',
        'delivery_time',
        'payment_method',
        'due_date',
        'notes',
        'items',
        'total_price',
        'payment_status',
        'order_status'
    ];

    protected $casts = [
        'items' => 'array',
        'delivery_time' => 'datetime',
        'due_date' => 'datetime'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
