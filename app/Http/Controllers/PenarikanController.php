<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota,KategoriSimpanan, Simpanan, Penarikan, PenarikanDanaSosial};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenarikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function simpanan()
    {
        $title = 'Kelola Penarikan';
        $anggota = Anggota::orderBy('nama', 'asc')->get();
        return view('petugas.penarikan.index',  compact('title', 'anggota'));
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_anggota' => 'required|numeric|exists:anggota,id_anggota',
            'id_kategori' => 'required|numeric|exists:kategori_simpanan,id_kategori',
            'jumlah' => 'required',
            'keterangan' => 'required|max:255',
            'tgl_penarikan' => 'required|date',
        ], [
            'id_anggota.required' => 'Anggota tidak ditemukan!',
            'id_anggota.numeric' => 'Id anggota tidak valid!',
            'id_anggota.exists' => 'Id anggota tidakn ditemukan!',
            'id_petugas.exists' => 'Id petugas tidakn ditemukan!',
            'id_kategori.required' => 'Kategori tidak ditemukan!',
            'id_kategori.numeric' => 'Id kategori tidak valid!',
            'id_kategori.exists' => 'Id kategori tidakn ditemukan!',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Jumlah harus angka',
            'keterangan.required' => 'Keterangan tidak boleh kosong',
            'keterangan.max' => 'Keterangan maksimal 255 karakter',
            'tgl_penarikan.required' => 'Tanggal penarikan tidak boleh kosong',
            'tgl_penarikan.date' => 'Tanggal penarikan harus tanggal',
        ]);
        try {
            // cek jumlah saldo dan jumlah penarikan
            $anggota = Anggota::where('id_anggota', $request->id_anggota)->first();
            $saldo = $anggota->sisaSimpanan($request->id_kategori);

            $jumlah = $this->convertRupiahToNumber($request->jumlah);
            if ($saldo < $jumlah) {
                return redirect()->back()->withInput()->with(['error' => 'Saldo tidak cukup']);
            }
            Penarikan::create([
                'id_anggota' => $request->id_anggota,
                'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                'id_kategori' => $request->id_kategori,
                'jumlah' => $jumlah,
                'keterangan' => $request->keterangan,
                'tgl_penarikan' => $request->tgl_penarikan,
                'saldo_sebelum' => $saldo,
                'saldo_sesudah' => $saldo - $jumlah,
            ]);
            // kurangi saldo
            $anggota->kategori_simpanan_anggota()->where('id_kategori', $request->id_kategori)->update([
                'saldo' => $saldo - $jumlah,
            ]);

            return redirect()->back()->withInput()->with(['success' => 'Penarikan berhasil ditambahkan']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Detail Penarikan';
        $anggota = Anggota::where('id_anggota', $id)->first();
        if (!$anggota) {
            return redirect()->back()->with(['error' => 'Anggota tidak ditemukan']);
        }
        $sisaSimpanan = $anggota->sisaSimpanan();

        $kategoriSimpanan = KategoriSimpanan::where('nama', 'like', '%Simpanan%')->orderBy('id_kategori', 'asc')->get();
        $penarikan = Penarikan::where('id_anggota', $id)->orderBy('created_at', 'desc')->get();
        return view('petugas.penarikan.show', compact('title', 'anggota', 'penarikan', 'sisaSimpanan', 'kategoriSimpanan'));
    }


    public function danaSosial(Request $request)
    {
        $title = 'Kelola Penarikan Dana Sosial';
        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-t');
        $cari = $request->cari;
        $penarikan = PenarikanDanaSosial::where(function ($query) use ($cari) {
            $query->where('keterangan', 'like', '%' . $cari . '%');
        })->orWhereHas('petugas', function ($query) use ($cari) {
            $query->where('nama', 'like', '%' . $cari . '%');
        })->orderBy('created_at', 'desc')->paginate(10);
        return view('petugas.penarikan.dana-sosial',  compact('title', 'penarikan', 'tanggal_awal', 'tanggal_akhir', 'cari'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeDanaSosial(Request $request)
    {
        $this->validate($request, [
            'jumlah' => 'required',
            'keterangan' => 'required|max:60',
            'tgl_penarikan' => 'required|date',
        ], [
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Jumlah harus angka',
            'keterangan.required' => 'Keterangan tidak boleh kosong',
            'keterangan.max' => 'Keterangan maksimal 255 karakter',
            'tgl_penarikan.required' => 'Tanggal penarikan tidak boleh kosong',
            'tgl_penarikan.date' => 'Tanggal penarikan harus tanggal',
        ]);
        try {
            $jumlah = $this->convertRupiahToNumber($request->jumlah);
            PenarikanDanaSosial::create([
                'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                'jumlah' => $jumlah,
                'keterangan' => $request->keterangan,
                'tgl_penarikan' => $request->tgl_penarikan,
            ]);
            return redirect()->back()->withInput()->with(['success' => 'Penarikan berhasil ditambahkan']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => $th->getMessage()]);
        }
    }
}
