<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RekapPembayaranReportExport  implements FromView
{
        protected $pembayaran;
        protected $daftarKategoriSimpanan;
        protected $title;
        protected $tgl_awal;
        protected $tgl_akhir;
        protected $dates;


        public function __construct($pembayaran, $daftarKategoriSimpanan, $title, $tgl_awal, $tgl_akhir, $dates)
        {
            $this->pembayaran = $pembayaran;
            $this->daftarKategoriSimpanan = $daftarKategoriSimpanan;
            $this->title = $title;
            $this->tgl_awal = $tgl_awal;
            $this->tgl_akhir = $tgl_akhir;
            $this->dates = $dates;
        }

        public function view(): View
        {
            return view('exports.rekap_pembayaran_report', [
                'pembayaran' => $this->pembayaran,
                'daftarKategoriSimpanan' => $this->daftarKategoriSimpanan,
                'title' => $this->title,
                'tgl_awal' => $this->tgl_awal,
                'tgl_akhir' => $this->tgl_akhir,
                'dates' => $this->dates
            ]);
        }
}
