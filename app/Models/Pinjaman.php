<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';
    protected $primaryKey = 'id_pinjaman';

    protected $fillable = [
        'id_pinjaman',
        'id_anggota',
        'id_petugas',
        'tgl_pinjam',
        'pokok',
        'lama_angsuran',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class, 'id_pinjaman', 'id_pinjaman');
    }
    
    // apppend status
    public function getStatusAttribute()
    {
        $total_pokok = $this->pokok;
        $total_angsuran_pokok = $this->angsuran->sum('pokok');
        $sisa_pinjaman = $total_pokok - $total_angsuran_pokok;
        if ($sisa_pinjaman == 0) {
            return 'Lunas';
        } else {
            return 'Belum Lunas (Rp. ' . number_format($sisa_pinjaman, 0, ',', '.') . ')';
        }
    }
}
