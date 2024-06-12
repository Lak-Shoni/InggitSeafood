<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'kategori_paket',
        'nama_menu',
        'gambar_menu',
        'isi_menu',
        'harga_menu',
    ];
}
