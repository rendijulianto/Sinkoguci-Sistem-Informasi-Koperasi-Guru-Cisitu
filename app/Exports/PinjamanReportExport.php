<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PinjamanReportExport implements WithMultipleSheets
{
    private $pinjaman;

    public function __construct($pinjaman)
    {
        $this->pinjaman = $pinjaman;
    }

    public function sheets(): array
    {
        // Define the sheets you want to export here
        return [
            'Pinjaman' => new PinjamanRekapReportExport($this->pinjaman),
            'PinjamanRincian' => new PinjamanRincianReportExport($this->pinjaman),
        ];
    }
}
