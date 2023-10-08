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
        return $this->hasMany(KategoriSimpananAnggota::class, 'id_anggota');
    }

    public function scopeFilter($query, $id_sekolah, $cari)
    {
        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', '%' . $cari . '%')->orWhere('id_anggota', 'like', '%' . $cari . '%')->orWhere('alamat', 'like', '%' . $cari . '%');
            });
        }
        if ($id_sekolah) {
            if ($id_sekolah == 'all') {
                $query->where('id_sekolah', '!=', null);
            } else {
                $query->where('id_sekolah', $id_sekolah);
            }
        }
        return $query;
    }

    public function kategori_simpanan_default($update = null)
    {
        $default = [];
        $kategori = KategoriSimpanan::select('id_kategori','nama', 'jumlah')->orderBy('id_kategori', 'asc')->get();
        foreach ($kategori as $k) {
            $kategori_simpanan = KategoriSimpananAnggota::where('id_anggota', $this->id_anggota)->where('id_kategori', $k->id_kategori)->first();
            $nominal = $k->jumlah;
            if($kategori_simpanan != null) {
                $nominal = $kategori_simpanan->nominal;
            }
            if($k->id_kategori == 1 AND !$update) {
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
            $kategori = $this->kategori_simpanan_anggota()->whereHas('kategori', function($q) {
                $q->where('nama', 'like', '%Simpanan%');
            })->get();
            foreach ($kategori as $k) {
                $sisaSimpanan[] = [
                    'id_kategori' => $k->id_kategori,
                    'nama' => $k->kategori->nama,
                    'nominal' => $k->saldo,
                ];
            }
        }
        return $sisaSimpanan;
    }

    // public function getSimpanan($tahun, $bulan = null, $tanggal = null)
    // {
    //     // jika $tanggal tidak null, maka ambil simpanan pada tanggal tersebut
    //     // jika $tanggal null dan $bulan tidak null, maka ambil simpanan pada bulan tersebut
    //     //
    // }

    // public function simpananBulan($bulan)
    // {
    //     $kategori = KategoriSimpanan::select('id_kategori', 'nama')->orderBy('id_kategori', 'asc')->get();
    //     $simpanan = [];
    //     $bulan = '01-'.$bulan.'-'.date('Y');
    //     $simpanan[] = Carbon::parse($bulan)->translatedFormat('F Y');
    //     $total = 0;
    //     foreach ($kategori as $key => $value) {
    //         $simpanan[] = $this->simpanan()->where('id_kategori', $value->id_kategori)->whereMonth('tgl_bayar', Carbon::parse($bulan)->format('m'))->sum('jumlah');
    //         $total += $simpanan[$key+1];
    //     }
    //     $simpanan['total'] = $total;
    //     return $simpanan;
    // }

    public function getSimpanan($tahun, $bulan = null, $tanggal = null)
    {
        $simpanan = [];
        $group = '';
        if ($tahun) {
            $group = Carbon::parse('01-01-'.$tahun)->translatedFormat('Y');
        }
        if ($bulan) {
            $group = Carbon::parse('01-'.$bulan.'-'.$tahun)->translatedFormat('F Y');
        }
        if ($tanggal) {
            $group = Carbon::parse($tanggal.'-'.$bulan.'-'.$tahun)->translatedFormat('d F Y');
        }
        $kategori = KategoriSimpanan::select('id_kategori', 'nama')->orderBy('id_kategori', 'asc')->get();
        $simpanan[] = $group;
        $total = 0;

        foreach ($kategori as $key => $value) {
            $query = $this->simpanan()->where('id_kategori', $value->id_kategori);
            if($tahun) {
                $query = $query->whereYear('tgl_bayar', $tahun);
            }
            if($bulan) {
                $query = $query->whereMonth('tgl_bayar', $bulan);
            }
            if($tanggal) {
                $query = $query->whereDay('tgl_bayar', $tanggal);
            }
            $simpanan[] = $query->sum('jumlah');
            $total += $simpanan[$key + 1];
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

    public function getTagihanSimpanan($bulan, $tahun)
    {
        // Ambil data kategori simpanan
        $kategori = KategoriSimpanan::select('id_kategori', 'nama', 'jumlah')->orderBy('id_kategori', 'asc')->get();

        // Inisialisasi array tagihan
        $tagihan = [];
        $total = 0;

        $bulanTahunSekarang = Carbon::parse('01-'. date('m-Y'))->timestamp;
        $bulanTahunTagihan = Carbon::parse('01-'. $bulan .'-'. $tahun)->timestamp;


        foreach ($kategori as $k) {
            // Hitung total simpanan berdasarkan kategori untuk bulan dan tahun tertentu
            $total_simpanan = $this->simpanan()
                ->where('id_kategori', $k->id_kategori)
                ->whereMonth('tgl_bayar', $bulan)
                ->whereYear('tgl_bayar', $tahun)
                ->sum('jumlah');

            if ($bulanTahunTagihan < $bulanTahunSekarang) {
                $jumlah_tagihan = $total_simpanan ?? 0;
            } else {
                $jumlah_tagihan = $this->kategori_simpanan_anggota()
                    ->where('id_kategori', $k->id_kategori)
                    ->first()
                    ->nominal ?? $k->jumlah;
            }

            // Hitung tagihan yang belum dibayar
            $tagihan[] = ($k->id_kategori == 1) ? 0 : max(0, $jumlah_tagihan - $total_simpanan);

            // Akumulasikan total tagihan
            $total += $tagihan[count($tagihan) - 1];
        }

        // Tambahkan total tagihan ke dalam array tagihan
        $tagihan['total'] = $total;

        return $tagihan;
    }

    public function terbayarSimpanan($tahun, $bulan = null) {
        // Ambil data kategori simpanan
        $kategori = KategoriSimpanan::select('id_kategori', 'nama', 'jumlah')->orderBy('id_kategori', 'asc')->get();

        // Inisialisasi array terbayar
        $terbayar = [];
        $total = 0;

        foreach ($kategori as $k) {
            // Query untuk mengambil riwayat simpanan berdasarkan kategori dan tahun
            $riwayat_simpanan_query = $this->simpanan()
                ->where('id_kategori', $k->id_kategori)
                ->whereYear('tgl_bayar', $tahun);

            // Jika bulan diisi, tambahkan kondisi where untuk bulan
            if ($bulan) {
                $riwayat_simpanan_query->whereMonth('tgl_bayar', $bulan);
            }

            // Ambil data riwayat simpanan
            $riwayat_simpanan = $riwayat_simpanan_query->get();

            // Hitung total yang sudah dibayar
            $sudah_dibayar = $riwayat_simpanan->sum('jumlah');

            // Tambahkan total yang sudah dibayar ke dalam array terbayar
            $terbayar[] = $sudah_dibayar;

            // Akumulasikan total terbayar
            $total += $sudah_dibayar;
        }

        // Tambahkan total terbayar ke dalam array terbayar
        $terbayar['total'] = $total;

        return $terbayar;
    }


    public function tagihanPinjaman()
    {
        // Cek apakah memiliki pinjaman dengan sisa pokok atau sisa jasa yang lebih dari 0
        $pinjaman = Pinjaman::where('id_anggota', $this->id_anggota)
            ->where(function ($q) {
                $q->where('sisa_pokok', '>', 0)->orWhere('sisa_jasa', '>', 0);
            })
            ->first();

        // Inisialisasi array tagihan
        $tagihan = [
            'pokok' => 0,
            'jasa' => 0,
            'angsuran' =>  0,
            'total' => 0
        ];

        if ($pinjaman) {
            // Hitung nominal angsuran
            $nominal_angsuran = $pinjaman->nominal / $pinjaman->lama_angsuran;

            // Isi nilai tagihan berdasarkan data pinjaman
            $tagihan['pokok'] = $pinjaman->sisa_pokok;
            $tagihan['angsuran'] = min($nominal_angsuran, $pinjaman->sisa_pokok);
            $tagihan['jasa'] = $pinjaman->sisa_jasa;
        }

        // Hitung total tagihan
        $tagihan['total'] = $tagihan['pokok'] + $tagihan['jasa'];

        return $tagihan;
    }


    public function terbayarPinjaman($tahun, $bulan = null)
    {
        // Cek apakah memiliki pinjaman dengan sisa pokok atau sisa jasa yang lebih dari 0
        $pinjaman = Pinjaman::where('id_anggota', $this->id_anggota)
            ->where(function ($q) {
                $q->where('sisa_pokok', '>', 0)->orWhere('sisa_jasa', '>', 0);
            })
            ->first();

        // Inisialisasi array terbayar
        $terbayar = [
            'pokok' => 0,
            'jasa' => 0,
            'total' => 0
        ];

        if ($pinjaman) {
            // Query untuk mengambil riwayat angsuran berdasarkan pinjaman, tahun, dan bulan (jika diisi)
            $riwayat_angsuran_query = $pinjaman->angsuran()->whereYear('tgl_bayar', $tahun);

            if ($bulan) {
                $riwayat_angsuran_query->whereMonth('tgl_bayar', $bulan);
            }

            // Ambil data riwayat angsuran
            $riwayat_angsuran = $riwayat_angsuran_query->get();

            // Hitung total yang sudah dibayar
            $terbayar['pokok'] = $riwayat_angsuran->sum('bayar_pokok');
            $terbayar['jasa'] = $riwayat_angsuran->sum('bayar_jasa');

            // Hitung total terbayar
            $terbayar['total'] = $terbayar['pokok'] + $terbayar['jasa'];
        }

        return $terbayar;
    }
}
