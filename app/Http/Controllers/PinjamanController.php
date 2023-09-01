<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;

class PinjamanController extends Controller
{
    public function index(Request $request) {
        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-t');
        $cari = $request->cari;
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
        }

        $pinjaman = Pinjaman::where('id_pinjaman', 'like', '%' . $cari . '%')
            ->orWhereHas('anggota', function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })
            ->orWhere('pokok', 'like', '%' . $cari . '%')
            ->orWhere('tgl_pinjam', 'like', '%' . $cari . '%')
            ->whereBetween('tgl_pinjam', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('tgl_pinjam', 'desc')
            ->paginate(10);

      
        
        $title = 'Kelola Pinjaman';
        
        return view('petugas.pinjaman.index', compact('title', 'pinjaman', 'tanggal_awal', 'tanggal_akhir'));
    }
}
