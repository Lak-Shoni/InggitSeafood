<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_paket',
        'nama_paket',
        'gambar_paket',
        'isi_paket',
        'harga_paket',
    ];

    public function jenis_paket()
    {
        return $this->belongsTo(Jenis_Paket::class, 'jenis_paket');
    }
}
