<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
class SimpananBulananRincianReportExport implements FromView
{
    protected $sekolah;
    protected $bulan;
    protected $tahun;
    protected $daftarKategoriSimpanan;

    public function __construct($bulan, $sekolah, $daftarKategoriSimpanan, $tahun)
    {
        $this->sekolah = $sekolah;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->daftarKategoriSimpanan = $daftarKategoriSimpanan;
    }


    public function view(): View
    {
        return view('exports.simpanan_bulanan_rincian', [
            'sekolah' => $this->sekolah,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'daftarKategoriSimpanan' => $this->daftarKategoriSimpanan
        ]);
    }
}
