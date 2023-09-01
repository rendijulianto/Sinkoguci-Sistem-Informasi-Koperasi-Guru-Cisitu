<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota,KategoriSimpanan, Simpanan};


class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kelola Simpanan';
        $anggota = Anggota::orderBy('nama', 'asc')->get();
        $kategoriSimpanan = KategoriSimpanan::where('nama', 'like', '%simpanan%')->orderby('id_kategori', 'asc')->get();
        return view('petugas.simpanan.index',  compact('title', 'anggota', 'kategoriSimpanan'));
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
            'simpanan_pokok' => 'required|numeric',
            'simpanan_wajib' => 'required|numeric',
            'simpanan_khusus' => 'required|numeric',
            'simpanan_hari_raya' => 'required|numeric',
            'dana_khusus' => 'required|numeric',
            'simpanan_suka_rela' => 'required|numeric',
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
            'simpanan_hari_raya.required' => 'Simpanan hari raya tidak boleh kosong',
            'simpanan_hari_raya.numeric' => 'Simpanan hari raya harus angka',
            'dana_khusus.required' => 'Dana Khusus tidak boleh kosong',
            'dana_khusus.numeric' => 'Dana Khusus harus angka',
            'simpanan_suka_rela.required' => 'Simpanan suka rela tidak boleh kosong',
            'simpanan_suka_rela.numeric' => 'Simpanan suka rela harus angka',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'tgl_bayar.required' => 'Tanggal bayar tidak boleh kosong!',
          ]);

        try {
            // 'id_kategori'      => $request->id_kategori,
            // 'simpanan_pokok' => $request->simpanan_pokok,
            // 'simpanan_wajib' => $request->simpanan_wajib,
            // 'simpanan_khusus' => $request->simpanan_khusus,
            // 'simpanan_hari_raya' => $request->simpanan_hari_raya,
            // 'dana_khusus' => $request->dana_khusus,
            // 'simpanan_suka_rela' => $request->simpanan_suka_rela,
            // 'keterangan' => $request->keterangan,
            // 'tgl_bayar' => $request->tgl_bayar,
            Simpanan::create([
                'id_anggota'      => $request->id_anggota,
                'id_petugas'      => $request->id_petugas,
            ]);

            return redirect()->back()->with(['success' => 'Menambahkan simpanan baru']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
