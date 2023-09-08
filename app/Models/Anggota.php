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
            $default[] = [
                'id_kategori' => $k->id_kategori,
                'nama' => $k->nama,
                'jumlah' => $nominal,
            ];
        }
        return $default;
    }

    public function sisaSimpanan($id_kategori = null)
    {
        if($id_kategori) {
            $sisaSimpanan = $this->kategori_simpanan_anggota()->where('id_kategori', $id_kategori)->first()->saldo ?? 0;
        } else {
            $sisaSimpanan = [];
            $kategori = KategoriSimpanan::select('id_kategori', 'nama')->where('nama', 'like', '%Simpanan%')->orderBy('id_kategori', 'asc')->get();
            foreach ($kategori as $k) {
                $sisaSimpanan[] = [
                    'id_kategori' => $k->id_kategori,
                    'nama' => $k->nama,
                    'nominal' => $this->kategori_simpanan_anggota()->where('id_kategori', $k->id_kategori)->first()->saldo ?? 0,
                ];
            }
        }
        return $sisaSimpanan;
    }

    public function simpananBulan($bulan)
    {
        $kategori = KategoriSimpanan::select('id_kategori', 'nama')->orderBy('id_kategori', 'asc')->get();
        $simpanan = [];
        $bulan = '01-'.$bulan.'-'.date('Y');
        $simpanan[] = Carbon::parse($bulan)->translatedFormat('F Y');
        $total = 0;
        foreach ($kategori as $key => $value) {
            $simpanan[] = $this->simpanan()->where('id_kategori', $value->id_kategori)->whereMonth('tgl_bayar', Carbon::parse($bulan)->format('m'))->sum('jumlah');
            $total += $simpanan[$key+1];
        }
        $simpanan['total'] = $total;
        return $simpanan;
    }

    public function simpananHari($tahun)
    {
        $kategori = KategoriSimpanan::select('id_kategori', 'nama')->orderBy('id_kategori', 'asc')->get();
        $simpanan = [];
        // munculkan tgl_bayarnya saja yang ada simpanan di tahun $tahun
        $tgl_bayar = $this->simpanan()->whereYear('tgl_bayar', $tahun)->orderBy('tgl_bayar', 'asc')->pluck('tgl_bayar')->unique();
        foreach ($tgl_bayar as $tgl) {
            $simpanan[] = [
                'tgl_bayar' => Carbon::parse($tgl)->translatedFormat('d F Y'),
                'simpanan' => []
            ];
            $total = 0;
            foreach ($kategori as $key => $value) {
                $simpanan[count($simpanan)-1]['simpanan']['keterangan'] = $this->simpanan()->where('id_kategori', $value->id_kategori)->where('tgl_bayar', $tgl)->first()->keterangan ?? '';
                $simpanan[count($simpanan)-1]['simpanan'][] = $this->simpanan()->where('id_kategori', $value->id_kategori)->where('tgl_bayar', $tgl)->first()->jumlah ?? 0;
                $total += $simpanan[count($simpanan)-1]['simpanan'][$key];
            }
            $simpanan[count($simpanan)-1]['simpanan']['total'] = $total;
        }
        return $simpanan;
    }

    public function tagihanSimpanan($bulan, $tahun)
    {
        // cek apakah sudah ada simpanan untuk bulan ini
        $kategori = KategoriSimpanan::select('id_kategori', 'nama', 'jumlah')->orderBy('id_kategori', 'asc')->get();
        $tagihan = [];
        $total = 0;
        foreach ($kategori as $k) {
            $riwayat_simpanan = $this->simpanan()->where('id_kategori', $k->id_kategori)->whereMonth('tgl_bayar', $bulan)->whereYear('tgl_bayar', $tahun)->get();
            $sudah_dibayar = 0;
            $jumlah_tagihan = $this->kategori_simpanan_anggota()->where('id_kategori', $k->id_kategori)->first()->nominal ?? $k->jumlah;
            foreach ($riwayat_simpanan as $r) {
                $sudah_dibayar += $r->jumlah;
            }
            if(count($riwayat_simpanan) == 0) {
                if($k->id_kategori == 1) {
                    $tagihan[] = 0;
                } else {
                    $tagihan[] = $jumlah_tagihan;
                }
            } else if ($k->id_kategori == 1) {
                $tagihan[] = 0;
            } else {
                $tagihan[] = $jumlah_tagihan - $sudah_dibayar;
            }
            $total += $tagihan[count($tagihan)-1];
        }
        $tagihan['total'] = $total;
        return $tagihan;
    }

    public function terbayarSimpanan($tahun, $bulan = null) {
        $kategori = KategoriSimpanan::select('id_kategori', 'nama', 'jumlah')->orderBy('id_kategori', 'asc')->get();
        $terbayar = [];
        $total = 0;
        foreach ($kategori as $k) {
            $riwayat_simpanan = $this->simpanan()->where('id_kategori', $k->id_kategori)->whereYear('tgl_bayar', $tahun);

            if($bulan) {
                $riwayat_simpanan = $riwayat_simpanan->whereMonth('tgl_bayar', $bulan);
            }
            $riwayat_simpanan = $riwayat_simpanan->get();
            $sudah_dibayar = 0;
            foreach ($riwayat_simpanan as $r) {
                $sudah_dibayar += $r->jumlah;
            }
            $terbayar[] = $sudah_dibayar;
            $total += $terbayar[count($terbayar)-1];
        }
        $terbayar['total'] = $total;
        return $terbayar;
    }

    public function tagihanPinjaman()
    {
        // cek apakah memiliki pinjaman
        $pinjaman = Pinjaman::where('id_anggota', $this->id_anggota)->where(function($q) {
            $q->where('sisa_pokok', '>', 0)->orWhere('sisa_jasa', '>', 0);
        })->first();

        $tagihan = [
            'pokok' => 0,
            'jasa' => 0,
            'angsuran' =>  0,
            'total' => 0
        ];

        if($pinjaman) {
            $nominal_angsuran = $pinjaman->nominal / $pinjaman->lama_angsuran;
            $tagihan['pokok'] = $pinjaman->sisa_pokok;
            $tagihan['angsuran'] = $nominal_angsuran < $pinjaman->sisa_pokok ? $nominal_angsuran : $pinjaman->sisa_pokok;
            $tagihan['jasa'] = $pinjaman->sisa_jasa;
        }
        $tagihan['total'] = $tagihan['pokok'] + $tagihan['jasa'];
        return $tagihan;
    }

    public function terbayarPinjaman($tahun, $bulan = null)
    {
        // cek apakah memiliki pinjaman
        $pinjaman = Pinjaman::where('id_anggota', $this->id_anggota)->where(function($q) {
            $q->where('sisa_pokok', '>', 0)->orWhere('sisa_jasa', '>', 0);
        })->first();
        $terbayar = [
            'pokok' => 0,
            'jasa' => 0,
            'total' => 0
        ];

        if($pinjaman) {
            $riwayat_angsuran = $pinjaman->angsuran()->whereYear('tgl_bayar', $tahun);
            if($bulan) {
                $riwayat_angsuran = $riwayat_angsuran->whereMonth('tgl_bayar', $bulan);
            }
            $riwayat_angsuran = $riwayat_angsuran->get();
            foreach ($riwayat_angsuran as $r) {
                $terbayar['pokok'] += $r->bayar_pokok;
                $terbayar['jasa'] += $r->bayar_jasa;
            }
            $terbayar['total'] = $terbayar['pokok'] + $terbayar['jasa'];
        }
        return $terbayar;


    }


}
