<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota, Simpanan, Pinjaman,Angsuran, Cicilan, Penarikan, Petugas, Sekolah, KategoriSimpanan};
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

// BillingReportExport
use App\Exports\{BillingReportExport, SimpananBulananReportExport, SimpananTahunanReportExport, PembayaranReportExport,AngsuranExport,PinjamanReportExport,PembayaranTahunanRekapReport};
use Illuminate\Support\Facades\DB;
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

    public function transaksi(Request $request)
    {

        $tgl = $request->tgl??date('Y-m-d');
        // Ambil daftar kategori simpanan dari database
$daftarKategoriSimpanan = KategoriSimpanan::orderBy('id_kategori', 'asc')->get();
  $selectClauses = [
    'tanggal',
    'nama_anggota',
    'nama_petugas',
    'SUM(total_angsuran_bayar_pokok) AS angsuran_bayar_pokok',
    'SUM(total_angsuran_bayar_jasa) AS angsuran_bayar_jasa',
  ];

        foreach ($daftarKategoriSimpanan as $kategori) {
            $selectClauses[] = 'SUM(CASE WHEN id_kategori = ' . $kategori->id_kategori . ' THEN total_simpanan  ELSE 0 END) AS nominal_kategori_id_' . $kategori->id_kategori;
        }
        // dd($selectClauses);

$transaksi = DB::table(DB::raw('
    (SELECT
        DATE(s.tgl_bayar) AS tanggal,
        ag.nama AS nama_anggota,
        p.nama AS nama_petugas,
        SUM(s.jumlah) AS total_simpanan,
        0 AS total_angsuran,
        s.id_kategori AS id_kategori,
        0 AS total_angsuran_bayar_pokok,
        0 AS total_angsuran_bayar_jasa,
        s.keterangan AS keterangan
    FROM Simpanan s
    JOIN Anggota ag ON s.id_anggota = ag.id_anggota
    LEFT JOIN Petugas p ON s.id_petugas = p.id_petugas
    GROUP BY tanggal, id_kategori, ag.nama, p.nama, s.keterangan

    UNION ALL

    SELECT
        DATE(a.tgl_bayar) AS tanggal,
        ag.nama AS nama_anggota,
        p.nama AS nama_petugas,
        0 AS total_simpanan,
        SUM(a.bayar_pokok + a.bayar_jasa) AS total_angsuran,
        NULL AS id_kategori,
        SUM(a.bayar_pokok) AS total_angsuran_bayar_pokok,
        SUM(a.bayar_jasa) AS total_angsuran_bayar_jasa,
        NULL AS keterangan
    FROM Angsuran a
    JOIN Anggota ag ON a.id_anggota = ag.id_anggota
    LEFT JOIN Petugas p ON a.id_petugas = p.id_petugas
    GROUP BY tanggal, ag.nama, p.nama
    ) AS transaksi
'))
->selectRaw(implode(', ', $selectClauses))
->where('tanggal', '=', $tgl)
->groupBy('tanggal', 'nama_anggota', 'nama_petugas')
->orderBy('tanggal')
->get();

// dd($transaksi);
        $title = 'Laporan Transaksi Pembayaran ';

        return view('petugas.laporan.transaksi', compact('transaksi', 'daftarKategoriSimpanan', 'title', 'tgl'));
    }

    public function rekapTransaksi(Request $request)
    {


        $tgl_awal = $request->tgl_awal ? Carbon::parse($request->tgl_awal)->format('Y-m-d') : Carbon::today()->format('Y-m-d');
        $tgl_akhir = $request->tgl_akhir ? Carbon::parse($request->tgl_akhir)->format('Y-m-d') : Carbon::today()->format('Y-m-d');

        // Buat daftar tanggal referensi
        $dates = [];
        $currentDate = Carbon::parse($tgl_awal);

        while ($currentDate <= Carbon::parse($tgl_akhir)) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Ambil daftar kategori simpanan dari database
        $daftarKategoriSimpanan = KategoriSimpanan::orderBy('id_kategori', 'asc')->get();

        $selectClauses = [
            'tanggal',
            'SUM(total_angsuran_bayar_pokok) AS angsuran_bayar_pokok',
            'SUM(total_angsuran_bayar_jasa) AS angsuran_bayar_jasa',
        ];

        foreach ($daftarKategoriSimpanan as $kategori) {
            $selectClauses[] = "SUM(CASE WHEN id_kategori = $kategori->id_kategori  THEN total_simpanan ELSE 0 END) AS nominal_kategori_id_$kategori->id_kategori";

        }

        // Buat kueri menggunakan Laravel Query Builder
        $transaksi = DB::table(DB::raw('
            (SELECT
                DATE(s.tgl_bayar) AS tanggal,
                ag.nama AS nama_anggota,
                p.nama AS nama_petugas,
                SUM(s.jumlah) AS total_simpanan,
                0 AS total_angsuran,
                s.id_kategori AS id_kategori,
                0 AS total_angsuran_bayar_pokok,
                0 AS total_angsuran_bayar_jasa,
                s.keterangan AS keterangan
            FROM Simpanan s
            JOIN Anggota ag ON s.id_anggota = ag.id_anggota
            LEFT JOIN Petugas p ON s.id_petugas = p.id_petugas
            GROUP BY tanggal, id_kategori, ag.nama, p.nama, s.keterangan

            UNION ALL

            SELECT
                DATE(a.tgl_bayar) AS tanggal,
                ag.nama AS nama_anggota,
                p.nama AS nama_petugas,
                0 AS total_simpanan,
                SUM(a.bayar_pokok + a.bayar_jasa) AS total_angsuran,
                NULL AS id_kategori,
                SUM(a.bayar_pokok) AS total_angsuran_bayar_pokok,
                SUM(a.bayar_jasa) AS total_angsuran_bayar_jasa,
                NULL AS keterangan
            FROM Angsuran a
            JOIN Anggota ag ON a.id_anggota = ag.id_anggota
            LEFT JOIN Petugas p ON a.id_petugas = p.id_petugas
            GROUP BY tanggal, ag.nama, p.nama
            ) AS transaksi
        '))
            ->selectRaw(implode(', ', $selectClauses))
            ->whereIn('tanggal', $dates)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'DESC')
            ->get();


        $title = 'Laporan Transaksi Pembayaran ';

        return view('petugas.laporan.rekap-transaksi', compact('transaksi', 'daftarKategoriSimpanan', 'title', 'tgl_awal', 'tgl_akhir', 'dates'));
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
