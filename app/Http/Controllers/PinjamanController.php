<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Pinjaman, Anggota, Petugas};
use Illuminate\Support\Facades\Auth;

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
            ->orWhereHas('petugas', function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%');
            })
            ->orWhere('nominal', 'like', '%' . $cari . '%')
            ->orWhere('tgl_pinjam', 'like', '%' . $cari . '%')
            ->whereBetween('tgl_pinjam', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('tgl_pinjam', 'desc')
            ->paginate(10);



        $title = 'Kelola Pinjaman';

        return view('petugas.pinjaman.index', compact('title', 'pinjaman', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function create() {
        $title = 'Pengajuan Pinjaman';
        $anggota = Anggota::orderBy('nama', 'asc')->get();
        $id_pinjam = Pinjaman::max('id_pinjaman') + 1;
        return view('petugas.pinjaman.pengajuan', compact('title', 'anggota', 'id_pinjam'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'id_anggota' => 'required',
            'nominal' => 'required|numeric',
            'lama_angsuran' => 'required|numeric',
            'tgl_pinjam' => 'required|date',
        ], [
            'id_anggota.required' => 'Anggota harus dipilih',
            'nominal.required' => 'Nominal harus diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'lama_angsuran.required' => 'Lama angsuran harus diisi',
            'lama_angsuran.numeric' => 'Lama angsuran harus berupa angka',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi',
            'tgl_pinjam.date' => 'Tanggal pinjam harus berupa tanggal',
        ]);


      try {
        $pinjaman = Pinjaman::create([
            'id_anggota' => $request->id_anggota,
            'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
            'nominal' => $request->nominal,
            'tgl_pinjam' => $request->tgl_pinjam,
            'lama_angsuran' => $request->lama_angsuran,
            'sisa_pokok' => $request->nominal,
            'sisa_jasa' => 0,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data pinjaman');
      } catch (\Throwable $th) {
        return redirect()->back()->withInput()->with('error', $th->getMessage());
      }
    }
}
