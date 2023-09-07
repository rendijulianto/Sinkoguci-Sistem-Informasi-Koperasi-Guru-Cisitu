<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class SimpananBulananReportExport implements WithMultipleSheets
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


    public function sheets(): array
    {
        // Define the sheets you want to export here
        return [
            'SimpananRekap' => new simpananBulananRekapExport($this->bulan, $this->sekolah, $this->daftarKategoriSimpanan, $this->tahun),
            'SimpananRincian' => new simpananBulananRincianReportExport($this->bulan, $this->sekolah, $this->daftarKategoriSimpanan, $this->tahun),
            // Add more sheets as needed
        ];
    }
}
