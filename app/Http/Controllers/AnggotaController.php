<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota, Sekolah, KategoriSimpanan};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;


class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Kelola Anggota';
        $id_sekolah = $request->get('id_sekolah');
        $cari = $request->get('cari');
        $anggota = Anggota::filter($id_sekolah, $cari)->orderBy('nama', 'asc')->paginate(10);
        $sekolahs = Sekolah::orderBy('nama', 'asc')->get();
        $kategoriSimpanan = KategoriSimpanan::orderBy('id_kategori', 'asc')->get();
        return view('petugas.anggota.index', compact('title', 'anggota', 'sekolahs', 'kategoriSimpanan'));
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
            $anggota = Anggota::create([
                'id_petugas' => $idPetugas,
                'id_sekolah' => $request->id_sekolah,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tgl_lahir' => $request->tgl_lahir,
            ]);

            $kategoriSimpanan = KategoriSimpanan::orderBy('id_kategori', 'asc')->get();
            // default simpanan
            foreach ($kategoriSimpanan as $k) {
                $anggota->kategori_simpanan()->attach($k->id_kategori, [
                    'nominal' => $k->jumlah,
                    'saldo' => 0,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Anggota berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
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

    public function cetak(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $pdf = PDF::loadview('petugas.anggota.cetak', compact('anggota'))->setPaper('a4', 'landscape');
    //    preview
        return $pdf->stream();
    }


    public function updateNominalDefaultSimpanan(Request $request, string $id)
    {
        $kategoriSimpanan = KategoriSimpanan::orderBy('id_kategori', 'asc')->get();
        $validate_kategori = [];
        $message = [];
        foreach ($kategoriSimpanan as $k) {
            $validate_kategori[strtolower(str_replace(' ', '_', $k->nama))] = 'nullable|numeric|min:' . $k->jumlah;
            $message[strtolower(str_replace(' ', '_', $k->nama)) . '.numeric'] = 'Jumlah harus angka';
            $message[strtolower(str_replace(' ', '_', $k->nama)) . '.min'] = 'Jumlah nominal ' . $k->nama . ' minimal Rp ' . number_format($k->jumlah, 0, ',', '.');
        }
        $this->validate($request, $validate_kategori, $message);
        DB::beginTransaction();
        try {
            $anggota = Anggota::findOrFail($id);
            foreach ($kategoriSimpanan as $k) {
                $object = strtolower(str_replace(' ', '_', $k->nama));
                if ($request->$object != null) {
                    $updpate = $anggota->kategori_simpanan()->updateExistingPivot($k->id_kategori, [
                        'nominal' => $request->$object,
                    ]);
                    if (!$updpate) {
                        $anggota->kategori_simpanan()->attach($k->id_kategori, [
                            'nominal' => $request->$object,
                            'saldo' => 0,
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil memperbarui nominal simpanan');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
}
