<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class BillingReportExport implements FromView
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
        return view('exports.billing_report', [
            'sekolah' => $this->sekolah,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'daftarKategoriSimpanan' => $this->daftarKategoriSimpanan
        ]);
    }
}
