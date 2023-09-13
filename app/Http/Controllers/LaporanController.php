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
