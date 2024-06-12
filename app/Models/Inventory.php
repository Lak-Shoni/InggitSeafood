<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';

    // Fillable fields untuk mass assignment
    protected $fillable = [
        'nama_barang',
        'kategori',
        'jumlah',
        'satuan',
        'kondisi',
        'tanggal_pembelian',
        'harga_satuan',
        'total_harga',
        'tanggal_pembaruan_terakhir'
    ];

    // Timestamps
    public $timestamps = true;
}
