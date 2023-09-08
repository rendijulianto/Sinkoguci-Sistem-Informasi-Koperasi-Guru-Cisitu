<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class SimpananTahunanReportExport implements WithMultipleSheets
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


    public function sheets(): array
    {
        // Define the sheets you want to export here
        return [
            'SimpananRekap' => new simpananTahunanRekapExport($this->sekolah, $this->daftarKategoriSimpanan, $this->tahun),
            'SimpananRincian' => new simpananTahunanRincianReportExport($this->sekolah, $this->daftarKategoriSimpanan, $this->tahun),
            // Add more sheets as needed
        ];
    }
}
