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

    public function scopeFilter($query, $cari, $anggota_id, $kategori_id, $tanggal_awal, $tanggal_akhir)
    {
        if ($cari) {
            $query->where(function($q) use ($cari) {
                $q->where('tgl_bayar', 'like', '%'.$cari.'%')
                ->orWhere('jumlah', 'like', '%'.$cari.'%')
                ->orWhereHas('anggota', function($query) use ($cari) {
                    $query->where('nama', 'like', '%'.$cari.'%');
                })
                ->orWhereHas('kategori', function($query) use ($cari) {
                    $query->where('nama', 'like', '%'.$cari.'%');
                })
                ->orWhereHas('petugas', function($query) use ($cari) {
                    $query->where('nama', 'like', '%'.$cari.'%');
                });
            });
        }
        if ($anggota_id) {
            $query->where('id_anggota', '=', $anggota_id);
        }
        if ($kategori_id) {
            $query->where('id_kategori', '=', $kategori_id);
        }
        if ($tanggal_awal) {
            $query->where('tgl_bayar', '>=', $tanggal_awal);
        }
        if ($tanggal_akhir) {
            $query->where('tgl_bayar', '<=', $tanggal_akhir);
        }
        return $query;
    }
}

