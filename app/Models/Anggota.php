<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
  

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }


    public function simpanan()
    {
        return $this->hasMany(Simpanan::class, 'id_anggota', 'id_anggota');
    }

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class, 'id_anggota', 'id_anggota');
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
        return $this->belongsToMany(KategoriSimpanan::class, 'kategori_simpanan_anggota', 'id_anggota', 'id_kategori');
    }

    public function kategori_simpanan_anggota()
    {
        return $this->hasMany(KategoriSimpananAnggota::class, 'id_anggota', 'id_anggota');
    }

    public function kategori_simpanan_default()
    {
        $default = [];
        $kategori = KategoriSimpanan::select('id_kategori','nama', 'jumlah')->where('nama', 'like', '%Simpanan%')->orderBy('id_kategori', 'asc')->get();
        foreach ($kategori as $k) {
            $kategori_simpanan = KategoriSimpananAnggota::where('id_anggota', $this->id_anggota)->where('id_kategori', $k->id_kategori)->first();
            $nominal = $k->jumlah;
            if($kategori_simpanan != null) {
                $nominal = $kategori_simpanan->nominal;
            }
            if($k->id_kategori == 1) {
                $check_simpanan = Simpanan::where('id_anggota', $this->id_anggota)->where('id_kategori', $k->id_kategori)->first();
                if($check_simpanan != null) {
                    $nominal = 0;
                }
            }
            $default[strtolower(str_replace(' ', '_', $k->nama))] = $nominal;
        }
        return $default;
    }

    public function sisaSimpanan()
    {
        $sisaSimpanan = [];
        $kategori = KategoriSimpanan::select('id_kategori', 'nama')->where('nama', 'like', '%Simpanan%')->orderBy('id_kategori', 'asc')->get();
        foreach ($kategori as $k) {
            $sisaSimpanan[strtolower(str_replace(' ', '_', $k->nama))] = Simpanan::where('id_anggota', $this->id_anggota)->where('id_kategori', $k->id_kategori)->sum('jumlah') - Penarikan::where('id_anggota', $this->id_anggota)->where('id_kategori', $k->id_kategori)->sum('jumlah');
        }
        return $sisaSimpanan;
    }

    public function simpananBulan($bulan)
    {
        $kategori = KategoriSimpanan::select('id_kategori', 'nama')->orderBy('id_kategori', 'asc')->get();
        $simpanan = [];
        $bulan = '01-'.$bulan.'-'.date('Y');
        $simpanan['bulan'] = Carbon::parse($bulan)->translatedFormat('F Y');
        $total = 0;
        foreach ($kategori as $key => $value) {
            $simpanan[strtolower(str_replace(' ', '_', $value->nama))] = $this->simpanan()->where('id_kategori', $value->id_kategori)->whereMonth('tgl_bayar', Carbon::parse($bulan)->format('m'))->sum('jumlah');
            $total += $simpanan[strtolower(str_replace(' ', '_', $value->nama))];
        }
        $simpanan['total'] = $total;
        return $simpanan;
    }
}
