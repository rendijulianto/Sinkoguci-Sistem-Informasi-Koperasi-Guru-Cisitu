<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Pinjaman, Anggota, Petugas};
use Illuminate\Support\Facades\Auth;
use DB;
class PinjamanController extends Controller
{
    public function index(Request $request) {
        $tanggal_awal = date('Y-01-01');
        $tanggal_akhir = date('Y-12-31');
        $cari = $request->cari;
        $status = $request->status;
        $pinjaman = Pinjaman::query();

        if(!empty($request->tanggal_awal) && !empty($request->tanggal_akhir)) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $pinjaman->whereBetween('tgl_pinjam', [$tanggal_awal, $tanggal_akhir]);
        }

        // status
        if (!empty($status)) {
            if ($status == 'lunas') {
                $pinjaman->whereRaw('sisa_pokok = 0 AND sisa_jasa = 0');
            } elseif ($status == 'belum_lunas') {
                $pinjaman->where(function ($query) {
                    $query->where('sisa_pokok', '>', 0)
                        ->orWhere('sisa_jasa', '>', 0);
                });
            }
        }

        if (!empty($cari)) {
            $pinjaman->where(function ($query) use ($cari) {
                $query->where('id_pinjaman', 'like', '%' . $cari . '%')
                    ->orWhere('tgl_pinjam', 'like', '%' . $cari . '%')
                    ->orWhereHas('anggota', function ($query) use ($cari) {
                        $query->where('nama', 'like', '%' . $cari . '%')->orWhere('id_anggota', 'like', '%' . $cari . '%');
                    })->orWhereHas('petugas', function ($query) use ($cari) {
                        $query->where('nama', 'like', '%' . $cari . '%');
                    });
            });
        }

        $pinjaman = $pinjaman->orderBy('id_pinjaman', 'desc')->paginate(10);
        $title = 'Kelola Pinjaman';

        return view('petugas.pinjaman.index', compact('title', 'pinjaman', 'tanggal_awal', 'tanggal_akhir', 'cari', 'status'));
    }

    public function indexAdmin(Request $request)
    {
        $tanggal_awal = date('Y-01-01');
        $tanggal_akhir = date('Y-12-31');
        $cari = $request->cari;
        $status = $request->status;
        $pinjaman = Pinjaman::query();

        if(!empty($request->tanggal_awal) && !empty($request->tanggal_akhir)) {
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;
            $pinjaman->whereBetween('tgl_pinjam', [$tanggal_awal, $tanggal_akhir]);
        }

        // status
        if (!empty($status)) {
            if ($status == 'lunas') {
                $pinjaman->whereRaw('sisa_pokok = 0 AND sisa_jasa = 0');
            } elseif ($status == 'belum_lunas') {
                $pinjaman->where(function ($query) {
                    $query->where('sisa_pokok', '>', 0)
                        ->orWhere('sisa_jasa', '>', 0);
                });
            }
        }

        if (!empty($cari)) {
            $pinjaman->where(function ($query) use ($cari) {
                $query->where('id_pinjaman', 'like', '%' . $cari . '%')
                    ->orWhere('tgl_pinjam', 'like', '%' . $cari . '%')
                    ->orWhereHas('anggota', function ($query) use ($cari) {
                        $query->where('nama', 'like', '%' . $cari . '%');
                    })->orWhereHas('petugas', function ($query) use ($cari) {
                        $query->where('nama', 'like', '%' . $cari . '%');
                    });
            });
        }


        $title = 'Laporan Pinjaman';

        if($request->aksi == "download") {
            $pinjaman = $pinjaman->orderBy('id_pinjaman', 'desc')->get();
            return Excel::download(new PinjamanReportExport($pinjaman), 'Laporan Pinjaman ' . $tanggal_awal . ' - ' . $tanggal_akhir . '.xlsx');
        }
        $pinjaman = $pinjaman->orderBy('id_pinjaman', 'desc')->paginate(10);

        return view('admin.pinjaman.index', compact('title', 'pinjaman', 'tanggal_awal', 'tanggal_akhir', 'cari', 'status'));
    }

    public function angsuran (string $id) {
        $pinjaman = Pinjaman::findOrFail($id);
        $title = 'Angsuran Pinjaman';
        $angsuran = $pinjaman->angsuran()->orderBy('created_at', 'desc')->get();
        return view('admin.pinjaman.angsuran', compact('title', 'angsuran', 'pinjaman'));
    }
   
    public function destroyAngsuran(string $id, string $tgl_bayar, string $bayar_pokok, string $bayar_jasa, string $setelah_pokok, string $setelah_jasa) {
       DB::beginTransaction();
       try {
           $angsuran = DB::table('angsuran')->where('id_pinjaman', $id)->where([
                ['tgl_bayar', $tgl_bayar],
                ['bayar_pokok', $bayar_pokok],
                ['bayar_jasa', $bayar_jasa],
                ['setelah_pokok', $setelah_pokok],
                ['setelah_jasa', $setelah_jasa],
              ])->first();
           if($angsuran) {
                $bayar_pokok = $angsuran->bayar_pokok;
                $bayar_jasa = $angsuran->bayar_jasa;
                DB::table('angsuran')->where([
                    ['id_pinjaman', $id],
                    ['tgl_bayar', $tgl_bayar],
                    ['bayar_pokok', $bayar_pokok],
                    ['bayar_jasa', $bayar_jasa],
                    ['setelah_pokok', $setelah_pokok],
                    ['setelah_jasa', $setelah_jasa],
                ])->delete();
                
                $pinjaman = Pinjaman::findOrFail($id);
                $pinjaman->sisa_pokok += $bayar_pokok;
                $pinjaman->sisa_jasa += $bayar_jasa;
                $pinjaman->save();
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil menghapus data angsuran');
           } else {
               throw new \Exception('Data angsuran tidak ditemukan');
           }
       } catch (\Throwable $th) {
              DB::rollback();
              return redirect()->back()->with('error', $th->getMessage());
       }
    }

    public function destroy(string $id) {
        DB::beginTransaction();
        try {
            $pinjaman = Pinjaman::findOrFail($id);
            $pinjaman->angsuran()->delete();
            $pinjaman->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menghapus data pinjaman');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create() {
        $title = 'Pengajuan Pinjaman';
        $anggota = Anggota::orderBy('nama', 'asc')->get();
        $id_pinjam = Pinjaman::max('id_pinjaman') + 1;
        return view('petugas.pinjaman.pengajuan', compact('title', 'anggota', 'id_pinjam'));
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



    public function store(Request $request) {


        $this->validate($request, [
            'id_anggota' => 'required|numeric|exists:anggota,id_anggota',
            'nominal' => 'required',
            'lama_angsuran' => 'required|numeric',
            'tgl_pinjam' => 'required|date',
        ], [
            'id_anggota.required' => 'Anggota harus dipilih',
            'nominal.required' => 'Nominal harus diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'lama_angsuran.required' => 'Lama angsuran harus diisi',
            'lama_angsuran.numeric' => 'Lama angsuran harus berupa angka',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi',
            'tgl_pinjam.date' => 'Tanggal pinjam harus berupa tanggal',
        ]);


      try {
        $pinjaman = Pinjaman::create([
            'id_anggota' => $request->id_anggota,
            'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
            'nominal' => $this->convertRupiahToNumber($request->nominal),
            'tgl_pinjam' => $request->tgl_pinjam,
            'lama_angsuran' => $request->lama_angsuran,
            'sisa_pokok' => $this->convertRupiahToNumber($request->nominal),
            'sisa_jasa' => 0,
        ]);

        return redirect()->route('petugas.pinjaman.index')->with('success', 'Berhasil menambahkan data pinjaman');
      } catch (\Throwable $th) {
        return redirect()->back()->withInput()->with('error', $th->getMessage());
      }
    }


    public function tambahJasaTagihanBulanBaru(Request $request) {
        // Dikatakan Belum Lunas Jika Sisa Pokoknya Masih Ada atau Sisa Jasa Masih Ada
        // daftar pinjaman yang belum lunas dan tgl_update_jasa nya bukan bulan dan tahun sekarang
        $pinjaman = Pinjaman::where(function ($query) {
            $query->where('sisa_pokok', '>', 0)
                ->orWhere('sisa_jasa', '>', 0);
        })

            ->where(function ($query) {
                $query->whereYear('tgl_update_jasa', '!=', date('Y'))
                    ->orWhereMonth('tgl_update_jasa', '!=', date('m'))
                    ->orWhereNull('tgl_update_jasa');
            })
            ->get();



        $persen_jasa = 0.03;
        foreach ($pinjaman as $p) {
            //hitung jasa per bulan
            $jasa_per_bulan = $p->sisa_pokok * $persen_jasa;
            //tambahkan jasa per bulan ke sisa jasa
            $p->sisa_jasa += $jasa_per_bulan;
            // $p->tgl_update_jasa = date('Y-m-d');
            $p->tgl_update_jasa = date('Y-m-d', strtotime($p->tgl_update_jasa . ' +1 month'));
            $p->save();
        }
    }
}
