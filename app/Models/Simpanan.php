<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Simpanan extends Model
{
    use HasFactory;

    protected $table = 'simpanan';
    protected $primaryKey = 'id_simpanan';

    protected $fillable = [
        'id_simpanan',
        'id_anggota',
        'id_petugas',
        'id_kategori',
        'jumlah',
        'tgl_bayar',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSimpanan::class, 'id_kategori', 'id_kategori');
    }
}
