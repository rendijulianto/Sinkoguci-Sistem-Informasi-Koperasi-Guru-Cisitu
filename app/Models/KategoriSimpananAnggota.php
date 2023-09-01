<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSimpananAnggota extends Model
{
    use HasFactory;

    protected $table = 'kategori_simpanan_anggota';

    protected $fillable = [
        'id_anggota',
        'id_kategori',
        'nominal',
        'saldo',
    ];


    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSimpanan::class, 'id_kategori', 'id_kategori');
    }

}
