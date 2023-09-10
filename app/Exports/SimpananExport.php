<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class SimpananExport implements FromView
{
    protected $anggota;
    protected $kategoriSimpanan;

    public function __construct($anggota, $kategoriSimpanan)
    {
        $this->anggota = $anggota;
        $this->kategoriSimpanan = $kategoriSimpanan;
    }

    public function view(): View
    {
        return view('exports.simpanan', [
            'anggota' => $this->anggota,
            'kategoriSimpanan' => $this->kategoriSimpanan
        ]);
    }
}
