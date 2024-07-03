<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_Paket extends Model
{
    use HasFactory;
    protected $table = 'jenis_pakets';

    public function paket()
    {
        return $this->hasMany(Paket::class, 'jenis_paket');
    }
}
