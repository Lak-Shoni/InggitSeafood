<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_date',
        'omset',
        'purchasing',
        'tenaga_kerja',
        'pln',
        'akomodasi',
        'sewa_alat',
        'profit',
    ];
}
