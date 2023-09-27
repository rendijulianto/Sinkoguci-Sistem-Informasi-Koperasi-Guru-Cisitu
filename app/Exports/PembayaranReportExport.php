<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
class PembayaranReportExport implements FromView
{
    // $pembayaran, $daftarKategoriSimpanan, $title, $tgl
    protected $pembayaran;
    protected $daftarKategoriSimpanan;
    protected $title;
    protected $tgl;


    public function __construct($pembayaran, $daftarKategoriSimpanan, $title, $tgl)
    {
        $this->pembayaran = $pembayaran;
        $this->daftarKategoriSimpanan = $daftarKategoriSimpanan;
        $this->title = $title;
        $this->tgl = $tgl;
    }


    public function view(): View
    {
        return view('exports.pembayaran_report', [
            'pembayaran' => $this->pembayaran,
            'daftarKategoriSimpanan' => $this->daftarKategoriSimpanan,
            'title' => $this->title,
            'tgl' => $this->tgl
        ]);
    }
}
