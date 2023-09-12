<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota,KategoriSimpanan, Simpanan, Penarikan,KategoriSimpananAnggota};
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{SimpananExport};
use DB;
use Auth;

class SimpananController extends Controller
{

    private function convertRupiahToNumber($rupiah)
    {
       // Remove non-numeric characters and spaces
        $numericString = preg_replace("/[^0-9]/", "", $rupiah);

        // Convert the numeric string to an integer or float
        $numericValue = (int) $numericString; // Use (float) for decimals

        // Output the numeric value
        if($numericValue == null) {
            return 0;
        } else {
            return $numericValue;
        }
  }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kelola Simpanan';
        $anggota = Anggota::orderBy('nama', 'asc')->get();
        return view('petugas.simpanan.index',  compact('title', 'anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kategoriSimpanan = KategoriSimpanan::orderBy('id_kategori', 'asc')->get();
        $validate_kategori = [
            'id_anggota' => 'required|numeric|exists:anggota,id_anggota',
            'keterangan' => 'required|max:255',
            'tgl_bayar' => 'required|date',
        ];
        $message_kategori = [
            'id_anggota.required'     => 'Anggota tidak ditemukan!',
            'id_anggota.numeric'     => 'Id anggota tidak valid!',
            'id_anggota.exists' => 'Id anggota tidakn ditemukan!',
            'keterangan.required' => 'Keterangan tidak boleh kosong',
            'keterangan.max' => 'Keterangan maksimal 255 karakter',
            'tgl_bayar.required' => 'Tanggal bayar tidak boleh kosong',
            'tgl_bayar.date' => 'Tanggal bayar harus tanggal',
        ];
        foreach ($kategoriSimpanan as $k) {
            $validate_kategori[str_replace(' ', '_', $k->nama)] = 'nullable';

        }
        $this->validate($request, $validate_kategori, $message_kategori);
        DB::beginTransaction();
        try {
           $dataSimpanan = [
                'id_anggota' => $request->id_anggota,
                'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                'jumlah' => 0,
                'keterangan' => $request->keterangan,
                'tgl_bayar' => $request->tgl_bayar,
            ];

            foreach ($kategoriSimpanan as $k) {
                $object = strtolower(str_replace(' ', '_', $k->nama));
                if ($request->$object != null) {
                    $dataSimpanan['id_kategori'] = $k->id_kategori;
                    $dataSimpanan['jumlah'] = $this->convertRupiahToNumber($request->$object);
                    $simpan =  Simpanan::create($dataSimpanan);
                    $kategoriSimpananAnggota = DB::table('kategori_simpanan_anggota')
                        ->where('id_anggota', '=', $request->id_anggota)
                        ->where('id_kategori', '=', $k->id_kategori)
                        ->first();
                    if ($kategoriSimpananAnggota) {
                        DB::table('kategori_simpanan_anggota')
                            ->where('id_anggota', '=', $request->id_anggota)
                            ->where('id_kategori', '=', $k->id_kategori)
                            ->update([
                                'saldo' => $kategoriSimpananAnggota->saldo + $this->convertRupiahToNumber($request->$object),
                            ]);
                    }
                }
            }
            DB::commit();
            return redirect()->back()->withInput()->with(['success' => 'Menambahkan simpanan baru']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $title = 'Detail Simpanan';
        $anggota = Anggota::where('id_anggota', '=', $id)->first();
        if (!$anggota) {
            return abort(404);
        }
        $simpananDefault = $anggota->kategori_simpanan_default();
        $sisaSimpanan = $anggota->sisaSimpanan();

        $simpanan = [];
        for ($i=date('m'); $i >= 1; $i--) {
            $simpanan[$i] = $anggota->getSimpanan(date('Y'), $i);
        }

        $kategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();
        if($request->aksi == "download") {
            return Excel::download(new SimpananExport($anggota,$kategoriSimpanan), 'Simpanan-'.$anggota->nama.' - '.$anggota->sekolah->nama.' - '.date('d-m-Y').'.xlsx');
        } else {
            return view('petugas.simpanan.show', compact('title', 'anggota', 'simpanan', 'kategoriSimpanan', 'sisaSimpanan', 'simpananDefault'));
        }
    }
}
