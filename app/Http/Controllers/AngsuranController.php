<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Pinjaman
use App\Models\{Pinjaman, Anggota, Petugas};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{AngsuranExport};

class AngsuranController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Angsuran';

        $pinjaman = Pinjaman::where(function ($query) {
            $query->where('sisa_pokok', '>', 0)
                ->orWhere('sisa_jasa', '>', 0);
        })->orderBy('id_pinjaman', 'desc')->get();

        return view('petugas.angsuran.index', compact('title', 'pinjaman'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_pinjaman' => 'required|numeric|exists:pinjaman,id_pinjaman',
            'bayar_pokok' => 'required',
            'bayar_jasa' => 'required',
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
            $bayar_pokok = Helper::rupiahToNumeric($request->bayar_pokok);
            $bayar_jasa = Helper::rupiahToNumeric($request->bayar_jasa);
            if(!$pinjaman){
                return redirect()->back()->withInput()->with('error', 'Pinjaman tidak ditemukan');
            } else if  ($pinjaman->sisa_pokok == 0 AND $pinjaman->sisa_jasa == 0) {
                return redirect()->back()->withInput()->with('error', 'Pinjaman sudah lunas');
            } else if ($pinjaman->sisa_pokok < $bayar_pokok) {
                return redirect()->back()->withInput()->with('error', 'Bayar pokok melebihi sisa pokok');
            } else if ($pinjaman->sisa_jasa < $bayar_jasa) {
                return redirect()->back()->withInput()->with('error', 'Bayar jasa melebihi sisa jasa');
            }

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
                'id_anggota' => $pinjaman->id_anggota,
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
            return redirect()->back()->withInput(

            )->with('success', 'Berhasil menambahkan data angsuran');

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
        $title = 'Angsuran';
        $pinjaman = Pinjaman::findOrFail($id);
        if(!$pinjaman){
            return abort(404);
        }
        $angsuran = $pinjaman->angsuran()->orderBy('created_at', 'desc')->get();
        if ($request->aksi ==  "download") {
            return Excel::download(new AngsuranExport($pinjaman), 'Data-Angsuran-' . $pinjaman->id_pinjaman . '.xlsx');
        } else {
            return view('petugas.angsuran.show', compact('title', 'pinjaman', 'angsuran'));
        }
    }

}
