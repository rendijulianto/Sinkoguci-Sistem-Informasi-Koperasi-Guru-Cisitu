<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
class SimpananTahunanRekapExport implements FromView
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
        return view('exports.simpanan_tahunan_report', [
            'sekolah' => $this->sekolah,
            'tahun' => $this->tahun,
            'daftarKategoriSimpanan' => $this->daftarKategoriSimpanan
        ]);
    }
}
