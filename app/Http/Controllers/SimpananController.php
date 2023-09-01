<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota,KategoriSimpanan, Simpanan, Penarikan};
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
            'id_anggota' => 'required|numeric|exists:anggota,id_anggota',
            'simpanan_pokok' => 'nullable|numeric',
            'simpanan_wajib' => 'nullable|numeric',
            'simpanan_khusus' => 'nullable|numeric',
            'simpanan_suka_rela' => 'nullable|numeric',
            'simpanan_hari_raya' => 'nullable|numeric',
            'simpanan_karya_wisata' => 'nullable|numeric',
            'dana_khusus' => 'nullable|numeric',
            'keterangan' => 'required|max:255',
            'tgl_bayar' => 'required|date',
        ],
        [
            'id_anggota.required'     => 'Anggota tidak ditemukan!',
            'id_anggota.numeric'     => 'Id anggota tidak valid!',
            'id_anggota.exists' => 'Id anggota tidakn ditemukan!',
            'simpanan_pokok.required' => 'Simpanan pokok tidak boleh kosong',
            'simpanan_pokok.numeric' => 'Simpanan pokok harus angka!',
            'simpanan_khusus.required' => 'Simpanan khusus tidak boleh kosong',
            'simpanan_khusus.numeric' => 'Simpanan khusus harus angka',
            'simpanan_wajib.required' => 'Simpanan wajib tidak boleh kosong',
            'simpanan_wajib.numeric' => 'Simpanan wajib harus angka',
            'simpanan_suka_rela.required' => 'Simpanan suka rela tidak boleh kosong',
            'simpanan_suka_rela.numeric' => 'Simpanan suka rela harus angka',
            'simpanan_hari_raya.required' => 'Simpanan hari raya tidak boleh kosong',
            'simpanan_hari_raya.numeric' => 'Simpanan hari raya harus angka',
            'simpanan_karya_wisata.required' => 'Simpanan karya wisata tidak boleh kosong',
            'simpanan_karya_wisata.numeric' => 'Simpanan karya wisata harus angka',
            'dana_khusus.required' => 'Dana khusus tidak boleh kosong',
            'dana_khusus.numeric' => 'Dana khusus harus angka',
            'keterangan.required' => 'Keterangan tidak boleh kosong',
            'keterangan.max' => 'Keterangan maksimal 255 karakter',
            'tgl_bayar.required' => 'Tanggal bayar tidak boleh kosong',
            'tgl_bayar.date' => 'Tanggal bayar harus tanggal',

          ]);
        DB::beginTransaction();
        try {
           $dataSimpanan = [
                'id_anggota' => $request->id_anggota,
                'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                'jumlah' => 0,
                'keterangan' => $request->keterangan,
                'tgl_bayar' => $request->tgl_bayar,
            ];

            if($request->simpanan_pokok) {
                $dataSimpanan['id_kategori'] = 1;
                $dataSimpanan['jumlah'] = $request->simpanan_pokok;
                $simpanan = Simpanan::create($dataSimpanan);
            }

            if($request->simpanan_wajib) {
                $dataSimpanan['id_kategori'] = 2;
                $dataSimpanan['jumlah'] = $request->simpanan_wajib;
                $simpanan = Simpanan::create($dataSimpanan);
            }

            if($request->simpanan_khusus) {
                $dataSimpanan['id_kategori'] = 3;
                $dataSimpanan['jumlah'] = $request->simpanan_khusus;
                $simpanan = Simpanan::create($dataSimpanan);
            }

            if($request->simpanan_suka_rela) {
                $dataSimpanan['id_kategori'] = 5;
                $dataSimpanan['jumlah'] = $request->simpanan_suka_rela;
                $simpanan = Simpanan::create($dataSimpanan);
            }

            if($request->simpanan_hari_raya) {
                $dataSimpanan['id_kategori'] = 6;
                $dataSimpanan['jumlah'] = $request->simpanan_hari_raya;
                $simpanan = Simpanan::create($dataSimpanan);
            }

            if($request->simpanan_karya_wisata) {
                $dataSimpanan['id_kategori'] = 7;
                $dataSimpanan['jumlah'] = $request->simpanan_karya_wisata;
                $simpanan = Simpanan::create($dataSimpanan);
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
    public function show(string $id)
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

        $simpanan = json_decode(json_encode($simpanan));
        $kategoriSimpanan = KategoriSimpanan::where('nama', 'like', '%simpanan%')->orderby('id_kategori', 'asc')->get();
        return view('petugas.simpanan.show', compact('title', 'anggota', 'simpanan', 'kategoriSimpanan', 'sisaSimpanan', 'simpananDefault'));
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
