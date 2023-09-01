<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cari = $request->cari;
        $title = 'Kelola Sekolah';
        $sekolah = Sekolah::where('nama','like',"%".$cari."%")->orderBy('id_sekolah', 'DESC')->paginate(10);
        return view('admin.sekolah.index', compact('title', 'sekolah'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:100'
        ]);
        try {
            Sekolah::create([
                'nama' => $request->nama
            ]);
            return redirect()->back()->with(['success' => 'Data berhasil disimpan!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => 'Data gagal disimpan!']);
        }

    }





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:100'
        ]);
        try {
            $sekolah = Sekolah::findOrFail($id);
            $sekolah->update([
                'nama' => $request->nama
            ]);
            return redirect()->back()->with(['success' => 'Data berhasil diubah!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => 'Data gagal diubah!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sekolah = Sekolah::findOrFail($id);
            $sekolah->delete();
            return redirect()->back()->with(['success' => 'Data berhasil dihapus!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => 'Data gagal dihapus!']);
        }
    }
}
