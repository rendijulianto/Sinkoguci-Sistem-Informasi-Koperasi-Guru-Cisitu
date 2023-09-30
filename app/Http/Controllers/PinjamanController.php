<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Pinjaman, Anggota, Petugas};
use Illuminate\Support\Facades\Auth;
use DB;
use App\Exports\PinjamanReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Helper;

class PinjamanController extends Controller
{
    public function index(Request $request) {
        $tanggal_awal = date('Y-01-01');
        $tanggal_akhir = date('Y-12-31');
        $cari = $request->cari;
        $status = $request->status;
        $pinjaman = Pinjaman::filter($cari, $status, $tanggal_awal, $tanggal_akhir)->with('anggota', 'petugas')->orderBy('tgl_pinjam', 'desc')->paginate(10);
        $title = 'Kelola Pinjaman';
        return view('petugas.pinjaman.index', compact('title', 'pinjaman', 'tanggal_awal', 'tanggal_akhir', 'cari', 'status'));
    }

    public function indexAdmin(Request $request)
    {
        $tanggal_awal = date('Y-01-01');
        $tanggal_akhir = date('Y-12-31');
        $cari = $request->cari;
        $status = $request->status;

        $title = 'Laporan Pinjaman';
        $pinjaman = Pinjaman::filter($cari, $status, $tanggal_awal, $tanggal_akhir)->with('anggota', 'petugas')->orderBy('tgl_pinjam', 'desc');
        if($request->aksi == "download") {
            $pinjaman = $pinjaman->get();
            return Excel::download(new PinjamanReportExport($pinjaman), 'Laporan Pinjaman ' . $tanggal_awal . ' - ' . $tanggal_akhir . '.xlsx');
        }
        $pinjaman = $pinjaman->paginate(10);

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
        $nominal = Helper::rupiahToNumeric($request->nominal);
        $pinjaman = Pinjaman::create([
            'id_anggota' => $request->id_anggota,
            'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
            'nominal' => $nominal,
            'tgl_pinjam' => $request->tgl_pinjam,
            'lama_angsuran' => $request->lama_angsuran,
            'sisa_pokok' => $nominal,
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
