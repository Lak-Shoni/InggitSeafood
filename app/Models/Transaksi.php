<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';

    protected $fillable = [
        'bahan_masakan_id',
        'tanggal_transaksi',
        'barang_masuk',
        'barang_keluar',
        'barang_sisa',
    ];

    public $timestamps = true;

    public function bahanMasakan()
    {
        return $this->belongsTo(BahanMasakan::class);
    }
}
