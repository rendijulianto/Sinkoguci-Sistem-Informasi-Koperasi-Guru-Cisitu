<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpananDetail extends Model
{
    use HasFactory;

    protected $table = 'simpanan_detail';

    protected $fillable = [
        'id_simpanan',
        'id_kategori',
        'jumlah',
    ];

    public function simpanan()
    {
        return $this->belongsTo(Simpanan::class, 'id_simpanan', 'id_simpanan');
    }

    public function kategori_simpanan()
    {
        return $this->belongsTo(KategoriSimpanan::class, 'id_kategori', 'id_kategori');
    }

}
