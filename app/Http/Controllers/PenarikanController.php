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


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_anggota' => 'required|numeric|exists:anggota,id_anggota',
            'id_kategori' => 'required|numeric|exists:kategori_simpanan,id_kategori',
            'jumlah' => 'required|numeric',
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
            $saldo = DB::table('kategori_simpanan_anggota')->where('id_anggota', $request->id_anggota)->where('id_kategori', $request->id_kategori)->first()->saldo ?? 0;
            if ($saldo < $request->jumlah) {
                return redirect()->back()->withInput()->with(['error' => 'Saldo tidak cukup']);
            }
            // tambahkan penarikan
            Penarikan::create([
                'id_anggota' => $request->id_anggota,
                'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                'id_kategori' => $request->id_kategori,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'tgl_penarikan' => $request->tgl_penarikan,
                'saldo_sebelum' => $saldo,
                'saldo_sesudah' => $saldo - $request->jumlah,
            ]);
            // kurangi saldo
            DB::table('kategori_simpanan_anggota')->where('id_anggota', $request->id_anggota)->where('id_kategori', $request->id_kategori)->update([
                'saldo' => $saldo - $request->jumlah,
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
        $penarikan = Penarikan::where('id_anggota', $id)->orderBy('tgl_penarikan', 'desc')->get();
        return view('petugas.penarikan.show', compact('title', 'anggota', 'penarikan', 'sisaSimpanan', 'kategoriSimpanan'));
    }


    public function danaSosial()
    {
        $title = 'Kelola Penarikan Dana Sosial';
        PenarikanDanaSosial::count() == 0 ? $saldo_sekarang = Simpanan::where('id_kategori', 4)->sum('jumlah') : $saldo_sekarang = DB::table('penarikan_dana_sosial')->orderBy('id_penarikan', 'desc')->first()->saldo_sesudah;
        $penarikan = PenarikanDanaSosial::orderBy('tgl_penarikan', 'desc')->get();
        return view('petugas.penarikan.dana-sosial',  compact('title', 'saldo_sekarang', 'penarikan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeDanaSosial(Request $request)
    {
        $this->validate($request, [
            'jumlah' => 'required|numeric',
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
            $saldo_sebelum = PenarikanDanaSosial::count() == 0 ? Simpanan::where('id_kategori', 4)->sum('jumlah') : DB::table('penarikan_dana_sosial')->orderBy('id_penarikan', 'desc')->first()->saldo_sesudah;
            if ($saldo_sebelum < $request->jumlah) {
                return redirect()->back()->withInput()->with(['error' => 'Saldo tidak cukup']);
            }
            $saldo_sesudah = $saldo_sebelum - $request->jumlah;
            PenarikanDanaSosial::create([
                'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'tgl_penarikan' => $request->tgl_penarikan,
                'saldo_sebelum' => $saldo_sebelum,
                'saldo_sesudah' => $saldo_sesudah,
            ]);
            return redirect()->back()->withInput()->with(['success' => 'Penarikan berhasil ditambahkan']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['error' => $th->getMessage()]);
        }
    }
}
