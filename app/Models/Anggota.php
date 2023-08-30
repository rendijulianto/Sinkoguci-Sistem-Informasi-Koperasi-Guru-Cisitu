<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'id_anggota',
        'id_petugas',
        'id_sekolah',
        'nama',
        'alamat',
        'tgl_lahir',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class, 'id_anggota', 'id_anggota');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }

    public function penarikan()
    {
        return $this->hasMany(Penarikan::class, 'id_anggota', 'id_anggota');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class, 'id_anggota', 'id_anggota');
    }

    public function kategori_simpanan()
    {
        return $this->belongsToMany(KategoriSimpananAnggota::class, 'kategori_simpanan_anggota', 'id_anggota', 'id_kategori_simpanan');
    }
}
