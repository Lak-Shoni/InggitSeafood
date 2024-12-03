<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi_Bahan extends Model
{
    use HasFactory;
    protected $table = 'transaksi_bahan';

    protected $fillable = [
        'bahan_masakan_id',
        'tanggal_transaksi',
        'bahan_masuk',
        'bahan_keluar',
        'jumlah_bahan',
        'harga_satuan',
        'total_harga'
    ];

    public $timestamps = true;

    public function bahanMasakan()
    {
        return $this->belongsTo(BahanMasakan::class);
    }
}
