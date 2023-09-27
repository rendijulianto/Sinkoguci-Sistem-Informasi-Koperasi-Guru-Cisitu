<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota,KategoriSimpanan, Simpanan, Penarikan,KategoriSimpananAnggota};
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{SimpananExport};
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

    public function indexAdmin(Request $request)
    {
        $title = 'Kelola Simpanan';
        $anggota = Anggota::with('sekolah')->orderBy('nama', 'asc')->get();
        $kategori = KategoriSimpanan::orderBy('id_kategori', 'asc')->get();
        $simpanan = Simpanan::query();
        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-t');
        $kategori_id = $request->kategori_id;
        $anggota_id = $request->anggota_id;
        $cari = $request->cari;
        if ($cari) {
            $simpanan->where(function($q) use ($cari) {
                $q->where('tgl_bayar', 'like', '%'.$cari.'%')
                ->orWhere('jumlah', 'like', '%'.$cari.'%')
                ->orWhereHas('anggota', function($query) use ($cari) {
                    $query->where('nama', 'like', '%'.$cari.'%');
                })
                ->orWhereHas('petugas', function($query) use ($cari) {
                    $query->where('nama', 'like', '%'.$cari.'%');
                });
            });
        }
        if ($anggota_id) {
            $simpanan->where('id_anggota', '=', $anggota_id);
        }
        if ($kategori_id) {
            $simpanan->where('id_kategori', '=', $kategori_id);
        }

        if ($request->tanggal_awal) {
            $tanggal_awal = $request->tanggal_awal;
        }
        if ($request->tanggal_akhir) {
            $tanggal_akhir = $request->tanggal_akhir;
        }
        $simpanan->whereBetween('tgl_bayar', [$tanggal_awal, $tanggal_akhir]);
        $simpanan = $simpanan->with('anggota','kategori','petugas')->orderBy('tgl_bayar', 'desc')->paginate(10);

        return view('admin.simpanan.index',  compact('title', 'anggota', 'simpanan', 'tanggal_awal', 'tanggal_akhir', 'cari', 'kategori', 'kategori_id', 'anggota_id'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kategoriSimpanan = KategoriSimpanan::orderBy('id_kategori', 'asc')->get();
        $validate_kategori = [
            'id_anggota' => 'required|numeric|exists:anggota,id_anggota',
            'tgl_bayar' => 'required|date',
        ];
        $message_kategori = [
            'id_anggota.required'     => 'Anggota tidak ditemukan!',
            'id_anggota.numeric'     => 'Id anggota tidak valid!',
            'id_anggota.exists' => 'Id anggota tidakn ditemukan!',
            'tgl_bayar.required' => 'Tanggal bayar tidak boleh kosong',
            'tgl_bayar.date' => 'Tanggal bayar harus tanggal',
        ];
        foreach ($kategoriSimpanan as $k) {
            $validate_kategori[str_replace(' ', '_', $k->nama)] = 'nullable';

        }
        $this->validate($request, $validate_kategori, $message_kategori);
        DB::beginTransaction();
        try {
           $dataSimpanan = [
                'id_anggota' => $request->id_anggota,
                'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                'jumlah' => 0,
                'tgl_bayar' => $request->tgl_bayar,
            ];

            foreach ($kategoriSimpanan as $k) {
                $object = strtolower(str_replace(' ', '_', $k->nama));
                if ($request->$object != null) {
                    $jumlah = Helper::rupiahToNumeric($request->$object);
                    $dataSimpanan['id_kategori'] = $k->id_kategori;
                    $dataSimpanan['jumlah'] = $jumlah;
                    $simpan =  Simpanan::create($dataSimpanan);
                    $kategoriSimpananAnggota = DB::table('kategori_simpanan_anggota')
                        ->where('id_anggota', '=', $request->id_anggota)
                        ->where('id_kategori', '=', $k->id_kategori)
                        ->first();
                    if ($kategoriSimpananAnggota) {
                        DB::table('kategori_simpanan_anggota')
                            ->where('id_anggota', '=', $request->id_anggota)
                            ->where('id_kategori', '=', $k->id_kategori)
                            ->update([
                                'saldo' => $kategoriSimpananAnggota->saldo + $jumlah,
                            ]);
                    }
                }
            }
            DB::commit();
            return redirect()->back()->withInput()->with(['success' => 'Menambahkan simpanan baru']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $title = 'Detail Simpanan';
        $anggota = Anggota::where('id_anggota', '=', $id)->first();
        if (!$anggota) {
            return abort(404);
        }
        $simpananDefault = $anggota->kategori_simpanan_default();
        // dd($simpananDefault);
        $sisaSimpanan = $anggota->sisaSimpanan();

        $simpanan = [];
        for ($i=date('m'); $i >= 1; $i--) {
            $simpanan[$i] = $anggota->getSimpanan(date('Y'), $i);
        }

        $kategoriSimpanan = KategoriSimpanan::orderby('id_kategori', 'asc')->get();
        if($request->aksi == "download") {
            return Excel::download(new SimpananExport($anggota,$kategoriSimpanan), 'Simpanan-'.$anggota->nama.' - '.$anggota->sekolah->nama.' - '.date('d-m-Y').'.xlsx');
        } else {
            return view('petugas.simpanan.show', compact('title', 'anggota', 'simpanan', 'kategoriSimpanan', 'sisaSimpanan', 'simpananDefault'));
        }
    }


    // update
    public function update(Request $request, $id)
    {
        $simpanan = Simpanan::where('id_simpanan', '=', $id)->first();
        if (!$simpanan) {
            return abort(404);
        }

        $validate_kategori = [
            'jumlah' => 'required',
            'tgl_bayar' => 'required|date',
        ];
        $message_kategori = [
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'tgl_bayar.required' => 'Tanggal bayar tidak boleh kosong',
            'tgl_bayar.date' => 'Tanggal bayar harus tanggal',
        ];


        $this->validate($request, $validate_kategori, $message_kategori);
        DB::beginTransaction();
        try {
            $anggota = Anggota::where('id_anggota', '=', $simpanan->id_anggota)->first();
            $kategoriSimpananAnggota = DB::table('kategori_simpanan_anggota')
                ->where('id_anggota', '=', $simpanan->id_anggota)
                ->where('id_kategori', '=', $simpanan->id_kategori)
                ->first();
            $saldo_sekarang = $simpanan->jumlah;
            $saldo_baru = Helper::rupiahToNumeric($request->jumlah);
            if ($saldo_sekarang > $saldo_baru) {
                $saldo = $kategoriSimpananAnggota->saldo - ($saldo_sekarang - $saldo_baru);
            } else {
                $saldo = $kategoriSimpananAnggota->saldo + ($saldo_baru - $saldo_sekarang);
            }

            if ($kategoriSimpananAnggota && $saldo >=  $saldo_baru) {
                DB::table('kategori_simpanan_anggota')
                    ->where('id_anggota', '=', $simpanan->id_anggota)
                    ->where('id_kategori', '=', $simpanan->id_kategori)
                    ->update([
                        'saldo' => $saldo,
                    ]);
                $simpanan->update([
                    'jumlah' => $saldo_baru,
                    'tgl_bayar' => $request->tgl_bayar,
                ]);
            } else {
               throw new \Exception("Data tidak bisa diubah, saldo tidak mencukupi");
            }

            DB::commit();
            return redirect()->back()->with(['success' => 'Mengubah simpanan']);

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with(['error' => $th->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $simpanan = Simpanan::where('id_simpanan', '=', $id)->first();
        if (!$simpanan) {
            return abort(404);
        }
        DB::beginTransaction();
        try {
            $anggota = Anggota::where('id_anggota', '=', $simpanan->id_anggota)->first();
            $kategoriSimpananAnggota = DB::table('kategori_simpanan_anggota')
                ->where('id_anggota', '=', $simpanan->id_anggota)
                ->where('id_kategori', '=', $simpanan->id_kategori)
                ->first();
            if ($kategoriSimpananAnggota && $kategoriSimpananAnggota->saldo >=  $simpanan->jumlah) {
                DB::table('kategori_simpanan_anggota')
                    ->where('id_anggota', '=', $simpanan->id_anggota)
                    ->where('id_kategori', '=', $simpanan->id_kategori)
                    ->update([
                        'saldo' => $kategoriSimpananAnggota->saldo - $simpanan->jumlah,
                    ]);
                $simpanan->delete();
            } else {
               throw new \Exception("Data tidak bisa dihapus, saldo tidak mencukupi");
            }

            DB::commit();
            return redirect()->back()->with(['success' => 'Menghapus simpanan']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
