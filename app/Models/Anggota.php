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
        $kategori = KategoriSimpanan::select('id_kategori','nama', 'jumlah')->orderBy('id_kategori', 'asc')->get();
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
            $sisaSimpanan[strtolower(str_replace(' ', '_', $k->nama))] = KategoriSimpananAnggota::where('id_anggota', $this->id_anggota)->where('id_kategori', $k->id_kategori)->first()->saldo ?? 0;
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

    public function tagihanSimpanan($bulan)
    {
        // cek apakah sudah ada simpanan untuk bulan ini
        $kategori = KategoriSimpanan::select('id_kategori', 'nama', 'jumlah')->orderBy('id_kategori', 'asc')->get();
        $simpanan = [];
        $bulan = '01-'.$bulan.'-'.date('Y');
      
        $total = 0;
        foreach ($kategori as $key => $value) {
            // cek apakah sudah ada simpanan untuk bulan ini dan kategori ini jika sudah maka tidak perlu ditagih
            $cek = Simpanan::where('id_anggota', $this->id_anggota)->where('id_kategori', $value->id_kategori)->whereMonth('tgl_bayar', Carbon::parse($bulan)->format('m'))->first();
            $tagihan = KategoriSimpananAnggota::where('id_anggota', $this->id_anggota)->where('id_kategori', $value->id_kategori)->first();
            if($tagihan == null) {
                $jumlah_tagihan = $value->jumlah;
            } else {
                $jumlah_tagihan = $tagihan->nominal;
            }
           
            if($cek == null) {
                // cek apakah simpanan pokok pernah dibayar
                if($value->id_kategori == 1) {
                    $cek = Simpanan::where('id_anggota', $this->id_anggota)->where('id_kategori', $value->id_kategori)->first();
                    if($cek != null) {
                        $simpanan[strtolower(str_replace(' ', '_', $value->nama))] = 0;
                    } else {
                        $simpanan[strtolower(str_replace(' ', '_', $value->nama))] = $jumlah_tagihan;
                        $total += $simpanan[strtolower(str_replace(' ', '_', $value->nama))];
                    }
                } else {
                    $simpanan[strtolower(str_replace(' ', '_', $value->nama))] = $jumlah_tagihan;
                    $total += $simpanan[strtolower(str_replace(' ', '_', $value->nama))];
                }
            } else  if ($value->id_kategori == 1) {
                $simpanan[strtolower(str_replace(' ', '_', $value->nama))] = 0;
            } else {
                $simpanan[strtolower(str_replace(' ', '_', $value->nama))] = $jumlah_tagihan - $cek->jumlah;
                $total += $simpanan[strtolower(str_replace(' ', '_', $value->nama))];
            }
        }
        $simpanan['total'] = $total;
        return $simpanan;
    }

    public function tagihanPinjaman()
    {
        // cek apakah memiliki pinjaman
        $pinjaman = Pinjaman::where('id_anggota', $this->id_anggota)->where(function($q) {
            $q->where('sisa_pokok', '>', 0)->orWhere('sisa_jasa', '>', 0);
        })->get();
        $tagihan = [
            'pokok' => 0,
            'jasa' => 0,
            'total' => 0
        ];
        
        foreach ($pinjaman as $p) {
            $tagihan['pokok'] += $p->sisa_pokok;
            $tagihan['jasa'] += $p->sisa_jasa;
        }
        $tagihan['total'] = $tagihan['pokok'] + $tagihan['jasa'];
        return $tagihan;
    }
}
