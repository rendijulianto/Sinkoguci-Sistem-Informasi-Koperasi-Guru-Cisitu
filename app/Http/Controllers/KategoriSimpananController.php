<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{KategoriSimpanan,KategoriSimpananAnggota};

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
            KategoriSimpanan::create([
                'nama' => $request->nama,
                'jumlah' => $this->convertRupiahToNumber($request->jumlah),
            ]);

            return redirect()->back()->with(['success' => 'Kategori Simpanan: ' . $request->nama . ' Ditambahkan']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

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

        try {
            $kategoriSimpanan = KategoriSimpanan::findOrFail($id);
            $kategoriSimpanan->update([
                'nama' => $request->nama,
                'jumlah' => $this->convertRupiahToNumber($request->jumlah),
            ]);

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

    public function ubahMasalJumlah(Request $request)
    {
        $this->validate($request, [
            'id_kategori' => 'required|numeric|exists:kategori_simpanan,id_kategori',
            'jumlah' => 'required',
        ], [
            'id_kategori.required' => 'Kategori tidak boleh kosong',
            'id_kategori.numeric' => 'Kategori harus berupa angka',
            'id_kategori.exists' => 'Kategori tidak ditemukan',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
        ]);

        try {
            $kategoriSimpanan = KategoriSimpanan::findOrFail($request->id_kategori);
            $kategoriSimpanan->update([
                'jumlah' => $this->convertRupiahToNumber($request->jumlah),
            ]);
            KategoriSimpananAnggota::where('id_kategori', $request->id_kategori)->update([
                'nominal' => $this->convertRupiahToNumber($request->jumlah),
            ]);

            return redirect()->back()->with(['success' => 'Jumlah Kategori Simpanan: ' . $kategoriSimpanan->nama . ' Diperbaharui']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
