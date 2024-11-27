<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'address',
        'instansi_name',
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
    public function hutang()
    {
        return $this->hasOne(Hutang::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_code = self::generateOrderId($model->user_id);
        });
    }

    public static function generateOrderId($userId)
    {
        return $userId . date('YmdHis');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
