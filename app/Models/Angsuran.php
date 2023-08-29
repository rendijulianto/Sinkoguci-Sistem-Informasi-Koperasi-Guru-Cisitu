<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;

    protected $table = 'angsuran';

    protected $fillable = [
        'id_pinjaman',
        'id_petugas',
        'angsuran_ke',
        'tgl_bayar',
        'pokok',
        'jasa',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_pinjaman', 'id_pinjaman');
    }
}
