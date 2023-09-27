<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota, Simpanan, Pinjaman,Angsuran, Cicilan, Penarikan, Petugas, Sekolah, KategoriSimpanan};
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

// BillingReportExport
use App\Exports\{BillingReportExport, SimpananBulananReportExport, SimpananTahunanReportExport, PembayaranReportExport,AngsuranExport,PinjamanReportExport,PembayaranTahunanRekapReport, RekapPembayaranReportExport};
use Illuminate\Support\Facades\DB;
class LaporanController extends Controller
{
    public function tagihan(Request $request)
    {
       $title = 'Laporan Tagihan';
       $bulan = $request->bulan;
       $tahun = $request->tahun;
       $daftarSekolah = Sekolah::select('id_sekolah', 'nama')->orderBy('nama', 'asc')->get();
       $daftarKategoriSimpanan = KategoriSimpanan::select('id_kategori', 'nama')->orderby('id_kategori', 'asc')->get();

       $id_sekolah = $request->id_sekolah;
       if($id_sekolah AND $id_sekolah  != 'all') {
           $sekolah = Sekolah::select('id_sekolah', 'nama')->where('id_sekolah', $id_sekolah)->get();
        } else {
            $sekolah = Sekolah::select('id_sekolah', 'nama')->orderBy('nama', 'asc')->get();
       }
       if($request->aksi == "download") {
        return Excel::download(new BillingReportExport($bulan, $sekolah, $daftarKategoriSimpanan, $tahun), 'Laporan Tagihan.xlsx');
       }
       return view('petugas.laporan.tagihan', compact('bulan', 'sekolah', 'daftarSekolah', 'daftarKategoriSimpanan', 'title', 'tahun', 'id_sekolah'));
    }


    public function pembayaran(Request $request)
    {

        $tgl = $request->tgl??date('Y-m-d');
        // Ambil daftar kategori simpanan dari database
$daftarKategoriSimpanan = KategoriSimpanan::orderBy('id_kategori', 'asc')->get();
  $selectClauses = [
    'tanggal',
    'nama_anggota',
    'nama_petugas',
    'keterangan',
    'SUM(total_angsuran_bayar_pokok) AS angsuran_bayar_pokok',
    'SUM(total_angsuran_bayar_jasa) AS angsuran_bayar_jasa',
  ];

        foreach ($daftarKategoriSimpanan as $kategori) {
            $selectClauses[] = 'SUM(CASE WHEN id_kategori = ' . $kategori->id_kategori . ' THEN total_simpanan  ELSE 0 END) AS nominal_kategori_id_' . $kategori->id_kategori;
        }
        // dd($selectClauses);

$pembayaran = DB::table(DB::raw('
    (SELECT
        DATE(s.tgl_bayar) AS tanggal,
        ag.nama AS nama_anggota,
        p.nama AS nama_petugas,
        sekolah.nama AS keterangan,
        SUM(s.jumlah) AS total_simpanan,
        0 AS total_angsuran,
        s.id_kategori AS id_kategori,
        0 AS total_angsuran_bayar_pokok,
        0 AS total_angsuran_bayar_jasa
    FROM simpanan s
    JOIN anggota ag ON s.id_anggota = ag.id_anggota
    LEFT JOIN petugas p ON s.id_petugas = p.id_petugas
    JOIN sekolah ON ag.id_sekolah = sekolah.id_sekolah
    GROUP BY tanggal, id_kategori, ag.nama, p.nama, sekolah.nama

    UNION ALL

    SELECT
        DATE(a.tgl_bayar) AS tanggal,
        ag.nama AS nama_anggota,
        p.nama AS nama_petugas,
        sekolah.nama AS keterangan,
        0 AS total_simpanan,
        SUM(a.bayar_pokok + a.bayar_jasa) AS total_angsuran,
        NULL AS id_kategori,
        SUM(a.bayar_pokok) AS total_angsuran_bayar_pokok,
        SUM(a.bayar_jasa) AS total_angsuran_bayar_jasa
    FROM angsuran a
    JOIN anggota ag ON a.id_anggota = ag.id_anggota
    LEFT JOIN petugas p ON a.id_petugas = p.id_petugas
    LEFT JOIN sekolah ON ag.id_sekolah = sekolah.id_sekolah
    GROUP BY tanggal, ag.nama, p.nama, sekolah.nama
    ) AS pembayaran
'))
->selectRaw(implode(', ', $selectClauses))
->where('tanggal', '=', $tgl)
->groupBy('tanggal', 'nama_anggota', 'nama_petugas', 'keterangan')
->orderBy('tanggal')
->get();

        $title = 'Laporan Transaksi Pembayaran ';

        if ($request->aksi == "download") {
            return Excel::download(new PembayaranReportExport($pembayaran, $daftarKategoriSimpanan, $title, $tgl), 'Laporan Transaksi Pembayaran ' . $tgl . '.xlsx');
        }

        return view('petugas.laporan.pembayaran', compact('pembayaran', 'daftarKategoriSimpanan', 'title', 'tgl'));
    }

    public function rekapPembayaran(Request $request)
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
        $pembayaran = DB::table(DB::raw('
            (SELECT
                DATE(s.tgl_bayar) AS tanggal,
                ag.nama AS nama_anggota,
                p.nama AS nama_petugas,
                SUM(s.jumlah) AS total_simpanan,
                0 AS total_angsuran,
                s.id_kategori AS id_kategori,
                0 AS total_angsuran_bayar_pokok,
                0 AS total_angsuran_bayar_jasa
            FROM simpanan s
            JOIN anggota ag ON s.id_anggota = ag.id_anggota
            LEFT JOIN petugas p ON s.id_petugas = p.id_petugas
            GROUP BY tanggal, id_kategori, ag.nama, p.nama

            UNION ALL

            SELECT
                DATE(a.tgl_bayar) AS tanggal,
                ag.nama AS nama_anggota,
                p.nama AS nama_petugas,
                0 AS total_simpanan,
                SUM(a.bayar_pokok + a.bayar_jasa) AS total_angsuran,
                NULL AS id_kategori,
                SUM(a.bayar_pokok) AS total_angsuran_bayar_pokok,
                SUM(a.bayar_jasa) AS total_angsuran_bayar_jasa

            FROM angsuran a
            JOIN anggota ag ON a.id_anggota = ag.id_anggota
            LEFT JOIN petugas p ON a.id_petugas = p.id_petugas
            GROUP BY tanggal, ag.nama, p.nama
            ) AS pembayaran
        '))
            ->selectRaw(implode(', ', $selectClauses))
            ->whereIn('tanggal', $dates)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'DESC')
            ->get();


        $title = 'Laporan Transaksi Pembayaran ';

        if ($request->aksi == "download") {
            return Excel::download(new RekapPembayaranReportExport($pembayaran, $daftarKategoriSimpanan, $title, $tgl_awal, $tgl_akhir, $dates), 'Laporan Rekap Pembayaran ' . $tgl_awal . ' - ' . $tgl_akhir . '.xlsx');
        }

        return view('petugas.laporan.rekap-pembayaran', compact('pembayaran', 'daftarKategoriSimpanan', 'title', 'tgl_awal', 'tgl_akhir', 'dates'));
    }
}
