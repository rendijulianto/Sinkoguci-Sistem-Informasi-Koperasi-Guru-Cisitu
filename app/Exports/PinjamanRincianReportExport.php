<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PinjamanRincianReportExport implements FromView
{

    protected $pinjaman;

    public function __construct($pinjaman)
    {
        $this->pinjaman = $pinjaman;
    }

    public function view(): View
    {
        return view('exports.pinjaman_rincian_report', [
            'pinjaman' => $this->pinjaman,
        ]);
    }
}
