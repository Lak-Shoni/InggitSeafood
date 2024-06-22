<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_Menu extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kategori'];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'kategori_paket');
    }
}
