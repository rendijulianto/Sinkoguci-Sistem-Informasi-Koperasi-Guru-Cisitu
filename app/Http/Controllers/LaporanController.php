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
        $nama_sekolah = $id_sekolah == 'all' ? 'Semua Sekolah' : $sekolah->first()->nama;
        $file_laporan = 'Laporan Simpanan Bulanan '.$nama_sekolah.' Bulan '.$bulan.'-'.$tahun.'.xlsx';
        return Excel::download(new SimpananBulananReportExport($bulan, $sekolah, $daftarKategoriSimpanan, $tahun), $file_laporan);
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
            $nama_sekolah = $id_sekolah == 'all' ? 'Semua Sekolah' : $sekolah->first()->nama;
            $file_laporan = 'Laporan Simpanan Tahunan '.$nama_sekolah.' Tahun '.$tahun.'.xlsx';
          return Excel::download(new SimpananTahunanReportExport($sekolah, $daftarKategoriSimpanan, $tahun), $file_laporan);
         }
           return view('admin.laporan.simpanan-tahunan', compact( 'sekolah', 'daftarSekolah', 'daftarKategoriSimpanan', 'title', 'tahun', 'id_sekolah'));
    }


    public function pinjaman(Request $request)
    {
        $tanggal_awal = date('Y-01-01');
        $tanggal_akhir = date('Y-12-31');
        $cari = $request->cari;
        $status = $request->status;
        $pinjaman = Pinjaman::query();

        if(!empty($request->tanggal_awal) && !empty($request->tanggal_akhir)) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $pinjaman->whereBetween('tgl_pinjam', [$tanggal_awal, $tanggal_akhir]);
        }

        // status
        if (!empty($status)) {
            if ($status == 'lunas') {
                $pinjaman->whereRaw('sisa_pokok = 0 AND sisa_jasa = 0');
            } elseif ($status == 'belum_lunas') {
                $pinjaman->where(function ($query) {
                    $query->where('sisa_pokok', '>', 0)
                        ->orWhere('sisa_jasa', '>', 0);
                });
            }
        }

        if (!empty($cari)) {
            $pinjaman->where(function ($query) use ($cari) {
                $query->where('id_pinjaman', 'like', '%' . $cari . '%')
                    ->orWhere('tgl_pinjam', 'like', '%' . $cari . '%')
                    ->orWhereHas('anggota', function ($query) use ($cari) {
                        $query->where('nama', 'like', '%' . $cari . '%');
                    })->orWhereHas('petugas', function ($query) use ($cari) {
                        $query->where('nama', 'like', '%' . $cari . '%');
                    });
            });
        }


        $title = 'Laporan Pinjaman';

        if($request->aksi == "download") {
            $pinjaman = $pinjaman->orderBy('id_pinjaman', 'desc')->get();
            return Excel::download(new PinjamanReportExport($pinjaman), 'Laporan Pinjaman ' . $tanggal_awal . ' - ' . $tanggal_akhir . '.xlsx');
        }
        $pinjaman = $pinjaman->orderBy('id_pinjaman', 'desc')->paginate(10);

        return view('admin.laporan.pinjaman', compact('title', 'pinjaman', 'tanggal_awal', 'tanggal_akhir', 'cari', 'status'));
    }

    public function pinjamanCicilanDownload(Request $request, string $id)
    {
        $title = 'Cicilan';
        $pinjaman = Pinjaman::findOrFail($id);
        if(!$pinjaman){
            return abort(404);
        }
        return Excel::download(new AngsuranExport($pinjaman), 'Laporan Angsuran ' . $pinjaman->anggota->nama . ' Pinjaman ' . $pinjaman->id_pinjaman . '.xlsx');
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
