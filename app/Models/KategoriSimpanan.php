<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSimpanan extends Model
{
    use HasFactory;

    protected $table = 'kategori_simpanan';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'id_kategori',
        'nama',
        'jumlah',
    ];

}
