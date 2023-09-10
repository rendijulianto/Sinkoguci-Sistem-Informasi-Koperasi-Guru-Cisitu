<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class AngsuranExport implements FromView
{
    protected $pinjaman;

    public function __construct($pinjaman)
    {
       $this->pinjaman = $pinjaman;
    }

    public function view(): View
    {
        return view('exports.angsuran', [
            'pinjaman' => $this->pinjaman
        ]);
    }
}
