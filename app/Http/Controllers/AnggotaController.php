<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota, Sekolah};
use Illuminate\Support\Facades\DB;


class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Anggota';
        $sekolah = Sekolah::orderBy('nama', 'asc')->get();
        return view('petugas.anggota.index', compact('title', 'sekolah'));
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
           'nama' => 'required|min:3|max:60',
           'tgl_lahir' => 'required|date',
           'alamat' => 'required|min:3|max:255',
           'id_sekolah' => 'required|exists:sekolah,id_sekolah',
           'simpanan_pokok' => 'required|numeric',
           'simpanan_hari_raya' => 'required|numeric',
           'simpanan_karyawisata' => 'required|numeric',
       ]);
   
      
       DB::beginTransaction();
       try {
        $anggota = Anggota::create([
            'id_petugas' => auth()->guard('petugas')->user()->id_petugas,
            'id_sekolah' => $request->id_sekolah,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tgl_lahir' => $request->tgl_lahir,
        ]);

        $anggota->kategori_simpanan()->attach([1 => ['nominal' => $request->simpanan_pokok], 2 => ['nominal' => $request->simpanan_hari_raya], 3 => ['nominal' => $request->simpanan_karyawisata]]);
        DB::commit();
        return redirect()->back()->with('success', 'Data anggota berhasil ditambahkan');
       } catch (\Throwable $th) {
        DB::rollback();
        return redirect()->back()->withInput()->with('error', $th->getMessage());
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
