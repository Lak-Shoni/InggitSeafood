<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanMasakan extends Model
{
    use HasFactory;
    protected $table = 'bahan_masakan';

    // Fillable fields untuk mass assignment
    protected $fillable = [
        'nama_barang',
        'barang_masuk',
        'barang_keluar',
        'barang_sisa'
    ];

    // Timestamps
    public $timestamps = true;
}
