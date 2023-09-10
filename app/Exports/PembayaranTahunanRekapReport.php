<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
class PembayaranTahunanRekapReport implements FromView
{
    protected $sekolah;
    protected $tahun;
    protected $daftarKategoriSimpanan;

    public function __construct($sekolah, $daftarKategoriSimpanan, $tahun)
    {
        $this->sekolah = $sekolah;
        $this->tahun = $tahun;
        $this->daftarKategoriSimpanan = $daftarKategoriSimpanan;
    }


    public function view(): View
    {
        return view('exports.pembayaran_tahunan_rekap_report', [
            'sekolah' => $this->sekolah,
            'tahun' => $this->tahun,
            'daftarKategoriSimpanan' => $this->daftarKategoriSimpanan
        ]);
    }
}
