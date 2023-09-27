<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{KategoriSimpanan,KategoriSimpananAnggota};
use Helper;

class KategoriSimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cari = $request->cari;
        $title = 'Kelola Kategori Simpanan';

        $kategoriSimpanan = KategoriSimpanan::query()
            ->when($cari, function ($query, $cari) {
                $query->where('nama', 'like', '%' . $cari . '%')
                    ->orWhere('jumlah', 'like', '%' . $cari . '%')
                    ->orWhere('id_kategori', $cari);
            })
                ->orderBy('id_kategori', 'desc')
                ->paginate(10);
        return view('admin.kategori_simpanan.index', compact('title', 'kategoriSimpanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:60',
            'jumlah' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.string' => 'Nama harus berupa string',
            'nama.max' => 'Nama maksimal 60 karakter',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
        ]);

        try {
            $jumlah = Helper::rupiahToNumeric($request->jumlah);
            $kategori_simppanan = KategoriSimpanan::create([
                'nama' => $request->nama,
                'jumlah' => $jumlah,
            ]);

            $anggota = Anggota::select('id_anggota')->get();
            foreach ($anggota as $item) {
                KategoriSimpananAnggota::create([
                    'id_anggota' => $item->id_anggota,
                    'id_kategori' => $kategori_simppanan->id_kategori,
                    'nominal' => $jumlah,
                ]);
            }

            return redirect()->back()->with(['success' => 'Kategori Simpanan: ' . $request->nama . ' Ditambahkan']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:60',
            'jumlah' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.string' => 'Nama harus berupa string',
            'nama.max' => 'Nama maksimal 60 karakter',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
        ]);

        $jumlah = Helper::rupiahToNumeric($request->jumlah);
        try {
            $kategoriSimpanan = KategoriSimpanan::findOrFail($id);
            $kategoriSimpanan->update([
                'nama' => $request->nama,
                'jumlah' => $jumlah,
            ]);

            KategoriSimpananAnggota::where('id_kategori', $id)
    ->where('nominal', '<', $jumlah)
    ->update(['nominal' => $jumlah]);

            return redirect()->back()->with(['success' => 'Kategori Simpanan: ' . $kategoriSimpanan->nama . ' Diperbaharui']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategoriSimpanan = KategoriSimpanan::findOrFail($id);
            $kategoriSimpanan->delete();
            return redirect()->back()->with(['success' => 'Kategori Simpanan: ' . $kategoriSimpanan->nama . ' Dihapus']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
