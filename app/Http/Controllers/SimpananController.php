<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota,KategoriSimpanan, Simpanan, Penarikan};
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{SimpananExport};
use DB;
use Auth;

class SimpananController extends Controller
{
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
            $validate_kategori[str_replace(' ', '_', $k->nama)] = 'nullable|numeric';
            $message_kategori[str_replace(' ', '_', $k->nama).'.numeric'] = 'Jumlah harus angka';
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
                    $dataSimpanan['jumlah'] = $request->$object;
                    $simpan =  Simpanan::create($dataSimpanan);
                }
            }
            DB::commit();
            return redirect()->back()->withInput()->with(['success' => 'Menambahkan simpanan baru']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with(['failed' => $th->getMessage()]);
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
            $simpanan[$i] = $anggota->simpananBulan($i);
        }


        if($request->aksi == "download") {
            $kategoriSimpanan = KategoriSimpanan::where('nama', 'like', '%Simpanan%')->orderby('id_kategori', 'asc')->get();
            return Excel::download(new SimpananExport($anggota,$kategoriSimpanan), 'Simpanan-'.$anggota->nama.' - '.$anggota->sekolah->nama.' - '.date('d-m-Y').'.xlsx');
        } else {
            $kategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();
            return view('petugas.simpanan.show', compact('title', 'anggota', 'simpanan', 'kategoriSimpanan', 'sisaSimpanan', 'simpananDefault'));
        }
    }
}
