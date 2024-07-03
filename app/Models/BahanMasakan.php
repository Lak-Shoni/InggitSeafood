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
        'nama_bahan',
        'bahan_masuk',
        'bahan_keluar',
        'jumlah_bahan',
        'satuan'
    ];

    // Timestamps
    public $timestamps = true;
}
