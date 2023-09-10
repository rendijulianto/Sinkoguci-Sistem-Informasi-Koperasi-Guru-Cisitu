<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota, Simpanan, Pinjaman, Cicilan, Penarikan, Petugas, Sekolah, KategoriSimpanan};
use Maatwebsite\Excel\Facades\Excel;
// BillingReportExport
use App\Exports\{BillingReportExport, SimpananBulananReportExport, SimpananTahunanReportExport, PembayaranReportExport,AngsuranExport,PinjamanReportExport,PembayaranTahunanRekapReport};
class LaporanController extends Controller
{
    public function tagihan(Request $request)
    {
       $title = 'Laporan Tagihan';
       $bulan = $request->bulan??date('m');
       $tahun = $request->tahun??date('Y');
       $daftarSekolah = Sekolah::orderBy('nama', 'asc')->get();
       $daftarKategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();

       $id_sekolah = $request->id_sekolah??'all';
       if($id_sekolah AND $id_sekolah  != 'all') {
           $sekolah = Sekolah::where('id_sekolah', $id_sekolah)->get();
        } else {
            $sekolah = Sekolah::orderBy('nama', 'asc')->get();
       }
       if($request->aksi == "download") {
        return Excel::download(new BillingReportExport($bulan, $sekolah, $daftarKategoriSimpanan, $tahun), 'Laporan Tagihan.xlsx');
       }
       return view('petugas.laporan.tagihan', compact('bulan', 'sekolah', 'daftarSekolah', 'daftarKategoriSimpanan', 'title', 'tahun', 'id_sekolah'));
    }

    public function pembayaran(Request $request)
    {
      $title = 'Laporan Pembayaran';
      $bulan = $request->bulan??date('m');
      $tahun = $request->tahun??date('Y');
      $id_sekolah = $request->id_sekolah??'all';
      $daftarSekolah = Sekolah::orderBy('nama', 'asc')->get();
      $daftarKategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();

      if($id_sekolah AND $id_sekolah  != 'all') {
          $sekolah = Sekolah::where('id_sekolah', $id_sekolah)->get();
       } else {
           $sekolah = Sekolah::orderBy('nama', 'asc')->get();
      }

      if($request->aksi == "download") {
       return Excel::download(new PembayaranReportExport($bulan, $sekolah, $daftarKategoriSimpanan, $tahun), 'Laporan Pembayaran.xlsx');
      }
      return view('petugas.laporan.pembayaran', compact('bulan', 'sekolah', 'daftarSekolah', 'daftarKategoriSimpanan', 'title', 'tahun', 'id_sekolah'));
    }

    public function simpananBulanan(Request $request)
    {
       $title = 'Laporan Simpanan';
       $bulan = $request->bulan??date('m');
       $tahun = $request->tahun??date('Y');
       $daftarSekolah = Sekolah::orderBy('nama', 'asc')->get();
         $daftarKategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();
       $id_sekolah = $request->id_sekolah??'all';
       if($id_sekolah AND $id_sekolah  != 'all') {
           $sekolah = Sekolah::where('id_sekolah', $id_sekolah)->get();
        } else {
            $sekolah = Sekolah::orderBy('nama', 'asc')->get();
       }
       if($request->aksi == "download") {
        return Excel::download(new SimpananBulananReportExport($bulan, $sekolah, $daftarKategoriSimpanan, $tahun), 'Laporan Simpanan Bulanan-'.$bulan.'-'.$tahun.'.xlsx');
       }
         return view('admin.laporan.simpanan', compact('bulan', 'sekolah', 'daftarSekolah', 'daftarKategoriSimpanan', 'title', 'tahun', 'id_sekolah'));
    }

    public function simpananTahunan(Request $request)
    {
         $title = 'Laporan Simpanan Tahunan';
         $tahun = $request->tahun??date('Y');
         $daftarSekolah = Sekolah::orderBy('nama', 'asc')->get();
         $daftarKategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();
         $id_sekolah = $request->id_sekolah??'all';
         if($id_sekolah AND $id_sekolah  != 'all') {
             $sekolah = Sekolah::where('id_sekolah', $id_sekolah)->get();
          } else {
              $sekolah = Sekolah::orderBy('nama', 'asc')->get();
         }
         if($request->aksi == "download") {
          return Excel::download(new SimpananTahunanReportExport($sekolah, $daftarKategoriSimpanan, $tahun), 'Laporan Simpanan Tahunan-'.$tahun.'.xlsx');
         }
           return view('admin.laporan.simpanan-tahunan', compact( 'sekolah', 'daftarSekolah', 'daftarKategoriSimpanan', 'title', 'tahun', 'id_sekolah'));
    }


    public function pinjaman(Request $request)
    {
        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-t');
        $cari = $request->cari;
        $status = $request->status;
        if ($request->has('tanggal_awal') && $request->has('tanggal_awal')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
        }


        $pinjaman = Pinjaman::where('id_pinjaman', 'like', '%' . $cari . '%')
            ->where('tgl_pinjam', 'like', '%' . $cari . '%')
            ->whereBetween('tgl_pinjam', [$tanggal_awal, $tanggal_akhir])
            ->where(function ($query) use ($status, $cari) {
                if ($status == 'lunas') {
                    $query->where('sisa_pokok', '=', 0)
                        ->where('sisa_jasa', '=', 0);
                } elseif ($status == 'belum_lunas') {
                    $query->where('sisa_pokok', '>', 0)
                        ->orWhere('sisa_jasa', '>', 0);
                }
            })->orWhereHas('anggota', function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })->orWhereHas('petugas', function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })
            ->orderBy('sisa_pokok', 'desc')->orderBy('sisa_jasa', 'desc')->paginate(10);

        $title = 'Laporan Pinjaman';

        if($request->aksi == "download") {
            $pinjaman = Pinjaman::where('id_pinjaman', 'like', '%' . $cari . '%')
            ->where('tgl_pinjam', 'like', '%' . $cari . '%')
            ->whereBetween('tgl_pinjam', [$tanggal_awal, $tanggal_akhir])
            ->where(function ($query) use ($status, $cari) {
                if ($status == 'lunas') {
                    $query->where('sisa_pokok', '=', 0)
                        ->where('sisa_jasa', '=', 0);
                } elseif ($status == 'belum_lunas') {
                    $query->where('sisa_pokok', '>', 0)
                        ->orWhere('sisa_jasa', '>', 0);
                }
            })->orWhereHas('anggota', function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })->orWhereHas('petugas', function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })
            ->orderBy('sisa_pokok', 'desc')->orderBy('sisa_jasa', 'desc')->get();
            return Excel::download(new PinjamanReportExport($pinjaman), 'Laporan Pinjaman.xlsx');
        }

        return view('admin.laporan.pinjaman', compact('title', 'pinjaman', 'tanggal_awal', 'tanggal_akhir', 'cari', 'status'));
    }

    public function pinjamanCicilanDownload(Request $request, string $id)
    {
        $title = 'Cicilan';
        $pinjaman = Pinjaman::findOrFail($id);
        if(!$pinjaman){
            return abort(404);
        }
        return Excel::download(new AngsuranExport($pinjaman), 'Data-Cicilan-' . $pinjaman->id_pinjaman . '.xlsx');
    }

    public function pembayaranBulanan(Request $request)
    {
      $title = 'Laporan Pembayaran';
      $bulan = $request->bulan??date('m');
      $tahun = $request->tahun??date('Y');
      $id_sekolah = $request->id_sekolah??'all';
      $daftarSekolah = Sekolah::orderBy('nama', 'asc')->get();
      $daftarKategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();

      if($id_sekolah AND $id_sekolah  != 'all') {
          $sekolah = Sekolah::where('id_sekolah', $id_sekolah)->get();
       } else {
           $sekolah = Sekolah::orderBy('nama', 'asc')->get();
      }

      if($request->aksi == "download") {
       return Excel::download(new PembayaranReportExport($bulan, $sekolah, $daftarKategoriSimpanan, $tahun), 'Laporan Pembayaran.xlsx');
      }
      return view('admin.laporan.pembayaran', compact('bulan', 'sekolah', 'daftarSekolah', 'daftarKategoriSimpanan', 'title', 'tahun', 'id_sekolah'));
    }


    public function pembayaranTahunan(Request $request)
    {
      $title = 'Laporan Pembayaran';
      $tahun = $request->tahun??date('Y');
      $id_sekolah = $request->id_sekolah??'all';
      $daftarSekolah = Sekolah::orderBy('nama', 'asc')->get();
      $daftarKategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();

      if($id_sekolah AND $id_sekolah  != 'all') {
          $sekolah = Sekolah::where('id_sekolah', $id_sekolah)->get();
       } else {
           $sekolah = Sekolah::orderBy('nama', 'asc')->get();
      }

      if($request->aksi == "download") {
       return Excel::download(new PembayaranTahunanRekapReport($sekolah, $daftarKategoriSimpanan, $tahun), 'Laporan Pembayaran.xlsx');
      }
      return view('admin.laporan.pembayaran-tahunan', compact('sekolah', 'daftarSekolah', 'daftarKategoriSimpanan', 'title', 'tahun', 'id_sekolah'));
    }


}
