<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota, Sekolah};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Anggota';
        $anggota = Anggota::with('sekolah')->orderBy('id_anggota', 'desc')->paginate(10);
        $sekolahs = Sekolah::orderBy('nama', 'asc')->get();
        return view('petugas.anggota.index', compact('title', 'anggota','sekolahs'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:3|max:60',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|min:3|max:255',
            'id_sekolah' => 'required|exists:sekolah,id_sekolah',
        ]);

        DB::beginTransaction();
        try {
            $idPetugas = Auth::guard('petugas')->user()->id_petugas;
            Anggota::create([
                'id_petugas' => $idPetugas,
                'id_sekolah' => $request->id_sekolah,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tgl_lahir' => $request->tgl_lahir,
            ]);



            DB::commit();
            return redirect()->back()->with('success', 'Anggota berhasil ditambahkan');
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
        $title = 'Detail Anggota';
        $anggota = Anggota::findOrFail($id);
        return view('petugas.anggota.show', compact('title', 'anggota'));
    }

/**
 * Show the form for editing the specified resource.
 */
public function edit(string $id)
{
    $title = 'Edit Anggota';
    $anggota = Anggota::findOrFail($id);
    $sekolahs = Sekolah::orderBy('nama', 'asc')->get();
    return view('petugas.anggota.edit', compact('title', 'anggota', 'sekolahs'));
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $this->validate($request, [
        'nama' => 'required|min:3|max:60',
        'tgl_lahir' => 'required|date',
        'alamat' => 'required|min:3|max:255',
        'id_sekolah' => 'required|exists:sekolah,id_sekolah',
    ]);

    DB::beginTransaction();
    try {
        $anggota = Anggota::findOrFail($id);
        $anggota->update([
            'id_sekolah' => $request->id_sekolah,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tgl_lahir' => $request->tgl_lahir,
        ]);
        DB::commit();
        return redirect()->back()->with('success', 'Data anggota berhasil diperbarui');
    } catch (\Throwable $th) {
        DB::rollback();
        return redirect()->back()->withInput()->with('error', $th->getMessage());
    }
}

/**
 * Remove the specified resource from storage.
 */
public function destroy(string $id)
{
    try {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();
        return redirect()->back()->with('success', 'Anggota: ' . $anggota->nama . ' Dihapus');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', $th->getMessage());
    }
}

}
