<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'angsuran';

    protected $fillable = [
        'id_pinjaman',
        'id_petugas',
        'bayar_pokok',
        'bayar_jasa',
        'tgl_bayar',
        'sebelum_pokok',
        'sebelum_jasa',
        'setelah_pokok',
        'setelah_jasa',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman', 'id_pinjaman');
    }
}
