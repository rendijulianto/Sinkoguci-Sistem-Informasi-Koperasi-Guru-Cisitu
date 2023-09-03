<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenarikanDanaSosial extends Model
{
    use HasFactory;

    protected $table = 'penarikan_dana_sosial';

    protected $primaryKey = 'id_penarikan';

    protected $fillable = [
        'id_penarikan',
        'id_petugas',
        'id_anggota',
        'tgl_penarikan',
        'jumlah',
        'keterangan',
        'saldo_sebelum',
        'saldo_sesudah',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

}
