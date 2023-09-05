<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota, Simpanan, Pinjaman, Cicilan, Penarikan, Petugas, Sekolah, KategoriSimpanan};
use Maatwebsite\Excel\Facades\Excel;
// BillingReportExport
use App\Exports\{BillingReportExport};
class LaporanController extends Controller
{
    public function tagihan(Request $request)
    {
       $title = 'Laporan Tagihan';
       $bulan = $request->bulan??date('m');
       $tahun = $request->tahun??date('Y');
       $daftarSekolah = Sekolah::orderBy('nama', 'asc')->get();
       $daftarKategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();
       $sekolah = '';
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

    public function previewTagihan(Request $request)
    {
        $aksi = $request->aksi??'';
        $bulan = $request->bulan??date('m-Y');
        $id_sekolah = $request->id_sekolah??'';
        $sekolah = Sekolah::where('id', $id_sekolah)->first();
        if ($aksi == 'cetak') {
            $anggota = Anggota::where('id_sekolah', $id_sekolah)->orderBy('nama', 'asc')->get();
            return view('petugas.laporan.preview-tagihan', compact('bulan', 'sekolah', 'anggota'));
        } else {
            $anggota = Anggota::where('id_sekolah', $id_sekolah)->orderBy('nama', 'asc')->paginate(10);
            return view('petugas.laporan.preview-tagihan', compact('bulan', 'sekolah', 'anggota'));
        }
    }


}
