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
        'tgl_terakhir_bayar',
        'tgl_update_jasa',
        'nominal',
        'lama_angsuran',
        'sisa_pokok',
        'sisa_jasa',
        'status',

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

        if ($this->sisa_pokok == 0 && $this->sisa_jasa == 0) {
            return 'Lunas';
        } else {
            return 'Belum Lunas';
        }
    }

    public function scopeFilter($query, $cari,  $status, $tanggal_awal, $tanggal_akhir)
    {
        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('tgl_pinjam', 'like', '%' . $cari . '%')
                    ->orWhere('nominal', 'like', '%' . $cari . '%')
                    ->orWhere('lama_angsuran', 'like', '%' . $cari . '%')
                    ->orWhere('sisa_pokok', 'like', '%' . $cari . '%')
                    ->orWhere('sisa_jasa', 'like', '%' . $cari . '%')
                    ->orWhereHas('anggota', function ($query) use ($cari) {
                        $query->where('nama', 'like', '%' . $cari . '%');
                    })
                    ->orWhereHas('petugas', function ($query) use ($cari) {
                        $query->where('nama', 'like', '%' . $cari . '%');
                    });
            });
        }
        if ($status) {
            if ($status == 'lunas') {
                $query->where(function ($query) {
                    $query->where('sisa_pokok', '=', 0)
                        ->where('sisa_jasa', '=', 0);
                });
            } else {
                $query->where(function ($query) {
                    $query->where('sisa_pokok', '>', 0)
                        ->orWhere('sisa_jasa', '>', 0);
                });
            }
        }
        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereBetween('tgl_pinjam', [$tanggal_awal, $tanggal_akhir]);
        }
        return $query;
    }



}
