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


    public function anggota()
    {
        return $this->belongsToMany(Anggota::class, 'kategori_simpanan_anggota', 'id_kategori', 'id_anggota');
    }

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class, 'id_kategori', 'id_kategori');
    }

    public function kategori_simpanan_anggota()
    {
        return $this->hasMany(KategoriSimpananAnggota::class, 'id_kategori', 'id_kategori');
    }

    public static function scopeFilter($query, $cari)
    {
        if ($cari) {
            $query->where(function($q) use ($cari) {
                $q->where('nama', 'like', '%'.$cari.'%')
                ->orWhere('id_kategori', 'like', '%'.$cari.'%');
            });
        }
        return $query;
    }


}
