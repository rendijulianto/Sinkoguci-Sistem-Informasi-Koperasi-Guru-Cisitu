<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Pinjaman
use App\Models\{Pinjaman, Anggota, Petugas};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{AngsuranExport};

class CicilanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Cicilan';

        $pinjaman = Pinjaman::orderBy('tgl_pinjam', 'desc')->get();

        return view('petugas.cicilan.index', compact('title', 'pinjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_pinjaman' => 'required|numeric|exists:pinjaman,id_pinjaman',
            'bayar_pokok' => 'required|numeric',
            'bayar_jasa' => 'required|numeric',
            'tgl_bayar' => 'required|date',
        ], [
            'id_pinjaman.required' => 'Pinjaman harus dipilih',
            'id_pinjaman.numeric' => 'Pinjaman tidak valid',
            'id_pinjaman.exists' => 'Pinjaman tidak ditemukan',
            'bayar_pokok.required' => 'Bayar pokok harus diisi',
            'bayar_pokok.numeric' => 'Bayar pokok harus berupa angka',
            'bayar_jasa.required' => 'Bayar jasa harus diisi',
            'bayar_jasa.numeric' => 'Bayar jasa harus berupa angka',
            'tgl_bayar.required' => 'Tanggal bayar harus diisi',
            'tgl_bayar.date' => 'Tanggal bayar harus berupa tanggal',
        ]);
        DB::beginTransaction();
        try {
            $pinjaman = Pinjaman::findOrFail($request->id_pinjaman);
            $bayar_pokok = $request->bayar_pokok;
            $bayar_jasa = $request->bayar_jasa;
            $tgl_bayar = $request->tgl_bayar;
            # Data Pinjaman
            $pokok_sekarang = $pinjaman->sisa_pokok;
            $jasa_sekarang = $pinjaman->sisa_jasa;
            # Update Pinjaman
            $pinjaman->sisa_pokok = $pokok_sekarang - $bayar_pokok;
            $pinjaman->sisa_jasa = $jasa_sekarang - $bayar_jasa;
            $pinjaman->tgl_terakhir_bayar = $tgl_bayar;
            $pinjaman->save();
            # Data Angsuran
            $angsuran = [
                'id_pinjaman' => $pinjaman->id_pinjaman,
                'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                'bayar_pokok' => $bayar_pokok,
                'bayar_jasa' => $bayar_jasa,
                'tgl_bayar' => $tgl_bayar,
                'sebelum_pokok' => $pokok_sekarang,
                'sebelum_jasa' => $jasa_sekarang,
                'setelah_pokok' => $pinjaman->sisa_pokok,
                'setelah_jasa' => $pinjaman->sisa_jasa,
            ];

            $pinjaman->angsuran()->create($angsuran);
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menambahkan data cicilan');

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $title = 'Cicilan';
        $pinjaman = Pinjaman::findOrFail($id);
        if(!$pinjaman){
            return abort(404);
        }
        $cicilan = $pinjaman->angsuran()->orderBy('created_at', 'desc')->get();
        if ($request->aksi ==  "download") {
            return Excel::download(new AngsuranExport($pinjaman), 'Data-Cicilan-' . $pinjaman->id_pinjaman . '.xlsx');
        } else {
            return view('petugas.cicilan.show', compact('title', 'pinjaman', 'cicilan'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
